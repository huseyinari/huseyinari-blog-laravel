<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getCategories(){
        $categories = Category::select(['id','categoryName','seo'])->get();
        foreach($categories as $category){
            $category->postCount = $category->getPostCount();
        }
        $categories = $categories->sortByDesc('postCount')->values();

        return response()->json([
            'status' => true,
            'categories' => $categories
        ]);
    }
    public function getCategoryDetails($seo){
        $category = Category::where('seo',$seo)->select(['categoryName','categoryDescription','id','created_at'])->get();

        if(count($category) === 0){
            return response()->json([
                'status' => false,
                'error' => 'Kategori bulunamadı !'
            ]);
        }else{
            return response()->json([
                'status' => true,
                'category' => $category[0]
            ]);
        }
    }
}
