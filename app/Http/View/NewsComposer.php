<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\News;
use App\Models\NewsBottom;

class NewsComposer
{
    public function compose(View $view)
    {
        $news = News::all();
        $newsbottom = NewsBottom::all();

        $view->with(compact('news', 'newsbottom'));
    }
}
