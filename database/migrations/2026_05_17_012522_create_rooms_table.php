<?php

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

        Schema::create('room_types', function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_id');
            $table->string('name');
            $table->decimal('hourly_rate', 10, 2);
            $table->integer('max_pax');
            $table->boolean('is_available')->default(false);
            $table->boolean('featured')->default(false);
            $table->foreignId('room_type_id')->constrained('room_types')->restrictOnDelete();
            $table->text('description')->nullable();
            $table->text('photo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('room_types');
    }
};
