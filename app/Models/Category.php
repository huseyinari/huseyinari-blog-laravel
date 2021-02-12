<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'Categories';
    protected $fillable = ['categoryName','categoryDescription','seo'];

    public function getPosts(){
        return $this->hasMany('App\Models\Post','categoryId','id');
    }
    public function getPostCount(){ // kategoriye ait kaç adet post var
        return $this->getPosts()->get()->count();
    }
}
