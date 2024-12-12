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

        Schema::create(ModelResolver::reviewStatisticTable(), function (Blueprint $table) {
            $table->id();
            $table->morphs('reviewable');
            $table->json('ratings');
            $table->bigInteger('total_helpful');
            $table->bigInteger('total_reviews');
            $table->bigInteger('positive_recommendations');
            $table->bigInteger('total_recommendations');

            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(ModelResolver::reviewStatisticTable());
    }
};
