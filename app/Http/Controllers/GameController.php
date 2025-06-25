<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    /**
     * Отображение формы добавления игры
     */
    public function create()
    {
        return view('add-game');
    }

    public function show(Game $game)
    {
        // Laravel автоматически найдет игру по slug благодаря route-model binding
        // Мы передаем найденный объект $game в представление 'app-detail'
        // Важно: в представлении app-detail.blade.php переменная будет называться 'app'
        return view('app-detail', ['app' => $game]);
    }
    /**
     * Сохранение новой игры.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Валидация входных данных
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'nullable|string|max:255',
            'on_request' => 'nullable|boolean',
            'title_image' => 'required|image|max:2048', // Макс. 2MB
            'screenshots.*' => 'nullable|image|max:2048',
            'platform' => 'required|in:ios,android',
            'earnings' => 'required|string',
            'age' => 'required|string',
            'installs' => 'required|string',
            'monetization' => 'nullable|array',
            'attachments.*' => 'nullable|file|max:10240', // Макс. 10MB
            'financials.*' => 'nullable|file|max:10240',
            'description' => 'required|string',
            'link' => 'nullable|url',
            'payment_methods' => 'nullable|array',
            'seller' => 'nullable|exists:users,id',
            'video_link' => 'nullable|url',
            'specials' => 'nullable|array',
        ]);
        
        try {
            // 2. Создание новой игры
            $game = new Game();
            $game->fill($request->except(['title_image', 'screenshots', 'attachments', 'financials']));
            $game->user_id = auth()->id();
            $game->slug = Str::slug($request->title) . '-' . time();

            // 3. Сохранение файлов
            if ($request->hasFile('title_image')) {
                $path = $request->file('title_image')->store('game_images', 'public');
                $game->title_image = $path;
            }
            
            if ($request->hasFile('screenshots')) {
                $screenshots = [];
                foreach ($request->file('screenshots') as $screenshot) {
                    if ($screenshot->isValid()) {
                        $path = $screenshot->store('game_screenshots', 'public');
                        $screenshots[] = $path;
                    }
                }
                $game->screenshots = json_encode($screenshots);
            }
            
            if ($request->hasFile('attachments')) {
                $attachments = [];
                foreach ($request->file('attachments') as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('game_attachments', 'public');
                        $attachments[] = ['path' => $path, 'name' => $file->getClientOriginalName()];
                    }
                }
                $game->attachments = json_encode($attachments);
            }

            if ($request->hasFile('financials')) {
                $financials = [];
                foreach ($request->file('financials') as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('game_financials', 'public');
                        $financials[] = ['path' => $path, 'name' => $file->getClientOriginalName()];
                    }
                }
                $game->financials = json_encode($financials);
            }

            $game->monetization = $request->monetization ? json_encode($request->monetization) : null;
            $game->payment_methods = $request->payment_methods ? json_encode($request->payment_methods) : null;
            $game->specials = $request->specials ? json_encode($request->specials) : null;

            $game->save();
            
            return redirect()->route('games.add')->with('success', 'Game added successfully!');
            
        } catch (\Exception $e) {
            Log::error('Error adding game: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Something went wrong. Please try again. Error: ' . $e->getMessage());
        }
    }
}