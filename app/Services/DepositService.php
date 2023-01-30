<?php

namespace App\Services;

use App\Services\Interfaces\DepositInterface;
use Illuminate\Http\Request;

class DepositService implements DepositInterface
{
    private $deposit_charge=0.03;

    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function depositRule($data)
    {
      foreach ($data as $key => $value) {
        $value[6]=(float)round(($this->deposit_charge / 100) * $value[4],1);
        $newArray[]=$value;
      }
      return $newArray;

    }
}
