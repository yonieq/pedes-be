<?php

namespace App\Http\Controllers;

use App\Models\News;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Collection;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // return Inertia::render('Pages/News/Index');
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('title', 'LIKE', "%{$value}%")
                        ->orWhere('is_active', 'LIKE', "%{$value}%")
                        ->orWhere('categoryNews', 'LIKE', "%{$value}%");
                });
            });
        });
        $news = QueryBuilder::for(News::class)
            ->with('categoryNews')
            ->defaultSort('title')
            ->allowedSorts(['title', 'is_active', 'category_news_id', 'id'])
            ->allowedFilters(['title', $globalSearch])
            ->paginate(8)
            ->withQueryString();

        $news->transform(function ($news) {
            return [
                'title' => $news->title,
                'image' => $news->image,
                'category_news_id' => $news->categoryNews->name,
                'category_name' => optional($news->categoryNews)->name,
                // ubah jika is_active = 1 menjadi active dan jika is_active = 0 menjadi inactive
                'is_active' => $news->is_active == 1 ? 'Active' : 'Inactive',
            ];
        });

        return Inertia::render('Pages/News/Index', ['news' => $news])->table(function (InertiaTable $table) {
            $table->column('title', 'Title', searchable: true, sortable: true);
            $table->column('is_active', 'Active', searchable: true, sortable: true);
            $table->column('category_name', 'Category', searchable: true, sortable: true);
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}