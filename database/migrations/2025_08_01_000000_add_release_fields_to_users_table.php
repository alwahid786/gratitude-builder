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
            $table->boolean('release_signed')->default(false)->after('role');
            $table->text('release_signature')->nullable()->after('release_signed');
            $table->timestamp('release_signed_at')->nullable()->after('release_signature');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['release_signed', 'release_signature', 'release_signed_at']);
        });
    }
};