<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // adsense, adsera, manual
            $table->string('position'); // header, footer, sidebar, content_top, content_bottom, between_posts
            $table->longText('code');
            $table->boolean('is_active')->default(true);
            $table->json('display_rules')->nullable(); // pages, posts, categories where to show
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['type', 'position', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};