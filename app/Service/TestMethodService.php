<?php

namespace App\Service;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TestMethodService
{
    public function sum($x, $y)
    {
        return floatval(round($x+$y,4));
    }

    public function upload($folder ,$data)
    {
        try {
            $file = Storage::putFile($folder, $data);
            return $file;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function login(LoginRequest $request)
    {
        if(Auth::attempt($request->only('email', 'password', true))){
            return true;
        } else {
            return false;
        }
    }
}