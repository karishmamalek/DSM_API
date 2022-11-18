<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    
    /*private $TBL_CATEGORY='';
    public function __construct()
    {
        $this->TBL_CATEGORY = Config::get('constants.TBL_CATEGORY');
        $table = $this->TBL_CATEGORY;
    }*/
    
    protected $table = 'category';

    public static function getcat_android_app_version($category_id){
        $catData = DB::table('category')
        ->selectRaw('android_app_version')
        ->where('cat_id', '=',$category_id )
        ->get();
        return $catData;
    }
 }
