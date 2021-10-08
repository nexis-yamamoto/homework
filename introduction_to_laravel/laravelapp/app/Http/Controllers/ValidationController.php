<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function index(Request $request)
    {
        $data = ['message' => 'フォームを入力してください'];
        return view('validation.simple', $data);
    }

    public function post(Request $request)
    {
        $validate_rules = [
            'name' => 'required',
            'mail' => 'email',
            'age' => 'numeric|between:0,150',
        ];
        
        $this->validate($request, $validate_rules);
        return view('validation.simple', ['message' => '正しく入力されました']);
    }
}
