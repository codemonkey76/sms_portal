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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->longText('body');
            $table->unsignedSmallInteger('numSegments')->default(0);
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('status')->nullable();
            $table->string('sid')->nullable();
            $table->boolean('isMMS')->default(false);
            $table->dateTime('dateUpdated')->nullable();
            $table->dateTime('dateSent')->nullable();
            $table->datetime('dateCreated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
