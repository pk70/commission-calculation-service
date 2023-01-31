<?php

namespace App\Services;

class CurrencyExchangeService
{
    private $rate_array = [];
    public function __construct()
    {
        try {

            $url = "https://developers.paysera.com/tasks/api/currency-exchange-rates";
            //  Initiate curl
            $ch = curl_init();
            // Disable SSL verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // Will return the response, if false it print the response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Set the url
            curl_setopt($ch, CURLOPT_URL, $url);
            // Execute
            $result = curl_exec($ch);
            // Closing
            curl_close($ch);
            $data = json_decode($result, true);
            if (isset($data['rates'])) {
                $this->rate_array = $data['rates'];
            }
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }

    /**
     * Currency conversion.
     * @param string
     * @return float
     */

    public function getRateByCurrency($currency): float
    {
        if (array_key_exists($currency, $this->rate_array)) {
            return $this->rate_array[$currency];
        }
    }
}
