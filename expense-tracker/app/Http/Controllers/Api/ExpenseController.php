<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        return Expense::with('category')
            ->where('year', $request->year)
            ->where('month', $request->month)
            ->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'year' => 'required|integer',
            'month' => 'required|integer',
            'amount' => 'required|numeric'
        ]);

        return Expense::create($data);
    }
    public function update(Request $request, Expense $expense)
{
    $data = $request->validate([
        'expense_category_id' => 'required|exists:expense_categories,id',
        'year' => 'required|integer',
        'month' => 'required|integer',
        'amount' => 'required|numeric'
    ]);

    $expense->update($data);

    return $expense;
}

public function destroy(Expense $expense)
{
    $expense->delete();

    return response()->noContent();
}

}

