<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'title',
        'description',
        'image',
        'category_news_id',
        'is_active',
    ];

    /**
     * Get the category news that owns the news.
     */

    public function categoryNews()
    {
        return $this->belongsTo(CategoryNews::class);
    }
}