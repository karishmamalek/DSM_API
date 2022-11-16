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
        $msgData = DB::table('category_sub')
        ->join('message', 'message.id', '=', 'category_sub.cat_id')
        ->join('message_sub', 'message_sub.sms_id', '=', 'category_sub.cat_id')
        ->selectRaw('message.*, REPLACE(message.sms, "<br/>", "") AS sms')
        ->where('message_sub.cat_id', '=',$category_id )
        ->inRandomOrder()->paginate($perPage);
        return new PageDataCollection($msgData);

    }
}
