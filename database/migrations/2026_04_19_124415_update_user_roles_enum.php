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
        Schema::table('users', function (Blueprint $table) {
            // Drop old constraint and update default
            Illuminate\Support\Facades\DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
            Illuminate\Support\Facades\DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'donor'");
            // Add new constraint
            Illuminate\Support\Facades\DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'porter', 'donor'))");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            Illuminate\Support\Facades\DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
            Illuminate\Support\Facades\DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'user'");
            Illuminate\Support\Facades\DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('user', 'admin'))");
        });
    }
};
