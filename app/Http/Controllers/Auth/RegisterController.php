<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | Это должен быть единственный контроллер для регистрации пользователей.
    | Убедитесь, что нет другого контроллера с похожей функциональностью.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home'; // Убедитесь, что маршрут существует

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            // Назначаем роль напрямую в базе, без внешних зависимостей
            'role' => 'user', // Или используйте другой механизм назначения ролей
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            // Валидация данных
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|string|in:user,admin',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Создание пользователя
            $user = $this->create($request->all());

            // Генерация токена активации
            $activationToken = Str::random(60);
            $user->activation_token = $activationToken;
            $user->save();

            // Создание ссылки активации
            $activationLink = route('user.activate', ['token' => $activationToken]);

            // Отправка письма с ссылкой активации
            try {
                Mail::to($user->email)->send(new ActivationMail($user, $activationLink));
            } catch (\Exception $e) {
                Log::error('Ошибка при отправке письма активации: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Регистрация прошла успешно. Проверьте вашу почту для активации аккаунта.'
            ]);
        } catch (\Exception $e) {
            Log::error('Ошибка регистрации: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при регистрации',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Activate user account.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function activate($token)
    {
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            return redirect()->route('home')->with('error', 'Неверный токен активации.');
        }

        $user->is_active = true;
        $user->activation_token = null;
        $user->email_verified_at = now();
        $user->save();

        // Вместо редиректа, возвращаем страницу с popup
        return view('auth.activation-success', ['user' => $user]);
    }

    /**
     * Remove all users (for admin only)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeUsers(Request $request)
    {
        try {
            // Проверяем, является ли текущий пользователь админом
            if (!$request->user() || $request->user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Недостаточно прав для выполнения этой операции.'
                ], 403);
            }

            // Получаем количество пользователей перед удалением
            $count = User::count();

            // Оставляем только текущего пользователя (админа)
            User::where('id', '!=', $request->user()->id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Удалено пользователей: ' . ($count - 1),
                'remaining' => 1
            ]);
        } catch (\Exception $e) {
            Log::error('Ошибка при удалении пользователей: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при удалении пользователей',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
