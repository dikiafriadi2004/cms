<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Add indexes on deleted_at columns. Default Eloquent SoftDeletes scope
 * adds `WHERE deleted_at IS NULL` to every query — without an index this
 * forces a full table scan on tables with many rows.
 */
return new class extends Migration
{
    public function up(): void
    {
        foreach (['posts', 'pages', 'users'] as $table) {
            if (Schema::hasColumn($table, 'deleted_at') && !$this->indexExists($table, "{$table}_deleted_at_index")) {
                Schema::table($table, function (Blueprint $t) use ($table) {
                    $t->index('deleted_at', "{$table}_deleted_at_index");
                });
            }
        }
    }

    public function down(): void
    {
        foreach (['posts', 'pages', 'users'] as $table) {
            if ($this->indexExists($table, "{$table}_deleted_at_index")) {
                Schema::table($table, function (Blueprint $t) use ($table) {
                    $t->dropIndex("{$table}_deleted_at_index");
                });
            }
        }
    }

    private function indexExists(string $table, string $index): bool
    {
        $database = DB::connection()->getDatabaseName();
        $result = DB::selectOne(
            'SELECT COUNT(*) AS cnt FROM information_schema.statistics WHERE table_schema = ? AND table_name = ? AND index_name = ?',
            [$database, $table, $index]
        );
        return $result && (int) $result->cnt > 0;
    }
};
