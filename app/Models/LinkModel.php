<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkModel extends Model
{
    use HasFactory;

    protected $table = 'links';
    protected $fillable = ['link'];

    public function news(){
        return $this->belongsToMany(NewsModel::class, 'news_links', 'link_id');
    }
}
