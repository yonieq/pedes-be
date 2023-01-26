<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\ComplaintCategoryResource;
use App\Models\CategoryComplaint;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ComplaintCategoryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $complaintCategories = CategoryComplaint::all();
        return new ComplaintCategoryResource($complaintCategories, 'ComplaintCategory', Response::HTTP_OK, 'Data fetched successfully');
    }
}