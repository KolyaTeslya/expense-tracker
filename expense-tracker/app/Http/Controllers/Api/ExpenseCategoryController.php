<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        return ExpenseCategory::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string'
        ]);

        return ExpenseCategory::create($data);
    }
    public function update(Request $request, ExpenseCategory $expenseCategory)
{
    $data = $request->validate([
        'name' => 'required|string'
    ]);

    $expenseCategory->update($data);

    return $expenseCategory;
}

public function destroy(ExpenseCategory $expenseCategory)
{
    $expenseCategory->delete();

    return response()->noContent();
}

}

