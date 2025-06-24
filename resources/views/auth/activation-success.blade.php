@extends('layout.app')

@section('title', 'Аккаунт активирован')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Активация аккаунта</div>

                <div class="card-body">
                    <div class="alert alert-success">
                        Ваш аккаунт успешно активирован. Теперь вы можете войти.
                    </div>

                    <div class="text-center mt-3">
                        <button id="show-login-btn" class="btn btn-primary">Войти</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Показываем popup автоматически через небольшую задержку
        setTimeout(function () {
            // Проверяем существует ли функция showPopup
            if (typeof showPopup === 'function') {
                showPopup('activation-success-popup');
            } else {
                // Если функция недоступна, используем кнопку
                console.log('Функция showPopup не найдена');
            }
        }, 500);

        // Обработка нажатия на кнопку "Войти"
        document.getElementById('show-login-btn').addEventListener('click', function () {
            if (typeof showPopup === 'function') {
                showPopup('login-popup');
            } else {
                window.location.href = '/login';
            }
        });
    });
</script>
@endsection