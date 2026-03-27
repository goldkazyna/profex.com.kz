<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->user()->incomes()->orderByDesc('date');

        if ($request->has('month') && $request->has('year')) {
            $query->whereMonth('date', $request->month)
                  ->whereYear('date', $request->year);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'category' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
        ]);

        $income = $request->user()->incomes()->create($data);

        return response()->json($income, 201);
    }

    public function show(Request $request, Income $income)
    {
        if ($income->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json($income);
    }

    public function update(Request $request, Income $income)
    {
        if ($income->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'amount' => 'sometimes|numeric|min:0',
            'date' => 'sometimes|date',
            'category' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
        ]);

        $income->update($data);

        return response()->json($income);
    }

    public function destroy(Request $request, Income $income)
    {
        if ($income->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $income->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
