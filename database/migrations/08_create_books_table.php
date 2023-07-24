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
        Schema::create('books', function (Blueprint $table) {
            $table->string('id', 8)->primary();
            $table->string('title');
            $table->string('slug');
            $table->string('description')->nullable();
            $table->integer('num_pages')->nullable();
            $table->timestamp('publish_date')->useCurrent();
            $table->integer('downloads')->default(0);
            $table->decimal('rating', 2, 1)->default(0);
            $table->string('cover_url')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('publisher_id')->nullable();
            $table->unsignedBigInteger('author_id')->nullable();
            
            $table->foreign('publisher_id')->references('id')->on('publishers');
            $table->foreign('author_id')->references('id')->on('authors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
