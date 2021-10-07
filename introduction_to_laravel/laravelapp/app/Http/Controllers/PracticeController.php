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
}
