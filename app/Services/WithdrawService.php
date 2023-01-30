<?php

namespace App\Services;


class WithdrawService
{

    private $exchange_rate;
    private $userOperationArray = [];

    private $sessionUserArray = [];


    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function withdrawRule($data)
    {

        $newArray = [];
        $dateArray = [];
        $rest_amount_by_user = 0;

        $this->operationPerUser($data);
        $tr_date_d = [];

        $i = 0;
        foreach ($this->userOperationArray as $key => $value) {

            foreach ($value as $key1 => $value1) {
                //user identification
                if ($key == $value1[1]) {
                    //above 1000
                    if ($value1[2] == 'private') {

                        if ($value1[4] > 1000) {
                            $value1[6] = round((($value1[4] - 1000) * .3) / 100, 1);
                            $value1[7] = 'true';
                            $value1[8] = 0;
                            $this->sessionUserArray[] = [
                                $value1[0], $value1[1], $value1[2], $value1[3],
                                $value1[4], $value1[5], $value1[6], $value1[7], $value1[8]
                            ];
                        } elseif ($value1[4] <= 1000) {
                            if (array_key_exists($key, $tr_date_d)) {
                                if (array_key_exists($i - 1, $tr_date_d[$key])) {
                                    if ($this->dateTimeDiffer($tr_date_d[$key][$i - 1], $value1[0]) <= 7) {
                                        if (array_key_exists($i - 1, $this->sessionUserArray) && $this->sessionUserArray[$i - 1][7] == 'true') {
                                            $value1[6] = round(($value1[4] * .3) / 100, 1);
                                            $value1[7] = 'true';
                                            $value1[8] = 0;
                                            //$tr_deduct_d[$key][$i] = "true";
                                            $this->sessionUserArray[] = [
                                                $value1[0], $value1[1], $value1[2], $value1[3],
                                                $value1[4], $value1[5], $value1[6], $value1[7], $value1[8]
                                            ];
                                        } //true
                                        else {
                                            if (array_key_exists($i - 1, $this->sessionUserArray) && $this->sessionUserArray[$i - 1][8] >= 0) {
                                                if ($this->sessionUserArray[$i - 1][8] + $value1[4] > 1000) {
                                                    $value1[6] = round(((1000 - $this->sessionUserArray[$i - 1][8]) * .3) / 100, 1);
                                                    $value1[7] = 'true';
                                                    $value1[8] = 0;
                                                    //$tr_deduct_d[$key][$i] = "true";
                                                    $this->sessionUserArray[] = [
                                                        $value1[0], $value1[1], $value1[2], $value1[3],
                                                        $value1[4], $value1[5], $value1[6], $value1[7], $value1[8]
                                                    ];
                                                } else {
                                                    $value1[6] = 0;
                                                    $value1[7] = 'false';
                                                    $value1[8] = 1000 - $value1[4];
                                                    //$tr_deduct_d[$key][$i] = "true";
                                                    $this->sessionUserArray[] = [
                                                        $value1[0], $value1[1], $value1[2], $value1[3],
                                                        $value1[4], $value1[5], $value1[6], $value1[7], $value1[8]
                                                    ];
                                                }
                                            }
                                        } //false
                                    } //7<=
                                    else {
                                        if ($value1[4] > 1000) {
                                            $value1[6] = round((($value1[4] - 1000) * .3) / 100, 1);
                                            $value1[7] = 'true';
                                            $value1[8] = 0;
                                            //$tr_deduct_d[$key][$i] = "true";
                                            $this->sessionUserArray[] = [
                                                $value1[0], $value1[1], $value1[2], $value1[3],
                                                $value1[4], $value1[5], $value1[6], $value1[7], $value1[8]
                                            ];
                                        } else {
                                            $value1[6] = 0;
                                            $value1[7] = 'false';
                                            $value1[8] = 1000 - $value1[4];
                                            //$tr_deduct_d[$key][$i] = "true";
                                            $this->sessionUserArray[] = [
                                                $value1[0], $value1[1], $value1[2], $value1[3],
                                                $value1[4], $value1[5], $value1[6], $value1[7], $value1[8]
                                            ];
                                        }
                                    } //7>
                                } else {
                                    //Log::info(['test'=>$value1]);
                                    $value1[6] = 0;
                                    $value1[7] = 'false';
                                    $value1[8] = 1000 - $value1[4];
                                    //$tr_deduct_d[$key][$i] = "true";
                                    $this->sessionUserArray[] = [
                                        $value1[0], $value1[1], $value1[2], $value1[3],
                                        $value1[4], $value1[5], $value1[6], $value1[7], $value1[8]
                                    ];
                                }
                            } else {
                                $value1[6] = 0;
                                $value1[7] = 'false';
                                $value1[8] = 1000 - $value1[4];
                                //$tr_deduct_d[$key][$i] = "true";
                                $this->sessionUserArray[] = [
                                    $value1[0], $value1[1], $value1[2], $value1[3],
                                    $value1[4], $value1[5], $value1[6], $value1[7], $value1[8]
                                ];
                            }
                        } //<=1000
                        $tr_date_d[$key][$i] = $value1[0];
                    } else {
                        $value1[6] = round((($value1[4]) *  0.5) / 100, 1);
                        $value1[7] = 'true';
                        $value1[8] = 0;
                        //$tr_deduct_d[$key][$i] = "true";
                        $this->sessionUserArray[] = [
                            $value1[0], $value1[1], $value1[2], $value1[3],
                            $value1[4], $value1[5], $value1[6], $value1[7], $value1[8]
                        ];
                    }
                } //key==value


                $i++;
            } //inner foreach
        } //first foreach
        return $this->sessionUserArray;
    }

    public function dateTimeDiffer($from, $to)
    {
        $tow = \Carbon\Carbon::createFromFormat('Y-m-d', $to);
        $fromw = \Carbon\Carbon::createFromFormat('Y-m-d', $from);

        $diff_in_days = $tow->diffInDays($fromw);

        return $diff_in_days;
    }

    public function operationPerUser($data)
    {
        foreach ($data as $key => $value) {

            if ($value[5] != 'EUR') {
                $exchange_rate = new CurrencyExchangeService();
                $this->exchange_rate = $exchange_rate->getRateByCurrency($value[5]);
                $value[4] = number_format($value[4] / $this->exchange_rate, 2, '.', '');
            }

            $this->userOperationArray[$value[1]][] = $value;

        }
    }

    //Rule for greater than 1000

    public function withdrawRule_1()
    {

    }

}
