<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HelloMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // コントローラのアクションが実行され、その結果のレスポンスが変数$responseに収められる
        $response = $next($request);
        // レスポンスに設定されているコンテンツが取得できる。
        //これは送り返されるHTMLソースコードのテキストが入っている。<middleware>というタグを正規表現で置き換える。
        $content = $response->content();
        // <middleware>◯◯</middleware>というテキストを<a href="http://◯◯">◯◯</a>というテキストに置き換えする処理
        // これにより<middleware>というタグにドメイン名を書いておけば、そのドメインにアクセスするためのリンクが自動生成される
        $pattern = '/<middleware>(.*)<\/middleware>/i';
        $replace = '<a href="http://$1">$1</a>';
        $content = preg_replace($pattern, $replace, $content);
        // setContentメソッドでレスポンスにコンテンツを設定
        $response->setContent($content);
        return $response;
    }
}