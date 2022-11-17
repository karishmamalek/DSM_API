<?php

namespace App\Models;

use App\Http\Resources\PageDataCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';

    public static function messageFromCategories($category_id,$perPage=10){
        $msgData = DB::table('message_sub')
        ->join('message', 'message.id', '=', 'message_sub.sms_id')
        ->join('category', 'category.cat_id', '=', 'message_sub.cat_id')
        ->join('category_sub', 'category.cat_id', '=', 'category_sub.cat_id')
        ->selectRaw('category.cat_id,category.android_app_version,message.*, REPLACE(message.sms, "<br/>", "") AS sms')
        ->where('message_sub.cat_id', '=',$category_id )
        ->inRandomOrder()->paginate($perPage);
        return new PageDataCollection($msgData);
    }
}
