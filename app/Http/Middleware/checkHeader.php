<?php

namespace App\Http\Middleware;

use App\Models\Category;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class checkHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $catId = $request->route()->parameter('id');
        $androidAppVersion = $request->header('ANDROID-APP-VERSION');
        $catData = Category::getcat_android_app_version($catId);
        $dbVersion = $catData[0]->android_app_version;
        $ERROR_MSG = Config::get('constants.ERROR_MSG');
        $ERROR_STATUS_CODE = Config::get('constants.ERROR_STATUS_CODE');
        
        if (version_compare($dbVersion, $androidAppVersion) == 1) {
			return jsonResponse($ERROR_STATUS_CODE,$ERROR_MSG,null);
		}else{
            return $next($request);
        }
    }
}
