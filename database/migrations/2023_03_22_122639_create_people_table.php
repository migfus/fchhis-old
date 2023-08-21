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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('staff_id')->unsigned();
            $table->integer('agent_id')->unsigned();
            $table->integer('client_id')->unsigned()->nullable(); // NOTE for Beneficiaries Option
            $table->tinyInteger('pay_type_id')->unsigned()->nullable();
            $table->tinyInteger('plan_id')->unsinged()->nullable();

            $table->string('name');
            $table->date('bday')->nullable();
            $table->integer('bplace_id')->nullable();
            $table->boolean('sex')->default(0);
            $table->integer('address_id')->comment('city ID, Province')->nullable(); //city, province
            $table->string('address')->comment('Specific Address')->nullable();  //specific,
            $table->date('due_at')->nullable(); // NOTE due date
            $table->date('fulfilled_at')->nullable();
            $table->string('or')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
