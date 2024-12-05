<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'category_id',
        'image_path'
    ];

    
    protected $appends = ['excerpt', 'reading_time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
        public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->content), 150);
    }

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return ceil($wordCount / 200);
        }
}