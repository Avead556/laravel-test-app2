<?php

namespace App\Http\Controllers;


use App\Service\CurrencyService;
use Illuminate\Contracts\View\View;

class CurrencyController extends Controller
{
    public function index(CurrencyService $currencyService): View
    {
        return view('currencies.index', [
            'currencies' => $currencyService->getCurrencies()
        ]);

    }
}
