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
        Schema::create('division_of_tasks', function (Blueprint $table) {
            $table->id('division_of_task_id');
            $table->unsignedBigInteger('user_id');
            $table->string('group_name');
            $table->string('student_name_1');
            $table->string('jobdesc_1');
            $table->string('student_name_2');
            $table->string('jobdesc_2');
            $table->string('student_name_3');
            $table->string('jobdesc_3');
            $table->string('student_name_4');
            $table->string('jobdesc_4');
            $table->string('student_name_5');
            $table->string('jobdesc_5');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('division_of_tasks');
    }
};
