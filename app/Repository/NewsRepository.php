<?php

namespace App\Repository;

use App\Models\News;

class NewsRepository
{
    public function getNewsToday()
    {
        $news = News::where('is_active', true)->whereDate('created_at', '=', now())->paginate(10);

        return $news;
    }
}