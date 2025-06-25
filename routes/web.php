<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Добавлен импорт Auth для Auth::routes()
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Controllers\Api\SellerController;
use App\Http\Controllers\GameController;

Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('/company', function () {
    return view('company');
});

Route::get('/services', function () {
    return view('services');
});

Route::middleware(['auth'])->group(function () {
    // Страница с формой добавления игры
    Route::get('/add', [App\Http\Controllers\GameController::class, 'create'])->name('games.add');

    // Обработка POST-запроса от формы
    Route::post('/add', [App\Http\Controllers\GameController::class, 'store'])->name('games.store');
});

Route::get('/faq', function () {
    return view('faq');
});

Route::get('/contacts', function () {
    return view('contacts');
});

Route::get('/cabinet', function () {
    return view('cabinet');
});

Route::get('/detail', function () {
    return view('app-detail');
});

// Маршрут для маркетплейса
Route::get('/marketplace', [App\Http\Controllers\MarketplaceController::class, 'index'])->name('marketplace');

use App\Http\Controllers\AppController;

Route::get('/apps', [AppController::class, 'index']);
Route::get('/apps/{id}', [AppController::class, 'show']);

// Оставляем только маршрут для активации аккаунта, так как Auth::routes() его не обеспечивает
Route::get('/user/activate/{token}', [RegisterController::class, 'activate'])->name('user.activate');

// Маршрут выхода лучше заменить на стандартный из Auth::routes()
// Route::post('/logout', function (Request $request) {
//     Auth::logout();
//     $request->session()->invalidate();
//     $request->session()->regenerateToken();
//     return redirect('/');
// })->name('logout');

// Маршрут для отладки последней ошибки
Route::get('/api/debug-last-error', function () {
    $log = @file_get_contents(storage_path('logs/laravel.log'));
    if (!$log) {
        return response()->json(['message' => 'Log file not found or empty']);
    }
    
    // Получаем последнюю запись лога с ошибкой
    $errorPosition = strrpos($log, '[' . date('Y-m-d'));
    $lastError = $errorPosition !== false ? substr($log, $errorPosition) : 'No recent errors found';
    
    return response()->json(['message' => $lastError]);
});

// Маршруты для восстановления пароля
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    
    $user = User::where('email', $request->email)->first();
    
    // Записываем в лог попытку восстановления пароля
    Log::info('Запрос на восстановление пароля', ['email' => $request->email]);
    
    // Даже если пользователь не найден, мы возвращаем одинаковый ответ для безопасности
    // В реальном приложении здесь будет логика отправки письма для сброса пароля
    
    return response()->json([
        'success' => true,
        'message' => 'If your email exists in our system, we have sent you a password reset link.'
    ]);
})->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    // В реальном приложении здесь будет логика сброса пароля
    
    return response()->json([
        'success' => true,
        'message' => 'Your password has been reset successfully.'
    ]);
})->middleware('guest')->name('password.update');

// Маршрут для повторной отправки email активации - исправленная версия
Route::post('/resend-activation', function (Request $request) {
    try {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);
        
        $user = User::where('email', $request->email)->first();
        
        // Если пользователь уже активирован
        if ($user->is_active) {
            return response()->json([
                'success' => true,
                'message' => 'Your account is already activated. You can log in now.'
            ]);
        }
        
        // Если токен активации отсутствует, генерируем новый
        if (empty($user->activation_token)) {
            $user->activation_token = Str::random(60);
            $user->save();
        }
        
        // Создаем ссылку активации
        $activationLink = route('user.activate', ['token' => $user->activation_token]);
        
        // Логи для диагностики
        \Log::info('Повторная отправка письма активации', [
            'email' => $user->email,
            'token' => $user->activation_token,
            'link' => $activationLink
        ]);
        
        // Отправляем письмо - убираем проверку failures()
        try {
            Mail::to($user->email)->send(new \App\Mail\ActivationMail($user, $activationLink));
            \Log::info('Письмо активации отправлено повторно');
        } catch (\Exception $e) {
            \Log::error('Ошибка при отправке письма: ' . $e->getMessage());
            throw $e; // Передаем исключение дальше
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Activation email has been sent. Please check your inbox.'
        ]);
    } catch (\Exception $e) {
        \Log::error('Ошибка повторной отправки активационного письма: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to send activation email: ' . $e->getMessage(),
            'debug' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
})->name('resend.activation');

// Тестовый маршрут для проверки отправки писем - исправленная версия
Route::get('/test-mail', function() {
    try {
        // Логируем попытку отправки тестового письма
        \Log::info('Тестовая отправка письма');
        
        // Отправляем простое тестовое письмо
        \Mail::raw('Тестовое сообщение для проверки работы почты', function($message) {
            $message->to('test@example.com')
                    ->subject('Тестовое письмо');
        });
        
        \Log::info('Тестовое письмо отправлено успешно');
        
        return 'Тестовое письмо отправлено успешно! Проверьте Mailhog по адресу http://localhost:8025';
    } catch (\Exception $e) {
        \Log::error('Исключение при отправке тестового письма: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        
        return 'Ошибка при отправке тестового письма: ' . $e->getMessage();
    }
});

// Объединяем административные маршруты в один блок
Route::prefix('admin')->middleware(['auth', 'can:admin'])->group(function () {
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users');
    Route::delete('/users/remove-all', [RegisterController::class, 'removeUsers'])->name('admin.users.remove-all');
    // Другие админ-маршруты...
});

// Объединяем маршруты менеджера в один блок
Route::middleware(['auth'])->group(function () {
    Route::get('/games/add', [GameController::class, 'create'])->name('games.add');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
    // Другие маршруты для менеджеров...
});


// API маршруты лучше переместить в api.php
// Но пока оставим их здесь, просто добавим префикс /api
Route::prefix('api')->group(function () {
    Route::get('/sellers/list', [SellerController::class, 'list']);
    Route::get('/sellers/search', [SellerController::class, 'search'])->name('api.sellers.search');
});

// Этот маршрут дублирует '/games/add', оставим только один вариант
// Route::get('/games/create', function () {
//     return view('add-game');
// })->name('games.create');

// Регистрируем все стандартные маршруты аутентификации
// Этот вызов заменяет индивидуальные маршруты для login, register, password reset и т.д.
Auth::routes();