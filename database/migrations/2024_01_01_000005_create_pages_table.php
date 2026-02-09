<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->string('template')->default('default');
            $table->string('status')->default('draft'); // draft, published
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->json('open_graph')->nullable();
            $table->json('twitter_card')->nullable();
            
            // Page Settings
            $table->boolean('show_in_menu')->default(false);
            $table->boolean('is_homepage')->default(false);
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
            
            $table->index(['status', 'show_in_menu']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};