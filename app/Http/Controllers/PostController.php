<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;

class PostController extends Controller
{
    public function getLatestPosts(){ // bütün postları en son atılandan başlayarak getir
        $count = 5;
        $latestPosts = Post::orderBy('id','DESC')->paginate($count);
        foreach($latestPosts as $post){
            $post->postContent = strip_tags(htmlspecialchars_decode($post->postContent));   // post içeriğindeki html etiketlerini kaldır
            $post->getCategory;
            $post->getPostOwner;
            $post->starAverage = $post->getRatingAverage(); // postun yıldız ortalaması
            $post->commentCount = $post->getComments()->get()->count(); // yorum sayısı
        }
        return response()->json([
            'status' => true,
            'latestPosts' => $latestPosts
        ]);
    }

    public function getMostReadPosts(){  // En çok okunan postlar
        $count = 3; // kaç adet popüler post çekilecek
        $mostReadPosts = Post::orderBy('viewCount','DESC')->skip(0)->take($count)->get();    // görüntülenme sayısına göre count adet post çek

        return response()->json([
            'status' => true,
            'mostReadPosts' => $mostReadPosts
        ]);
    }

    public function getPopulerPosts(){  // en çok yorum alan postlar
        $count = 3; // kaç adet popüler post çekilecek

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
            $random;
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
    public function youMayAlsoLike($currentPostId,$categoryId){ // post ayrıntıları sayfasında kullanılması için bunları da sevebilirsiniz kısmına okunan post ile aynı kategoriden 2 tane random post buluyor
        $allPosts = Post::where('categoryId',$categoryId)->where('id','!=',$currentPostId)->select(['coverPhoto','title','created_at','seo'])->get(); // parametre olarak gelen kategorinin mevcut post hariç tüm postlarını çek
        $maxPostCount = $allPosts->count();
        
        $anotherPosts = []; // rastege postları tutacak dizi
        $anotherPostsCount = 2; // 2 adet rastgele post çekilecek

        if(count($allPosts) === 0){ // kategoride mevcut post'tan başka post yok ise
            $anotherPosts = [];
        }else if(count($allPosts) === 1){ // farklı olarak 1 post varsa
            $anotherPosts[] = $allPosts[0];
        }else{
            $randomNumbers = [];
            for($i=0; $i < $anotherPostsCount; $i++){
                $random;
                while(1 === 1){
                    $random = rand(0,$maxPostCount-1);  // 0 ile post sayısı arasında bir sayı üret
                    if(!in_array($random,$randomNumbers))   // eğer daha önceden bu sayı üretilmediyse döngüyü kır
                        break;
                }
                $randomNumbers[$i] = $random;
                $anotherPosts[$i] = $allPosts[$random]; // üretilen random sayı olan indisteki postu al
            }
        }
        return $anotherPosts;
    }
    public function getPostDetail($seo){

        $postDetail = Post::where('seo',$seo)->get();
        
        if(count($postDetail) !== 0){
            $postDetail = $postDetail[0];
            $postDetail->getCategory;
            $postDetail->getPostOwner;
            $postDetail->get_comments = $postDetail->getCommentsWithAnswers();

            $anotherPosts = $this->youMayAlsoLike($postDetail->id,$postDetail->categoryId);

            return response()->json([
                'status' => true,
                'details' => $postDetail,
                'anotherPosts' => $anotherPosts
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Yazı Bulunamadı !'
            ]);
        }

    }
    public function getCategoryPosts($seo){ // kategoriye ait postları getir
        $count = 5; // bir sayfada 5 post gösterilecek

        $category = Category::where('seo',$seo)->first();

        if($category === null)
            return;
        
        $posts = Post::where('categoryId',$category->id)->paginate($count);
        foreach ($posts as $post) {
            $post->getPostOwner;
            $post->postContent = strip_tags(htmlspecialchars_decode($post->postContent));   // post içeriğindeki html etiketlerini kaldır
            $post->commentCount = $post->getComments()->get()->count(); // yorum sayısı
        }
        return response()->json([
            'status' => true,
            'posts' => $posts
        ]);
    }
}
