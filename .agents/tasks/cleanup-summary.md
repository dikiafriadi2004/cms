# Dead Code Cleanup Summary

> Tanggal: Sesuai waktu eksekusi  
> Commit: `c5f9087`  
> Branch: `main`

---

## 1. File yang Dihapus (18 file)

### PHP Classes
| File | Alasan |
|------|--------|
| `app/Helpers/SeoHelper.php` | Tidak ada satu pun pemanggilan — semua fungsinya duplikat dari method model |
| `app/Http/Middleware/CheckRole.php` | Tidak di-alias ke routes; routes pakai `spatie/laravel-permission`, bukan class ini |
| `app/View/Components/AppLayout.php` | Tidak ada view `layouts/app.blade.php` dan tidak dipakai di mana pun |
| `app/View/Components/GuestLayout.php` | Tidak ada view `layouts/guest.blade.php` dan tidak dipakai di mana pun |
| `app/View/Components/AdSlot.php` | Tidak ada penggunaan `<x-ad-slot>` di views manapun |
| `app/Http/Controllers/Auth/PasswordController.php` | Route `PUT /password` tidak dipakai; profile update pakai `admin.profile.password.update` |
| `app/Http/Controllers/Auth/EmailVerificationPromptController.php` | Email verification tidak aktif (`MustVerifyEmail` di-comment di User model) |
| `app/Http/Controllers/Auth/EmailVerificationNotificationController.php` | Sama — email verification tidak aktif |
| `app/Http/Controllers/Auth/VerifyEmailController.php` | Sama — email verification tidak aktif |

### FormRequest Classes (dihapus karena controller pakai inline validation)
| File | Alasan |
|------|--------|
| `app/Http/Requests/StorePostRequest.php` | PostController::store() pakai `$request->validate()` inline |
| `app/Http/Requests/UpdatePostRequest.php` | PostController::update() pakai `$request->validate()` inline |
| `app/Http/Requests/StorePageRequest.php` | PageController::store() pakai `$request->validate()` inline |
| `app/Http/Requests/UpdatePageRequest.php` | PageController::update() pakai `$request->validate()` inline |
| `app/Http/Requests/ProfileUpdateRequest.php` | ProfileController pakai `$request->validate()` inline |

### Blade Views
| File | Alasan |
|------|--------|
| `resources/views/components/ad-slot.blade.php` | Pasangan dari AdSlot component yang tidak dipakai |
| `resources/views/auth/verify-email.blade.php` | Email verification tidak aktif |
| `resources/views/frontend/templates/default/blog/index-backup.blade.php` | File backup lama, tidak direferensi |
| `resources/views/frontend/templates/default/blog/index-ajax.blade.php` | Draft versi ajax, tidak direferensi |
| `resources/views/admin/contacts/show-new.blade.php` | Draft UI baru, tidak direferensi |
| `resources/views/admin/contacts/show-simple.blade.php` | Draft simpel, tidak direferensi |
| `resources/views/emails/contact-form.blade.php` | Tidak ada Mailable class yang merendernya |
| `resources/views/partials/blog-category-filters.blade.php` | Tidak pernah di-`@include` dari mana pun |
| `resources/views/partials/blog-posts.blade.php` | Tidak pernah di-`@include` dari mana pun |

---

## 2. Routes yang Dihapus dari `routes/auth.php`

| Method | URI | Name | Alasan |
|--------|-----|------|--------|
| `PUT` | `/password` | `password.update` | PasswordController dihapus; password update lewat `admin.profile.password.update` |
| `GET` | `/verify-email` | `verification.notice` | Email verification tidak aktif |
| `GET` | `/email/verify/{id}/{hash}` | `verification.verify` | Email verification tidak aktif |
| `POST` | `/email/verification-notification` | `verification.send` | Email verification tidak aktif |

`use` statements yang dihapus dari `routes/auth.php`:
- `App\Http\Controllers\Auth\EmailVerificationNotificationController`
- `App\Http\Controllers\Auth\EmailVerificationPromptController`
- `App\Http\Controllers\Auth\PasswordController`
- `App\Http\Controllers\Auth\VerifyEmailController`

---

## 3. Composer Packages yang Dihapus

### `spatie/laravel-sitemap` ^7.2 — BERHASIL dihapus
Package ini dan 6 dependensinya dihapus:
- `spatie/laravel-sitemap` 7.3.8
- `spatie/browsershot` 5.2.0
- `spatie/crawler` 8.4.7
- `spatie/robots-txt` 2.5.3
- `masterminds/html5` 2.10.0
- `nicmart/tree` 0.10.1
- `symfony/dom-crawler` v7.4.4

**Alasan:** `SitemapController` membangun sitemap sendiri secara manual (XML concatenation + caching). Library ini tidak dipakai sama sekali.

### `league/commonmark` — TIDAK DIHAPUS (tidak perlu)
Package ini **tidak ada** di `composer.json` proyek secara langsung. Ia adalah transitive dependency dari `laravel/framework` (Laravel membutuhkannya). Audit menyebutkan untuk menghapusnya karena tidak dipakai di kode, tapi ternyata tidak pernah ada di `require` proyek secara eksplisit — jadi tidak ada yang perlu dihapus.

---

## 4. Bug yang Diperbaiki

### BUG: `Contact::markAsReplied()` tidak set `replied_at`

**Sebelum:**
```php
public function markAsReplied()
{
    $this->update(['status' => 'replied']);
}
```

**Sesudah:**
```php
public function markAsReplied()
{
    $this->update([
        'status'     => 'replied',
        'replied_at' => now(),
    ]);
}
```

Kolom `replied_at` sekarang di-set dengan benar ketika kontak dibalas. Sebelumnya selalu `NULL` meski kontak sudah dibalas.

---

## 5. Perbaikan Teknis

### Fix: `env()` langsung di `AppServiceProvider` → diganti `config()`

**File:** `app/Providers/AppServiceProvider.php`

**Masalah:** Memanggil `env('FORCE_HTTPS')` langsung di ServiceProvider tidak aman setelah `php artisan config:cache` — setelah config di-cache, `env()` mengembalikan `null` untuk semua env var yang tidak ada di default PHP env.

**Perbaikan:** 
- Tambahkan `'force_https' => env('FORCE_HTTPS', false)` ke `config/app.php`
- Ganti `env('FORCE_HTTPS', false)` di AppServiceProvider menjadi `config('app.force_https', false)`
- Logika juga diperketat: sebelumnya force HTTPS selalu aktif di production tanpa syarat, sekarang hanya aktif di production jika request memang sudah secure

**Sebelum:**
```php
$forceHttps = env('FORCE_HTTPS', false)
    || config('app.env') === 'production'
    || request()->header('X-Forwarded-Proto') === 'https';
```

**Sesudah:**
```php
$forceHttps = config('app.force_https', false)
    || (config('app.env') === 'production' && request()->isSecure())
    || request()->header('X-Forwarded-Proto') === 'https';
```

### Cleanup: `AdAnalytic` model

- Hapus `'country'` dan `'city'` dari `$fillable` — kolom ini tidak pernah diisi di controller, selalu `NULL`
- Hapus `scopeToday()`, `scopeThisWeek()`, `scopeThisMonth()`, `scopeLastDays()` — tidak dipanggil dari luar model
- Hapus `getTopPerformingAds()` — tidak dipanggil di mana pun; controller punya query inline sendiri

### Cleanup: `Post` model
- Hapus `latestPublished()` — tidak dipakai di controller manapun; semua query post terbaru dilakukan inline

### Cleanup: `TemplateService`
- Hapus `viewExists()` — tidak dipanggil dari luar; `getView()` sudah melakukan pengecekan yang sama secara internal

---

## 6. Hasil Verifikasi

```
php artisan config:clear  →  ✅ Configuration cache cleared successfully.
php artisan cache:clear   →  ✅ Application cache cleared successfully.
php artisan view:clear    →  ✅ Compiled views cleared successfully.
php artisan route:clear   →  ✅ Route cache cleared successfully.
php artisan route:list    →  ✅ No errors, routes listed correctly
php artisan config:show app | grep force_https  →  ✅ force_https: false
```

Output `config:show app` (grep):
```
  env .................................................................................. local  
  url ........................................................................ http://cms.test  
  frontend_url ......................................................... http://localhost:3000  
  asset_url ..................................................................................  
  force_https .......................................................................... false  
```

---

## 7. Item yang Tidak Bisa Dikerjakan / Catatan

| Item | Status | Catatan |
|------|--------|---------|
| `composer remove league/commonmark` | ⚠️ Tidak diperlukan | Package ini tidak ada di `composer.json` proyek secara eksplisit — ia transitive dep dari `laravel/framework` dan tidak bisa dihapus. Audit salah mengidentifikasi ini sebagai dep langsung. |
| Drop kolom `country`/`city` di database | ⏭️ Di-skip (di luar scope) | Audit menyebut membuat migration untuk `dropColumn`. Ini tidak ada di instruksi eksekusi dan merupakan perubahan schema database yang butuh keputusan terpisah. `$fillable` sudah dibersihkan. |

---

## Ringkasan Singkat

- **23 file dihapus** (9 PHP classes + 5 FormRequests + 9 blade views)
- **4 routes dihapus** dari `routes/auth.php`
- **1 composer package dihapus** (`spatie/laravel-sitemap` + 6 transitive deps)
- **1 bug diperbaiki** (`Contact::markAsReplied()`)
- **1 perbaikan teknis** (`env()` → `config()` di AppServiceProvider + `force_https` di config/app.php)
- **5 method/scope dihapus** dari 3 model/service
- Semua artisan verification commands **lulus tanpa error**
