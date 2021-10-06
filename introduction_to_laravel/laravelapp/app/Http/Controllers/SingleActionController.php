<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SingleActionController extends Controller
{
    // パラメータidとRequest, Responseは順番を問わない模様
    public function __invoke($id='0', Request $request, Response $response) {
        $url = $request->url();
        $fullUrl = $request->fullUrl();
        $path = $request->path();
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
        <h3>Request</h3>
        <pre>$request</pre>
        <h3>Request Url</h3>
        <pre>$url</pre>
        <h3>Request Full Url</h3>
        <pre>$fullUrl</pre>
        <h3>Request Path</h3>
        <pre>$path</pre>
        <h3>Response</h3>
        <pre>$response</pre>
    
        <p>これはシングルアクションのコントローラです</p>
        <p>id={$id}</p>
        </body>
        </html>
        EOF;

        $response->setContent($html);
        return $response;
    }
}
