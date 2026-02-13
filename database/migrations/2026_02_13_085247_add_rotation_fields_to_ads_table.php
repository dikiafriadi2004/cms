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
        Schema::table('ads', function (Blueprint $table) {
            $table->string('rotation_group')->nullable()->after('position')->index();
            $table->integer('rotation_weight')->default(1)->after('rotation_group');
            $table->enum('rotation_mode', ['random', 'weighted', 'sequential'])->default('random')->after('rotation_weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['rotation_group', 'rotation_weight', 'rotation_mode']);
        });
    }
};
