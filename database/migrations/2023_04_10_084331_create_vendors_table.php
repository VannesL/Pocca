<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('canteen_id')->constrained('canteens')->restrictOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('admins')->restrictOnDelete()->default(null);
            $table->foreignId('range_id')->nullable()->constrained('price_ranges')->restrictOnDelete();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('store_name');
            $table->string('phone_number');
            $table->string('address');
            $table->string('description')->nullable();
            $table->integer('favorites');
            $table->string('qris');
            $table->string('image')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
};
