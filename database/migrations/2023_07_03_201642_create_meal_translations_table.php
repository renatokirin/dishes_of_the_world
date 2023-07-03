<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('meal_translations', function (Blueprint $table) {
            $table->id();
            $table->integer('meal_id')->unsigned();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->unique(['meal_id', 'locale']);
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_translations');
    }
};
