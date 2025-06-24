<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\MailManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Зарегистрируем корректные привязки вместо отсутствующих классов
        // Если у вас есть модель Role
        $this->app->bind('role', function ($app) {
            return new \App\Models\Role(); // Измените на ваш актуальный класс Role
        });

        // Если у вас есть класс Manager
        $this->app->bind('manager', function ($app) {
            return new \App\Models\Manager(); // Измените на ваш актуальный класс Manager
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Добавляем аварийный транспорт для отправки почты
        $this->setupMailFailover();
    }

    /**
     * Настройка аварийного переключения для почты
     */
    protected function setupMailFailover(): void
    {
        Mail::extend('failover', function (array $config) {
            return new class ($config) {
                protected $config;
                protected $maxAttempts = 2;
                
                public function __construct($config)
                {
                    $this->config = $config;
                }
                
                public function send($message)
                {
                    try {
                        // Пытаемся отправить через SMTP
                        app(MailManager::class)
                            ->mailer('smtp')
                            ->send($message);
                        
                        Log::info('Письмо успешно отправлено через SMTP');
                    } catch (\Exception $e) {
                        Log::warning('Ошибка отправки через SMTP, переключение на лог: ' . $e->getMessage());
                        
                        // При ошибке отправляем через лог
                        app(MailManager::class)
                            ->mailer('log')
                            ->send($message);
                        
                        Log::info('Письмо сохранено в лог');
                    }
                }
            };
        });
    }
}
