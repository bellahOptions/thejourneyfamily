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
        Schema::create('retreat_registrations', function (Blueprint $table) {
            $table->id();
            $table->uuid('confirmation_token')->unique();
            $table->string('couple_name');
            $table->string('email');
            $table->date('wedding_anniversary');
            $table->string('participant_whatsapp', 30);
            $table->string('spouse_whatsapp', 30);
            $table->string('transport_status', 20);
            $table->string('bringing_children', 20);
            $table->string('children_ages')->nullable();
            $table->text('expectations')->nullable();
            $table->text('prayer_request')->nullable();
            $table->text('previous_feedback')->nullable();
            $table->string('payment_made', 10);
            $table->string('package_key');
            $table->string('package_label');
            $table->unsignedInteger('package_price');
            $table->text('questions')->nullable();
            $table->timestamp('consent_at');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['email', 'created_at']);
            $table->index(['package_key', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retreat_registrations');
    }
};
