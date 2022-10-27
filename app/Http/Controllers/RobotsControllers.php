<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RobotsControllers extends Controller
{
    //
    public function index() {     
      return response()->view('robots.index', [
         // 'article' => $articles,
         // 'category' => $categories,
         // 'subcategory' => $subcategories,
          //'tag' => $tags,
      ])->header('Content-Type', 'text');
    }
}
