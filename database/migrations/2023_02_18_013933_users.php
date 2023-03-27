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
    Schema::create("users", function (Blueprint $table) {
            $table->id();
            $table->string("email");
            $table->string("password");
            $table->char('userName', 150);
            $table->boolean('admin')->default(false);
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->binary("profile_pic")->nullable()->default(null);
            $table->boolean("first_login")->default(true);

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
