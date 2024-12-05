<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class CacheClearController extends Controller
{
    public function clearCache()
    {
        // Clear route cache
        Artisan::call('route:clear');
        
        // Clear config cache
        Artisan::call('config:clear');
        
        // Clear view cache
        Artisan::call('view:clear');
        
        // Clear application cache
        Artisan::call('cache:clear');

        // Optional: Clear compiled services and packages
        Artisan::call('optimize:clear');

        return response()->json(['message' => 'Cache cleared successfully!']);
    }
}
