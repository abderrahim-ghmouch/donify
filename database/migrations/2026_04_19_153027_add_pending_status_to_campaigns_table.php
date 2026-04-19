<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Change default status from 'active' to 'pending' so new campaigns
     * need admin approval before going live.
     */
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            // add start_date and end_date if they don't exist
            if (!Schema::hasColumn('campaigns', 'start_date')) {
                $table->date('start_date')->nullable();
            }
            if (!Schema::hasColumn('campaigns', 'end_date')) {
                $table->date('end_date')->nullable();
            }
        });

        // Change the default value of status to 'pending'
        DB::statement("ALTER TABLE campaigns ALTER COLUMN status SET DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE campaigns ALTER COLUMN status SET DEFAULT 'active'");
    }
};
