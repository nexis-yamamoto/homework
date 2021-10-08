<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EasyController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'persons' => [
                ['name' => '山田太郎', 'mail' => 'yamada@example.com'],
                ['name' => '田中はなこ', 'mail' => 'tanaka@example.com'],
                ['name' => '鈴木さちこ', 'mail' => 'suzuki@example.com']
            ],
            'middleware_persons' => $request->middleware_persons,
            'message' => 'message form controller',
        ];
        return view('easy.simple', $data);
    }
}
