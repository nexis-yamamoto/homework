<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use MStaack\LaravelPostgis\Schema\Blueprint;
use App\Models\Meta;


class UpperController extends Controller
{
    public function form()
    {
        $data = [
            'msg' => 'これはBlade Templateのサンプルです'
        ];
        // resources/viewsの下の practice/form.phpを指す
        // practice/form.blade.phpがあるときはこちらが優先
        return view('new', $data);
    }
/*    public function post(Request $request)
    {
        $msg = $request->name;
        $data = [
            'msg' => $msg
        ];
        return view('new', $data);
    }*/

    public function create(Request $request)
    {
        // postパラメータ受け取り
        $name = $request->name;

        // テーブル作成実行
        // against pool schema
        Schema::connection('pool')->dropIfExists($name);

        Schema::connection('pool')->create($name, function (Blueprint $table) {
            $table->id();
            //$table->string('address')->unique();
            //$table->point('location'); // GEOGRAPHY POINT column with SRID of 4326 (these are the default values).
            $table->point('location', 'GEOMETRY', 27700); // GEOMETRY column with SRID of 27700.
            $table->timestamps();
        });

        // 結果view表示
        $data = [
            'msg' => $name . ' table created.'
        ];
        return view('new', $data);
    }

    public function add()
    {
        // TODO against pool schema
        if (Schema::connection('pool')->hasColumn('tests', 'address2')) {
            Schema::connection('pool')->table('tests', function(BluePrint $table){
                $table->dropColumn('address2');
            });
        }
//        if (Schema::hasColumn('tests', 'address')) {
//            $table->cropColumn('address');
//        }

        Schema::connection('pool')->table('tests', function (Blueprint $table) {
            $table->string('address2');
        });

        Schema::connection('pgsql')->table('meta', function (Blueprint $table) {
            $meta = new Meta();
            $meta->column_name = 'address2';
            $meta->save();
        });
    }
}
