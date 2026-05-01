<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /** @use HasFactory<\Database\Factories\PatientFactory> */
    use HasFactory;
    
    protected $table = 'patients';

    protected $fillable = [
        'name',
        'dob',
        'sex',
        'emer_con',
        'phone',
        'email',
        'address',
        'medical_history',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }


    //     public function up(): void
    // {
    //     Schema::create('patients', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('name');
    //         $table->date('dob');
    //         $table->string('sex');
    //         $table->string('emer_con');
    //         $table->timestamps();
    //     });
    // }
}
