<?php

namespace App\Http\Controllers;

use App\GeminiAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Trip;

class TripController extends Controller
{
    protected $geminiAIService;

    // Inject GeminiAIService
    public function __construct(GeminiAIService $geminiAIService)
    {
        $this->middleware('auth:sanctum'); // Ensure authentication
        $this->geminiAIService = $geminiAIService;
    }

    /**
     * Store a new trip
     */
    public function store(Request $request)
    {
        // Ensure user is authenticated
        if (!auth()->user()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validatedData = $request->validate([
            'destination' => 'required|string',
            'date_depart' => 'required|date',
            'date_retour' => 'required|date|after:date_depart',
            'budget' => 'required|numeric|min:0',
            'type_voyage' => 'nullable|string',
            'style_hebergement' => 'nullable|string',
            'transport_prefere' => 'nullable|string',
            'climat_souhaite' => 'nullable|string',
        ]);

        // Create trip
        $trip = Trip::create(array_merge($validatedData, [
            'user_id' => auth()->id(), // Auto-fill user_id
        ]));

        return response()->json([
            'message' => 'Trip created successfully',
            'trip' => $trip
        ], 201);
    }

    /**
     * Get AI-based activity recommendations
     */
    public function recommendActivities(Request $request)
    {
        $validatedData = $request->validate([
            'destination' => 'required|string',
            'budget' => 'required|numeric',
            'preferences' => 'nullable|array',
        ]);

        // Fetch recommendations from Gemini AI service
        $recommendations = $this->geminiAIService->getRecommendations(
            $validatedData['destination'],
            $validatedData['budget'],
            $validatedData['preferences'] ?? []
        );

        return response()->json([
            'message' => 'Recommendations fetched successfully!',
            'activities' => $recommendations,
        ]);
    }
}
