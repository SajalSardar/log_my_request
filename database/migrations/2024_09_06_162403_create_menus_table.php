<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable();
            $table->integer('user_id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('route')->default('#');
            $table->string('url')->nullable();
            $table->text('icon')->nullable();
            $table->json('roles')->nullable();
            $table->string('status')->default('active');
            $table->string('order')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('menus');
    }
};
