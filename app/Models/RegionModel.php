<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionModel extends Model
{
    use HasFactory;

    protected $table = 'regions';
    protected $fillable = ['name'];

    public function news(){
        return $this->belongsToMany(NewsModel::class, 'news_regions', 'region_id');
    }
}
