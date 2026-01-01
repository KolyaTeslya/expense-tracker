<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IncomeSource;
use Illuminate\Http\Request;

class IncomeSourceController extends Controller
{
    public function index()
    {
        return IncomeSource::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string'
        ]);

        return IncomeSource::create($data);
    }
    public function update(Request $request, IncomeSource $incomeSource)
{
    $data = $request->validate([
        'name' => 'required|string'
    ]);

    $incomeSource->update($data);

    return $incomeSource;
}

public function destroy(IncomeSource $incomeSource)
{
    $incomeSource->delete();

    return response()->noContent();
}

}

