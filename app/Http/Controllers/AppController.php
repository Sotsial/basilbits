<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\App;

class AppController extends Controller
{
    public function index()
    {
        $apps = [
            [
                'title' => 'Pixel Quest',
                'platform' => ['iOS', 'Android'],
                'images' => ['images/pixel1.jpg', 'images/pixel2.jpg', 'images/pixel3.jpg', 'images/pixel4.jpg'],
                'description' => 'A retro-style adventure game with puzzle mechanics.',
                'monetization' => 'in-app',
                'type' => 'game',
                'lastMonthProfit' => '1k-5k',
                'lastYearProfit' => '10k+',
                'age' => '1-3 years',
                'installs' => '100k-1M',
                'price' => 4.99
            ],
            [
                'title' => 'TaskMaster Pro',
                'platform' => ['Android'],
                'images' => ['images/task1.jpg', 'images/task2.jpg', 'images/task3.jpg', 'images/task4.jpg'],
                'description' => 'Productivity app for team task management.',
                'monetization' => 'paid app',
                'type' => 'non-game',
                'lastMonthProfit' => '100-1000',
                'lastYearProfit' => '5k-10k',
                'age' => '6-12 month',
                'installs' => '10k-100k',
                'price' => 9.99
            ],
            [
                'title' => 'Fitness Tracker+',
                'platform' => ['iOS'],
                'images' => ['images/fit1.jpg', 'images/fit2.jpg', 'images/fit3.jpg', 'images/fit4.jpg'],
                'description' => 'AI-powered workout and nutrition planner.',
                'monetization' => 'ads',
                'type' => 'non-game',
                'lastMonthProfit' => 'Less than 100$',
                'lastYearProfit' => '1k-5k',
                'age' => 'Less than 1 month',
                'installs' => '1-10k',
                'price' => 0.00
            ]
        ];

        return view('app-detail', ['apps' => $apps]);
    }

    public function show($id)
    {
        // Имитация данных для примера
        $app = [];
        
        // Используем массив приложений
        $apps = [
            [
                'title' => 'Pixel Quest',
                'platform' => ['iOS', 'Android'],
                'images' => ['images/pixel1.jpg', 'images/pixel2.jpg', 'images/pixel3.jpg', 'images/pixel4.jpg'],
                'description' => 'A retro-style adventure game with puzzle mechanics.',
                'monetization' => 'in-app',
                'type' => 'game',
                'lastMonthProfit' => '1k-5k',
                'lastYearProfit' => '10k+',
                'age' => '1-3 years',
                'installs' => '100k-1M',
                'price' => 4.99
            ],
            // другие приложения...
        ];
        
        return view('app-detail', [
            'app' => $app,
            'apps' => $apps
        ]);
    }
}