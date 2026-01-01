<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Expense;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year;
        $month = $request->month;

        $totalIncome = Income::where('year', $year)
            ->where('month', $month)
            ->sum('amount');

        $totalExpenses = Expense::where('year', $year)
            ->where('month', $month)
            ->sum('amount');

        return [
            'total_income' => $totalIncome,
            'total_expenses' => $totalExpenses,
            'balance' => $totalIncome - $totalExpenses
        ];
    }
}

