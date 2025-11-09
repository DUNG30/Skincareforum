<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reactions', function (Blueprint $table) {
            $table->id(); // id BIGINT UNSIGNED auto increment
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // liên kết với users.id
            $table->foreignId('thread_id')->constrained()->onDelete('cascade'); // liên kết với threads.id
            $table->string('type', 50); // loại reaction: like, love, haha, ...
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
