<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('destinations', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->text('description');
      $table->string('country');
      $table->string('city');
      $table->float('culture_score')->default(0);
      $table->float('nature_score')->default(0);
      $table->float('adventure_score')->default(0);
      $table->float('gastronomy_score')->default(0);
      $table->integer('budget_level');
      $table->json('best_season');
      $table->integer('typical_duration');
      $table->boolean('family_friendly')->default(false);
      $table->boolean('solo_friendly')->default(false);
      $table->boolean('couple_friendly')->default(false);
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('destinations');
  }
};
