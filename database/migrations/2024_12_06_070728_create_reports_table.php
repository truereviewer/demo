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

        Schema::create(ModelResolver::reportTable(), function (Blueprint $table) {
            $table->id();

            $table->morphs('reportable');
            $table->morphs('owner');

            $table->text('reason');

            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(ModelResolver::reportTable());
    }
};
