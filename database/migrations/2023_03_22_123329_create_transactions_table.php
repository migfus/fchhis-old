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
            $table->unsignedBigInteger('agent_id')->index(); // refered agent
            $table->unsignedBigInteger('staff_id')->index(); // staff
            $table->unsignedBigInteger('client_id')->index(); // user_id
            $table->unsignedBigInteger('pay_type_id')->index();
            $table->unsignedBigInteger('plan_details_id')->index();

            $table->decimal('amount', 12, 2);

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
