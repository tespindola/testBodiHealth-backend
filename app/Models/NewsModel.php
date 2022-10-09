<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsModel extends Model
{
    use HasFactory;

    protected $table = 'news';
    protected $fillable = ['title', 'content', 'published', 'labels'];
    protected $casts = [
        'labels' => 'array'
    ];

    public function links(){
        return $this->belongsToMany(LinkModel::class, 'news_links', 'news_id', 'link_id');
    }

    public function categories(){
        return $this->belongsToMany(CategoryModel::class, 'news_categories', 'news_id', 'category_id');
    }

    public function profiles(){
        return $this->belongsToMany(ProfileModel::class, 'news_profiles', 'news_id', 'profile_id');
    }
    public function regions(){
        return $this->belongsToMany(RegionModel::class, 'news_regions', 'news_id', 'region_id');
    }
}
