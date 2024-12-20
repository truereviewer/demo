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

        Schema::create(ModelResolver::mediaTable(), function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->string('name');
            $table->string('type');
            $table->string('size');
            $table->string('path');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(ModelResolver::mediaTable());
    }
};
