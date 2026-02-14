<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'canonical_url')) {
                $table->dropColumn('canonical_url');
            }
        });

        Schema::table('pages', function (Blueprint $table) {
            if (Schema::hasColumn('pages', 'canonical_url')) {
                $table->dropColumn('canonical_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('canonical_url')->nullable()->after('meta_keywords');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->string('canonical_url')->nullable()->after('meta_keywords');
        });
    }
};
