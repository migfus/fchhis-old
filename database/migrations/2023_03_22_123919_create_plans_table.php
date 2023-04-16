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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('avatar')->nullable();
            $table->string('name');
            $table->tinyInteger('age_start');
            $table->tinyInteger('age_end');
            $table->text('desc')->nullable();
            $table->decimal('contract_price', 7, 2);
            $table->decimal('spot_pay', 7, 2);
            $table->decimal('spot_service', 7, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
