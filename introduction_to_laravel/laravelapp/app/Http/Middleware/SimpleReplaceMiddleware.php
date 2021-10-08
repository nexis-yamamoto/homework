<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SimpleReplaceMiddleware
{
    /**
     * コントローラの吐いたコンテンツを後処理で書き換えるmiddleware
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // コントローラのアクションを実行し、結果のレスポンスを取得
        $response = $next($request);
        // レスポンスのコンテンツ
        $content = $response->content();

        // 正規表現で置換
        $pattern = '/<middleware>(.*)<\/middleware>/i';
        $replace = '<a href="http://$1">$1</a>';
        $content = preg_replace($pattern, $replace, $content);

        // レスポンスに編集後の結果を設定して返却
        $response->setContent($content);
        return $response;
    }
}
