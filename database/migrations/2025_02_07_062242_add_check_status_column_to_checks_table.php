<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use TrueReviewer\Reviewer\Enums\CheckStatus;
use TrueReviewer\Reviewer\ModelResolver;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(ModelResolver::reviewTable(), function (Blueprint $table) {
            $table->char('check_status')->default(CheckStatus::Pending->value);
        });
    }
};
