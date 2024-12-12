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

        Schema::create(ModelResolver::reactionTable(), function (Blueprint $table) {
            $table->id();
            $table->morphs('owner');
            $table->morphs('model');
            $table->string('type');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(ModelResolver::reactionTable());
    }
};
