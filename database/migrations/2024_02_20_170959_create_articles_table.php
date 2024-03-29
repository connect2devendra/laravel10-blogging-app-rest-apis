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
            $table->string('article_title');
            $table->string('article_slug');
            $table->text('article_short_note')->nullable();
            $table->longText('article_body_content')->nullable();
            $table->string('thumbnail_img')->nullable();            
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['0', '1']);
            $table->timestamp('publish_date')->nullable();
            $table->softDeletes('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
