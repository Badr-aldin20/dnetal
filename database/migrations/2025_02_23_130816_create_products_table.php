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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->enum('modeType',['اخرى','ادوات جرحيه تستخدم لمره واحده','مستلزمات','معدات كبيره'])->default('مستلزمات');
            $table->text('description');
            $table->decimal('price_buy');
            $table->decimal('price_sales');
            $table->integer('counter');
            $table->enum('status',['Active','Unactive','wait'])->default('wait');
            $table->foreignId('Manger_Id')->constrained('users')->cascadeOnDelete();    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
