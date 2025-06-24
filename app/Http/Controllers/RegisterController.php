<?php
// app/Http/Controllers/Auth/RegisterController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\ActivationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:user,manager', // Проверка ролей
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Создание пользователя
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'activation_token' => Str::random(60),
            'is_active' => false,
        ]);

        // Генерация ссылки активации
        $activationLink = route('user.activate', ['token' => $user->activation_token]);

        // Отправка письма
        Mail::to($user->email)->send(new ActivationMail($user, $activationLink));

        return response()->json([
            'success' => true,
            'message' => 'Registration successful! Please check your email to activate your account.'
        ]);
    }

    public function activate($token)
    {
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            return redirect()->route('home')->with('error', 'Invalid activation link.');
        }

        $user->is_active = true;
        $user->activation_token = null;
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('home')
            ->with('success', 'Your account has been activated! You can now log in.');
    }
}