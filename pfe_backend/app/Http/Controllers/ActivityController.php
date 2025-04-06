<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller
{
    /**
     * Display a listing of all activities.
     */
    public function index()
    {
        $activities = Activity::all();
        return response()->json($activities, 200);
    }

    /**
     * Store a newly created activity.
     */
    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'description' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'expense' => 'required|numeric|min:0'
        ]);

        $activity = Activity::create($request->all());

        return response()->json([
            'message' => 'Activity created successfully',
            'activity' => $activity
        ], 201);
    }

    /**
     * Display activities for a specific trip.
     */
    public function getActivitiesByTrip($trip_id)
    {
        $activities = Activity::where('trip_id', $trip_id)->get();

        if ($activities->isEmpty()) {
            return response()->json(['message' => 'No activities found for this trip'], 404);
        }

        return response()->json($activities, 200);
    }

    /**
     * Update an existing activity.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'sometimes|string|max:255',
            'type' => 'sometimes|string|max:100',
            'expence' => 'sometimes|numeric|min:0'
        ]);

        $activity = Activity::find($id);

        if (!$activity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }

        $activity->update($request->all());

        return response()->json([
            'message' => 'Activity updated successfully',
            'activity' => $activity
        ], 200);
    }

    /**
     * Remove the specified activity.
     */
    public function destroy($id)
    {
        $activity = Activity::find($id);

        if (!$activity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }

        $activity->delete();

        return response()->json(['message' => 'Activity deleted successfully'], 200);
    }
}
