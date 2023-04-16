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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id')->unique();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->tinyInteger('role')->unsinged()->default(0)
              ->comment('[0-inactive][1-banned][2-admin][3-manager][4-agent][5-staff][6-client]');
            $table->tinyInteger('plan_id')->unsinged()->default(0)
              ->comment('[0-inactive][1-banned][2-admin');
            $table->boolean('notify_mobile')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
