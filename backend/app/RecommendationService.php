<?php

namespace App;

use App\Models\Destination;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class RecommendationService
{
  /**
   * Generate personalized travel recommendations based on user preferences
   */
  public function getPersonalizedRecommendations(array $userPreferences): array
  {
    try {
      // Get all destinations
      $destinations = Destination::with('activities')->get();

      // Score each destination based on user preferences
      $scoredDestinations = $this->scoreDestinations($destinations, $userPreferences);

      // Get top 3 destinations
      $recommendations = $scoredDestinations->sortByDesc('score')->take(3);

      return $this->formatRecommendations($recommendations);
    } catch (\Exception $e) {
      Log::error('Recommendation error: ' . $e->getMessage());
      return $this->getFallbackRecommendations($userPreferences);
    }
  }

  /**
   * Score destinations based on user preferences
   */
  private function scoreDestinations(Collection $destinations, array $preferences): Collection
  {
    return $destinations->map(function ($destination) use ($preferences) {
      $score = 0;

      // Score based on interests
      if (in_array('culture', $preferences['interests'])) {
        $score += $destination->culture_score;
      }
      if (in_array('nature', $preferences['interests'])) {
        $score += $destination->nature_score;
      }
      if (in_array('adventure', $preferences['interests'])) {
        $score += $destination->adventure_score;
      }
      if (in_array('gastronomy', $preferences['interests'])) {
        $score += $destination->gastronomy_score;
      }

      // Score based on travel style
      switch ($preferences['travelStyle']) {
        case 'solo':
          $score += $destination->solo_friendly ? 2 : -1;
          break;
        case 'couple':
          $score += $destination->couple_friendly ? 2 : -1;
          break;
        case 'family':
          $score += $destination->family_friendly ? 2 : -1;
          break;
      }

      // Score based on budget (inverse relationship - lower budget_level is better for lower budgets)
      $userBudgetLevel = $this->calculateBudgetLevel($preferences['budget']);
      $score += (6 - abs($userBudgetLevel - $destination->budget_level));

      // Score based on duration match
      $durationDiff = abs($preferences['duration'] - $destination->typical_duration);
      $score += max(0, 5 - $durationDiff);

      // Add score to destination
      $destination->score = $score;

      return $destination;
    });
  }

  /**
   * Calculate budget level (1-5) based on budget amount
   */
  private function calculateBudgetLevel(float $budget): int
  {
    if ($budget <= 500) return 1;
    if ($budget <= 1000) return 2;
    if ($budget <= 2000) return 3;
    if ($budget <= 4000) return 4;
    return 5;
  }

  /**
   * Format recommendations for response
   */
  private function formatRecommendations(Collection $recommendations): array
  {
    return [
      'destinations' => $recommendations->map(function ($destination) {
        return [
          'id' => $destination->id,
          'name' => $destination->name,
          'description' => $destination->description,
          'country' => $destination->country,
          'city' => $destination->city,
          'activities' => $destination->activities->map(function ($activity) {
            return [
              'id' => $activity->id,
              'name' => $activity->name,
              'description' => $activity->description,
              'estimated_cost' => $activity->estimated_cost
            ];
          }),
          'best_season' => $destination->best_season,
          'budget_level' => $destination->budget_level,
          'match_score' => round(($destination->score / 15) * 100) // Convert score to percentage
        ];
      })->values()->toArray(),
      'metadata' => [
        'generated_at' => now(),
        'total_destinations_analyzed' => $recommendations->count()
      ]
    ];
  }

  /**
   * Provide fallback recommendations
   */
  private function getFallbackRecommendations(array $preferences): array
  {
    // Get any 3 random destinations as fallback
    $fallbackDestinations = Destination::with('activities')
      ->inRandomOrder()
      ->take(3)
      ->get();

    return $this->formatRecommendations($fallbackDestinations);
  }
}
