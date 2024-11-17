<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class Categories extends Controller
{
   public static function get_categories(request $request)
   {

      $cat =  Category::latest()->where('status', 1)->get()->makeHidden(['created_at', 'updated_at', 'status','image']);

       return response()->json([
           'status' => true,
           'data' => $cat
       ]);

   }
}
