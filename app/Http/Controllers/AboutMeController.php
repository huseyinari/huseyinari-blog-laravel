<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;

class AboutMeController extends Controller
{
    public function getMyInfo(){
        $me = User::where('id',1)->select(['email','about','instagramAddress','facebookAddress','youtubeAddress','twitterAddress','photo'])->first();

        return response()->json([
            'status' => true,
            'aboutMe' => $me
        ]);
    }

    public function updateMyInfo(Request $request){
        $me = JWTAuth::user();

        $me->instagramAddress = $request->instagramAddress;
        $me->twitterAddress = $request->twitterAddress;
        $me->facebookAddress = $request->facebookAddress;
        $me->youtubeAddress = $request->youtubeAddress;
        $me->about = $request->about;
        $me->save();

        return response()->json([
            'status' => true,
            'message' => 'Bilgiler başarıyla güncellendi.'
        ]);
    }
}
