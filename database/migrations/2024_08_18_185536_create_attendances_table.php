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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // company id
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            // shift id
            $table->foreignId('shift_id')->constrained('shifts')->onDelete('cascade');
            // leave id
            $table->foreignId('leave_id')->nullable()->constrained('leaves')->onDelete('cascade');
            // leave type id
            $table->foreignId('leave_type_id')->nullable()->constrained('leave_types')->onDelete('cascade');
            // holiday id
            $table->foreignId('holiday_id')->nullable()->constrained('holidays')->onDelete('cascade');

            // is holiday
            $table->boolean('is_holiday')->default(false);

            // is leave
            $table->boolean('is_leave')->default(false);

            // date
            $table->date('date');
            // clock in date time
            $table->dateTime('clock_in_date_time')->nullable();
            // clock out date time
            $table->dateTime('clock_out_date_time')->nullable();

            // total duration
            $table->time('total_duration')->nullable();

            // is late
            $table->boolean('is_late')->default(false);

            // is half day
            $table->boolean('is_half_day')->default(false);

            // is paid
            $table->boolean('is_paid')->default(true);

            // status
            $table->string('status')->default('present');

            // reason
            $table->text('reason')->nullable();

            $table->timestamps();

            // // nullable for leave, leave type, holiday
            // $table->unsignedBigInteger('leave_id')->nullable();
            // $table->unsignedBigInteger('leave_type_id')->nullable();
            // $table->unsignedBigInteger('holiday_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
