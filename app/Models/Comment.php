<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'Comments';
    
    protected function serializeDate(DateTimeInterface $date){  // created_at ve updated_at tarihleri çekilirken ISO-8601 formatını(2019-12-02T20:01:00) kullandığı zaman daima UTC kullanılıyor. 
        return $date->format('Y-m-d H:i:s');                    // Timezone olarak Istanbul kullanmak için bu formatı da değiştirmemiz lazım
    }


    public function getAnswers(){
        return $this->hasMany('App\Models\Answer','commentId','id')->select(['id','nameSurname','answerContent','created_at','isAdminAnswer']);
    }
    public function getPostDetails(){
        return $this->hasOne('App\Models\Post','id','postId')->select(['title','seo']);
    }
}
