<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index(Request $resuest)
    {
        $items = Person::all();
        return view('person.index', ['items' => $items]);
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


}
