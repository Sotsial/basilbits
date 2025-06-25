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
