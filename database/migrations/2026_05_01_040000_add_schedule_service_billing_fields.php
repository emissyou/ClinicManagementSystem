<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->json('available_days')->nullable()->after('consultation_fee');
            $table->time('available_start_time')->nullable()->after('available_days');
            $table->time('available_end_time')->nullable()->after('available_start_time');
            $table->text('schedule_notes')->nullable()->after('clinic_assignment');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->string('service_type')->nullable()->after('doctor_id');
            $table->json('additional_services')->nullable()->after('reason');
            $table->decimal('additional_services_total', 10, 2)->default(0)->after('additional_services');
            $table->decimal('subtotal', 10, 2)->default(0)->after('additional_services_total');
            $table->decimal('total_amount', 10, 2)->default(0)->after('subtotal');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->string('receipt_number')->nullable()->unique()->after('id');
            $table->string('reference')->nullable()->after('receipt_number');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['receipt_number', 'reference']);
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['service_type', 'additional_services', 'additional_services_total', 'subtotal', 'total_amount']);
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn(['available_days', 'available_start_time', 'available_end_time', 'schedule_notes']);
        });
    }
};
