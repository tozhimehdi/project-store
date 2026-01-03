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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('body');
            $table->string('image')->nullable();
            $table->boolean('is_comment')->default(1); // امکان نظر دادن دارند؟
            $table->enum('status', ['draft', 'published','scheduled'])->default('draft')->nullable();
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
        });
        
        Schema::create('article_category', function (Blueprint $table) {
            $table->unsignedBigInteger('article_id');
            $table->foreign('article_id')->on('articles')->references('id')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->on('categories')->references('id')
                            ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['article_id', 'category_id']);
            // 1    1
            // 1    1
        });

        Schema::create('article_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('article_id');
            $table->foreign('article_id')->on('articles')->references('id')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('tag_id');
            $table->foreign('tag_id')->on('tags')->references('id')
                            ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['article_id', 'tag_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_tag');
        Schema::dropIfExists('article_category');
        Schema::dropIfExists('articles');

    }
};
