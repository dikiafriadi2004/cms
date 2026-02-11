<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->string('size_preset')->nullable()->after('in_content_paragraph')
                ->comment('Preset size: auto, small, medium, large, custom');
            $table->integer('custom_width')->nullable()->after('size_preset')
                ->comment('Custom width in pixels');
            $table->integer('custom_height')->nullable()->after('custom_width')
                ->comment('Custom height in pixels');
        });
    }

    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['size_preset', 'custom_width', 'custom_height']);
        });
    }
};
