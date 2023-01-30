<?php

namespace App\Http\Controllers;

use App\Services\DepositService;
use App\Services\WithdrawService;
use App\Services\FileService;
use App\Http\Controllers\Controller;
use App\Services\CurrencyExchangeService;


class CommissionController extends Controller
{
    public $file = [];
    public $file_write;
    public $deposit = [];
    public $withdraw = [];
    public $deposit_service_data = [];
    public $withdraw_service_data = [];
    public $withdrawService;
    public $depositService;
    public $final_deposit_array = [];
    public $final_withdraw_array = [];
    public $expected_final_array = [];

    public function __construct(FileService $fileAccess, WithdrawService $withdrawServices, DepositService $depositServices)
    {
        $this->file = $fileAccess->accessFileCsv();
        $this->file_write = $fileAccess;
        $this->withdrawService = $withdrawServices;
        $this->depositService = $depositServices;
    }

    /**
     * Generate user wise array.
     *
     * @return array
     */
    public function index()
    {
        foreach ($this->file as $key => $value) {
            if ($value[3] == 'withdraw') {
                $this->withdraw[] = $value;
            }
            if ($value[3] == 'deposit') {
                $this->deposit[] = $value;
            }
        }

        $this->final_deposit_array = $this->handleDepositService();

        $this->final_withdraw_array = $this->handleWithdrawService();

        $final_array = array_merge($this->final_withdraw_array, $this->final_deposit_array);
        foreach ($this->file as $key => $value) {
            foreach ($final_array as $key1 => $value1) {
                if (
                    $value[0] == $value1[0] && $value[1] == $value1[1]
                    && $value[2] == $value1[2] && $value[3] == $value1[3] && $value[5] == $value1[5]
                ) {
                    if ($value1[5] != 'EUR') {
                        $value1[6] = $this->convertCurrent($value1[6], $value1[5]);
                    }
                    $this->expected_final_array[$key] = $this->ExpectedDataFormat($value1);
                }
            }
        }
        $this->file_write->writeFileCsv($this->expected_final_array);
        return $this->expectedOutput($this->expected_final_array);
    }

    /**
     * Handle deposit transaction with deposit service.
     *
     * @return array
     */
    public function handleDepositService()
    {
        $this->deposit_service_data = $this->depositService->depositRule($this->deposit);
        return $this->deposit_service_data;
    }

    /**
     * Handle withdraw transaction with withdraw service.
     *
     * @return array
     */
    public function handleWithdrawService(): array
    {
        $this->withdraw_service_data = $this->withdrawService->withdrawRule($this->withdraw);
        return $this->withdraw_service_data;
    }
    /**
     * Formatting data as expected.
     * @param  array
     * @return string
     */
    public function ExpectedDataFormat(array $data): string
    {
        return $data[6];
    }
    /**
     * Formatting data as expected.
     * @param  array
     * @return array
     */
    public function expectedOutput(array $data): array
    {
        foreach ($data as $value) {
            $arr[] = $value;
        }
        return $arr;
    }

    /**
     * Currency conversion.
     * @param float,string
     * @return float
     */

    public function convertCurrent(float $amount, string $currency): float
    {
        $exchange_rate = new CurrencyExchangeService();
        $exchange_rate = $exchange_rate->getRateByCurrency($currency);
        return number_format($amount * $exchange_rate, 2, '.', '');
    }
}
