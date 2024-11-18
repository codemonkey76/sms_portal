<?php

use App\Models\Tag;
use App\Models\Template;
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
        Schema::create('tag_template', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tag::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Template::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_template');
    }
};
