<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->string('image')->nullable()->after('code');
            $table->string('link')->nullable()->after('image');
            $table->boolean('open_new_tab')->default(true)->after('link');
        });
    }

    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['image', 'link', 'open_new_tab']);
        });
    }
};
