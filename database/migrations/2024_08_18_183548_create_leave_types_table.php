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
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            // company id
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');

            // name
            $table->string('name')->nullable();
            // is_active
            $table->boolean('is_paid')->default(true);

            // total leave
            $table->integer('total_leave')->default(0);

            // max leave per month
            $table->integer('max_leave_per_month')->default(0)->nullable();

            // created by
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_types');
    }
};
