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
        return response()->json([
            'status' => true,
            'categories' => $categories
        ]);
    }
}
