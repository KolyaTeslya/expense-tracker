<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        return Income::with('source')
            ->where('year', $request->year)
            ->where('month', $request->month)
            ->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'income_source_id' => 'required|exists:income_sources,id',
            'year' => 'required|integer',
            'month' => 'required|integer',
            'amount' => 'required|numeric'
        ]);

        return Income::create($data);
    }
    public function update(Request $request, Income $income)
{
    $data = $request->validate([
        'income_source_id' => 'required|exists:income_sources,id',
        'year' => 'required|integer',
        'month' => 'required|integer',
        'amount' => 'required|numeric'
    ]);

    $income->update($data);

    return $income;
}

public function destroy(Income $income)
{
    $income->delete();

    return response()->noContent();
}

    
}

