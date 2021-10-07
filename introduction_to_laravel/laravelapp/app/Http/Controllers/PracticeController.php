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
        // resources/viewsの下の practice/form.phpを指す
        // practice/form.blade.phpがあるときはこちらが優先
        return view('practice.form');
    }
    public function post(Request $request)
    {
        $msg = $request->msg;
        $data = [
            'msg' => $msg
        ];
        return view('practice.form', $data);
    }

    //Blade Loop Directive
    public function loop()
    {
        $list = ['one', 'two', 'three', 'four', 'five'];
        $data = [
            'list' => $list,
            'emptylist' => []
        ];
        return view('practice.loop', $data);
    }
}
