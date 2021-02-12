<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use Illuminate\Support\Str;

class Posts_Seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Post::factory(100)->create();

        $post = new Post();
        $post->title = 'C Dilinde Değişkenler';
        $post->coverPhoto = 'c_degiskenler.jpg';
        $post->postOwner = 1;
        $post->viewCount = 10;
        $post->postContent = '<div> <h1> C Dilinde Değişkenler </h1> </div>';
        $post->categoryId = 1;
        $post->seo = Str::slug('C Dilinde Değişkenler');
        $post->save();

        $post = new Post();
        $post->title = 'Java Dilinde Döngüler';
        $post->coverPhoto = 'java_donguler.jpg';
        $post->postOwner = 1;
        $post->viewCount = 55;
        $post->postContent = '<div> <h1> Java Dilinde Döngüler </h1> </div>';
        $post->categoryId = 2;
        $post->seo = Str::slug('Java Dilinde Döngüler');
        $post->save();

        $post = new Post();
        $post->title = 'C Pointer Kullanımı';
        $post->coverPhoto = 'c_pointer.jpg';
        $post->postOwner = 1;
        $post->viewCount = 30;
        $post->postContent = '<div> <h1> C Dilinde Pointer Nedir ? Nasıl Kullanılır ? </h1> </div>';
        $post->categoryId = 1;
        $post->seo = Str::slug('C Pointer Kullanımı');
        $post->save();

        $post = new Post();
        $post->title = 'MySql Tablo Oluşturma ve Silme';
        $post->coverPhoto = 'mysql_tablo.jpg';
        $post->postOwner = 1;
        $post->viewCount = 35;
        $post->postContent = '<div> <h1> Mysql Tablo Oluşturma ve Silme ? </h1> <p> Veritabanlarında verilerimizi tablolarda tutarız. Şimdi Mysql ile tablolarımızı nasıl oluşturabileceğimize bakalım </p> </div>';
        $post->categoryId = 3;
        $post->seo = Str::slug('MySql Tablo Oluşturma ve Silme');
        $post->save();

        $post = new Post();
        $post->title = 'C Dosya İşlemleri';
        $post->coverPhoto = 'c_dosya_islemleri.jpg';
        $post->postOwner = 1;
        $post->viewCount = 90;
        $post->postContent = '<div> <h1> C Dilinde Dosya İşlemleri </h1> <p> C ile çalışırken verilerimizi program kapandığında kaybetmemek için dosya işlemlerini kullanmalıyız. </p> <p> Verilerimizi dosyalara yazabilir ve dosyalardan okuyabiliriz </p> </div>';
        $post->categoryId = 1;
        $post->seo = Str::slug('C Dosya İşlemleri');
        $post->save();

        $post = new Post();
        $post->title = "Java ile Nesne Yönelimli Programlama ";
        $post->coverPhoto = 'java_nesne_yonelimli.jpg';
        $post->postOwner = 1;
        $post->viewCount = 15;
        $post->postContent = '<div> <h1> Java Nesne Yönelimli Programlama </h1> <p> Bu dersimizde java ile nesne yönelimli programlamayı temel düzeyde öğreneceğiz. </p> <p> Sınıf ve nesneleri öğrenmekle başlayalım. </p> </div>';
        $post->categoryId = 2;
        $post->seo = Str::slug('Java ile Nesne Yönelimli Programlama ');
        $post->save();
    }
}
