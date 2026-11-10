<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropUnique('conversations_item_id_user_id_unique');
            $table->foreignId('buyer_id')->nullable()->after('user_id')->constrained('users')->cascadeOnDelete();
        });

        $legacyBuyerId = DB::table('users')->where('username', 'henry')->value('id');

        if ($legacyBuyerId !== null) {
            DB::table('conversations')->whereNull('buyer_id')->update(['buyer_id' => $legacyBuyerId]);
        }

        Schema::table('conversations', function (Blueprint $table) {
            $table->unsignedBigInteger('buyer_id')->nullable(false)->change();
        });

        Schema::table('conversations', function (Blueprint $table) {
            $table->unique(['item_id', 'buyer_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropUnique('conversations_item_id_buyer_id_user_id_unique');
            $table->dropConstrainedForeignId('buyer_id');
            $table->unique(['item_id', 'user_id']);
        });
    }
};
