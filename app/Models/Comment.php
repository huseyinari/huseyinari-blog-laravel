<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'Comments';

    public function getAnswers(){
        return $this->hasMany('App\Models\Answer','commentId','id')->select(['nameSurname','answerContent','created_at','isAdminAnswer']);
    }
    public function getPostDetails(){
        return $this->hasOne('App\Models\Post','id','postId')->select(['title','seo']);
    }
}
