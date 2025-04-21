<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Activity;

class BudgetController extends Controller
{
    // 1. Define or update the budget for a trip
    public function createBudget(Request $request, $trip_id)
    {
        $trip = Trip::findOrFail($trip_id);

        $request->validate([
            'budget' => 'required|numeric|min:0',
        ]);

        $trip->budget = $request->budget;
        $trip->save();

        return response()->json(['message' => 'Budget set successfully', 'budget' => $trip->budget], 200);
    }

    // 2. Add an expense (e.g., from an activity)
    public function addExpense(Request $request, $trip_id)
    {
        $trip = Trip::findOrFail($trip_id);

        $request->validate([
            'expense' => 'required|numeric|min:0',
        ]);

        // Reduce the budget by the expense amount
        $trip->budget -= $request->expense;
        $trip->save();

        return response()->json([
            'message' => 'Expense added successfully',
            'remaining_budget' => $trip->budget
        ], 200);
    }

    // 3. Get the current budget of a trip, including expenses from activities
    public function getBudget($trip_id)
    {
        $trip = Trip::findOrFail($trip_id);

        // Calculate total expenses from activities
        $totalExpenses = Activity::where('trip_id', $trip_id)->sum('expense');

        return response()->json([
            'trip_id' => $trip->id,
            'initial_budget' => $trip->budget,
            'total_expenses' => $totalExpenses,
            'remaining_budget' => $trip->budget - $totalExpenses
        ], 200);
    }
}
