<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'appointment_id',
        'receipt_number',
        'reference',
        'amount',
        'type',
        'status',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
