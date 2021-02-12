<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Users_Seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->nameSurname = 'Hüseyin ARI';
        $user->email = 'hsynari1060@gmail.com';
        $user->about = 'Merhaba ben Hüseyin ARI. Necmettin Erbakan Üniversitesi Bilgisayar Mühendisliği 4. sınıf öğrencisiyim. Web teknolojileri alanında kendimi geliştirmekteyim. Daha fazla içerik için lütfen takipte kalın...';
        $user->instagramAddress = 'https://www.instagram.com/hsynnari/';
        $user->facebookAddress = 'https://www.facebook.com/hsyn.arii';
        $user->youtubeAddress = 'https://www.youtube.com/channel/UC4G-fAG-njYA8pA_14ocCBQ';
        $user->photo = 'huseyin-ari.jpg';
        $user->roleId = 1;
        $user->isActive = 1;
        $user->password = Hash::make('ikizler42'); 
        $user->save();

        $user = new User();
        $user->nameSurname = 'Mustafa ARI';
        $user->email = 'mustafaari161@gmail.com';
        $user->roleId = 2;
        $user->isActive = 1;
        $user->password = Hash::make('7087231999'); 
        $user->save();
    }
}
