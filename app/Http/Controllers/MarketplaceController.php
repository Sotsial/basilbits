<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class MarketplaceController extends Controller
{
    /**
     * Display the marketplace page with filters.
     */
    public function index(Request $request)
    {
        $query = Game::query();

        // Keyword search
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                  ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        // Price filter (Min-Max Range)
        // Применяем фильтр, только если значение было изменено пользователем
        if ($request->filled('price_min') && $request->price_min > 0) {
            $query->where('price', '>=', $request->price_min);
        }

        // Применяем фильтр, только если значение не является максимальным
        if ($request->filled('price_max') && $request->price_max < 10000) {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->has('hide_no_price')) {
            $query->whereNotNull('price')->where('price', '>', 0);
        }

        // Platform filter
        if ($request->filled('platform')) {
            $query->whereIn('platform', $request->platform);
        }
        
        // Type filter
        if ($request->filled('type')) {
            $query->whereIn('type', $request->type);
        }

        // Last month earnings filter
        if ($request->filled('earnings_min')) {
            $query->where('earnings', '>=', $request->earnings_min);
        }
        
        // Age filter
        if ($request->filled('age_min')) {
            $query->where('age', '>=', $request->age_min);
        }

        // Installs filter
        if ($request->filled('installs_min')) {
            $query->where('installs', '>=', $request->installs_min);
        }
        
        // Monetization filter
        if ($request->filled('monetization')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->monetization as $monetization_type) {
                    $q->orWhereJsonContains('monetization', $monetization_type);
                }
            });
        }

        $games = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();
        
        return view('marketplace', compact('games'));
    }
}