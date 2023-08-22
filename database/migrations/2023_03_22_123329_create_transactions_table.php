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
        Schema::create('transactions', function (Blueprint $table) {
          $table->id();
          $table->string('or')->unique();
          $table->unsignedInteger('agent_id')->index(); // refered agent
          $table->unsignedInteger('staff_id')->index(); // staff
          $table->unsignedInteger('client_id')->index(); // user_id
          $table->unsignedTinyInteger('pay_type_id')->index();
          $table->unsignedInteger('plan_id')->index();
          $table->decimal('amount', 8, 2);
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
