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
        Schema::create('work_experiances', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('company');
            $table->boolean('currently_working');
            $table->string('location');
            $table->integer('selectEmpType');
            $table->integer('locationType');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experiances');
    }
};
