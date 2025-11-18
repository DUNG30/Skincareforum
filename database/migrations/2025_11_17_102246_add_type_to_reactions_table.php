<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reactions', function (Blueprint $table) {
            $table->string('type')->default('like')->after('user_id'); // mặc định là like
        });
    }

    public function down(): void
    {
        Schema::table('reactions', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};