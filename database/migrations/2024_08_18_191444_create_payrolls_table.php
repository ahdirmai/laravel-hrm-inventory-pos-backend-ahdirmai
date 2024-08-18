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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            // month
            $table->integer('month');
            // year
            $table->integer('year');
            // basic salary
            $table->decimal('basic_salary', 10, 2);

            // net salary
            $table->decimal('net_salary', 10, 2);

            // total days
            $table->integer('total_days');
            // total working days
            $table->integer('total_working_days');
            // total present days
            $table->integer('total_present_days');

            // total office time
            $table->time('total_office_time');
            // total worked time
            $table->time('total_worked_time');

            // half day
            $table->integer('half_days')->default(0);

            // late days
            $table->integer('late_days')->default(0);

            // unpaid leave
            $table->integer('unpaid_leave')->default(0);

            // paid leave
            $table->integer('paid_leave')->default(0);

            // holiday count
            $table->integer('holiday_count')->default(0);

            // payment date
            $table->date('payment_date');

            // status
            $table->string('status')->default('generated');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
