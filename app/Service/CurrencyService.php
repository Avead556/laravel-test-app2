<?php

namespace App\Service;

use App\Repository\CurrencyRepository;

readonly class CurrencyService
{

    public function __construct(private CurrencyRepository $currencyRepository)
    {
    }

    public function getCurrencies()
    {
        return $this->currencyRepository->getCurrencies();
    }
}
