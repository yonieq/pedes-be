<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;

class ComplaintController extends Controller
{
    //
    public function index()
    {
        // return Inertia::render('Pages/Complaint/Index');
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('title', 'LIKE', "%{$value}%")
                        ->orWhere('status', 'LIKE', "%{$value}%")
                        ->orWhere('categoryComplaint', 'LIKE', "%{$value}%")
                        ->orWhere('user', 'LIKE', "%{$value}%");
                });
            });
        });
        $complaints = QueryBuilder::for(Complaint::class)
            ->with(['categoryComplaint', 'user'])
            ->orderBy('created_at', 'asc')
            ->defaultSort('title')
            ->allowedSorts(['title', 'status', 'category_complaint_id', 'user_id'])
            ->allowedFilters(['title', $globalSearch])
            ->paginate(8)
            ->withQueryString();

        $complaints->transform(function ($complaint) {
            return [
                'id' => $complaint->id,
                'title' => $complaint->title,
                'status' => $complaint->status,
                'category_complaint_id' => $complaint->category_complaint_id,
                'category_name' => optional($complaint->categoryComplaint)->name,
                'user_id' => $complaint->user_id,
                'user_name' => optional($complaint->user)->name,
                'created_at' => $complaint->created_at,
                // rubah format tanggal menjadi bahasa indonesia
                'created_at_indo' => $complaint->created_at->translatedFormat('l, d F Y'),
            ];
        });

        return Inertia::render('Pages/Complaint/Index', ['complaints' => $complaints])->table(function (InertiaTable $table) {
            // $table->column('id', 'ID', searchable: true, sortable: true);
            $table->column('title', 'Title', searchable: true, sortable: true);
            $table->column('status', 'Status', searchable: true, sortable: true);
            $table->column('category_name', 'Category', searchable: true, sortable: true);
            $table->column('user_name', 'User', searchable: true, sortable: true);
            $table->column('created_at_indo', 'Tanggal', searchable: true, sortable: true);
        });
    }
}