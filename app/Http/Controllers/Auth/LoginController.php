<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Обработка запроса на вход в систему
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            Log::info('Попытка входа', ['email' => $request->email]);

            // Проверяем активирован ли аккаунт
            $user = User::where('email', $request->email)->first();

            if ($user && !$user->is_active) {
                Log::warning('Попытка входа с неактивированным аккаунтом', ['email' => $request->email]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Please activate your account first. Check your email for the activation link.'
                ], 403);
            }

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                Log::info('Успешный вход', ['user_id' => Auth::id()]);
                
                $request->session()->regenerate();

                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Login successful'
                    ]);
                }

                return redirect()->intended('/');
            }

            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        } catch (ValidationException $e) {
            Log::warning('Ошибка валидации при входе', [
                'email' => $request->email,
                'errors' => $e->errors()
            ]);
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials',
                    'errors' => $e->errors()
                ], 422);
            }
            
            throw $e;
        } catch (\Exception $e) {
            Log::error('Ошибка при входе в систему', [
                'email' => $request->email,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred during login',
                    'debug' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
            
            throw $e;
        }
    }
}
