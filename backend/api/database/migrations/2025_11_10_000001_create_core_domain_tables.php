<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // User roles (allow multiple roles per user: client, provider, admin)
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('role', 32); // client|provider|admin
            $table->timestamps();
            $table->unique(['user_id', 'role']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Preferred mode (client or provider) per user
        Schema::create('user_modes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('mode', 32); // client|provider
            $table->timestamps();
            $table->unique('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Service provider applications
        Schema::create('provider_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // applicant may pre-exist or not
            $table->string('email');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->text('experience')->nullable();
            $table->json('services')->nullable();
            $table->string('status', 32)->default('pending'); // pending|approved|rejected
            $table->timestamps();
            $table->index('email');
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });

        // Provider status per user (current approval state)
        Schema::create('provider_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('status', 32)->default('none'); // none|pending|approved
            $table->timestamps();
            $table->unique('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Providers profile (optional richer info)
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->json('service_categories')->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->string('status', 32)->default('none');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Bookings
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->string('service_name')->nullable();
            $table->date('scheduled_date')->nullable();
            $table->string('scheduled_time')->nullable();
            $table->text('address')->nullable();
            $table->decimal('lat', 10, 6)->nullable();
            $table->decimal('lng', 10, 6)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->string('status', 32)->default('pending');
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('provider_id')->references('id')->on('users')->nullOnDelete();
        });

        // Booking returns (issues after service)
        Schema::create('booking_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->json('issues')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });

        // Chat conversations keyed by booking
        Schema::create('chat_conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id')->unique();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamps();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('provider_id')->references('id')->on('users')->nullOnDelete();
        });

        // Chat messages (filterable by booking)
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('sender', 32); // client|provider
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->text('text');
            $table->timestamp('ts')->useCurrent();
            $table->timestamps();
            $table->index(['booking_id', 'ts']);
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('users')->nullOnDelete();
        });

        // OTP codes
        Schema::create('otp_codes', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('code', 12);
            $table->timestamp('expires_at');
            $table->timestamps();
            $table->index('email');
        });

        // System settings (singleton row)
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('system_name')->default('HausTap');
            $table->string('contact_email')->default('support@example.com');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('otp_codes');
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chat_conversations');
        Schema::dropIfExists('booking_returns');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('providers');
        Schema::dropIfExists('provider_statuses');
        Schema::dropIfExists('provider_applications');
        Schema::dropIfExists('user_modes');
        Schema::dropIfExists('user_roles');
    }
};