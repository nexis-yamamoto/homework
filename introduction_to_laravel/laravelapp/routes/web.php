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

// artisan http://192.168.253.88:8000/hello
// apache http://192.168.253.88/admin/hello
Route::get('/hello', function() {
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
    