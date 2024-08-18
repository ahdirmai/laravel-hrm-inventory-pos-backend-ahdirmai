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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            // company id
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');

            // user id
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // leave type id
            $table->foreignId('leave_type_id')->constrained('leave_types')->onDelete('cascade');

            // start date
            $table->date('start_date');

            // end date
            $table->date('end_date')->nullable();

            // total days
            $table->integer('total_days');

            // is half day
            $table->boolean('is_half_day')->default(false);

            // status
            $table->string('status')->default('pending');

            // reason
            $table->text('reason')->nullable();

            // is paid
            $table->boolean('is_paid')->default(false);

            // // created by
            // $table->foreignId('created_by')->constrained('users')->onDelete('cascade');

            // // updated by
            // $table->foreignId('updated_by')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
