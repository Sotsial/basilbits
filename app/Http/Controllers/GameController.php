<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GameController extends Controller
{
    /**
     * Отображение формы добавления игры
     */
    public function create()
    {
        return view('add-game');
    }

    /**
     * Store a newly created game in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'nullable|string|max:255',
            'on_request' => 'nullable|boolean',
            'title_image' => 'required|image|max:2048',
            'screenshots.*' => 'nullable|image|max:2048',
            'platform' => 'required|in:ios,android',
            'earnings' => 'required|string',
            'age' => 'required|string',
            'installs' => 'required|string',
            'monetization' => 'nullable|array',
            'attachments.*' => 'nullable|file|max:10240',
            'financials.*' => 'nullable|file|max:10240',
            'description' => 'required|string',
            'link' => 'nullable|url',
            'payment_methods' => 'nullable|array',
            'seller' => 'nullable|exists:users,id',
            'video_link' => 'nullable|url',
            'specials' => 'nullable|array',
        ]);
        
        try {
            // Создаем новую игру
            $game = new Game();
            $game->title = $request->title;
            $game->price = $request->price;
            $game->on_request = $request->has('on_request');
            $game->platform = $request->platform;
            $game->earnings = $request->earnings;
            $game->age = $request->age;
            $game->installs = $request->installs;
            $game->monetization = $request->monetization ? json_encode($request->monetization) : null;
            $game->description = $request->description;
            $game->link = $request->link;
            $game->payment_methods = $request->payment_methods ? json_encode($request->payment_methods) : null;
            $game->seller_id = $request->seller;
            $game->video_link = $request->video_link;
            $game->specials = $request->specials ? json_encode($request->specials) : null;
            $game->slug = Str::slug($request->title) . '-' . time();
            $game->user_id = auth()->id(); // Предполагается, что пользователь авторизован
            
            // Сохраняем титульное изображение
            if ($request->hasFile('title_image')) {
                $path = $request->file('title_image')->store('game_images', 'public');
                $game->title_image = $path;
            }
            
            // Сохраняем игру для получения ID
            $game->save();
            
            // Сохраняем скриншоты
            if ($request->hasFile('screenshots')) {
                $screenshots = [];
                foreach ($request->file('screenshots') as $screenshot) {
                    $path = $screenshot->store('game_screenshots', 'public');
                    $screenshots[] = $path;
                }
                $game->screenshots = json_encode($screenshots);
                $game->save();
            }
            
            // Обрабатываем вложения
            if ($request->hasFile('attachments')) {
                $attachments = [];
                foreach ($request->file('attachments') as $attachment) {
                    $path = $attachment->store('game_attachments', 'public');
                    $attachments[] = $path;
                }
                $game->attachments = json_encode($attachments);
                $game->save();
            }
            
            // Обрабатываем финансовые документы
            if ($request->hasFile('financials')) {
                $financials = [];
                foreach ($request->file('financials') as $financial) {
                    $path = $financial->store('game_financials', 'public');
                    $financials[] = $path;
                }
                $game->financials = json_encode($financials);
                $game->save();
            }
            
            return redirect()->route('games.show', $game->slug)->with('success', 'Game added successfully!');
            
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error adding game: ' . $e->getMessage());
        }
    }
    
    /**
     * Display the specified game.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $game = Game::where('slug', $slug)->firstOrFail();
        return view('games.show', compact('game'));
    }
    
    // Другие методы контроллера...
}
