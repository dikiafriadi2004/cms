<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Add missing indexes for performance.
 *
 * Adds indexes on columns that are frequently used in WHERE / ORDER BY
 * clauses across the public frontend and admin queries:
 * - posts.views_count (popular posts ordering)
 * - posts.status + published_at (already used by published scope)
 * - ads.start_date / end_date (active scope)
 * - contacts.email (search)
 * - contacts.status (filter)
 * - menu_items.parent_id (children lookup, FK already indexed in most cases but ensure)
 *
 * Each index is wrapped in an existence check so the migration is idempotent.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (!$this->indexExists('posts', 'posts_views_count_index')) {
                $table->index('views_count', 'posts_views_count_index');
            }
            if (!$this->indexExists('posts', 'posts_status_published_at_index')) {
                $table->index(['status', 'published_at'], 'posts_status_published_at_index');
            }
        });

        Schema::table('ads', function (Blueprint $table) {
            if (!$this->indexExists('ads', 'ads_active_dates_index')) {
                $table->index(['is_active', 'start_date', 'end_date'], 'ads_active_dates_index');
            }
            if (!$this->indexExists('ads', 'ads_position_index')) {
                $table->index('position', 'ads_position_index');
            }
        });

        Schema::table('contacts', function (Blueprint $table) {
            if (!$this->indexExists('contacts', 'contacts_email_index')) {
                $table->index('email', 'contacts_email_index');
            }
            if (!$this->indexExists('contacts', 'contacts_status_index')) {
                $table->index('status', 'contacts_status_index');
            }
        });

        if (Schema::hasTable('ad_analytics')) {
            Schema::table('ad_analytics', function (Blueprint $table) {
                if (!$this->indexExists('ad_analytics', 'ad_analytics_event_date_index')) {
                    $table->index('event_date', 'ad_analytics_event_date_index');
                }
                if (!$this->indexExists('ad_analytics', 'ad_analytics_event_type_index')) {
                    $table->index('event_type', 'ad_analytics_event_type_index');
                }
            });
        }

        Schema::table('users', function (Blueprint $table) {
            if (!$this->indexExists('users', 'users_is_active_index')) {
                $table->index('is_active', 'users_is_active_index');
            }
        });
    }
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if ($this->indexExists('posts', 'posts_views_count_index')) {
                $table->dropIndex('posts_views_count_index');
            }
            if ($this->indexExists('posts', 'posts_status_published_at_index')) {
                $table->dropIndex('posts_status_published_at_index');
            }
        });

        Schema::table('ads', function (Blueprint $table) {
            if ($this->indexExists('ads', 'ads_active_dates_index')) {
                $table->dropIndex('ads_active_dates_index');
            }
            if ($this->indexExists('ads', 'ads_position_index')) {
                $table->dropIndex('ads_position_index');
            }
        });

        Schema::table('contacts', function (Blueprint $table) {
            if ($this->indexExists('contacts', 'contacts_email_index')) {
                $table->dropIndex('contacts_email_index');
            }
            if ($this->indexExists('contacts', 'contacts_status_index')) {
                $table->dropIndex('contacts_status_index');
            }
        });

        if (Schema::hasTable('ad_analytics')) {
            Schema::table('ad_analytics', function (Blueprint $table) {
                if ($this->indexExists('ad_analytics', 'ad_analytics_event_date_index')) {
                    $table->dropIndex('ad_analytics_event_date_index');
                }
                if ($this->indexExists('ad_analytics', 'ad_analytics_event_type_index')) {
                    $table->dropIndex('ad_analytics_event_type_index');
                }
            });
        }

        Schema::table('users', function (Blueprint $table) {
            if ($this->indexExists('users', 'users_is_active_index')) {
                $table->dropIndex('users_is_active_index');
            }
        });
    }

    private function indexExists(string $table, string $index): bool
    {
        $database = DB::connection()->getDatabaseName();
        $result = DB::selectOne(
            'SELECT COUNT(*) AS cnt FROM information_schema.statistics WHERE table_schema = ? AND table_name = ? AND index_name = ?',
            [$database, $table, $index]
        );
        return $result && (int) $result->cnt > 0;
    }
};
