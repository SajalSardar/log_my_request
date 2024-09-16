<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('requester_type_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('attachment')->nullable();
            $table->string('student_id')->nullable();
            $table->string('priority')->nullable()->comment('low,medium,high');
            $table->date('due_date')->nullable();
            $table->string('status')->nullable()->comment('open,progress,pending,resolved,hold,closed,resolution');
            $table->date('resolved_at')->nullable();
            $table->integer('resolved_by')->nullable();
            $table->string('resolution_time')->nullable()->comment('calculate the time between ticket creation and resolution');
            $table->string('source')->nullable()->comment('website,phone,email,in_person/walk_in,logmyrequest');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('tickets');
    }
};
