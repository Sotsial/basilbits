<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class SellerController extends Controller
{
    /**
     * Поиск продавцов по запросу
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->input('query', '');
        
        $sellers = User::where('role', 'seller')
                      ->where('name', 'like', "%{$query}%")
                      ->orWhere('email', 'like', "%{$query}%")
                      ->limit(10)
                      ->get(['id', 'name', 'email']);
        
        return response()->json($sellers);
    }
}
