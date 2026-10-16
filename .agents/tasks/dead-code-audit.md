# Dead Code & Redundansi Audit — Laravel CMS

> **Audit ini bersifat READ-ONLY. Tidak ada kode yang diubah.**
> 
> Tanggal: Sesuai waktu investigasi  
> Proyek: `/Users/dikiafriadi/Desktop/Monetra/Project/cms`  
> Laravel: ^12.0, PHP: ^8.2

---

## RINGKASAN EKSEKUTIF

Secara keseluruhan proyek ini **cukup bersih** — tidak ada dead code yang masif. Masalah utamanya adalah:

1. **4 FormRequest class tidak dipakai** (ada tapi controller tidak type-hint mereka)
2. **SeoHelper.php tidak dipakai sama sekali** (semua fungsinya sudah ada duplikat di model)
3. **CheckRole middleware tidak di-alias ke routes** (ada tapi routes pakai `permission:`, bukan `role:`)
4. **5 view file adalah backup/draft** tidak direferensi (`index-ajax`, `index-backup`, `show-new`, `show-simple`)
5. **`league/commonmark` tidak dipakai** di codebase
6. **`spatie/laravel-sitemap`** tidak dipakai (sitemap dibuild manual di `SitemapController`)
7. **Email verification routes ada tapi `MustVerifyEmail` tidak diaktifkan** di User model
8. **`PasswordController` dari auth.php** tidak dipakai (profile password update pakai route berbeda)
9. **`AppLayout` dan `GuestLayout` View Components** tidak dipakai (tidak ada `layouts/app.blade.php` atau `layouts/guest.blade.php`)
10. **`AdSlot` Blade Component** tidak dipakai di views manapun (views pakai inline `foreach` langsung)
11. **`replied_at` tidak pernah di-set** di `markAsReplied()` method Contact model
12. **`country` dan `city` di `AdAnalytic`** selalu null — tidak pernah diisi di controller
13. **`canonical_url`** ada di semua FormRequest tapi sudah dihapus dari database di migration

---

## TIDAK DIPAKAI (bisa dihapus)

### 1. `SeoHelper.php` — Seluruh class tidak dipakai

**File:** `app/Helpers/SeoHelper.php`

**Bukti:** Grep atas seluruh `app/`, `resources/`, dan `routes/` tidak menemukan satu pun panggilan ke class ini.

```bash
grep -rn "SeoHelper" /Users/dikiafriadi/Desktop/Monetra/Project/cms/app \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/resources \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/routes
# Hasil: hanya SeoHelper.php itu sendiri (class definition)
```

**Analisis per-method:**
- `generateSlug()` — duplikat dari `spatie/laravel-sluggable` yang sudah dipakai di Post, Category, Tag
- `calculateReadingTime()` — sudah ada duplikat langsung di `Post::getReadingTimeAttribute()` dan `Post::calculateSeoScore()`  
- `generateMetaDescription()` — ada duplikat langsung di `Post::getMetaDescriptionAttribute()` dan `Page::getMetaDescriptionAttribute()`
- `calculateSeoScore()` — sudah ada di `Post::calculateSeoScore()` yang LEBIH LENGKAP
- `generateOpenGraph()`, `generateTwitterCard()`, `generateStructuredData()` — sudah ada di `Post::generateOpenGraphData()` dan `Page::generateOpenGraphData()`
- `sanitizeHtml()` — tidak dipakai, ada sanitize lebih lengkap di `Ad::sanitizeAdCode()`
- `extractKeywords()` — tidak dipakai di mana pun

**Rekomendasi:** Hapus `app/Helpers/SeoHelper.php` sepenuhnya.

---

### 2. FormRequest Classes — Ada 4 yang tidak di-type-hint controller

**Files:**
- `app/Http/Requests/StorePostRequest.php`
- `app/Http/Requests/UpdatePostRequest.php`
- `app/Http/Requests/StorePageRequest.php`
- `app/Http/Requests/UpdatePageRequest.php`

**Bukti:**

```bash
grep -n "use.*Request" app/Http/Controllers/Admin/PostController.php
# Hasil: use Illuminate\Http\Request;  ← plain Request, bukan StorePostRequest

grep -n "use.*Request" app/Http/Controllers/Admin/PageController.php
# Hasil: use Illuminate\Http\Request;  ← plain Request, bukan StorePageRequest
```

`PostController::store()`, `PostController::update()`, `PageController::store()`, `PageController::update()` semuanya type-hint `Illuminate\Http\Request` biasa dan mengulang validasi inline di controller. FormRequest classes ini dibuat tapi tidak pernah disambungkan.

**Catatan:** `ProfileUpdateRequest` juga tidak dipakai di `ProfileController` — controller tersebut validasi inline juga.

**Rekomendasi (pilih salah satu):**
- **Opsi A (disarankan):** Hapus ke-5 FormRequest class karena controller sudah validate inline. Kondisi saat ini adalah duplikasi aturan validasi.
- **Opsi B:** Ganti type-hint di controller dari `Request` ke FormRequest masing-masing, dan hapus inline validation. Ini cara "benar" Laravel tapi butuh effort refactor.

---

### 3. `CheckRole` Middleware — Ada tapi tidak di-route manapun

**File:** `app/Http/Middleware/CheckRole.php`

**Bukti:** Semua route admin menggunakan `middleware('permission:...')` dari `spatie/laravel-permission`. Tidak ada satu route pun yang menggunakan `middleware('role:...')` atau `check.role`. Middleware `CheckRole` juga tidak di-alias di `bootstrap/app.php`.

```bash
grep -rn "check\.role\|CheckRole\|middleware.*role:" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/app \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/routes
# Hasil: hanya class definition di CheckRole.php
```

Catatan: alias `role` di `bootstrap/app.php` mengarah ke `Spatie\Permission\Middleware\RoleMiddleware`, bukan ke `CheckRole`.

**Rekomendasi:** Hapus `app/Http/Middleware/CheckRole.php`.

---

### 4. View Files — Backup & Draft tidak dipakai

**Files yang tidak pernah di-render:**

| File | Keterangan |
|------|-----------|
| `resources/views/frontend/templates/default/blog/index-backup.blade.php` | Backup lama dari index.blade.php |
| `resources/views/frontend/templates/default/blog/index-ajax.blade.php` | Versi ajax yang tidak pernah direferensi |
| `resources/views/admin/contacts/show-new.blade.php` | Draft UI kontak baru |
| `resources/views/admin/contacts/show-simple.blade.php` | Versi simpel yang tidak dipakai |
| `resources/views/emails/contact-form.blade.php` | Email template yang tidak ada Mailable-nya |

**Bukti:**
```bash
grep -rn "index-ajax\|index-backup\|show-new\|show-simple\|contact-form" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/app \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/resources
# Hasil: tidak ada referensi (exit code 1)
```

`emails/contact-form.blade.php` tidak memiliki Mailable class yang merendernya. Tiga Mailable yang ada (`ContactNotification`, `ContactAutoReply`, `ContactReplyMail`) menggunakan view `emails/contact-notification`, `emails/contact-auto-reply`, dan `emails/contact-reply`.

**Rekomendasi:** Hapus 5 file tersebut.

---

### 5. `AppLayout` dan `GuestLayout` View Components — Tidak ada template-nya

**Files:**
- `app/View/Components/AppLayout.php` — merujuk `layouts.app` yang tidak ada
- `app/View/Components/GuestLayout.php` — merujuk `layouts.guest` yang tidak ada

**Bukti:**
```bash
grep -rn "x-app-layout\|x-guest-layout\|layouts\.app\|layouts\.guest" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/resources/views
# Hasil: kosong — tidak ada penggunaan
```

Folder `resources/views/layouts/` hanya berisi `admin.blade.php` dan `partials/admin-nav.blade.php`. Tidak ada `app.blade.php` atau `guest.blade.php`.

**Rekomendasi:** Hapus `app/View/Components/AppLayout.php` dan `app/View/Components/GuestLayout.php`.

---

### 6. `AdSlot` Blade Component — Tidak dipakai di views

**File:** `app/View/Components/AdSlot.php` + `resources/views/components/ad-slot.blade.php`

**Bukti:**
```bash
grep -rn "x-ad-slot\|<x-ad-slot" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/resources/views
# Hasil: kosong — tidak ada penggunaan
```

Semua views merender ads secara inline langsung (loop `foreach` atas koleksi `$ads[...]`), bukan via Blade component `<x-ad-slot>`.

**Rekomendasi:** Hapus `app/View/Components/AdSlot.php` dan `resources/views/components/ad-slot.blade.php`. **Atau** (jika ingin pakai component ke depan) refactor views untuk menggunakan `<x-ad-slot>` — ini sebenarnya cara yang lebih bersih.

---

### 7. `league/commonmark` — Dependency tidak terpakai

**composer.json:**
```json
"league/commonmark": "^2.5"
```

**Bukti:**
```bash
grep -rn "CommonMark\|commonmark\|Markdown\|markdown" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/app \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/resources
# Hasil: kosong — tidak ada penggunaan
```

Tidak ada satu pun file yang menggunakan `CommonMark`, parsing markdown, atau apapun dari package ini. Konten CMS menggunakan TinyMCE (WYSIWYG HTML), bukan Markdown.

**Rekomendasi:**
```bash
cd /Users/dikiafriadi/Desktop/Monetra/Project/cms
composer remove league/commonmark
```

---

### 8. `spatie/laravel-sitemap` — Dependency tidak terpakai

**composer.json:**
```json
"spatie/laravel-sitemap": "^7.2"
```

**Bukti:**
```bash
grep -rn "Spatie\\\\Sitemap\|SitemapFactory\|SitemapGenerator" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/app
# Hasil: kosong — tidak ada penggunaan
```

`SitemapController.php` membangun sitemap sendiri secara manual menggunakan string XML concatenation + caching. Tidak ada penggunaan apapun dari library `spatie/laravel-sitemap`.

**Rekomendasi:**
```bash
cd /Users/dikiafriadi/Desktop/Monetra/Project/cms
composer remove spatie/laravel-sitemap
```

---

### 9. Email Verification Routes — Tidak Aktif

**Files:**
- `app/Http/Controllers/Auth/EmailVerificationPromptController.php`
- `app/Http/Controllers/Auth/EmailVerificationNotificationController.php`
- `app/Http/Controllers/Auth/VerifyEmailController.php`
- `resources/views/auth/verify-email.blade.php`
- Routes di `routes/auth.php` (verification.notice, verification.verify, verification.send)

**Bukti:**
```bash
grep -n "MustVerifyEmail" /Users/dikiafriadi/Desktop/Monetra/Project/cms/app/Models/User.php
# Hasil: // use Illuminate\Contracts\Auth\MustVerifyEmail; ← DI-COMMENT OUT
```

`User` model tidak mengimplementasikan `MustVerifyEmail` interface, artinya email verification **tidak pernah dipicu**. Semua controller dan route terkait verification tidak akan pernah dieksekusi dalam alur normal.

**Rekomendasi:** Jika tidak ada rencana mengaktifkan email verification, hapus:
- 3 controller di `app/Http/Controllers/Auth/` (EmailVerification*, Verify*)
- `resources/views/auth/verify-email.blade.php`
- 3 routes di `routes/auth.php` (baris verification.notice, verify, send)

---

### 10. `PasswordController` (auth.php) — Tidak Dipakai

**File:** `app/Http/Controllers/Auth/PasswordController.php`

**Route:** `PUT /password` → `password.update` (di `routes/auth.php`)

**Bukti:** Profile password update di admin menggunakan route `admin.profile.password.update` (mengarah ke `Admin\ProfileController::updatePassword()`), bukan `password.update`. Tidak ada view yang link ke `route('password.update')`.

```bash
grep -rn "route.*password\.update\|password\.update" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/resources/views
# Hasil: hanya /admin/profile/edit.blade.php yang pakai 'admin.profile.password.update'
```

**Rekomendasi:** Hapus `app/Http/Controllers/Auth/PasswordController.php` dan hapus baris `Route::put('password', ...)` dari `routes/auth.php`.

---

## REDUNDAN / DUPLIKAT

### 11. SEO Score Calculation — Duplikat di 2 tempat

`Post::calculateSeoScore()` (di `app/Models/Post.php`) dan `SeoHelper::calculateSeoScore()` (di `app/Helpers/SeoHelper.php`) adalah duplikat logika yang sama. Versi di Model **lebih akurat** karena tahu tentang relasi `tags` (bisa eager-load), sedangkan versi di SeoHelper hanya menerima plain array.

**Yang dipakai:** Versi di `Post` model (dipanggil di `saving` event).  
**Yang tidak dipakai:** Versi di `SeoHelper` (tidak dipanggil di mana pun).

**Rekomendasi:** Hapus `SeoHelper.php` (sudah disebut di atas).

---

### 12. FormRequest vs Inline Validation — Duplikat aturan validasi

Aturan validasi untuk `store` dan `update` post/page **ada di dua tempat**:
1. FormRequest classes (`StorePostRequest`, `UpdatePostRequest`, dll.)
2. Inline `$request->validate([...])` di masing-masing controller

Karena controller **menggunakan yang inline** (bukan FormRequest), aturan di FormRequest tidak aktif. Ini berbahaya karena jika seseorang mengira FormRequest sudah diterapkan, mereka mungkin mengedit di sana tanpa efek apapun.

**Rekomendasi:** Hapus FormRequest yang tidak dipakai, atau wire mereka ke controller dengan mengganti type-hint.

---

### 13. `TemplateService::viewExists()` — Tidak dipakai

**File:** `app/Services/TemplateService.php`, method `viewExists()`

**Bukti:**
```bash
grep -rn "viewExists" /Users/dikiafriadi/Desktop/Monetra/Project/cms/app
# Hasil: hanya di TemplateService.php itu sendiri
```

Fungsi `getView()` sudah secara internal mengecek `view()->exists()`. Method `viewExists()` public adalah duplikasi yang tidak pernah dipanggil dari luar.

**Rekomendasi:** Hapus method `viewExists()` dari `TemplateService`.

---

### 14. `partials/blog-category-filters.blade.php` dan `partials/blog-posts.blade.php`

**Files:**
- `resources/views/partials/blog-category-filters.blade.php`
- `resources/views/partials/blog-posts.blade.php`

**Bukti:**
```bash
grep -rn "blog-category-filters\|blog-posts" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/app \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/resources
# Hasil: kosong — tidak ada referensi
```

Dua partial ini di root `resources/views/partials/` tidak pernah di-`@include` dari mana pun. Ini berbeda dengan `partials/pagination-custom.blade.php` yang memang dipakai.

**Rekomendasi:** Hapus keduanya.

---

## PERLU DIUBAH (ada bug atau cara lebih baik)

### 15. BUG: `Contact::markAsReplied()` tidak set `replied_at`

**File:** `app/Models/Contact.php`

```php
// Saat ini:
public function markAsReplied()
{
    $this->update(['status' => 'replied']);
    // ← replied_at TIDAK DIISI!
}
```

Field `replied_at` ada di `$fillable` dan migrasinya juga ada (`2026_02_06_144711_add_replied_at_to_contacts_table.php`), tapi tidak pernah di-set. Akibatnya kolom `replied_at` selalu `NULL` meskipun contact sudah dibalas.

**Perbaikan:**
```php
public function markAsReplied()
{
    $this->update([
        'status'      => 'replied',
        'replied_at'  => now(), // ← tambahkan ini
    ]);
}
```

---

### 16. Dead Database Columns: `country` dan `city` di `ad_analytics`

**File:** `app/Models/AdAnalytic.php` — ada di `$fillable`  
**Migration:** `2026_02_13_081940_create_ad_analytics_table.php`

**Bukti:**
```bash
grep -rn "'country'\|'city'" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/app/Http/Controllers/Admin/AdAnalyticsController.php
# Hasil: kosong — tidak pernah diisi
```

`AdAnalyticsController::createAnalyticEvent()` tidak pernah mengisi `country` atau `city`. Kolom ini selalu `NULL`. Juga tidak ada di tampilan analytics manapun.

**Rekomendasi:** Hapus `country` dan `city` dari `$fillable` AdAnalytic model. Jika kolom di DB tidak dipakai, buat migration untuk `dropColumn` untuk membersihkan schema.

---

### 17. `canonical_url` di FormRequest — Field yang sudah dihapus dari DB

**Files:** Semua 4 FormRequest + `UpdatePageRequest.php` memiliki rule `'canonical_url' => 'nullable|url'`

**Migration:** `2026_02_06_105714_remove_canonical_url_from_posts_and_pages_tables.php` — kolom sudah DIHAPUS dari database.

Akibatnya, jika FormRequest dipakai (setelah diperbaiki dari issue #2), validasi `canonical_url` akan melalui validation tapi field tidak tersimpan ke DB. Ini membingungkan.

**Rekomendasi:** Hapus `canonical_url` dari semua FormRequest.

---

### 18. `ConfirmablePasswordController` — Kemungkinan tidak dibutuhkan

**File:** `app/Http/Controllers/Auth/ConfirmablePasswordController.php`  
**Route:** `GET/POST /confirm-password` 

Fitur ini hanya diperlukan untuk flow tertentu di Breeze/Jetstream ketika ada aksi sensitif yang membutuhkan konfirmasi password. Di proyek ini tidak ada middleware `password.confirm` yang dipakai di route admin.

```bash
grep -rn "password\.confirm\|middleware.*password" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/routes
# Hasil: hanya definisi route itu sendiri
```

**Rekomendasi:** Aman untuk dihapus jika tidak ada rencana menggunakan middleware `password.confirm` di masa mendatang. View `auth/confirm-password.blade.php` bisa dihapus juga.

---

### 19. `AdAnalytic::getTopPerformingAds()` — Method tidak dipanggil

**File:** `app/Models/AdAnalytic.php`, method `getTopPerformingAds()`

**Bukti:**
```bash
grep -rn "getTopPerformingAds" /Users/dikiafriadi/Desktop/Monetra/Project/cms/app
# Hasil: hanya definisi di AdAnalytic.php
```

`AdAnalyticsController::index()` tidak menggunakan method ini — ia menggunakan query inline sendiri.

**Rekomendasi:** Hapus method ini dari AdAnalytic model, atau gunakan di controller untuk menggantikan kode duplikat.

---

### 20. `AdAnalytic` Scopes tidak semua dipakai

**Scopes yang ADA tapi tidak dipakai di luar AdAnalytic model:**
- `scopeThisWeek()` — tidak dipanggil di controller manapun
- `scopeThisMonth()` — tidak dipanggil di controller manapun
- `scopeLastDays()` — tidak dipanggil di controller manapun
- `scopeToday()` — tidak dipanggil di controller manapun
- `scopeDateRange()` — hanya dipanggil dari dalam AdAnalytic itu sendiri

**Yang dipakai controller:** `scopeImpressions()`, `scopeClicks()` — yang dua ini memang dipakai.

**Rekomendasi:** Hapus scopes yang tidak dipakai (`ThisWeek`, `ThisMonth`, `LastDays`, `Today`) untuk mengurangi surface area. `DateRange` bisa dipertahankan karena berguna.

---

### 21. `Post::latestPublished()` — Tidak dipakai di controllers

**File:** `app/Models/Post.php`, method `latestPublished()`

**Bukti:**
```bash
grep -rn "latestPublished" /Users/dikiafriadi/Desktop/Monetra/Project/cms/app
# Hasil: hanya definisi di Post.php
```

Semua controller yang butuh post terbaru langsung query `Post::published()->with(...)->latest('published_at')->limit(6)->get()` secara inline. `latestPublished()` tidak dipakai.

**Rekomendasi:** Hapus method ini, atau gunakan secara konsisten di controller untuk menghindari duplikat query.

---

### 22. Cara lebih modern: `env()` di AppServiceProvider di luar `config()`

**File:** `app/Providers/AppServiceProvider.php`

```php
// Saat ini:
$forceHttps = env('FORCE_HTTPS', false) || config('app.env') === 'production' || ...
```

Memanggil `env()` langsung di AppServiceProvider tidak aman saat config di-cache (`php artisan config:cache`). Setelah config dicache, `env()` selalu mengembalikan `null` untuk env vars yang tidak ada di config.

**Cara yang benar:**
1. Tambahkan ke `config/app.php`: `'force_https' => env('FORCE_HTTPS', false)`
2. Di AppServiceProvider: gunakan `config('app.force_https')` bukan `env('FORCE_HTTPS')`

---

## SUDAH BAIK ✅

Bagian-bagian berikut sudah clean dan tidak perlu perubahan:

| Komponen | Status |
|----------|--------|
| `SettingsCache.php` | Baik — caching agregat settings untuk view composer |
| `MailConfigService.php` | Baik — DB-driven mail config dengan proper cache invalidation |
| `TemplateService.php` | Baik — clean abstraction untuk multi-template system |
| `GoogleAnalyticsService.php` | Baik — service class dengan proper error handling |
| `CheckUserActive` middleware | Baik — terdaftar di auth group, aktif dipakai |
| `SecurityHeaders` middleware | Baik — global middleware, aktif dipakai |
| `RefreshPermissions` command | Baik — dipakai di deploy script |
| `helpers.php` (5 fungsi) | Baik — semua 5 fungsi dipakai: `storage_url`, `favicon_url`, `asset_version`, `format_date`/`format_datetime`/`time_ago` (via views), `safe_like_input` |
| `SitemapController` | Baik — custom sitemap yang efisien dengan chunking dan multi-level caching |
| Model boot events | Baik — cache invalidation sudah di semua model yang relevan |
| Policies (Post, Page, Category, Ad) | Baik — terdaftar di AppServiceProvider, dipakai via Gate |
| `spatie/laravel-permission` | Baik — dipakai secara ekstensif |
| `spatie/laravel-backup` | Baik — di-schedule di console.php |
| `spatie/laravel-sluggable` | Baik — dipakai di Post, Page, Category, Tag |
| `spatie/laravel-analytics` | Baik — dipakai di GoogleAnalyticsService |
| `intervention/image` | Baik — dipakai di MediaController dan AdController |
| `SoftDeletes` di Post, Page, User | Baik — dengan restore/forceDelete endpoints |
| Scheduled jobs di console.php | Baik — publish-scheduled-posts, prune-ad-analytics, backup |
| Contact reply system | Baik — 3 Mailable berbeda untuk use case berbeda |
| Ad rotation & analytics tracking | Baik — sistem lengkap dengan deduplication |
| Template system (5 template) | Baik — dengan fallback ke `frontend.*` views |
| Setting encryption (mail_password, ga_credentials) | Baik — enkripsi transparan di getter/setter |

---

## RINGKASAN TINDAKAN

### Prioritas Tinggi (bug nyata)
1. **FIX:** `Contact::markAsReplied()` — tambahkan `'replied_at' => now()`

### Prioritas Sedang (dead code yang bisa dihapus)
2. **HAPUS:** `app/Helpers/SeoHelper.php`
3. **HAPUS:** `app/Http/Middleware/CheckRole.php`
4. **HAPUS:** `app/View/Components/AppLayout.php` + `GuestLayout.php`
5. **HAPUS:** `app/View/Components/AdSlot.php` + `resources/views/components/ad-slot.blade.php`  
   *(atau refactor views untuk MENGGUNAKANNYA — pilih salah satu)*
6. **HAPUS 5 view backup:** `index-ajax`, `index-backup`, `show-new`, `show-simple`, `emails/contact-form`
7. **HAPUS 2 partial:** `partials/blog-category-filters.blade.php`, `partials/blog-posts.blade.php`
8. **HAPUS Auth controllers:** EmailVerification*, VerifyEmail, Password controllers (jika tidak diaktifkan)
9. **PUTUSKAN:** FormRequest — hapus atau wire ke controller

### Prioritas Rendah (dependencies)
10. **REMOVE COMPOSER:** `league/commonmark` (tidak dipakai)
11. **REMOVE COMPOSER:** `spatie/laravel-sitemap` (tidak dipakai)

### Perbaikan Teknis
12. **FIX:** `env()` di AppServiceProvider — pindahkan ke config()
13. **BERSIHKAN:** Hapus `canonical_url` dari semua FormRequest
14. **BERSIHKAN:** Hapus scopes AdAnalytic yang tidak dipakai
15. **BERSIHKAN:** Hapus `country`/`city` dari AdAnalytic `$fillable` (atau buat migration drop column)

---

## COMMANDS VERIFIKASI

```bash
# Cek SeoHelper tidak dipakai
grep -rn "SeoHelper" /Users/dikiafriadi/Desktop/Monetra/Project/cms/app \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/resources /Users/dikiafriadi/Desktop/Monetra/Project/cms/routes

# Cek CheckRole tidak dipakai
grep -rn "CheckRole\|check\.role\|'role:'" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/app /Users/dikiafriadi/Desktop/Monetra/Project/cms/routes

# Cek FormRequest tidak di-type-hint
grep -n "function store\|function update" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/app/Http/Controllers/Admin/PostController.php
grep -n "function store\|function update" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/app/Http/Controllers/Admin/PageController.php

# Cek view backup tidak direferensi
grep -rn "index-ajax\|index-backup\|show-new\|show-simple\|emails\.contact-form" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/app \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/resources

# Cek league/commonmark tidak dipakai
grep -rn "CommonMark\|commonmark\|Markdown" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/app \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/resources

# Cek spatie/laravel-sitemap tidak dipakai
grep -rn "Spatie\\\\Sitemap\|SitemapFactory" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/app

# Cek MustVerifyEmail tidak aktif
grep -n "MustVerifyEmail" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/app/Models/User.php

# Cek replied_at tidak di-set
grep -n "markAsReplied" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/app/Models/Contact.php

# Cek country/city tidak diisi
grep -rn "'country'\|'city'" \
  /Users/dikiafriadi/Desktop/Monetra/Project/cms/app/Http/Controllers/Admin/AdAnalyticsController.php
```
