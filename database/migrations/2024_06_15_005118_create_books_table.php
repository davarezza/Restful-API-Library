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
            $table->uuid('book_id')->primary();
            $table->uuid('book_category_id');
            $table->foreign('book_category_id')
                  ->references('category_id')->on('categories')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->uuid('book_publisher_id');
            $table->foreign('book_publisher_id')
                  ->references('publisher_id')->on('publishers')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->uuid('book_shelf_id');
            $table->foreign('book_shelf_id')
                  ->references('shelf_id')->on('shelves')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->uuid('book_author_id');
            $table->foreign('book_author_id')
                  ->references('author_id')->on('authors')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->string('book_name');
            $table->char('book_isbn', 16);
            $table->integer('book_stock');
            $table->string('book_description');
            $table->string('book_img');
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
