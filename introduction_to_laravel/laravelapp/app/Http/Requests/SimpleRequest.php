<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// FormRequestはRequestをフォーム用に拡張したもの
// コントローラ到着前にバリデーションなどを解決したいとき
class SimpleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * trueを返せばフォームリクエスト利用許可
     * falseを返すと不許可でHttpExceptionが発生
     * @return bool
     */
    //フォームリクエストクラスはauthorizeメソッドも用意しています。
    //このメソッドでは認証されているユーザーが、指定されたリソースを更新する権限を実際に持っているのかを確認します。
    //たとえば、ユーザーが更新しようとしているブログコメントを実際に所有しているかを判断するとしましょう。
    public function authorize()
    {
        //なぞな用途
        if ($this->path() === 'validation')
            return true;
        else
            return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validate_rules = [
            'name' => 'required',
            'mail' => 'email',
            'age' => 'numeric|between:0,150',
        ];
        return $validate_rules;
    }

    // validationメッセージの上書き設定
    // ローカライズとはまた違うので注意、日本語にするだけならlanguageのあたりをつかう？
    public function messages()
    {
        return [
            'name.required' => '名前はかならず入力します',
            'mail.email' => 'メールアドレスの書式でありません',
            'age.numeric' => '年齢は数値で',
            'age.between' => '年齢は0-150に収めてください',
        ];
    }
}
