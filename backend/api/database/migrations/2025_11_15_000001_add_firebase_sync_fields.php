<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firebase_id')->nullable()->after('id');
            $table->timestamp('firebase_synced_at')->nullable()->after('updated_at');
            $table->index('firebase_id');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->string('firebase_id')->nullable()->after('id');
            $table->timestamp('firebase_synced_at')->nullable()->after('updated_at');
            $table->index('firebase_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['firebase_id']);
            $table->dropColumn(['firebase_id', 'firebase_synced_at']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['firebase_id']);
            $table->dropColumn(['firebase_id', 'firebase_synced_at']);
        });
    }
};