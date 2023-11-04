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
        Schema::create('tweets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('message');
            $table->string('file')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('shareUrl')->nullable();
            $table->integer('like')->nullable()->default(0);
            $table->integer('numOfComments')->nullable()->default(0);
            $table->integer('shares')->nullable()->default(0);
            $table->integer('views')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tweets');
    }
};
