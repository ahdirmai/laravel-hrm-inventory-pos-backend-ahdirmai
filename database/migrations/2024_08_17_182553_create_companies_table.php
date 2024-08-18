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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('email', 191)->nullable();
            $table->string('phone', 191)->nullable();
            $table->string('website', 191)->nullable();
            $table->string('logo', 191)->nullable();
            $table->string('address', 1000)->nullable();
            $table->string('status', 191)->default('active');
            $table->unsignedInteger('total_users')->default(1);
            $table->time('clock_in_time')->default('09:30:00');
            $table->time('clock_out_time')->default('18:00:00');
            $table->unsignedInteger('early_clock_in_time')->nullable();
            $table->unsignedInteger('allow_clock_out_till')->nullable();
            $table->boolean('self_clocking')->default(true);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
