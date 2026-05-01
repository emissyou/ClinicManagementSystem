<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'service_type',
        'start_time',
        'end_time',
        'status',
        'reason',
        'additional_services',
        'additional_services_total',
        'subtotal',
        'total_amount',
        'fee',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'additional_services' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
