# Laporan Investigasi Bug Mendalam — Laravel CMS

**Tanggal**: Investigasi dilakukan pada codebase saat ini  
**Scope**: Controller, Model, Routes, Views, Services, Helpers, Middleware, Mail, Logs  
**Status**: READ-ONLY — tidak ada perubahan kode

---

## Ringkasan Eksekutif

Investigasi menemukan **4 bug konfirmasi** (pasti crash atau hasil salah pada kondisi tertentu) dan **9 potensi bug** (mungkin bermasalah dalam kondisi tertentu). Selain itu ditemukan **3 masalah konfigurasi** yang perlu perhatian. Tidak ada temuan yang bersifat critical (crash situs total), namun ada yang High severity dan harus ditangani sebelum production.

---

## BUG KONFIRMASI (Pasti Salah / Akan Crash)

---

### [B-1] `User::$twitter_handle` — Property Tidak Exist → Null Coalescing Aman, Tapi Data Salah
**Severity: Medium**  
**File**: `app/Models/Post.php`, baris 216

```php
'twitter:creator' => $this->user->twitter_handle ?? config('app.twitter_handle', '@yoursite'),
```

**Masalah**: Model `User` tidak punya kolom `twitter_handle` di `$fillable` maupun di migration.  
Akibatnya `$this->user->twitter_handle` selalu `null` (karena Eloquent mengembalikan `null` untuk properti yang tidak ada di kolom), sehingga `twitter:creator` selalu default ke `config('app.twitter_handle', '@yoursite')` — bukan handle user yang sebenarnya.  
Ini bukan crash, tapi data Twitter Card selalu salah untuk semua post.

**Fix**: Tambahkan kolom `twitter_handle` ke tabel `users` (migration), `User::$fillable`, dan form edit user. Atau hapus `twitter:creator` dari `generateTwitterCardData()` jika memang tidak diimplementasi.

---

### [B-2] `Contact::markAsReplied()` — `replied_at` Tidak Di-set
**Severity: Medium**  
**File**: `app/Models/Contact.php`, baris 59–62

```php
public function markAsReplied()
{
    $this->update(['status' => 'replied']);
}
```

**Masalah**: `Contact` punya kolom `replied_at` (ada di `$fillable` dan `$casts`), tapi `markAsReplied()` **tidak mengisi `replied_at`**. Bandingkan dengan `markAsRead()` yang mengisi `read_at` dengan benar.  
Akibatnya `replied_at` selalu `NULL` di database meski contact sudah dibalas. Ini menyebabkan laporan/filter berdasarkan `replied_at` tidak akurat.

**Fix**:
```php
public function markAsReplied()
{
    $this->update([
        'status' => 'replied',
        'replied_at' => now(),
    ]);
}
```

---

### [B-3] `Ad::selectWeightedAd()` — Division by Zero Jika `rotation_weight` Semua Nol
**Severity: Medium**  
**File**: `app/Models/Ad.php`, baris 257–272

```php
protected static function selectWeightedAd($ads)
{
    $totalWeight = $ads->sum('rotation_weight');
    $random = rand(1, $totalWeight); // ← CRASH jika totalWeight = 0
    ...
}
```

**Masalah**: `rand(1, 0)` di PHP mengembalikan nilai acak antara 0 dan 1 tapi dokumen PHP menyatakan perilaku ini **undefined/deprecated** dan di beberapa versi PHP menghasilkan Warning: "rand(): max(-2147483648) is less than min(1)". Jika semua iklan dalam rotation group tidak mengisi `rotation_weight` (default `null`), maka `sum()` = 0 dan `rand(1, 0)` akan menghasilkan output tak terduga.

**Fix**:
```php
protected static function selectWeightedAd($ads)
{
    $totalWeight = $ads->sum('rotation_weight');
    if ($totalWeight <= 0) {
        return $ads->random(); // fallback ke random jika semua weight 0
    }
    $random = rand(1, $totalWeight);
    ...
}
```

---

### [B-4] `SitemapController` — `offset()` + `chunk()` Tidak Bekerja Bersamaan
**Severity: Medium**  
**File**: `app/Http/Controllers/SitemapController.php`, baris 141–147 dan 158–164

```php
Post::published()
    ->select('slug', 'updated_at')
    ->offset($offset)        // ← masalah di sini
    ->limit(self::MAX_URLS_PER_SITEMAP)
    ->chunk(500, function ($posts) use (&$sitemap) { ... });
```

**Masalah**: Di Laravel, `chunk()` **mengabaikan `offset()` yang sudah di-set** karena `chunk()` mengelola offset-nya sendiri secara internal. Ini berarti untuk sitemap paginated (saat situs > 5000 URL), semua halaman sitemap akan menghasilkan konten yang **sama** (dari halaman 1 terus), bukan halaman yang berbeda.

**Dampak**: Sitemap untuk situs besar akan memiliki duplikat URL di semua paginated sitemap. Ini hanya terjadi jika total posts melebihi `MAX_URLS_PER_SITEMAP` (5000).

**Fix**: Ganti `chunk()` dengan `skip()` + `take()` + `each()`, atau gunakan `forPage()`:
```php
Post::published()
    ->select('slug', 'updated_at')
    ->skip($offset)
    ->take(self::MAX_URLS_PER_SITEMAP)
    ->get()
    ->each(function ($post) use (&$sitemap) { ... });
```

---

## POTENSI BUG (Bisa Bermasalah di Kondisi Tertentu)

---

### [P-1] `AppServiceProvider` — FORCE_HTTPS Logic Tidak Benar
**Severity: High**  
**File**: `app/Providers/AppServiceProvider.php`, baris 41–47

```php
$forceHttps = env('FORCE_HTTPS', false)
    || config('app.env') === 'production'  // ← MASALAH
    || request()->header('X-Forwarded-Proto') === 'https';
```

**Masalah**: Baris `config('app.env') === 'production'` berarti **setiap kali `APP_ENV=production`**, HTTPS di-force secara otomatis tanpa memandang apakah server benar-benar menggunakan HTTPS. Ini adalah penyebab utama **sesi berakhir / redirect loop** yang dilaporkan sebelumnya jika `APP_ENV=production` namun tidak ada HTTPS.  

Saat ini `.env` sudah di-set `APP_ENV=local` yang seharusnya aman. Namun jika di-deploy ke staging/production tanpa HTTPS yang benar, ini akan langsung menyebabkan masalah.

**Fix**: Hapus kondisi `config('app.env') === 'production'` atau ganti dengan:
```php
$forceHttps = env('FORCE_HTTPS', false)
    || (config('app.env') === 'production' && request()->isSecure())
    || request()->header('X-Forwarded-Proto') === 'https';
```

---

### [P-2] `SettingsCache::all()` Dikembalikan sebagai Collection, Diakses sebagai Array
**Severity: Medium**  
**File**: `app/Http/Controllers/Admin/ContactController.php`, baris 129–144

```php
$settings = SettingsCache::all(); // ← returns Collection
...
'siteName' => $settings['site_name'] ?? config('app.name'), // ← array access on Collection
```

**Masalah**: `SettingsCache::all()` mengembalikan `Illuminate\Support\Collection`. Collection mendukung array-access (`$collection['key']`), tapi ini akan return `null` jika key tidak ada — tanpa `ArrayAccess` exception. Jadi secara teknis **tidak crash**, tapi bergantung pada perilaku Collection yang bisa berubah.

Inkonsistensi yang lebih penting: kode lain menggunakan `$settings->get('key', default)` (method cara yang benar untuk Collection). Admin `ContactController` menggunakan `$settings['key']` (array syntax) yang tidak menyediakan default value secara eksplisit jika key tidak ada.

**Fix**: Gunakan `$settings->get('site_name', config('app.name'))` secara konsisten di semua tempat.

---

### [P-3] `Post::generateOpenGraphData()` — Relasi `user` / `category` Bisa Null
**Severity: Medium**  
**File**: `app/Models/Post.php`, baris 193–213

```php
public function generateOpenGraphData(): array
{
    return [
        ...
        'article:author' => $this->user->name ?? '',   // null safe ✓
        'article:section' => $this->category->name ?? '', // null safe ✓
        'article:tag' => $this->tags->pluck('name')->toArray(), // ← MASALAH
    ];
}
```

**Masalah**: `$this->tags->pluck('name')` — jika relasi `tags` belum di-eager-load saat dipanggil dari boot `saved` event, ini akan trigger lazy-load query. Ini bukan crash tapi menghasilkan ekstra N+1 query. Lebih serius: di beberapa kondisi (baru dibuat, tags belum sync), `$this->tags` bisa return Collection kosong yang aman — tapi jika model digunakan di context tanpa DB access (misalnya unit test mock), ini bisa gagal.

Di boot `saved` event (baris 239), ada `$post->loadMissing(['user', 'category', 'tags'])` sebelum memanggil `generateOpenGraphData()` — ini sudah benar. Tapi `generateOpenGraphData()` juga dipanggil langsung dari controller atau test tanpa loading relasi.

**Fix**: Tidak kritis untuk saat ini, tapi dokumentasikan bahwa caller harus load relasi sebelum memanggil method ini.

---

### [P-4] `BlogController::show()` — `relatedPosts` Query Berpotensi Empty Condition
**Severity: Low**  
**File**: `app/Http/Controllers/Frontend/BlogController.php`, baris 97–115

```php
$relatedPosts = Post::published()
    ->where(function ($query) use ($post) {
        if ($post->category_id) {
            $query->where('category_id', $post->category_id);
        }
        
        if ($post->tags->count() > 0) {
            $query->orWhereHas('tags', ...);
        }
    })
    ->limit(4)
    ->get();
```

**Masalah**: Jika post tidak punya `category_id` DAN tidak punya tags, callback query kosong tidak menambahkan kondisi apapun. Query menjadi `WHERE 1=1 AND id != X` yang akan mengambil **4 post acak terbaru** — bukan "related" sama sekali. Ini bukan crash, tapi UX salah (shows unrelated posts).

**Fix**: Tambahkan fallback atau kembalikan empty collection jika tidak ada kondisi:
```php
$relatedPosts = collect();
if ($post->category_id || $post->tags->count() > 0) {
    // jalankan query di atas
}
```

---

### [P-5] `AdController::getTargetDimensions()` — `auto` Preset dengan `null` Height Bisa Crash `cover()`
**Severity: Medium**  
**File**: `app/Http/Controllers/Admin/AdController.php`, baris 98–103

```php
if ($dimensions['width'] && $dimensions['height']) {
    $image->cover($dimensions['width'], $dimensions['height']); // perlu keduanya tidak null
} elseif ($dimensions['width']) {
    $image->scale(width: $dimensions['width']);
} elseif ($dimensions['height']) {
    $image->scale(height: $dimensions['height']);
}
```

Untuk preset `auto`, `height` di-set `null` di semua posisi. Logic di atas akan masuk ke `elseif ($dimensions['width'])` dan memanggil `$image->scale(width: $dimensions['width'])`. Ini sebenarnya **benar** dan tidak crash.

Namun jika user memilih preset `custom` dengan `custom_width = null` dan `custom_height = null` (form tidak diisi), maka `getTargetDimensions()` mengembalikan `['width' => null, 'height' => null]`, semua kondisi `if/elseif` false, sehingga gambar tidak di-resize sama sekali (tanpa error). Gambar original ukuran besar tetap tersimpan.

**Fix**: Tambahkan validasi pada `store()`/`update()` untuk memastikan custom preset selalu punya width atau height yang diisi.

---

### [P-6] `MenuController::reorderItems()` — Tidak Validasi Ownership Menu Item
**Severity: Medium**  
**File**: `app/Http/Controllers/Admin/MenuController.php`, baris 126–148

```php
public function reorderItems(Request $request, Menu $menu)
{
    $items = $request->validate([
        'items.*.id' => 'required|exists:menu_items,id',
        ...
    ])['items'];

    foreach ($items as $itemData) {
        MenuItem::where('id', $itemData['id'])->update([...]);
    }
}
```

**Masalah**: Validasi hanya mengecek `exists:menu_items,id` tapi tidak memverifikasi bahwa `menu_item.menu_id = $menu->id`. Artinya user yang punya akses ke menu A bisa mengirim ID menu items dari menu B dan mengubah `sort_order` / `parent_id` menu item di menu lain.

**Fix**: Tambahkan validasi `exists:menu_items,id,menu_id,{$menu->id}`:
```php
'items.*.id' => ['required', 'integer', Rule::exists('menu_items', 'id')->where('menu_id', $menu->id)],
```

---

### [P-7] `GoogleAnalyticsService` — `configureAnalytics()` Overwrite Config Tidak Aman untuk Multi-Request
**Severity: Low**  
**File**: `app/Services/GoogleAnalyticsService.php`, baris 47–53

```php
protected function configureAnalytics()
{
    config(['analytics.property_id' => $propertyId]);
    config(['analytics.service_account_credentials_json' => $credentials]);
    return true;
}
```

**Masalah**: `config()` di Laravel bersifat per-request (tidak persisten ke disk), tapi pada server dengan async processing (Octane, Swoole, RoadRunner), runtime config yang diubah bisa bocor ke request lain jika shared memory digunakan. Untuk setup PHP-FPM standar ini aman, tapi perlu catatan jika proyek di-upgrade ke Octane.

---

### [P-8] `Post` Boot Event `saved` — Potential Infinite Loop (Sudah Di-mitigasi, Tapi Rapuh)
**Severity: Low**  
**File**: `app/Models/Post.php`, baris 232–252

```php
static::saved(function ($post) {
    ...
    if ($needsUpdate) {
        $post->saveQuietly(); // ← prevent recursive saved event
    }
    static::clearCache();
});
```

`saveQuietly()` di-set `$post->open_graph` dan `$post->twitter_card` lalu save tanpa firing events. Ini sudah benar. Namun `clearCache()` dipanggil di setiap `saved` event. Jika ada external process yang memanggil `$post->save()` dalam jumlah besar (bulk import), ini akan memicu `SitemapController::flushCache()` berulang kali yang berisi loop 400 iterations:

```php
foreach (['static', 'posts', 'pages', 'taxonomies'] as $type) {
    for ($i = 1; $i <= 100; $i++) {
        $cache->forget("sitemap.xml.{$type}.{$i}");
    }
}
```

Total 400 cache delete calls per save. Pada bulk import 1000 posts = 400.000 cache operations. Untuk Redis ini mungkin lambat.

---

### [P-9] `SettingController::templatePreview()` — Tidak Ada Auth Check pada View Data
**Severity: Low**  
**File**: `app/Http/Controllers/Admin/SettingController.php`, baris 197–231

```php
public function templatePreview($template)
{
    if (!TemplateService::templateExists($template)) {
        abort(404);
    }
    ...
    return view($viewPath, compact('latestPosts', 'settings', ...));
}
```

**Masalah**: Route ini ada di bawah `auth` middleware, jadi sudah protected. Namun `$settings = Setting::pluck('value', 'key')->toArray()` mengambil **semua setting termasuk sensitive keys** seperti `mail_password` dan `ga_credentials_json` (meski nilai terenkripsi). Setting ini kemudian di-pass ke view frontend yang menggunakan `{!! $settings['xxx'] !!}` — potensi XSS ringan jika template meng-output setting langsung tanpa escape.

---

## TEMUAN LOG NYATA

Dari `storage/logs/laravel.log`:

### [L-1] SQLite Error pada Saat Migrasi
**Severity: Info (Sudah Teratasi)**

```
[2026-10-15] production.ERROR: Database file at path [...database.sqlite] does not exist
```

Log menunjukkan pernah ada percobaan migrasi menggunakan SQLite padahal `.env` sudah diset ke MySQL. Ini terjadi karena ada sisa **config cache** (`bootstrap/cache/config.php`) yang menyimpan `DB_CONNECTION=sqlite` dari konfigurasi lama. Log terakhir timestamp `2026-10-15` (sudah lama, tidak aktif).

**Fix**: Sudah tidak relevan jika MySQL berjalan normal. Pastikan tidak ada sisa cache: `php artisan config:clear`.

---

## MASALAH KONFIGURASI

### [K-1] `APP_ENV=local` tapi `APP_URL=http://cms.test`
**File**: `.env`

`cms.test` adalah domain lokal berbasis Valet/Herd. Pastikan hosts file (`/etc/hosts`) mengandung entry `127.0.0.1 cms.test`. Jika tidak, semua URL yang di-generate oleh `url()` dan `route()` akan salah. Cek dengan `php artisan route:list` dan pastikan domain-nya benar.

### [K-2] `QUEUE_CONNECTION=database` tapi Queue Worker Mungkin Tidak Berjalan
**File**: `.env`

Email contact form menggunakan `ShouldQueue` (dispatch ke queue). Dengan `QUEUE_CONNECTION=database`, email **tidak akan terkirim** kecuali ada queue worker yang berjalan (`php artisan queue:work`). Jika tidak ada worker, email mengantri selamanya di tabel `jobs` tanpa error yang terlihat.

**Fix**: Untuk development, ganti `QUEUE_CONNECTION=sync` agar email langsung dikirim tanpa worker. Untuk production, pastikan Supervisor menjalankan `queue:work`.

### [K-3] Dependency Major Version Behind
Dari `composer outdated`:
- `intervention/image 3.x` → 4.x tersedia (breaking changes)
- `spatie/laravel-permission 6.x` → 8.x tersedia
- `spatie/laravel-backup 9.x` → 10.x tersedia
- `laravel/framework 12.x` → 13.x tersedia

Ini tidak perlu di-update sekarang, tapi perlu catatan untuk roadmap.

---

## TABEL PRIORITAS FIX

| ID | Severity | Deskripsi | File | Fix |
|----|----------|-----------|------|-----|
| B-2 | Medium | `replied_at` tidak di-set di `markAsReplied()` | `Contact.php:59` | Tambah `replied_at => now()` |
| B-3 | Medium | Division by zero di `selectWeightedAd()` | `Ad.php:259` | Guard `$totalWeight <= 0` |
| B-4 | Medium | `offset()+chunk()` tidak bekerja bersama | `SitemapController.php:141` | Ganti dengan `skip()->take()->get()` |
| P-1 | High | `APP_ENV=production` auto-force HTTPS tanpa cek | `AppServiceProvider.php:43` | Tambah `&& request()->isSecure()` |
| P-2 | Medium | Inkonsistensi array vs Collection access `SettingsCache` | `ContactController.php:136` | Gunakan `->get()` method |
| P-6 | Medium | MenuController::reorderItems tidak validasi menu ownership | `MenuController.php:133` | Tambah `where('menu_id')` validation |
| B-1 | Medium | `twitter_handle` tidak ada di User model | `Post.php:216` | Tambah kolom atau hapus field |

---

## KESIMPULAN

Proyek ini secara keseluruhan memiliki kualitas kode yang **baik** — validasi input, penanganan exception, soft delete, cache invalidation, dan security headers sudah diterapkan dengan benar. Bug yang ditemukan bersifat logic (data salah) bukan crash fatal. 

**Prioritas segera**:
1. **P-1** (AppServiceProvider FORCE_HTTPS) — ini adalah penyebab potensial sesi berakhir di environment non-local
2. **B-2** (replied_at tidak di-set) — mudah diperbaiki, data integrity
3. **B-3** (division by zero pada weighted ads) — potensi crash saat ada rotation ads dengan weight 0
4. **K-2** (Queue worker) — email tidak terkirim tanpa worker, sangat terlihat oleh user
