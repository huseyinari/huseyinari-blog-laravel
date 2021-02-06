<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
    public function getLatestPosts(){ // bütün postları en son atılandan başlayarak getir
        $count = 3;
        $latestPosts = Post::orderBy('id','DESC')->paginate($count);
        foreach($latestPosts as $post){
            $post->postContent = strip_tags(htmlspecialchars_decode($post->postContent));   // post içeriğindeki html etiketlerini kaldır
            $post->getCategory;
            $post->getPostOwner;
            $post->starAverage = $post->getRatingAverage(); // postun yıldız ortalaması
        }
        return response()->json([
            'status' => true,
            'latestPosts' => $latestPosts
        ]);
    }

    public function getMostReadPosts(){  // En çok okunan postlar
        $count = 2; // kaç adet popüler post çekilecek
        $mostReadPosts = Post::orderBy('viewCount','DESC')->skip(0)->take($count)->get();    // görüntülenme sayısına göre count adet post çek

        return response()->json([
            'status' => true,
            'mostReadPosts' => $mostReadPosts
        ]);
    }

    public function getPopulerPosts(){  // en çok yorum alan postlar
        $count = 2; // kaç adet popüler post çekilecek

        $populerPosts = Post::all();
        foreach ($populerPosts as $post) {
            $post->commentCount = $post->getComments->count();  // postların içine yorum sayılarını ve yorumlarını ekle
        }
        $populerPosts = collect($populerPosts)->sortBy('commentCount')->reverse()->take($count)->values(); 
        // popüler postları collection yaparak commentCount'a göre büyükten küçüğe sıralıyor,count tanesini ve sadece value'ları alıyor. (collection yapınca elemanların başına key olarak indislerini eklediği için value'ları aldım)

        return response()->json([
            'status' => true,
            'populerPosts' => $populerPosts
        ]);
    }

    public function getRandomPosts(){
        $allPosts = Post::all();
        $postCount = $allPosts->count();

        $randomPosts = [];
        $randomPostCount = 4;   // 4 adet random post üretilecek

        $randomNumbers = [];

        // 4 adet birbirinden farklı random sayı üretme
        for($i=0; $i<$randomPostCount; $i++){
            while(1===1){
                $random = rand(0,$postCount-1); // 0 ile toplam post sayısı arasında random sayı üret
                if(!in_array($random,$randomNumbers))   // daha önceden dizimize eklenmediyse döngüden çıkarak diziye ekle
                    break;
            }
            $randomNumbers[] = $random;
        }

        // üretilen sayıları indis olarak kullanarak random postları seçme
        for($i=0; $i<$randomPostCount; $i++){
            $randomPosts[$i] = $allPosts[$randomNumbers[$i]];
            $randomPosts[$i]->getCategory;
            $randomPosts[$i]->getPostOwner;
        }

        return response()->json([
            'status' => true,
            'randomPosts' => $randomPosts
        ]);
    }
}
