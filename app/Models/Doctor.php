<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';

    protected $fillable = [
        'name',
        'specialization',
        'consultation_fee',
        'qualifications',
        'clinic_assignment',
        'available_days',
        'available_start_time',
        'available_end_time',
        'schedule_notes',
    ];

    protected $casts = [
        'available_days' => 'array',
        'available_start_time' => 'datetime:H:i',
        'available_end_time' => 'datetime:H:i',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
