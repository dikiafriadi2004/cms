<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hanya insert jika belum ada
        $exists = DB::table('settings')->where('key', 'robots_txt')->exists();

        if (!$exists) {
            DB::table('settings')->insert([
                'key'         => 'robots_txt',
                'value'       => "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /login\n\nSitemap: " . url('/sitemap.xml'),
                'type'        => 'textarea',
                'group'       => 'seo',
                'label'       => 'Robots.txt Content',
                'description' => 'Isi file robots.txt untuk mengatur akses crawler/bot search engine',
                'sort_order'  => 8,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('settings')->where('key', 'robots_txt')->delete();
    }
};
