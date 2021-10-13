<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PersonController extends Controller
{
    public function index(Request $resuest)
    {
        //$items = Person::all();
        // リレーションのレコード有無によるしぼりこみ
        $hasPosts = Person::has('boards')->get();
        $noPosts = Person::doesntHave('boards')->get();
        $data = [
            'hasItems' => $hasPosts,
            'noItems' => $noPosts
        ];
        return view('person.index', $data);
    }

    public function paginate_index(Request $request)
    {
        $sort = $request->sort;
        //$items = Person::orderBy($sort, 'asc')->simplePaginate(5);
        $items = Person::orderBy($sort, 'asc')->paginate(5);
        $data = [
            'hasItems' => array(),
            'noItems' => array(),
            'items' => $items,
            'sort' => $sort,
        ];
        return view('person.index', $data);
    }

    public function show($id = 0)
    {
        $person = Person::find($id);
        return view('person.show', ['item' => $person]);
    }

    public function find(Request $request)
    {
        return view('person.find', ['input' => '']);
    }
    public function search(Request $request)
    {
        #$person = Person::all(); # 全件
        #$person = Person::find($request->input)->get(); # idで
        $person = Person::where('name', 'like', '%'.$request->input.'%')->get(); # nameで
        $person = Person::nameEqual($request->input)->get(); # local scope
        $person = Person::ageGreaterThan(20)->ageLessThan(40)->get(); # local scope連鎖
        $data = ['input' => $request->input, 'items' => $person];
        return view('person.find', $data);
    }

    public function add(Request $request)
    {
        return view('person.add');
    }
    public function create(Request $request)
    {
        // バリデーション
        $this->validate($request, Person::$rules);
        $person = new Person;
        // フォームデータをすべて使うがtokenだけはcsrf用で認証済みなので不要
        $form = $request->all();
        Log::debug($form);
        unset($form['_token']);
        // フォームの値をまとめてpersonインスタンスに設定してsave保存
        $person->fill($form)->save();
        return redirect('/person');
    }

    public function edit(Request $request)
    {
        // 既存レコードを取得してインスタンス作成
        $person = Person::find($request->id);
        return view('person.edit', ['form' => $person]);
    }
    public function update(Request $request)
    {
        $this->validate($request, Person::$rules);
        // 取得した既存レコードのインスタンスに上書き保存
        $person = Person::find($request->id);
        $form = $request->all();
        unset($form['__token']);
        $person->fill($form)->save();
        return redirect('/person');
    }

    public function delete(Request $request)
    {
        $person = Person::find($request->id);
        return view('person.delete', ['form' => $person]);
    }
    public function remove(Request $request)
    {
        Person::find($request->id)->delete();
        return redirect('/person');
    }

    public function session(Request $request)
    {
        $sessionMsg = $request->session()->get('msg');
        return view('person.session', ['sessionString' => $sessionMsg]);
    }
    public function session_write(Request $request)
    {
        $msg = $request->input;
        $request->session()->put('msg', $msg);
        return redirect('person/session');
    }

}
