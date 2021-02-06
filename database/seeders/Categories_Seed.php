<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class Categories_Seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->categoryName = 'C Dersleri';
        $category->categoryDescription = 'Bu kategoride C dili ilgili konular yer almaktadır. Başlangıçtan ileri seviyeye kadar, C dili ile ilgili çoğu konuyu buradan okuyabilirsiniz.';
        $category->seo = Str::slug('C Dersleri');
        $category->save();

        $category2 = new Category();
        $category2->categoryName = 'Java Dersleri';
        $category2->categoryDescription = 'Bu kategoride Java dili ilgili konular yer almaktadır. Başlangıçtan ileri seviyeye kadar, Java dili ile ilgili çoğu konuyu buradan okuyabilirsiniz.';
        $category2->seo = Str::slug('Java Dersleri');
        $category2->save();

        $category3 = new Category();
        $category3->categoryName = 'SQL Dersleri';
        $category3->categoryDescription = 'Bu kategoride MySql ile ilgili konular yer almaktadır. Başlangıçtan ileri seviyeye kadar, MySql dili ile ilgili çoğu konuyu buradan okuyabilirsiniz.';
        $category3->seo = Str::slug('SQL Dersleri');
        $category3->save();
    }
}
