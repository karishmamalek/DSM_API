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
       DB::enableQueryLog(); // Enable query log

        $header = $request->header('ANDROID-APP-VERSION');
        $msgData = DB::table('message_sub')
        ->join('message', 'message.id', '=', 'message_sub.sms_id')
        ->join('category', 'category.cat_id', '=', 'message_sub.cat_id')
        ->join('category_sub', 'category.cat_id', '=', 'category_sub.cat_id')
        ->selectRaw('category.cat_id, category.android_app_version,message.*, REPLACE(message.sms, "<br/>", "") AS sms')
        ->where('message_sub.cat_id', '=',$id )
        ->where('category.android_app_version', '=', '1.0.7')
        ->inRandomOrder()->paginate($perPage);
        dd(DB::getQueryLog()); // Show results of log

        // echo "<pre>";
         //print_r($msgData);
        // echo "</pre>";
        
        if(!empty($msgData)){
            return jsonResponse(200,"Message Detail",new PageDataCollection($msgData));
        }else{
            return jsonResponse(200,"Error",null);
        }
       // $data = Category::messageFromCategories($id,$perPage);
        
        
        
       // $arrayData = $data[''];
        // $datadecode = html_entity_decode($data['']);
        // $output = json_decode($datadecode,true);
       // print_r($output);
        //print_r($output->status_code);
        //$parsed_json = json_decode($output->data);
        //die();
        /*if($header >= $app_version){}else{}*/
        
    }
}
