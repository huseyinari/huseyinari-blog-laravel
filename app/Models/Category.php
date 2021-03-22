<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Category extends Model
{
    use HasFactory;

    protected $table = 'Categories';
    protected $fillable = ['categoryName','categoryDescription','seo'];

    protected function serializeDate(DateTimeInterface $date){  // created_at ve updated_at tarihleri çekilirken ISO-8601 formatını(2019-12-02T20:01:00) kullandığı zaman daima UTC kullanılıyor. 
        return $date->format('Y-m-d H:i:s');                    // Timezone olarak Istanbul kullanmak için bu formatı da değiştirmemiz lazım
    }
    

    public function getPosts(){
        return $this->hasMany('App\Models\Post','categoryId','id');
    }
    public function getPostCount(){ // kategoriye ait kaç adet post var
        return $this->getPosts()->get()->count();
    }
}
