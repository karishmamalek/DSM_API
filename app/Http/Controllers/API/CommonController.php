<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageDataCollection;
use App\Models\Category;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
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
       $catData = Category::paginate($perPage);
       $CATEGORY_LISTING_MSG = Config::get('constants.CATEGORY_LISTING_MSG');
       $ERROR_MSG = Config::get('constants.ERROR_MSG');
       $SUCCESS_STATUS_CODE = Config::get('constants.SUCCESS_STATUS_CODE');
       $ERROR_STATUS_CODE = Config::get('constants.ERROR_STATUS_CODE');
       
       if(!empty($catData)){
        return jsonResponse($SUCCESS_STATUS_CODE,$CATEGORY_LISTING_MSG, new PageDataCollection($catData));
       }else{
        return jsonResponse($ERROR_STATUS_CODE,$ERROR_MSG, null);
       }
       
    }

    /**
     * Get messages using category id 
     */
    public function category_message(Request $request,$id){
        $perPage = $request->input('results', 10);
        if (!is_numeric($perPage)) {
          $perPage = 10;
        }
        $smsData = Message::get_messages_from_categories($id,$perPage);
        $MESSAGE_SUCCESS_MSG = Config::get('constants.MESSAGE_SUCCESS_MSG');
        $NO_DATA_FOUND_MSG = Config::get('constants.NO_DATA_FOUND_MSG');
        $SUCCESS_STATUS_CODE = Config::get('constants.SUCCESS_STATUS_CODE');
        $ERROR_STATUS_CODE = Config::get('constants.ERROR_STATUS_CODE');

        if(!empty($smsData)){
            return jsonResponse($SUCCESS_STATUS_CODE,$MESSAGE_SUCCESS_MSG,$smsData);
        }else{
            return jsonResponse($ERROR_STATUS_CODE,$NO_DATA_FOUND_MSG,null);
        }
        
    }
}
