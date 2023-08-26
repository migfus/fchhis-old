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
        Schema::create('infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();

            $table->unsignedBigInteger('staff_id')->index();
            $table->unsignedBigInteger('agent_id')->index();
            $table->unsignedTinyInteger('pay_type_id')->nullable();
            $table->unsignedTinyInteger('plan_id')->nullable();

            $table->string('name');
            $table->date('bday')->nullable();
            $table->unsignedInteger('bplace_id')->nullable();
            $table->boolean('sex')->default(0);
            $table->unsignedInteger('address_id')->comment('city ID, Province')->nullable(); //city, province
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
        Schema::dropIfExists('infos');
    }
};
