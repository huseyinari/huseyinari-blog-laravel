<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class Comments_Seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comment = new Comment();
        $comment->nameSurname = 'Umut Ulutaş';
        $comment->commentContent = 'Çok yararlı bir yazı olmuş. Teşekkürler';
        $comment->postId = 1;
        $comment->save();

        $comment = new Comment();
        $comment->nameSurname = 'Mustafa Arı';
        $comment->commentContent = 'Tam olarak anlayamadım. Yardımcı olur musunuz ?';
        $comment->postId = 1;
        $comment->save();

        $comment = new Comment();
        $comment->nameSurname = 'Oğuzcan Tanrıverdi';
        $comment->commentContent = 'Çok güzel bir anlatım. Teşekkür ederim.';
        $comment->postId = 1;
        $comment->save();

        $comment = new Comment();
        $comment->nameSurname = 'Gültekin Ağacık';
        $comment->commentContent = 'Sade ve anlaşılır bir anlatım olmuş tebrikler.';
        $comment->postId = 2;
        $comment->save();
        
    }
}
