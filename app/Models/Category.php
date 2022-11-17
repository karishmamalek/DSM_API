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

    public static function getcat_android_app_version($category_id){
        $catData = DB::table('category')
        ->selectRaw('android_app_version')
        ->where('cat_id', '=',$category_id )
        ->get();
        return $catData;
    }
 }
