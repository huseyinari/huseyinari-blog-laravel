<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'Posts';

    public function getCategory(){
        return $this->hasOne('App\Models\Category','id','categoryId')->select('categoryName');
    }
    public function getPostOwner(){
        return $this->hasOne('App\Models\User','id','postOwner')->select(['nameSurname','about','instagramAddress','twitterAddress','youtubeAddress','facebookAddress','photo']);
    }
    public function getComments(){
        return $this->hasMany('App\Models\Comment','postId','id')->select(['nameSurname','commentContent','created_at']);
    }
    public function getRatings(){
        return $this->hasMany('App\Models\Rating','postId','id')->select('star');
    }
    public function getRatingAverage(){ // postun yıldız ortalamasını bul
        $ratings = $this->getRatings()->get();
        $average = 0;
        $indis = 1;
        foreach ($ratings as $rating) {
            $average += $rating['star'];
            $average /= $indis++;
        }
        return floor($average);
    }
}
