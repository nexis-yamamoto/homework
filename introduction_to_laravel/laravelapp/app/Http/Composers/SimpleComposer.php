<?php

namespace App\Http\Composers;

use Illuminate\View\View;

// ControllerでやらないことだけどViewにいれるにははばかられるコードの置き場所
// Viewのライブラリ的位置？
class SimpleComposer
{
    public function compose(View $view)
    {
        $view->with('view_message2', 'this is ' . $view->getName() . 'view!.' );
    }
}