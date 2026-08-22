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
            $table->string('email')->nullable()->change();
            $table->string('package_key')->nullable()->change();
            $table->string('package_label')->nullable()->change();
            $table->unsignedInteger('package_price')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('retreat_registrations', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
            $table->string('package_key')->nullable(false)->change();
            $table->string('package_label')->nullable(false)->change();
            $table->unsignedInteger('package_price')->nullable(false)->change();
        });
    }
};
