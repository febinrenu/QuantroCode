<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TranslationSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();

        $path = database_path('seeders/translations');
        $files = File::files($path);

        $now = now();
        $allTranslations = [];

        foreach ($files as $file) {
            $locale = pathinfo($file, PATHINFO_FILENAME);
            $translations = require $file;

            foreach ($translations as $key => $value) {
                $allTranslations[] = [
                    'locale' => $locale,
                    'key' => $key,
                    'value' => $value,
                    'is_default' => $locale === 'en' ? 1 : 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Deduplicate by locale+key (PHP arrays are case-sensitive but
        // MySQL unique index is case-insensitive, causing collisions).
        $seen = [];
        $unique = [];
        foreach ($allTranslations as $row) {
            $dup = strtolower($row['locale'] . '|' . $row['key']);
            if (! isset($seen[$dup])) {
                $seen[$dup] = true;
                $unique[] = $row;
            }
        }

        // Truncate + bulk insert is much faster than upsert on remote databases.
        // SET FOREIGN_KEY_CHECKS is MySQL-only; SQLite uses a PRAGMA instead.
        $isSqlite = DB::connection()->getDriverName() === 'sqlite';
        DB::statement($isSqlite ? 'PRAGMA foreign_keys = OFF' : 'SET FOREIGN_KEY_CHECKS=0');
        DB::table('translations')->truncate();

        DB::transaction(function () use ($unique) {
            foreach (array_chunk($unique, 2000) as $chunk) {
                DB::table('translations')->insert($chunk);
            }
        });

        DB::statement($isSqlite ? 'PRAGMA foreign_keys = ON' : 'SET FOREIGN_KEY_CHECKS=1');
    }
}
