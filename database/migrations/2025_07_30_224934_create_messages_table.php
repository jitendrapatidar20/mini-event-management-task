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
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('message_thread_id')->nullable()->index('message_thread_id');
            $table->unsignedInteger('parent_id')->nullable()->index('parent_id');
            $table->string('slug')->nullable();
            $table->unsignedInteger('from_user_id')->index('from_user_id');
            $table->unsignedInteger('to_user_id')->index('to_user_id');
            $table->string('subject')->nullable();
            $table->longText('description')->nullable();
            $table->enum('is_seen', ['0', '1'])->default('0');
            $table->unsignedInteger('subject_matter_id')->nullable()->index('subject_matter_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
