<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('original_name');
            $table->string('file_path');
            $table->string('file_type'); // image, video, document, audio
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size');
            $table->json('dimensions')->nullable(); // width, height for images
            $table->string('alt_text')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('folder')->default('/');
            $table->timestamps();
            
            $table->index(['file_type', 'folder']);
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_files');
    }
};