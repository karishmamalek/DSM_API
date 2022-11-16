<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageDataCollection;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CommonController extends Controller
{
    /*
    * Get all categories with pagination
    */ 
    public function categories(Request $request){
        $perPage = $request->input('results', 10);
        if (!is_numeric($perPage)) {
            $perPage = 10;
        }
       $data = Category::paginate($perPage);
       return jsonResponse(200,"Categories", new PageDataCollection($data));
    }

    /**
     * Get messages using category id 
     */
    public function category_message(Request $request,$id){
        $perPage = $request->input('results', 10);
        if (!is_numeric($perPage)) {
          $perPage = 10;
        }
       // DB::enableQueryLog();
        $data = Category::messageFromCategories($id,$perPage);
        //$quries = DB::getQueryLog();
        //return dd($quries);
       // die();
        return jsonResponse(200,"Message Detail",$data);
    }

}
