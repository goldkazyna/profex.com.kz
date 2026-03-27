<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->user()->expenses()->orderByDesc('date');

        if ($request->has('month') && $request->has('year')) {
            $query->whereMonth('date', $request->month)
                  ->whereYear('date', $request->year);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'type' => 'required|in:fixed,variable,withdrawal,payroll,tax',
            'category' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
        ]);

        $expense = $request->user()->expenses()->create($data);

        return response()->json($expense, 201);
    }

    public function show(Request $request, Expense $expense)
    {
        if ($expense->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json($expense);
    }

    public function update(Request $request, Expense $expense)
    {
        if ($expense->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'amount' => 'sometimes|numeric|min:0',
            'date' => 'sometimes|date',
            'type' => 'sometimes|in:fixed,variable,withdrawal,payroll,tax',
            'category' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
        ]);

        $expense->update($data);

        return response()->json($expense);
    }

    public function destroy(Request $request, Expense $expense)
    {
        if ($expense->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $expense->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
