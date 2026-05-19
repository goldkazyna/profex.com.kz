<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('owner_payroll_salary', 15, 2)->default(85000)->after('tax_rate');
            $table->date('owner_payroll_start_month')->nullable()->after('owner_payroll_salary');
        });

        // Backfill start_month = first day of users.created_at month
        DB::statement("UPDATE users SET owner_payroll_start_month = DATE_FORMAT(created_at, '%Y-%m-01') WHERE owner_payroll_start_month IS NULL");
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['owner_payroll_salary', 'owner_payroll_start_month']);
        });
    }
};
