<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Laravel8以降、RouteServiceProvider.phpでnamespaceを解決してくれないので
// フルパスでControllerを記述する

// artisan http://192.168.253.88:8000/hello
Route::get('hello', 'App\Http\Controllers\HelloController@index');
// artisan http://192.168.253.88:8000/hello/view/yamamoto/2
Route::get('hello/view/{name?}/{no?}', 'App\Http\Controllers\HelloController@view');
Route::get('hello/some', 'App\Http\Controllers\HelloController@some');
Route::get('hello/other', 'App\Http\Controllers\HelloController@other');

// シングルアクションコントローラなら@action名を省略
// artisan http://192.168.253.88:8000/single
Route::get('single/{id?}', 'App\Http\Controllers\SingleActionController');



// artisan http://192.168.253.88:8000/practice/2
// phpテンプレートの使用＆routeパラメータ渡し
Route::get('practice/{id}', 'App\Http\Controllers\PracticeController@index');
// artisan http://192.168.253.88:8000/query?id=5
// phpテンプレート使用＆クエリ文字列を使う
Route::get('query', 'App\Http\Controllers\PracticeController@query');

// http://192.168.253.88:8000/blade/form
Route::get('blade/form', 'App\Http\Controllers\PracticeController@blade');
Route::post('blade/form', 'App\Http\Controllers\PracticeController@post');
// http://192.168.253.88:8000/blade/loop
Route::get('blade/loop', 'App\Http\Controllers\PracticeController@loop');

// http://192.168.253.88:8000/easy
Route::get('easy', 'App\Http\Controllers\EasyController@index')
    ->middleware('simple'); // Kernel.phpのrouteMiddlewareに登録して名称でつかうか
//    ->middleware(\App\Http\Middleware\SimpleMiddleware::class); // フルパスでつかうかのどちらか

Route::get('validation', 'App\Http\Controllers\ValidationController@index');
Route::post('validation', 'App\Http\Controllers\ValidationController@post');

Route::get('validation/custom', 'App\Http\Controllers\ValidationController@form');
Route::post('validation/custom', 'App\Http\Controllers\ValidationController@custom');

Route::get('validation/original', 'App\Http\Controllers\ValidationController@original_form');
Route::post('validation/original', 'App\Http\Controllers\ValidationController@original');

Route::get('cookie', 'App\Http\Controllers\EasyController@cookie');
Route::post('cookie', 'App\Http\Controllers\EasyController@cookie_post');


Route::get('people', 'App\Http\Controllers\PeopleController@index');
Route::get('people/add', 'App\Http\Controllers\PeopleController@add');
Route::post('people/add', 'App\Http\Controllers\PeopleController@create');

Route::get('people/edit/{id}', 'App\Http\Controllers\PeopleController@edit');
Route::post('people/edit', 'App\Http\Controllers\PeopleController@update');

Route::get('people/delete/{id}', 'App\Http\Controllers\PeopleController@delete');
Route::post('people/delete', 'App\Http\Controllers\PeopleController@remove');


///
/// 以下直に返す例
///

// artisan http://192.168.253.88:8000/hi
// apache http://192.168.253.88/admin/hi
Route::get('/hi', function() {
    return '<html><body><h1>hello</h1></body></html>';
});

$html = <<<EOF
<html>
<head>
<title>hello</title>
<style>
body { font-size: 16pt; color: #999; }
h1 { font-size: 100pt; text-align: right; color: #eee;
    margin: -40px 0px -50px 0px; /* 上 | 右 | 下 | 左 */}
</style>
</head>
<body>
<h1>hello</h1>
<p>This is a sample page.</p>
</body>
</html>
EOF;

// artisan http://192.168.253.88:8000/here
// 関数内外で名前空間が違うので(無印とRoute?)
// 変数$htmlはuseをつかって解消する
Route::get('/here', function() use ($html) {
    return $html;
});

// artisan http://192.168.253.88:8000/here/some_message
// getパラメータ渡し
Route::get('/here/{msg}', function($msg) {
$html = <<<EOF
<html>
<head>
<title>hello</title>
<style>
body { font-size: 16pt; color: #999; }
h1 { font-size: 100pt; text-align: right; color: #eee;
    margin: -40px 0px -50px 0px; /* 上 | 右 | 下 | 左 */}
</style>
</head>
<body>
<h1>hello</h1>
<p>This is a sample page.</p>
<p>{$msg}</p>
</body>
</html>
EOF;
    return $html;
});

// artisan http://192.168.253.88:8000/here/some_message
// getパラメータ渡し、2パラメータ目は省略してもよい
Route::get('/param/{msg}/{msg2?}', function($msg, $msg2='no message') {
    $html = <<<EOF
<html>
<head>
<title>hello</title>
<style>
body { font-size: 16pt; color: #999; }
h1 { font-size: 100pt; text-align: right; color: #eee;
    margin: -40px 0px -50px 0px; /* 上 | 右 | 下 | 左 */}
</style>
</head>
<body>
<h1>hello</h1>
<p>This is a sample page.</p>
<p>{$msg}</p>
<p>{$msg2}</p>
</body>
</html>
EOF;
    return $html;
});
    