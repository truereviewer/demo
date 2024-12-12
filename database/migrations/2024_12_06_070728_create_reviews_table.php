<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use TrueReviewer\Reviewer\ModelResolver;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create(ModelResolver::reviewTable(), function (Blueprint $table) {
            $table->id();
            $table->morphs('reviewable');
            $table->morphs('owner');
            $table->tinyInteger('rating');
            $table->string('title')->nullable();
            $table->longText('text')->nullable();
            $table->json('sub_ratings')->nullable();
            $table->boolean('verified_purchase');
            $table->boolean('is_recommended')->nullable();
            $table->boolean('approved')->default(false);
            $table->string('country_code')->nullable();

            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(ModelResolver::reviewTable());
    }
};
