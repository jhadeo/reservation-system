<?php

use App\ReservationStatus;
use App\PaymentStatus;
use App\PaymentMethod;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('room_id')->constrained('rooms')->restrictOnDelete();
            $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete();
            $table->integer('pax');
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_status')->default(PaymentStatus::Pending->value);
            $table->string('payment_method')->default(PaymentMethod::Cash->value);
            $table->string('status')->default(ReservationStatus::Pending->value);
            $table->dateTime('check_in_datetime');
            $table->dateTime('check_out_datetime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
