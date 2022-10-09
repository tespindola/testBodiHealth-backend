<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileModel extends Model
{
    use HasFactory;

    protected $table = 'profiles';
    protected $fillable = ['link'];

    public function news(){
        return $this->belongsToMany(NewsModel::class, 'news_profiles', 'profile_id');
    }
}
