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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone',9);
            $table->enum('type',['Master Admin','Admin Provider','Clinic'])->default('Clinic');
            $table->boolean('active')->default(false);
            $table->string('Location');
            $table->double('LOC_X')->nullable();
            $table->double('LOC_Y')->nullable();
            $table->string('name_company')->nullable();
            $table->bigInteger('stock')->default(0);
            $table->string('image')->default("person.jpg");
            $table->timestamps();                   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
