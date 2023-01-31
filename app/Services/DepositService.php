<?php

namespace App\Services;

use App\Services\Interfaces\DepositInterface;

class DepositService implements DepositInterface
{
    private $depositCharge = 0.03;

    public function __construct()
    {
    }

    /**
     * Calculation deposit transaction.
     * @param array
     * @return array
     */

    public function depositRule(array $data): array
    {
        foreach ($data as $key => $value) {
            $value[6] = (float)round(($this->depositCharge / 100) * $value[4], 1);
            $newArray[] = $value;
        }
        return $newArray;
    }
}
