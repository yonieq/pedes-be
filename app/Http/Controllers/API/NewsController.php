<?php

namespace App\Http\Controllers\API;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\NewsResource;
use App\Repository\NewsRepository;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
{
    //
    protected $newsRepository;
    public function __construct(NewsRepository $newsRepository)
    {
        $this->middleware('auth:api');
        $this->newsRepository = $newsRepository;
    }

    public function index()
    {
        //
        $news = $this->newsRepository->getNewsToday();
        return new NewsResource($news, 'News', Response::HTTP_OK, 'Data fetched successfully');
    }
}