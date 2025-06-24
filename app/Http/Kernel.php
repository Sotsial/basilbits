<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // Если у вас есть middleware, который ссылается на 'role' или 'manager',
        // убедитесь, что соответствующие классы существуют или замените их на корректные
        
        // Пример для middleware 'role'
        'role' => \App\Http\Middleware\CheckRole::class,
        
        // Пример для middleware 'manager'
        // 'manager' => \App\Http\Middleware\CheckManager::class,
    ];
}