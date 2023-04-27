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
            $table->integer('created_by_user_id')->unsigned();
            $table->integer('agent_id')->unsigned()->nullable();
            $table->string('lastName')->nullable();
            $table->string('firstName')->nullable();
            $table->string('midName')->nullable();
            $table->string('extName')->nullable();
            $table->date('bday')->nullable();
            $table->integer('bplace_id')->nullable();
            $table->boolean('sex')->default(0);
            $table->integer('address_id')->comment('city ID, Province')->nullable(); //city, province
            $table->string('address')->comment('Specific Address')->nullable();  //specific,
            $table->decimal('mobile', 10, 0)->nullable();
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
