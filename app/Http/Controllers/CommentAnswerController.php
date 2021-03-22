<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Answer;
use Validator;
use JWTAuth;

class CommentAnswerController extends Controller
{
    public function setComment(Request $request){ // yorum yap
        
        $rules = [
            'postId' => 'required|exists:Posts,id',
            'nameSurname' => 'required|min:5|max:50|string',
            'commentContent' => 'required|max:200',
        ];
        $messages = [
            'postId.exists' => 'Yorum yapmaya çalıştığınız yazı kaldırılmış.',
            'nameSurname.required' => 'Lütfen ad soyad alanını doldurunuz.',
            'nameSurname.min' => 'Lütfen geçerli bir ad soyad giriniz.',
            'nameSurname.max' => 'Lütfen geçerli bir ad soyad giriniz.',
            'nameSurname.string' => 'Lütfen geçerli bir ad soyad giriniz.',
            'commentContent.required' => 'Lütfen yorum içeriğini doldurunuz.',
            'commentContent.max' => 'Çok uzun bir yorum girdiniz.',
        ];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $newComment = new Comment();
        $newComment->postId = $request->postId;
        $newComment->nameSurname = $request->nameSurname;
        $newComment->commentContent = $request->commentContent;
        
        if($request->token !== '_'){   // request ile token geldiyse ve token admine aitse
            if(JWTAuth::setToken($request->token)->toUser()->roleId === 1)
                $newComment->isAdminComment = 1;
        }

        $newComment->save();

        return response()->json([
            'status' => true,
            'newComment' => $newComment
        ]);

    }

    public function setAnswer(Request $request){ // yorum yanıtla
        $rules = [
            'commentId' => 'required|exists:Comments,id',
            'nameSurname' => 'required|min:5|max:50|string',
            'answerContent' => 'required|max:200',
        ];
        $messages = [
            'commentId.required' => 'Yanıtlamak için öncelikle bir yorum seçmelisiniz.', 
            'commentId.exists' => 'Yanıtlamaya çalıştığınız yorum kaldırılmış.',
            'nameSurname.required' => 'Lütfen ad soyad alanını doldurunuz.',
            'nameSurname.min' => 'Lütfen geçerli bir ad soyad giriniz.',
            'nameSurname.max' => 'Lütfen geçerli bir ad soyad giriniz.',
            'nameSurname.string' => 'Lütfen geçerli bir ad soyad giriniz.',
            'answerContent.required' => 'Lütfen yorum içeriğini doldurunuz.',
            'answerContent.max' => 'Çok uzun bir yorum girdiniz.',
        ];

        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $newAnswer = new Answer();
        $newAnswer->commentId = $request->commentId;
        $newAnswer->nameSurname = $request->nameSurname;
        $newAnswer->answerContent = $request->answerContent;

        if($request->token !== '_'){
            if(JWTAuth::setToken($request->token)->toUser()->roleId === 1)
                $newAnswer->isAdminAnswer = 1;
        }

        $newAnswer->save();

        return response()->json([
            'status' => true,
            'newAnswer' => $newAnswer
        ]);
    }
}
