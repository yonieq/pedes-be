<?php

namespace App\Http\Controllers\API;

use App\Models\CategoryNews;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\API\NewsCategoryResource;

class NewsCategoryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        //
        $newsCategory = CategoryNews::latest()->get();
        return new NewsCategoryResource($newsCategory, 'NewsCategory', Response::HTTP_OK, 'Data fetched successfully');
    }
}