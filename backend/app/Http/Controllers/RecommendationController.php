<?php

namespace App\Http\Controllers;

use App\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RecommendationController extends Controller
{
  private $recommendationService;

  public function __construct(RecommendationService $recommendationService)
  {
    $this->recommendationService = $recommendationService;
  }

  /**
   * Get personalized travel recommendations
   */
  public function getRecommendations(Request $request): JsonResponse
  {
    $validated = $request->validate([
      'interests' => 'required|array',
      'interests.*' => 'string|in:culture,nature,adventure,gastronomy',
      'travelStyle' => 'required|string|in:solo,couple,family,group',
      'duration' => 'required|integer|min:1',
      'budget' => 'required|numeric|min:0',
      'preferences' => 'array'
    ]);

    $recommendations = $this->recommendationService->getPersonalizedRecommendations($validated);

    return response()->json([
      'success' => true,
      'data' => $recommendations
    ]);
  }
}
