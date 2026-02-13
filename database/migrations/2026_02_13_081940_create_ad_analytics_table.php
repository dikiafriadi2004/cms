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
        Schema::create('ad_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id')->constrained()->onDelete('cascade');
            $table->enum('event_type', ['impression', 'click'])->index();
            $table->string('page_url')->nullable();
            $table->string('page_type')->nullable(); // home, blog_index, blog_detail, etc
            $table->string('referrer')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('device_type')->nullable(); // mobile, tablet, desktop
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->timestamp('event_date')->index();
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index(['ad_id', 'event_type', 'event_date']);
            $table->index(['ad_id', 'event_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_analytics');
    }
};
