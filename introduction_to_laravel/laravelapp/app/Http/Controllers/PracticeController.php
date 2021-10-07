<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PracticeController extends Controller
{
    public function index($id)
    {
        $data = [
            'id' => $id,
            'msg' => 'これはコントローラ内で渡すメッセージです'
        ];
        // resources/viewsの下の practice/indexを指す
        return view('practice.index', $data);
    }
    // query stringの利用
    public function query(Request $request)
    {
        $data = [
            'id' => $request->id,
            'msg' => 'これはコントローラ内で渡すメッセージです'
        ];
        // resources/viewsの下の practice/indexを指す
        return view('practice.index', $data);
    }
    // Blade Template
    public function blade()
    {
        $data = [
            'msg' => 'これはBlade Templateのサンプルです'
        ];
        // resources/viewsの下の practice/form.phpを指す
        // practice/form.blade.phpがあるときはこちらが優先
        return view('practice.form', $data);
    }
    public function post(Request $request)
    {
        $msg = $request->msg;
        $data = [
            'msg' => $msg
        ];
        return view('practice.form', $data);
    }
}
