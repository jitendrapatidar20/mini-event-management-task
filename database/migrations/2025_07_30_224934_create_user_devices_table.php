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
        Schema::create('user_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable()->index('user_id');
            $table->string('browser');
            $table->string('device')->nullable();
            $table->string('platform')->nullable();
            $table->tinyInteger('isDesktop')->nullable();
            $table->tinyInteger('isPhone')->nullable();
            $table->tinyInteger('isTablet')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('created_at')->useCurrentOnUpdate()->nullable();

            $table->index(['user_id'], 'user_id_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_devices');
    }
};
