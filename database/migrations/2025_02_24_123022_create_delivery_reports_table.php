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
        Schema::create('delivery_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Delivery_Id')->constrained("delaveries");
            $table->foreignId('Clinic_Id')->constrained("users");
            $table->foreignId('bill_id')->constrained("bills");
            $table->integer('code')->default(random_int(0,9999));
            $table->enum('status',["Success","failure","underway"])->default("underway");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_reports');
    }
};
