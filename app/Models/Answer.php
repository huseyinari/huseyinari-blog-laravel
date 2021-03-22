<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'Answers';

    protected function serializeDate(DateTimeInterface $date){  // created_at ve updated_at tarihleri çekilirken ISO-8601 formatını(2019-12-02T20:01:00) kullandığı için tarihleri daima UTC olarak kabul ediyor. 
        return $date->format('Y-m-d H:i:s');                    // Timezone olarak Europe/Istanbul kullanmak için bu formatı da değiştirmemiz lazım
    }
}
