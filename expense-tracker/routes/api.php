<?php


    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Api\IncomeSourceController;
    use App\Http\Controllers\Api\IncomeController;
    use App\Http\Controllers\Api\ExpenseCategoryController;
    use App\Http\Controllers\Api\ExpenseController;
    use App\Http\Controllers\Api\DashboardController;
    use Illuminate\Support\Facades\Route;

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/income-sources', [IncomeSourceController::class, 'index']);
    Route::post('/income-sources', [IncomeSourceController::class, 'store']);

    Route::get('/incomes', [IncomeController::class, 'index']);
    Route::post('/incomes', [IncomeController::class, 'store']);

    Route::get('/expense-categories', [ExpenseCategoryController::class, 'index']);
    Route::post('/expense-categories', [ExpenseCategoryController::class, 'store']);

    Route::get('/expenses', [ExpenseController::class, 'index']);
    Route::post('/expenses', [ExpenseController::class, 'store']);

    Route::put('/income-sources/{incomeSource}', [IncomeSourceController::class, 'update']);
    Route::delete('/income-sources/{incomeSource}', [IncomeSourceController::class, 'destroy']);

    Route::put('/incomes/{income}', [IncomeController::class, 'update']);
    Route::delete('/incomes/{income}', [IncomeController::class, 'destroy']);

    Route::put('/expense-categories/{expenseCategory}', [ExpenseCategoryController::class, 'update']);
    Route::delete('/expense-categories/{expenseCategory}', [ExpenseCategoryController::class, 'destroy']);

    Route::put('/expenses/{expense}', [ExpenseController::class, 'update']);
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy']);

    Route::get('/health', function () {
    return response()->json([
        'status' => 'ok'
        ]);
    });
