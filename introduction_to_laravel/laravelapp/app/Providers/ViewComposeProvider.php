<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposeProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // サンプルなので無名関数でちょっとやっとく場合
        View::composer(
            'easy.simple', function($view) {
                $view->with('view_message1', 'composer message!');
            }
        );

        // ちゃんとクラス使う場合
        View::composer(
            'easy.simple', 'App\Http\Composers\SimpleComposer'
        );
    }
}
