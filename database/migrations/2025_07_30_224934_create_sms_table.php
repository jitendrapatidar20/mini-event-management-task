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
        Schema::create('sms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('receiver_id');
            $table->unsignedInteger('sender_id')->nullable();
            $table->text('message')->nullable();
            $table->string('phone_number', 50)->nullable();
            $table->string('messageId')->nullable();
            $table->string('send_status');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms');
    }
};
