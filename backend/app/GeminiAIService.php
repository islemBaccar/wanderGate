<?php

namespace App;

use Illuminate\Support\Facades\Http;

class GeminiAIService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GOOGLE_GEMINI_API_KEY'); // Ensure this key is set in .env
    }


    public function getRecommendations($destination, $budget, $preferences)
    {
        $apiKey = env('GEMINI_API_KEY'); // Make sure your API key is set in .env

        // Create the text prompt
        $prompt = "Recommend activities for a trip to $destination with a budget of $budget and preferences like " . implode(", ", $preferences) . ".";

        // Define the request payload correctly
        $payload = [
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ]
        ];

        // Make the API call
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateText?key=$apiKey", $payload);

        // Return the response as JSON
        return $response->json();
    }
}
