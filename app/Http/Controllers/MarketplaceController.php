<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class MarketplaceController extends Controller
{
    /**
     * Отображение страницы маркетплейса
     */
    public function index()
    {
        $games = Game::orderBy('created_at', 'desc')->paginate(12);
        return view('marketplace', compact('games'));
    }
}
