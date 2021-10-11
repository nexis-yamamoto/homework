<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeopleController extends Controller
{
    public function index(Request $request) {
        $items = DB::table('people')->get();
        return view('people.index', ['items' => $items]);
    }

    public function show(Request $request) {
        if (isset($request->keyword)) {
            $items = DB::table('people')
                ->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('mail', 'like', '%' . $request->keyword . '%')
                ->get();
        } else if (isset($request->minage) and isset($request->maxage)) {
            $items = DB::table('people')
                ->whereRaw('age >= ? and age <= ?', [$request->minage, $request->maxage])
                ->orderBy('age', 'asc')
                ->get();
        } else {
            $page = 0;
            $items = DB::table('people')
                ->offset($page * 3)
                ->limit(3)
                ->get();
        }
        return view('people.show', ['items' => $items]);
    }

    public function add(Request $request) {
        return view('people.add');
    }

    public function create(Request $request) {
        $param = [
            'name' => $request->name,
            'mail' => $request->mail,
            'age' => $request->age,
        ];
        DB::table('people')->insert($param);
        //DB::insert('insert into people (name,mail,age) values (:name,:mail,:age)', $param);
        return redirect('/people');
    }

    public function edit(Request $request, $id) {
        $param = ['id'=>$id];
        $item = DB::select('select * from people where id=:id', $param);
        return view('people.edit', ['form' => $item[0]]);
    }

    public function update(Request $request) {
        $param = [
//            'id' => $request->id,
            'name' => $request->name,
            'mail' => $request->mail,
            'age' => $request->age,
        ];
        DB::table('people')
            ->where('id', $request->id)
            ->update($param);
        //DB::update('update people set name=:name, mail=:mail, age=:age where id=:id', $param);
        return redirect('/people');
    }

    public function delete($id) {
        $param = ['id'=>$id];
        $item = DB::select('select * from people where id=:id', $param);
        return view('people.delete', ['form' => $item[0]]);
    }

    public function remove(Request $request) {
        $param = [
            'id' => $request->id
        ];
        //DB::delete('delete from people where id=:id', $param);
        DB::table('people')
            ->where('id', $request->id)
            ->delete();
        return redirect('/people');
    }
}
