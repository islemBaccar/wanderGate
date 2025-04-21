<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
  protected $fillable = [
    'name',
    'description',
    'country',
    'city',
    'culture_score',
    'nature_score',
    'adventure_score',
    'gastronomy_score',
    'budget_level', // 1-5 scale
    'best_season',  // JSON array of best months
    'typical_duration',
    'family_friendly',
    'solo_friendly',
    'couple_friendly'
  ];

  protected $casts = [
    'best_season' => 'array',
    'culture_score' => 'float',
    'nature_score' => 'float',
    'adventure_score' => 'float',
    'gastronomy_score' => 'float',
    'budget_level' => 'integer',
    'typical_duration' => 'integer',
    'family_friendly' => 'boolean',
    'solo_friendly' => 'boolean',
    'couple_friendly' => 'boolean'
  ];

  public function activities(): HasMany
  {
    return $this->hasMany(Activity::class);
  }
}
