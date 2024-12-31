<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('slug');
            $table->boolean('permission')->nullable();
            $table->boolean('view')->nullable();
            $table->boolean('livewire_component')->nullable();
            $table->boolean('mcrp')->nullable()->comment('model,controller,migration,policy,resource route');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('modules');
    }
};
