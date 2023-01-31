<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Support\Facades\View
     */

    public function index(Request $request)
    {
        return view('landing-page');
    }

    /**
     * Generate user wise array.
     *
     * @return response
     */

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input_csv' => 'required|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return redirect()->route('index', ['errors' => $validator->errors()->all()]);
        }

        $file = $request->file('input_csv');

        if($file->getClientOriginalName()!='input.csv'){
            return redirect()->route('index', ['errors' => [0=>'file name must be input.csv']]);
        }

        $file->move(storage_path(), $file->getClientOriginalName());
        return redirect()->route('index', ['message' => [0=>'File uploaded successfully']]);
    }
}
