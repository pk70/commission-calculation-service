<?php

namespace App\Services;

use Illuminate\Support\Facades\Response;

class FileService
{
    public function accessFileCsv()
    {
        $input_array = [];

        if (($open = fopen(storage_path() . "/input.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                $input_array[] = $data;
            }

            fclose($open);
        }

        $input_array = array_map('array_filter', $input_array);
        $input_array = array_filter($input_array);
        return $input_array;
    }
    public function writeFileCsv(array $data)
    {

        if (($file = fopen(storage_path() . "/output.csv", "w")) !== false) {
            fputcsv($file, $data, "\n");
            fclose($file);
        }
    }
    public function downloadFile()
    {
        $file=storage_path() . "/output.csv";
        return Response::download($file, 'output.csv');
    }
}
