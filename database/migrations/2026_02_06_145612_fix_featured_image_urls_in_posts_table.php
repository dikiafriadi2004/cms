<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Fix featured_image URLs that contain full URL to relative path
        DB::table('posts')
            ->whereNotNull('featured_image')
            ->orderBy('id')
            ->each(function ($post) {
                $featuredImage = $post->featured_image;
                
                // If it contains full URL, extract the path
                if (str_contains($featuredImage, 'http://') || str_contains($featuredImage, 'https://')) {
                    // Extract path after /storage/
                    if (preg_match('/\/storage\/(.+)$/', $featuredImage, $matches)) {
                        $relativePath = $matches[1];
                        DB::table('posts')
                            ->where('id', $post->id)
                            ->update(['featured_image' => $relativePath]);
                    }
                }
            });
    }

    public function down(): void
    {
        // No need to reverse this
    }
};
