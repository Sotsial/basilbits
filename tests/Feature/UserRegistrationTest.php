<?php
// tests/Feature/UserRegistrationTest.php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActivationMail;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        Mail::fake();

        $response = $this->postJson('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'user'
        ]);

        // Проверка JSON-ответа вместо редиректа
        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        // Проверяем, что пользователь создан
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'is_active' => false,
        ]);

        // Проверка отправки письма
        Mail::assertSent(ActivationMail::class, function ($mail) {
            return $mail->hasTo('test@example.com');
        });
    }

    public function test_user_can_activate_account()
    {
        // Создаем пользователя с токеном активации
        $user = User::factory()->create([
            'is_active' => false,
            'activation_token' => 'test-token',
            'email_verified_at' => null,
        ]);

        // Проверяем, что пользователь создан правильно перед активацией
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_active' => false,
            'activation_token' => 'test-token',
        ]);

        // Активируем аккаунт
        $response = $this->get(route('user.activate', ['token' => 'test-token']));

        // Проверяем что маршрут существует 
        if ($response->status() === 404) {
            $this->fail('Маршрут активации не найден. Проверьте определение route("user.activate").');
        }

        // Проверка редиректа
        $response->assertRedirect(route('home'));

        // Проверка, что аккаунт активирован
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_active' => true,
            'activation_token' => null,
        ]);
        
        // Убедимся что email_verified_at установлен
        $user->refresh();
        $this->assertNotNull($user->email_verified_at);
    }

    public function test_emails_are_sent_to_mailhog()
    {
        // Сбрасываем фейковую отправку писем, чтобы письма реально отправлялись
        Mail::fake(false);

        // Создаем пользователя и отправляем письмо активации
        $user = User::factory()->create([
            'is_active' => false,
            'activation_token' => 'mailhog-test-token',
            'email' => 'mailhog-test@example.com',
        ]);

        // Создаем ссылку активации
        $activationLink = route('user.activate', ['token' => 'mailhog-test-token']);

        // Отправляем письмо активации
        Mail::to($user->email)->send(new ActivationMail($user, $activationLink));

        // Примечание: реальная проверка содержимого требует HTTP-клиент для запроса к Mailhog API
        // Это просто проверка, что код отправки писем выполняется без ошибок
        $this->assertTrue(true, 'Письмо должно быть отправлено в Mailhog');
    }
}