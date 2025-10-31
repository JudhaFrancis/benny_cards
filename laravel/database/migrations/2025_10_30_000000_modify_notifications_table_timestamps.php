<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ModifyNotificationsTableTimestamps extends Migration
{
    public function up()
    {
        // Check if timestamps already exist BEFORE altering table
        $hasCreatedAt = Schema::hasColumn('notifications', 'created_at');
        $hasUpdatedAt = Schema::hasColumn('notifications', 'updated_at');

        Schema::table('notifications', function (Blueprint $table) use ($hasCreatedAt, $hasUpdatedAt) {
            // 🗑 Remove old timestamps if present
            if ($hasCreatedAt && $hasUpdatedAt) {
                $table->dropColumn(['created_at', 'updated_at']);
            }
        });

        // ⚡ Run a separate alter statement to add them back cleanly
        Schema::table('notifications', function (Blueprint $table) {
            if (!Schema::hasColumn('notifications', 'created_at')) {
                $table->timestamp('created_at')->nullable()->after('recipient_mobile_no');
            }
            if (!Schema::hasColumn('notifications', 'updated_at')) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            }
        });
    }

    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            if (Schema::hasColumn('notifications', 'created_at')) {
                $table->dropColumn(['created_at', 'updated_at']);
            }

            $table->timestamps();
        });
    }
}
