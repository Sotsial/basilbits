<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AddGameTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Тест на успешное добавление игры.
     *
     * @return void
     */
    public function test_user_can_add_game_with_images()
    {
        // Создаем тестового пользователя и авторизуемся
        $user = User::factory()->create();
        
        // Создаем фейковые файлы или используем реальные из public/img
        Storage::fake('public');
        
        // Проверяем существование тестовых изображений
        if (file_exists(public_path('img/test-image.jpg'))) {
            $titleImage = new UploadedFile(
                public_path('img/test-image.jpg'),
                'test-image.jpg',
                'image/jpeg',
                null,
                true
            );
        } else {
            $titleImage = UploadedFile::fake()->image('title-image.jpg');
        }
        
        // Создаем массив скриншотов
        $screenshots = [];
        for ($i = 1; $i <= 3; $i++) {
            if (file_exists(public_path("img/test-screenshot-{$i}.jpg"))) {
                $screenshots[] = new UploadedFile(
                    public_path("img/test-screenshot-{$i}.jpg"),
                    "test-screenshot-{$i}.jpg",
                    'image/jpeg',
                    null,
                    true
                );
            } else {
                $screenshots[] = UploadedFile::fake()->image("screenshot-{$i}.jpg");
            }
        }
        
        // Данные для отправки формы
        $gameData = [
            'title' => $this->faker->sentence(3),
            'price' => '1000',
            'title_image' => $titleImage,
            'screenshots' => $screenshots,
            'platform' => 'ios',
            'earnings' => '100-1000$',
            'age' => '1-3_years',
            'installs' => '10k-100k',
            'monetization' => ['ads', 'in-app'],
            'description' => $this->faker->paragraph,
            'link' => $this->faker->url,
            'payment_methods' => ['escrow', 'crypto'],
            'specials' => ['verified_seller'],
        ];
        
        // Отправляем запрос на добавление игры
        $response = $this->actingAs($user)
                         ->post(route('games.store'), $gameData);
        
        // Проверяем, что игра создана в базе данных
        $this->assertDatabaseHas('games', [
            'title' => $gameData['title'],
            'user_id' => $user->id,
        ]);
        
        // Получаем созданную игру
        $game = \App\Models\Game::where('title', $gameData['title'])->first();
        
        // Проверяем редирект на страницу игры
        $response->assertRedirect(route('games.show', $game->slug));
        
        // Проверяем, что файл сохранен
        Storage::disk('public')->assertExists(str_replace('public/', '', $game->title_image));
        
        // Проверяем успешное сообщение
        $response->assertSessionHas('success');
    }
    
    /**
     * Тест на валидацию формы.
     *
     * @return void
     */
    public function test_game_validation()
    {
        // Создаем тестового пользователя и авторизуемся
        $user = User::factory()->create();
        
        // Данные формы без обязательных полей
        $gameData = [
            // не указываем title
            'price' => '1000',
            // не указываем title_image
            'platform' => 'ios',
            // не указываем earnings
            // не указываем другие обязательные поля
        ];
        
        // Отправляем запрос на добавление игры
        $response = $this->actingAs($user)
                         ->post(route('games.store'), $gameData);
        
        // Проверяем, что получаем ошибки валидации
        $response->assertSessionHasErrors(['title', 'title_image', 'earnings', 'age', 'installs', 'description']);
    }
}
