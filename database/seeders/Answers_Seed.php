<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Answer;

class Answers_Seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $answer = new Answer();
        $answer->nameSurname = 'Hüseyin ARI';
        $answer->answerContent = 'Anlayamadığınız yeri belirtirseniz yardımcı olabilirim...';
        $answer->commentId = 2;
        $answer->save();

        $answer = new Answer();
        $answer->nameSurname = 'Hüseyin ARI';
        $answer->answerContent = 'Rica ederiz. İyi günler...';
        $answer->commentId = 3;
        $answer->save();

        $answer = new Answer();
        $answer->nameSurname = 'Deniz Tuna';
        $answer->answerContent = "Java nesne yönelimli programlama";
        $answer->commentId = 74;
        $answer->save();
    }
}
