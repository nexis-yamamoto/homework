<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SimpleRequest;
use Validator;
use App\Rules\Multiple;

class ValidationController extends Controller
{
    public function index(Request $request)
    {
        $data = ['message' => 'フォームを入力してください'];
        return view('validation.simple', $data);
    }

    public function post(SimpleRequest $request)
    {
        /* FormRequestに委譲した(requests/SimpleRequest)
        $validate_rules = [
            'name' => 'required',
            'mail' => 'email',
            'age' => 'numeric|between:0,150',
        ];
        $this->validate($request, $validate_rules); // 結果リダイレクトもする
        */
        return view('validation.simple', ['message' => '正しく入力されました']);
    }

    public function form(Request $request)
    {
        $data = ['message' => 'フォームを入力してください'];
        return view('validation.custom', $data);
    }

    public function custom(Request $request)
    {
        /* クエリ文字列のバリデーションもできる
        $query_validator = Validator::make($request->query(), [
            'id' => 'required',
        ]);
        if ($query_validator->fails()) {
            return redirect('/validation/custom')
                ->withErrors($query_validator) //エラーメッセージをリダイレクト先に引き継ぐ
                ->withInput(); // フォームデータをリダイレクト先に引き継ぐ
        }*/
        $messages = [
            'name.required' => '名前はかならず入力します',
            'mail.email' => 'メールアドレスの書式でありません',
            'age.numeric' => '年齢は数値で',
            'age.min' => '年齢は0以上にします',
            'age.max' => '年齢は200歳こえるとは長生きすぎでは？',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mail' => 'email',
            'age' => 'numeric',
        ], $messages);

        // ageがnumericだったらmin, maxのルールが追加される
        // 条件に応じてルールの追加（最初から設定しておくのと何が違う？どういう使いみち？）
        $validator->sometimes('age', 'min:0', function($input) {
            return is_numeric($input->age);
        });
        $validator->sometimes('age', 'max:200', function($input) {
            return is_numeric($input->age);
        });

        if ($validator->fails()) {
            return redirect('/validation/custom')
                ->withErrors($validator) //エラーメッセージをリダイレクト先に引き継ぐ
                ->withInput(); // フォームデータをリダイレクト先に引き継ぐ
        }
        return view('validation.custom', ['message' => '正しく入力されました!!']);
    }


    public function original_form(Request $request)
    {
        $data = ['message' => 'フォームを入力してください'];
        return view('validation.original', $data);
    }
    public function original(Request $request)
    {
        $messages = [
            'name.required' => '名前はかならず入力します',
            'mail.email' => 'メールアドレスの書式でありません',
            'age.numeric' => '年齢は数値で',
            'age.even' => '年齢は偶数で',
            'age.multiple3' => '年齢は3の倍数で',
        ];
        $validate_rules = [
            'name' => 'required',
            'mail' => 'email',
            'age' => ['numeric', 'even', 'multiple3', new Multiple(5)],
        ];
        $this->validate($request, $validate_rules, $messages); // 結果リダイレクトもする
        return view('validation.original', ['message' => '正しく入力されました']);
    }
}
