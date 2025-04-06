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
        Schema::create('a_l_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_Id")->constrained("products");
            $table->foreignId("Manger_Id")->constrained("users");
            $table->integer("counter")->default(1);
            $table->decimal("total_price");
            $table->foreignId("catagories_Id")->constrained("categories");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_l_sales');
    }
};
