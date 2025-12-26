<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CatFactController extends Controller
{
    public function getCatFact(Request $request)
    {
        $catFact = Cache::remember('cat_fact_'.$request->user()->id, 300, function () {
            $response = Http::get('https://catfact.ninja/fact');
            return $response->json();
        });

        return response()->json($catFact);
    }
}
