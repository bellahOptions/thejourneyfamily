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
        Schema::table('retreat_registrations', function (Blueprint $table) {
            $table->dropColumn('wedding_anniversary');
            $table->unsignedTinyInteger('anniversary_day')->after('email');
            $table->unsignedTinyInteger('anniversary_month')->after('anniversary_day');
            $table->string('transport_notes')->nullable()->after('transport_status');
            $table->text('payment_proof_note')->nullable()->after('payment_made');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('retreat_registrations', function (Blueprint $table) {
            $table->date('wedding_anniversary')->nullable()->after('email');
            $table->dropColumn(['anniversary_day', 'anniversary_month', 'transport_notes', 'payment_proof_note']);
        });
    }
};
