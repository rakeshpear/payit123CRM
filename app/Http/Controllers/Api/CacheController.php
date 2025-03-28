<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Controller;

class CacheController extends Controller
{
    public function clearCache()
    {
        // Clear application cache
        Artisan::call('cache:clear');

        // Clear config cache
        Artisan::call('config:clear');

        // Clear route cache
        Artisan::call('route:clear');

        // Clear view cache
        Artisan::call('view:clear');

        return response()->json(['message' => 'Cache cleared successfully']);
    }
}
