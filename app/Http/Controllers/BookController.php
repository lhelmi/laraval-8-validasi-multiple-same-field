<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BookController extends Controller
{
    public function index(){
        return view('validate');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title.*' => 'required|max:255',
        ]);
        $isValid = null;
        if ($validator->fails()) {
            $isValid = $validator->errors();
            $res = [
                'error' => true,
                'message' => $isValid
            ];
            return response()->json($res);
        }
        $res = [
            'error' => false,
            'message' => "mantapppp"
        ];
        return response()->json($res);
    }
}
