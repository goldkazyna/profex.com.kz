<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->date('hire_month')->nullable()->after('opvr_enabled');
            $table->date('terminated_month')->nullable()->after('hire_month');
        });

        // Backfill hire_month = first day of created_at month
        DB::statement("UPDATE employees SET hire_month = DATE_FORMAT(created_at, '%Y-%m-01') WHERE hire_month IS NULL");

        Schema::table('employees', function (Blueprint $table) {
            $table->date('hire_month')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['hire_month', 'terminated_month']);
        });
    }
};
