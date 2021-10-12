<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class BoardController extends Controller
{
    public function index(Request $request)
    {
        //DB::enableQueryLog();
        // 愚直に全件取得、リレーションは聞かれたときに毎度とる
        //$records = Board::all();
        // withでEagerローディングして全件取得(結果は同じ)
        $records = Board::with('person')->get();
        //$log = DB::getQueryLog();
        //Log::debug('index');
        //Log::debug($log);
        //DB::disableQueryLog();

        return view('board.index', ['items' => $records]);
    }

    public function add(Request $request)
    {
        return view('board.add');
    }
    public function create(Request $request)
    {
        $this->validate($request, Board::$rules);
        $board = new Board();
        $form = $request->all();
        Log::debug($form);
        unset($form['_token']);
        $board->fill($form)->save();
        return redirect('/board');
    }
}
