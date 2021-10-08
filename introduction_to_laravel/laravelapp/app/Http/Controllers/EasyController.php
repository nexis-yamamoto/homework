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

    //Cookieの読み
    public function cookie(Request $request)
    {
        if ($request->hasCookie('msg')) {
            $message = 'Cookie: ' . $request->cookie('msg');
        } else {
            $message = 'No Cookie;';
        }
        return view('easy.cookie', ['msg' => $message]);
    }
    //Cookieの書き
    public function cookie_post(Request $request)
    {
        $validation_rules = [
            'msg' => 'required'
        ];
        $this->validate($request, $validation_rules);
        $msg = $request->msg;
        $response = response()->view('easy.cookie', ['msg' => $msg . 'をクッキーに保存しました']);
        $response->cookie('msg', $msg, 100);
        return $response;
    }
}
