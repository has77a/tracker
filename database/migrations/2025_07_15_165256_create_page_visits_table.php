<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_visits', function (Blueprint $table) {
            $table->id();
            $table->string('page', 512);
            $table->timestamp('client_timestamp');
            $table->string('ip_address', 39)->nullable();
            $table->string('user_agent', 1024)->nullable();
            $table->string('fingerprint', 64);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_visits');
    }
};
