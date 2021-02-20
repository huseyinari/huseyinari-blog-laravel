<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\Models\Post;
use Validator;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function adminControl(){
        $user = JWTAuth::user();
        
        if($user->roleId === 1)
            return response()->json(['status' => true]);
        else
            return response()->json(['status' => false]);
    }

    public function addPost(Request $request){
        $rules = [
            'title' => 'required|min:5|max:100|unique:Posts,title',
            'postContent' => 'required',
            'categoryId' => 'required|exists:Categories,id',
            'coverPhoto' => 'required'
        ];
        $messages = [
            'title.required' => 'Yazı başlığı alanı doldurulmalıdır.',
            'title.min' => 'Yazı başlığı en az 5 karakterden oluşmalıdır.',
            'title.max' => 'Yazı başlığı en fazla 100 karakterden oluşmalıdır',
            'title.unique' => 'Bu yazı daha önceden eklenmiş',
            'postContent.required' => 'Yazı içeriği doldurulmalıdır.',
            'categoryId.required' => 'Lütfen yazının kategorisini seçiniz.',
            'categoryId.exists' => 'Geçerli bir kategori seçiniz.',
            'coverPhoto.required' => 'Lütfen yazıya bir kapak fotoğrafı seçiniz.' 
        ];
        
        $validate = Validator::make($request->all(),$rules,$messages);
        if($validate->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validate->errors()
            ]);
        }

        try{
            $postSeo = Str::slug($request->title);

            $photo = $request->coverPhoto;
            $photoName = $postSeo.'.' . explode('/', explode(':', substr($photo, 0, strpos($photo, ';')))[1])[1];
            \Image::make($photo)->save(public_path('post_images/').$photoName);
        
            $post = new Post();
            $post->title = $request->title;
            $post->postContent = $request->postContent;
            $post->categoryId = $request->categoryId;
            $post->postOwner = JWTAuth::user()->id;
            $post->seo = $postSeo;
            $post->coverPhoto = $photoName;
            $post->save();

            return response()->json([
                'status' => true,
                'message' => 'Yazı başarıyla eklendi.'
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'errors' => [
                    'serverError' => 'Yazı eklenirken hata oluştu. Daha sonra tekrar deneyiniz.'
                ]
            ]);
        }
        
    }

    public function addImage(Request $request){ // yazılar için resim yükleme
        if($request->post('file'))
       {
          try{
              $image = $request->post('file');
              $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
              \Image::make($image)->save(public_path('post_images/').$name);
          }catch(Exception $e){
            return response()->json(['status' => false]);
          }

          return response()->json(['status' => true,'url' => url('/') . '/post_images/' . $name]); // resim yükleme başarılı ise dosya url'iyle birlikte dön
        }
        return response()->json(['status' => false]);
    }
}
