<?php

namespace App\Http\Controllers;

use App\Services\DepositService;
use App\Services\WithdrawService;
use App\Services\FileService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
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
    public $final_deposit_array = [];
    public $final_withdraw_array = [];
    public $expected_final_array = [];

    public function __construct(FileService $fileAccess, WithdrawService $withdrawServices)
    {
        //Session::forget('userArray');
        Session::put('userArray', []);
        $this->file = $fileAccess->accessFileCsv();
        $this->file_write = $fileAccess;
        $this->withdrawService = $withdrawServices;
    }


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
        $depositServiceData = new DepositService();
        $this->final_deposit_array = $this->handleDepositService($depositServiceData);

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

    public function handleDepositService($depositServiceData)
    {
        $this->deposit_service_data = $depositServiceData->depositRule($this->deposit);
        return $this->deposit_service_data;
    }

    public function handleWithdrawService()
    {

        $this->withdraw_service_data = $this->withdrawService->withdrawRule($this->withdraw);

        return $this->withdraw_service_data;
    }

    public function ExpectedDataFormat($data)
    {

        return $data[6];
    }
    public function expectedOutput($data)
    {
        foreach ($data as $value) {
            $arr[] = $value;
        }
        return $arr;
    }


    public function convertCurrent($amount, $currency)
    {
        $exchange_rate = new CurrencyExchangeService();
        $exchange_rate = $exchange_rate->getRateByCurrency($currency);
        return number_format($amount * $exchange_rate, 2, '.', '');
    }
}
