<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    // Get all Catgories
    public function categories(Request $request){
        $categories = Category::all();
        return response()->json(['categories'=>$categories],200);
    }
}
