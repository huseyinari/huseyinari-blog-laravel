<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Post extends Model
{
    use HasFactory;

    protected $table = 'Posts';

    protected function serializeDate(DateTimeInterface $date){  // created_at ve updated_at tarihleri çekilirken ISO-8601 formatını(2019-12-02T20:01:00) kullandığı zaman daima UTC kullanılıyor. 
        return $date->format('Y-m-d H:i:s');                    // Timezone olarak Istanbul kullanmak için bu formatı da değiştirmemiz lazım
    }
    

    public function getCategory(){
        return $this->hasOne('App\Models\Category','id','categoryId')->select(['categoryName','seo']);
    }
    public function getPostOwner(){
        return $this->hasOne('App\Models\User','id','postOwner')->select(['nameSurname','about','instagramAddress','twitterAddress','youtubeAddress','facebookAddress','photo']);
    }
    public function getComments(){
        return $this->hasMany('App\Models\Comment','postId','id')->select(['nameSurname','commentContent','created_at','id','isAdminComment']);
    }
    // ----------- ilişkilerin dışındaki fonksiyonlar -------------------------

    public function getCommentsWithAnswers(){   // yorumları cevaplar ile birlikte getir
        $comments = $this->getComments()->get(); // ilişki fonksiyonundan yorumları alıp döngü ile yorumları ekle
        foreach($comments as $comment){
            $comment->getAnswers;
        }
        return $comments;
    }
}
