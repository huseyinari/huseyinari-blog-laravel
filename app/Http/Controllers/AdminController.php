<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Validator;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Answer;

class AdminController extends Controller
{
    // addPost,deletePost,updatePost ve deleteCategory kısmındaki kapak fotoğrafı ile ilgili yorum satırlı kısımlar, kapak fotoğrafını kendi sunucuma yüklemek istersem kullanabileceğim kısımlar

    public function adminControl(){
        $user = JWTAuth::user();
        
        if($user->roleId === 1)
            return response()->json(['status' => true]);
        else
            return response()->json(['status' => false]);
    }

    // postlar
    public function getAllPosts(){
        $posts = Post::orderBy('id','DESC')->get();
        
        return response()->json([
            'status' => true,
            'posts' => $posts
        ]);
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
        
        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        try{
            $postSeo = Str::slug($request->title);
            /*
            $photo = $request->coverPhoto;
            $photoName = $postSeo.'.' . explode('/', explode(':', substr($photo, 0, strpos($photo, ';')))[1])[1];
            \Image::make($photo)->save(public_path('post_images/').$photoName);
            */

            $post = new Post();
            $post->title = $request->title;
            $post->postContent = $request->postContent;
            $post->categoryId = $request->categoryId;
            $post->postOwner = JWTAuth::user()->id;
            $post->seo = $postSeo;
            //$post->coverPhoto = $photoName;
            $post->coverPhoto = $request->coverPhoto;
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
    public function deletePost(Request $request){
        $post = Post::where('id',$request->id)->first();

        if(!$post)
            return;

        try{
            // \unlink(public_path('post_images/' . $post->coverPhoto));
            $post->delete();
            return response()->json(['status' => true,'message' => 'Yazı başarıyla silindi.']);
        }catch(Exception $e){
            return response()->json(['status' => false,'message' => 'Yazı silinirken bir hata oluştu !']);
        }
    }
    public function updatePost(Request $request){
        $post = Post::where('id',$request->id)->first();
        
        if(!$post)
            return;
        
        $rules = [
            'title' => 'required|min:5|max:100',
            'postContent' => 'required',
            'categoryId' => 'required|exists:Categories,id',
            'coverPhoto' => 'required'
        ];
        $messages = [
            'title.required' => 'Yazı başlığı alanı doldurulmalıdır.',
            'title.min' => 'Yazı başlığı en az 5 karakterden oluşmalıdır.',
            'title.max' => 'Yazı başlığı en fazla 100 karakterden oluşmalıdır',
            'postContent.required' => 'Yazı içeriği doldurulmalıdır.',
            'categoryId.required' => 'Lütfen yazının kategorisini seçiniz.',
            'categoryId.exists' => 'Geçerli bir kategori seçiniz.',
            'coverPhoto.required' => 'Yazıya ait kapak resmi ekleyiniz.'
        ];
        
        $validator = Validator::make($request->all(),$rules,$messages);
        
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        // gönderilen yazı başlığı eskisinden farklıysa ve farklı bir yazıya aitse hatasını ekle
        $titleControl = Post::where('title',$request->title)->first();
        if($post->title !== $request->title && $titleControl){
            return response()->json(['status' => false, 'errors' => ['postContent' => 'Bu başlık daha önceden eklenmiş.']]);
        }

        // yazı bilgilerini güncelleme işlemleri
        $post->title = $request->title;
        $post->postContent = $request->postContent;
        $post->seo = Str::slug($request->title);
        $post->categoryId = $request->categoryId;
        $post->coverPhoto = $request->coverPhoto;
        /*
        if($request->coverPhoto){ // kapak fotoğrafı da yollanmışsa eskiyi silip yerine yenisini ekle
            unlink(public_path('post_images/') . $post->coverPhoto);
            $image = $request->post('coverPhoto');
            $name = Str::slug($request->title) . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($image)->save(public_path('post_images/').$name);

            $post->coverPhoto = $name;
        }
        */
        $post->save();

        return response()->json([
            'status' => true,
            'message' => 'Yazı başarıyla güncellendi.'
        ]);
    }

    // resimler
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

    // kategoriler
    public function addCategory(Request $request){
        $requestData = $request->all();
        $request['categoryDescription'] = str_replace(array("\n"),'',trim($request->categoryDescription));  // kategori açıklama kısmı textarea ile yazılıp gönderildiği için içindeki '\n' leri siliyorum
        
        $rules = [
            'categoryName' => 'required|max:100|unique:Categories,categoryName',
            'categoryDescription' => 'required|max:500'
        ];
        $messages = [
            'categoryName.required' => 'Kategori adı alanını doldurunuz.',
            'categoryName.max' => 'Kategori adı en fazla 100 karakter olmalıdır.',
            'categoryName.unique' => 'Bu kategori daha önceden eklenmiş.',
            'categoryDescription.required' => 'Kategori açıklamasını doldurunuz.',
            'categoryDescription.max' => 'Kategori açıklaması en fazla 500 karakter olmalıdır.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        $newCategory = new Category();
        $newCategory->categoryName = $request->categoryName;
        $newCategory->seo = Str::slug($request->categoryName);
        $newCategory->categoryDescription = $request->categoryDescription;
        $newCategory->save();

        return response()->json(['status' => true,'newCategory' => $newCategory]);
    }
    public function updateCategory(Request $request){
        $category = Category::where('id',$request->id)->firstOrFail();
        
        $requestData = $request->all();
        $request['categoryDescription'] = str_replace(array("\n"),'',trim($request->categoryDescription));  // kategori açıklama kısmı textarea ile yazılıp gönderildiği için içindeki '\n' leri siliyorum
        
        $rules = [
            'categoryName' => 'required|max:100',
            'categoryDescription' => 'required|max:500'
        ];
        $messages = [
            'categoryName.required' => 'Kategori adı alanını doldurunuz.',
            'categoryName.max' => 'Kategori adı en fazla 100 karakter olmalıdır.',
            'categoryDescription.required' => 'Kategori açıklamasını doldurunuz.',
            'categoryDescription.max' => 'Kategori açıklaması en fazla 500 karakter olmalıdır.'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $category->categoryName = $request->categoryName;
        $category->categoryDescription = $request->categoryDescription;
        $category->save();

        return response()->json([
            'status' => true,
            'category' => $category
        ]);
    }
    public function deleteCategory(Request $request){
        $category = Category::where('id',$request->id)->first();
        if(!$category){
            return response()->json(['status' => false]);
        }
        // kategoriye ait postların kapak fotoğraflarını sil - postlar,yorumlar... onDelete('cascade') olarak ayarlı olduğu için veritabanı kaldıracak
        /*
        $posts = Post::where('categoryId',$request->id)->get();
        foreach($posts as $post){
            unlink(public_path('post_images/') . $post->coverPhoto);
        }
        */

        $category->delete();
        return response()->json(['status' => true]);
    }

    // yorumlar-cevaplar
    public function getAllComments(){
        $comments = Comment::orderBy('created_at','DESC')->get();
        
        foreach($comments as $comment){
            $comment->getAnswers;
            $comment->getPostDetails;
        }

        return response()->json([
            'status' => true,
            'comments' => $comments
        ]);
    }
    public function deleteComment(Request $request){
        $comment = Comment::where('id',$request->id)->firstOrFail();
        $comment->delete();
        return response()->json(['status' => true]);
    }
    public function deleteAnswer(Request $request){
        $answer = Answer::where('id',$request->id)->firstOrFail();
        $answer->delete();
        return response()->json(['status' => true]);
    }
}
