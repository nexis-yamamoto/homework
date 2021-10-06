<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

global $head, $style, $body, $end;
$head = '<html><head>';
$style =<<<EOF
<style>
body { font-size: 16pt; color: #999; }
h1 { font-size: 100pt; text-align: right; color: #eee;
    margin: -40px 0px -50px 0px; /* 上 | 右 | 下 | 左 */}
</style>
EOF;
$body = '</head><body>';
$end = '</body></html>';

function tag($tag, $text) {
    return "<$tag>" . $text . "</$tag>";
}

class HelloController extends Controller
{
    public function index() {
        return <<<EOF
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
<p>This is a controller sample page.</p>
</body>
</html>
EOF;
    }

    public function view($name='unknown', $no='0') {
        return <<<EOF
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
<p>{$no}番の{$name}さんです.</p>
</body>
</html>
EOF;
    }

    function some() {
        global $head, $style, $body, $end;
        $html = $head . tag('title', 'hello/some') . $style . $body .
            tag('h1', 'Some') . tag('p', 'some page.') . '<a href="other">goto other</a>' . $end;
        return $html;
    }
    function other() {
        global $head, $style, $body, $end;
        $html = $head . tag('title', 'hello/other') . $style . $body .
            tag('h1', 'Other') . tag('p', 'other page.') . '<a href="some">goto some page</a>' . $end;
        return $html;
    }

}
