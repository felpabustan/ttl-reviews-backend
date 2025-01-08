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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('product_name');
            $table->string('reviewer');
            $table->text('content');
            $table->text('review_url')->nullable();
            $table->text('reviewer_avatar_url')->nullable();
            $table->integer('rating');
            $table->string('status')->default('pending');
            $table->timestamp('review_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
