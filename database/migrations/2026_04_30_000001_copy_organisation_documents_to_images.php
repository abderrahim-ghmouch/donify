<?php

use App\Models\Organisation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('organisations')
            ->whereNotNull('document_path')
            ->orderBy('id')
            ->get()
            ->each(function ($organisation) {
                $exists = DB::table('images')
                    ->where('imageable_type', Organisation::class)
                    ->where('imageable_id', $organisation->id)
                    ->where('url', $organisation->document_path)
                    ->exists();

                if ($exists) {
                    return;
                }

                DB::table('images')->insert([
                    'url' => $organisation->document_path,
                    'imageable_type' => Organisation::class,
                    'imageable_id' => $organisation->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
    }

    public function down(): void
    {
        $documentPaths = DB::table('organisations')
            ->whereNotNull('document_path')
            ->pluck('document_path');

        DB::table('images')
            ->where('imageable_type', Organisation::class)
            ->whereIn('url', $documentPaths)
            ->delete();
    }
};
