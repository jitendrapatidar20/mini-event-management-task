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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('email');
            $table->dateTime('email_verified_at')->nullable();
            $table->string('slug');
            $table->string('password');
            $table->string('phone_no');
            $table->unsignedInteger('role_id')->nullable()->default(2)->comment('id of role table');
            $table->longText('remember_token')->nullable();
            $table->longText('token')->nullable();
            $table->dateTime('token_expiry_time')->nullable();
            $table->enum('status', ['0', '1'])->default('1');
            $table->enum('approval_status', ['PENDING', 'APPROVED', 'REJECTED'])->default('PENDING');
            $table->text('reject_reason')->nullable();
            $table->string('last_ip')->nullable()->default('0');
            $table->string('last_latitude', 50)->nullable();
            $table->string('last_longitude', 50)->nullable();
            $table->unsignedInteger('creater_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
