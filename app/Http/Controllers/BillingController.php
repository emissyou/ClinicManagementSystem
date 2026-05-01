<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BillingController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('appointment')->orderBy('created_at','desc')->paginate(30);
        $revenueByDoctor = Transaction::query()
            ->selectRaw('doctors.name as doctor_name, SUM(CASE WHEN transactions.type = "payment" THEN transactions.amount ELSE 0 END) as revenue')
            ->join('appointments', 'appointments.id', '=', 'transactions.appointment_id')
            ->join('doctors', 'doctors.id', '=', 'appointments.doctor_id')
            ->groupBy('doctors.name')
            ->orderByDesc('revenue')
            ->get();

        $revenueByServiceType = Appointment::query()
            ->selectRaw('service_type, SUM(total_amount) as revenue')
            ->groupBy('service_type')
            ->orderByDesc('revenue')
            ->get();

        return view('billing.index', compact('transactions', 'revenueByDoctor', 'revenueByServiceType'));
    }

    public function show(Transaction $billing)
    {
        $billing->load('appointment.patient', 'appointment.doctor');
        return view('billing.show', ['transaction' => $billing]);
    }

    public function invoice(Appointment $appointment)
    {
        $appointment->load('patient','doctor','transactions');

        $paid = $appointment->transactions()->where('type','payment')->sum('amount');
        $refunded = $appointment->transactions()->where('type','refund')->sum('amount');
        $invoiceTotal = (float) ($appointment->total_amount ?? $appointment->subtotal ?? $appointment->fee ?? 0);
        $balance = $invoiceTotal - $paid + $refunded;

        return view('billing.invoice', [
            'appointment' => $appointment,
            'paid' => $paid,
            'refunded' => $refunded,
            'balance' => $balance,
            'invoiceTotal' => $invoiceTotal,
        ]);
    }

    public function receipt(Transaction $transaction)
    {
        $transaction->load('appointment.patient', 'appointment.doctor');

        return view('billing.receipt', [
            'transaction' => $transaction,
            'receiptNumber' => $transaction->receipt_number ?? ('RCP-' . strtoupper(Str::random(8))),
        ]);
    }

    public function reports()
    {
        $revenueByDoctor = Transaction::query()
            ->selectRaw('doctors.name as doctor_name, SUM(CASE WHEN transactions.type = "payment" THEN transactions.amount ELSE 0 END) as revenue')
            ->join('appointments', 'appointments.id', '=', 'transactions.appointment_id')
            ->join('doctors', 'doctors.id', '=', 'appointments.doctor_id')
            ->groupBy('doctors.name')
            ->orderByDesc('revenue')
            ->get();

        $revenueByServiceType = Appointment::query()
            ->selectRaw('service_type, SUM(total_amount) as revenue')
            ->groupBy('service_type')
            ->orderByDesc('revenue')
            ->get();

        return view('billing.reports', compact('revenueByDoctor', 'revenueByServiceType'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'appointment_id' => 'nullable|exists:appointments,id',
            'amount' => 'required|numeric',
            'type' => 'required|in:payment,refund',
            'status' => 'nullable|string',
            'paid_at' => 'nullable|date',
            'notes' => 'nullable|string',
            'reference' => 'nullable|string',
        ]);

        $data['receipt_number'] = 'RCP-' . strtoupper(Str::random(8));
        $data['reference'] = $data['reference'] ?? $data['receipt_number'];

        $txn = Transaction::create($data);
        return redirect()->back()->with('success','Transaction recorded.');
    }
}
