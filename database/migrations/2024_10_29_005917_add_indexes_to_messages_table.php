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
        Schema::table('messages', function (Blueprint $table) {
            $table->index(['customer_id', 'is_archived', 'dateCreated'], 'messages_customer_archived_date_index');
            $table->index(['customer_id', 'is_archived'], 'messages_customer_archived_count_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex('messages_customer_archived_date_index');
            $table->dropIndex('messages_customer_archived_count_index');
        });
    }
};
