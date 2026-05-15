<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class AppVersionController extends Controller
{
    public function show()
    {
        return response()->json([
            'latest_version' => config('app_version.latest'),
            'min_version' => config('app_version.min'),
            'store_ios' => config('app_version.store_ios'),
            'store_android' => config('app_version.store_android'),
        ]);
    }
}
