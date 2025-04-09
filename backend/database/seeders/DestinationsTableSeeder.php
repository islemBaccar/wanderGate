<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationsTableSeeder extends Seeder
{
  public function run(): void
  {
    $destinations = [
      [
        'name' => 'Paris',
        'description' => 'The City of Light, known for its art, culture, and gastronomy',
        'country' => 'France',
        'city' => 'Paris',
        'culture_score' => 4.8,
        'nature_score' => 2.0,
        'adventure_score' => 2.5,
        'gastronomy_score' => 4.9,
        'budget_level' => 4,
        'best_season' => ['4', '5', '6', '9'], // April, May, June, September
        'typical_duration' => 5,
        'family_friendly' => true,
        'solo_friendly' => true,
        'couple_friendly' => true,
      ],
      [
        'name' => 'Bali',
        'description' => 'Tropical paradise with rich culture and beautiful beaches',
        'country' => 'Indonesia',
        'city' => 'Denpasar',
        'culture_score' => 4.2,
        'nature_score' => 4.8,
        'adventure_score' => 4.5,
        'gastronomy_score' => 4.0,
        'budget_level' => 2,
        'best_season' => ['4', '5', '6', '7', '8', '9'], // April to September
        'typical_duration' => 7,
        'family_friendly' => true,
        'solo_friendly' => true,
        'couple_friendly' => true,
      ],
      [
        'name' => 'Queenstown',
        'description' => 'Adventure capital of New Zealand with stunning landscapes',
        'country' => 'New Zealand',
        'city' => 'Queenstown',
        'culture_score' => 3.0,
        'nature_score' => 4.9,
        'adventure_score' => 5.0,
        'gastronomy_score' => 3.5,
        'budget_level' => 3,
        'best_season' => ['12', '1', '2'], // December to February (Summer)
        'typical_duration' => 4,
        'family_friendly' => true,
        'solo_friendly' => true,
        'couple_friendly' => true,
      ],
      [
        'name' => 'Kyoto',
        'description' => 'Ancient capital of Japan with stunning temples and gardens',
        'country' => 'Japan',
        'city' => 'Kyoto',
        'culture_score' => 5.0,
        'nature_score' => 4.0,
        'adventure_score' => 2.0,
        'gastronomy_score' => 4.8,
        'budget_level' => 4,
        'best_season' => ['3', '4', '10', '11'], // March, April, October, November
        'typical_duration' => 4,
        'family_friendly' => true,
        'solo_friendly' => true,
        'couple_friendly' => true,
      ],
      [
        'name' => 'Santorini',
        'description' => 'Stunning Greek island with white-washed buildings and sunset views',
        'country' => 'Greece',
        'city' => 'Thira',
        'culture_score' => 4.0,
        'nature_score' => 4.5,
        'adventure_score' => 3.0,
        'gastronomy_score' => 4.2,
        'budget_level' => 4,
        'best_season' => ['5', '6', '7', '8', '9'], // May to September
        'typical_duration' => 4,
        'family_friendly' => false,
        'solo_friendly' => true,
        'couple_friendly' => true,
      ],
    ];

    foreach ($destinations as $destination) {
      Destination::create($destination);
    }
  }
}
