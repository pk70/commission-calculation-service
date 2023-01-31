<?php

namespace App\Services;

use Illuminate\Support\Facades\Response;

class FileService
{
    /**
     * Get input csv file for read.
     *
     * @return array
     */

    public function accessFileCsv(): ?array
    {
        $input_array = [];

        if(!file_exists(storage_path() . "/input.csv")){
          return null;
        }

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

    /**
     * Write csv file from data.
     *@param array
     */

    public function writeFileCsv(array $data): void
    {
        if (($file = fopen(storage_path() . "/output.csv", "w")) !== false) {
            fputcsv($file, $data, "\n");
            fclose($file);
        }
    }

    /**
     * Download csv file.
     *
     * @return Response
     */

    public function downloadFile()
    {
        $file = storage_path() . "/output.csv";
        return Response::download($file, 'output.csv');
    }
}
