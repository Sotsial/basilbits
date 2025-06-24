<header>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <nav class="nav">
        <div class="logo">
            <a href="/"><img src="img/logo.png" alt="" srcset="" /></a>
        </div>
        <div class="menu">
            <ul class="menu-list">
                <li><a href="/">Home</a></li>
                <li><a href="/company">About</a></li>
                <li><a href="/services">Services</a></li>
                <li><a href="/contacts">Contact</a></li>
                <li class="lang-switcher">
                    <span class="current-lang">English</span>
                    <div class="lang-dropdown">
                        <a href="?lang=en" class="lang-option">English</a>
                        <a href="?lang=ru" class="lang-option">Русский</a>
                        <a href="?lang=es" class="lang-option">Español</a>
                        <a href="?lang=es" class="lang-option">Tiếng Việt</a>
                        <a href="?lang=es" class="lang-option">简体中文</a>
                        <a href="?lang=es" class="lang-option">हिन्दी</a>
                    </div>
                </li>
                @auth
                <li class="lang-switcher">
                    <span class="current-lang">{{ Auth::user()->email }}</span>
                    <div class="lang-dropdown">
                        <a href="/cabinet" class="dropdown-option">Profile</a>
                        <a href="/add" class="dropdown-option">Add game</a>
                        <a href="{{ route('logout') }}" class="dropdown-option"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @else
                <li class="login-button"><a onclick="showPopup('login-popup')" href="#">Login</a></li>
                @endauth
            </ul>
        </div>
        <div class="burger-menu">
            <button class="burger-menu" aria-label="Toggle menu">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </button>
        </div>
    </nav>
</header>

<x-popup id="signup-popup" title="Create an account">
    <form action="{{ route('register') }}" method="POST" class="user-login" id="registration-form">
        @csrf

        <!-- Улучшенная область для отображения ошибок -->
        <div id="signup-errors" class="alert alert-danger" style="display: none; margin-bottom: 15px;"></div>

        <div class="form-group">
            <label for="name">Your name</label>
            <input type="text" name="name" id="name" placeholder="Name" required class="form-input">
            <div class="field-error" data-field="name"></div>
        </div>

        <div class="form-group">
            <label for="email">Your email address</label>
            <input type="email" name="email" id="email" placeholder="Email" required class="form-input">
            <div class="field-error" data-field="email"></div>
        </div>

        <div class="form-group">
            <label for="password">Create a password</label>
            <input type="password" name="password" id="password" placeholder="Password" required class="form-input">
            <div class="field-error" data-field="password"></div>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm password" required class="form-input">
            <div class="field-error" data-field="password_confirmation"></div>
        </div>

        <button type="submit" id="signup-button">Create account</button>
        <a href="#" class="forgot">By registering, you agree to our Terms of Service and Privacy Policy.</a>
    </form>
    <x-slot name="footer">
        <div class="login-link">
            Already have an account? <a href="#"
                onclick="hidePopup('signup-popup'); showPopup('login-popup');">Login</a>
        </div>
    </x-slot>
</x-popup>

<!-- Новый popup для уведомления об успешной регистрации -->
<x-popup id="registration-success" title="Registration Successful">
    <div class="success-message">
        <p>Your account has been successfully created!</p>
        <p>We've sent an activation link to your email address. Please check your inbox and click on the link to
            activate your account.</p>
        <p><small>If you don't receive the email within a few minutes, please check your spam folder or try to log in
                and use the "Resend Activation Email" option.</small></p>
    </div>
    <x-slot name="footer">
        <button onclick="hidePopup('registration-success')" class="popup-btn-primary">OK</button>
    </x-slot>
</x-popup>

<!-- Popup для успешной активации аккаунта -->
<x-popup id="activation-success-popup" title="Аккаунт активирован">
    <div class="success-message">
        <p>Ваш аккаунт был успешно активирован!</p>
        <p>Теперь вы можете войти, используя свой email и пароль.</p>
    </div>
    <x-slot name="footer">
        <button onclick="hidePopup('activation-success-popup'); showPopup('login-popup');"
            class="popup-btn-primary">Войти</button>
    </x-slot>
</x-popup>

<x-popup id="login-popup" title="Login">
    <form action="{{ route('login') }}" method="POST" class="user-login" id="login-form">
        @csrf
        <label for="login-email">Your email address</label>
        <input type="email" name="email" id="login-email" placeholder="Email" required>

        <label for="login-password">Your password</label>
        <input type="password" name="password" id="login-password" placeholder="Password" required>

        <div class="remember-me">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Remember me</label>
        </div>

        <button type="submit">Login</button>
        <a href="#" class="forgot" onclick="hidePopup('login-popup'); showPopup('forgot-password-popup');">Forgot
            password?</a>
    </form>
    <x-slot name="footer">
        <div class="signup-link">
            Don't have an account? <a href="#" onclick="hidePopup('login-popup'); showPopup('signup-popup');">Sign
                up</a>
        </div>
    </x-slot>
</x-popup>

<!-- Popup для восстановления пароля -->
<x-popup id="forgot-password-popup" title="Reset Password">
    <form action="{{ route('password.email') }}" method="POST" class="user-login" id="forgot-password-form">
        @csrf
        <p class="form-description">Enter your email address and we will send you a link to reset your password.</p>
        <label for="reset-email">Your email address</label>
        <input type="email" name="email" id="reset-email" placeholder="Email" required>

        <button type="submit">Send Reset Link</button>
    </form>
    <x-slot name="footer">
        <div class="login-link">
            Remembered your password? <a href="#"
                onclick="hidePopup('forgot-password-popup'); showPopup('login-popup');">Back to login</a>
        </div>
    </x-slot>
</x-popup>

<script>
    // Функции, доступные глобально
    function showPopup(popupId) {
        const popup = document.getElementById(popupId);
        if (popup) {
            popup.style.display = 'flex';
            document.body.classList.add('popup-open');
            // Добавляем класс для анимации
            setTimeout(() => {
                popup.classList.add('active');
            }, 10);
        }
    }

    function hidePopup(popupId) {
        const popup = document.getElementById(popupId);
        if (popup) {
            popup.classList.remove('active');
            setTimeout(() => {
                popup.style.display = 'none';
                document.body.classList.remove('popup-open');
            }, 300); // Задержка для завершения анимации
        }
    }

    // Функция для повторной отправки письма активации
    function resendActivationEmail(email) {
        if (!email) {
            alert('Please enter your email address');
            return;
        }

        console.log('Resending activation email to:', email);

        const buttons = document.querySelectorAll('.resend-activation-btn');
        buttons.forEach(button => {
            const originalText = button.textContent;
            button.textContent = 'Sending...';
            button.disabled = true;

            fetch('/resend-activation', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email: email })
            })
                .then(response => {
                    console.log('Resend activation response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Resend activation response:', data);

                    // Удаляем ошибку активации
                    const activationError = document.querySelector('.activation-error');
                    if (activationError) {
                        activationError.remove();
                    }

                    // Показываем сообщение об успехе
                    const messageElement = document.createElement('div');
                    messageElement.classList.add('success-message');
                    messageElement.style.backgroundColor = '#D4EDDA';
                    messageElement.style.color = '#155724';
                    messageElement.style.padding = '10px';
                    messageElement.style.borderRadius = '4px';
                    messageElement.style.marginBottom = '15px';
                    messageElement.textContent = data.message || 'Activation email has been resent. Please check your inbox.';

                    const loginForm = document.getElementById('login-form');
                    if (loginForm) {
                        loginForm.prepend(messageElement);
                    }
                })
                .catch(error => {
                    console.error('Error resending activation email:', error);
                    alert('Failed to resend activation email. Please try again later.');
                })
                .finally(() => {
                    // Восстанавливаем состояние всех кнопок
                    buttons.forEach(btn => {
                        btn.textContent = originalText;
                        btn.disabled = false;
                    });
                });
        });
    }

    // JavaScript для мобильного меню
    document.addEventListener('DOMContentLoaded', () => {
        const burgerMenu = document.querySelector('.burger-menu');
        const menu = document.querySelector('.menu');

        // Toggle menu
        burgerMenu.addEventListener('click', () => {
            burgerMenu.classList.toggle('active');
            menu.classList.toggle('active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                if (!burgerMenu.contains(e.target) && !menu.contains(e.target)) {
                    burgerMenu.classList.remove('active');
                    menu.classList.remove('active');
                }
            }
        });

        // Close menu on ESC press
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && window.innerWidth <= 768) {
                burgerMenu.classList.remove('active');
                menu.classList.remove('active');
            }
        });

        // Улучшенная обработка формы регистрации с улучшенной обработкой 422 ошибок
        const registrationForm = document.getElementById('registration-form');

        if (registrationForm) {
            console.log('Registration form found - initializing with improved validation');

            // Валидация полей в реальном времени
            const validateInput = (input) => {
                const field = input.getAttribute('name');
                const value = input.value.trim();
                let isValid = true;
                let errorMessage = '';
                
                // Очистка предыдущих стилей
                input.classList.remove('has-error', 'is-valid');
                
                // Проверка для каждого поля
                switch (field) {
                    case 'name':
                        if (value.length < 2) {
                            isValid = false;
                            errorMessage = 'Name must be at least 2 characters';
                        }
                        break;
                    case 'email':
                        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailPattern.test(value)) {
                            isValid = false;
                            errorMessage = 'Please enter a valid email address';
                        }
                        break;
                    case 'password':
                        if (value.length < 8) {
                            isValid = false;
                            errorMessage = 'Password must be at least 8 characters';
                        }
                        break;
                    case 'password_confirmation':
                        const password = document.getElementById('password').value;
                        if (value !== password) {
                            isValid = false;
                            errorMessage = 'Passwords do not match';
                        }
                        break;
                }
                
                // Обновление визуального состояния поля
                const errorElement = document.querySelector(`.field-error[data-field="${field}"]`);
                if (errorElement) {
                    if (!isValid) {
                        input.classList.add('has-error');
                        errorElement.textContent = errorMessage;
                        errorElement.style.display = 'block';
                    } else {
                        input.classList.add('is-valid');
                        errorElement.style.display = 'none';
                    }
                }
                
                return isValid;
            };

            // Добавим обработчики событий для мгновенной валидации
            registrationForm.querySelectorAll('input').forEach(input => {
                input.addEventListener('blur', function() {
                    validateInput(this);
                });
                
                input.addEventListener('input', function() {
                    // Очистка ошибок при вводе текста, но без валидации
                    const field = this.getAttribute('name');
                    const errorElement = document.querySelector(`.field-error[data-field="${field}"]`);
                    if (errorElement && errorElement.style.display === 'block') {
                        // Проверяем только если поле уже было отмечено как ошибочное
                        validateInput(this);
                    }
                });
            });

            // Улучшенный обработчик отправки формы с визуальной обратной связью
            registrationForm.addEventListener('submit', function (e) {
                e.preventDefault();
                console.log('Registration form submit intercepted');

                // Очистка предыдущих ошибок
                clearErrors();

                // Валидация всех полей перед отправкой
                let isFormValid = true;
                const formInputs = this.querySelectorAll('input');
                
                formInputs.forEach(input => {
                    if (!validateInput(input)) {
                        isFormValid = false;
                    }
                });
                
                // Если есть ошибки валидации, останавливаем отправку
                if (!isFormValid) {
                    const firstErrorInput = this.querySelector('input.has-error');
                    if (firstErrorInput) {
                        firstErrorInput.focus();
                        
                        // Показываем общее сообщение об ошибке
                        const errorContainer = document.getElementById('signup-errors');
                        errorContainer.textContent = 'Please fix the errors below before submitting';
                        errorContainer.style.display = 'block';
                        
                        // Плавная анимация к первой ошибке
                        firstErrorInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    return;
                }

                // Добавление индикатора загрузки
                const submitBtn = document.getElementById('signup-button');
                const originalBtnText = submitBtn.textContent;
                submitBtn.innerHTML = '<span class="spinner"></span> Processing...';
                submitBtn.disabled = true;

                // Продолжение с отправкой формы через AJAX
                // Создание FormData из формы
                const formData = new FormData(this);

                // AJAX запрос с улучшенной обработкой ошибок
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    console.log(`Registration response status: ${response.status}`);

                    // Обработка различных кодов состояния
                    if (response.redirected) {
                        window.location.href = response.url;
                        return null;
                    }

                    // Всегда получаем JSON из ответа
                    return response.json().catch(e => {
                        // Если не получилось распарсить как JSON, создаем специальную ошибку
                        const customError = new Error('Failed to parse server response');
                        customError.status = response.status;
                        customError.statusText = response.statusText;
                        throw customError;
                    });
                })
                .then(data => {
                    if (!data) return; // Обработка редиректа
                    
                    console.log('Registration response data:', data);

                    // Проверяем на наличие ошибок валидации (код 422)
                    if (data.errors) {
                        // Анимированное отображение ошибок валидации
                        console.log('Validation errors:', data.errors);

                        Object.entries(data.errors).forEach(([field, messages]) => {
                            const errorMessage = Array.isArray(messages) ? messages[0] : messages;
                            const input = document.querySelector(`input[name="${field}"]`);
                            
                            if (input) {
                                input.classList.add('has-error');
                                input.classList.remove('is-valid');
                                
                                // Плавная анимация ошибки
                                setTimeout(() => {
                                    showError(errorMessage, field);
                                }, 100);
                            } else {
                                showError(errorMessage);
                            }
                        });
                        
                        // Фокус на первом поле с ошибкой
                        const firstErrorInput = document.querySelector('input.has-error');
                        if (firstErrorInput) {
                            firstErrorInput.focus();
                            firstErrorInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                        
                        return;
                    }

                    // Проверяем на наличие общей ошибки
                    if (data.error || (data.success === false)) {
                        console.error('Error in response:', data.error || data.message);
                        showError(data.error || data.message);
                        return;
                    }

                    // Обработка успешной регистрации
                    if (data.success) {
                        console.log('Registration successful');
                        // Добавляем анимацию успеха
                        formInputs.forEach(input => {
                            input.classList.add('is-valid');
                        });
                        
                        // Показываем уведомление об успехе и сбрасываем форму
                        setTimeout(() => {
                            registrationForm.reset();
                            hidePopup('signup-popup');
                            showPopup('registration-success');
                        }, 500);
                    } else {
                        // Если нет явного признака успеха или ошибки
                        console.warn('Ambiguous response from server:', data);
                        showError('Unexpected server response. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error during registration:', error);
                    
                    // Улучшенная обработка ошибок сети
                    if (error.message === 'Failed to fetch') {
                        showError('Network error. Please check your internet connection and try again.');
                    } else {
                        showError('Error during registration: ' + error.message);
                    }
                })
                .finally(() => {
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                });
            });

            // Функция очистки ошибок с анимацией
            function clearErrors() {
                document.querySelectorAll('.field-error').forEach(el => {
                    el.style.opacity = '0';
                    setTimeout(() => {
                        el.textContent = '';
                        el.style.display = 'none';
                        el.style.opacity = '1';
                    }, 300);
                });

                document.querySelectorAll('input').forEach(input => {
                    input.classList.remove('has-error', 'is-valid');
                });

                const errorContainer = document.getElementById('signup-errors');
                if (errorContainer) {
                    errorContainer.style.opacity = '0';
                    setTimeout(() => {
                        errorContainer.style.display = 'none';
                        errorContainer.textContent = '';
                        errorContainer.style.opacity = '1';
                    }, 300);
                }
            }

            // Улучшенная функция отображения ошибки с анимацией
            function showError(message, field = null) {
                console.log(`Showing error${field ? ' for ' + field : ''}: ${message}`);

                if (field) {
                    const fieldError = document.querySelector(`.field-error[data-field="${field}"]`);
                    const inputField = document.querySelector(`input[name="${field}"]`);
                    
                    if (fieldError) {
                        fieldError.textContent = message;
                        fieldError.style.display = 'block';
                        fieldError.style.opacity = '0';
                        
                        // Плавное появление ошибки
                        setTimeout(() => {
                            fieldError.style.opacity = '1';
                        }, 10);
                    }
                    
                    if (inputField) {
                        // Добавляем визуальные индикаторы к полю с ошибкой
                        inputField.classList.add('has-error');
                        inputField.classList.remove('is-valid');
                        
                        // Мягкое "встряхивание" поля для привлечения внимания
                        inputField.animate(
                            [
                                { transform: 'translateX(0)' },
                                { transform: 'translateX(-5px)' },
                                { transform: 'translateX(5px)' },
                                { transform: 'translateX(0)' }
                            ], 
                            { duration: 300, easing: 'ease-in-out' }
                        );
                    }
                } else {
                    const errorContainer = document.getElementById('signup-errors');
                    if (errorContainer) {
                        errorContainer.textContent = message;
                        errorContainer.style.display = 'block';
                        errorContainer.style.opacity = '0';
                        
                        // Плавное появление общей ошибки
                        setTimeout(() => {
                            errorContainer.style.opacity = '1';
                            
                            // Убедимся, что пользователь видит сообщение об ошибке
                            errorContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }, 10);
                    }
                }
            }
        } else {
            console.error('Registration form not found');
        }

        // Обработчик формы логина
        const loginForm = document.getElementById('login-form');
        if (loginForm) {
            console.log('Login form found and initialized');

            loginForm.addEventListener('submit', function (e) {
                e.preventDefault();
                console.log('Login form submission started');

                // Очистка предыдущих ошибок
                const errorElements = document.querySelectorAll('.error-message');
                errorElements.forEach(el => el.remove());

                // Очистка предыдущих успешных сообщений
                const successMessages = document.querySelectorAll('.success-message');
                successMessages.forEach(el => el.remove());

                // Добавление индикатора загрузки
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.textContent;
                submitBtn.textContent = 'Logging in...';
                submitBtn.disabled = true;

                // Сбор данных формы
                const formData = new FormData(this);

                // Добавим дебаг сообщение для проверки данных формы
                console.log('Login form data:', Object.fromEntries(formData));

                // AJAX запрос для входа
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    // Разрешаем куки и сессию для правильной аутентификации
                    credentials: 'same-origin'
                })
                    .then(response => {
                        console.log('Login response status:', response.status);

                        // Проверяем перенаправление
                        if (response.redirected) {
                            console.log('Redirected to:', response.url);
                            window.location.href = response.url;
                            return;
                        }

                        if (response.status === 403) {
                            // Специальная обработка для неактивированного аккаунта
                            return response.json().then(data => {
                                // Создаем специальный объект для обработки ошибки активации
                                const activationError = {
                                    type: 'activation_required',
                                    message: data.message || 'Please activate your account first.',
                                    email: loginForm.querySelector('#login-email').value
                                };
                                throw activationError;
                            });
                        }

                        if (response.status >= 200 && response.status < 300) {
                            // Если ответ успешный
                            const contentType = response.headers.get('content-type');
                            if (contentType && contentType.includes('application/json')) {
                                return response.json();
                            } else {
                                console.log('Non-JSON response, reloading page');
                                window.location.reload();
                                return;
                            }
                        }

                        if (response.status === 422) {
                            // Ошибка валидации
                            return response.json().then(data => {
                                throw new Error('VALIDATION:' + JSON.stringify(data.errors));
                            });
                        }

                        throw new Error('Server returned ' + response.status + ': ' + response.statusText);
                    })
                    .then(data => {
                        console.log('Login response data:', data);

                        if (data && data.success) {
                            console.log('Login successful, reloading page');
                            window.location.reload();
                        } else {
                            // Показываем общую ошибку
                            const generalError = document.createElement('div');
                            generalError.classList.add('error-message');
                            generalError.textContent = data.message || 'Invalid credentials';
                            loginForm.prepend(generalError);
                        }
                    })
                    .catch(error => {
                        console.error('Error during login:', error);

                        // Отображение сообщения об ошибке
                        const generalError = document.createElement('div');
                        generalError.classList.add('error-message');

                        if (error.type === 'activation_required') {
                            // Специальное сообщение для неактивированного аккаунта
                            generalError.innerHTML = `
                                <div class="activation-error">
                                    <strong>Account Not Activated</strong>
                                    <p>${error.message}</p>
                                    <p>Please check your email inbox for the activation link we sent you.</p>
                                    <button type="button" class="resend-activation-btn" onclick="resendActivationEmail('${error.email}')">
                                        Resend Activation Email
                                    </button>
                                </div>
                            `;
                        } else if (error.message && error.message.startsWith('VALIDATION:')) {
                            // Ошибки валидации
                            try {
                                const errors = JSON.parse(error.message.replace('VALIDATION:', ''));
                                generalError.innerHTML = '<strong>Please fix the following errors:</strong><ul>';
                                Object.values(errors).forEach(msgs => {
                                    msgs.forEach(msg => {
                                        generalError.innerHTML += `<li>${msg}</li>`;
                                    });
                                });
                                generalError.innerHTML += '</ul>';
                            } catch (e) {
                                generalError.textContent = 'Please check your input and try again.';
                            }
                        } else if (error.message && error.message.includes('500')) {
                            // Серверная ошибка
                            generalError.innerHTML = `
                                <strong>Произошла серверная ошибка (500)</strong>
                                <p>Проверьте следующее:</p>
                                <ul>
                                    <li>Корректно ли настроен Laravel для аутентификации</li>
                                    <li>Есть ли проблемы с сессией (проверьте настройки session driver)</li>
                                    <li>Логи в storage/logs/laravel.log</li>
                                </ul>
                            `;
                        } else {
                            generalError.textContent = 'Login failed. Please check your credentials.';
                        }

                        // Удалим предыдущие сообщения об ошибках, если они есть
                        const previousErrors = loginForm.querySelectorAll('.error-message');
                        previousErrors.forEach(el => el.remove());

                        loginForm.prepend(generalError);

                        // Если это ошибка активации, добавляем стили для сообщения
                        if (error.type === 'activation_required') {
                            const activationError = loginForm.querySelector('.activation-error');
                            if (activationError) {
                                activationError.style.backgroundColor = '#FFF3CD';
                                activationError.style.color = '#856404';
                                activationError.style.padding = '10px';
                                activationError.style.borderRadius = '4px';
                                activationError.style.marginBottom = '15px';

                                const resendBtn = activationError.querySelector('.resend-activation-btn');
                                if (resendBtn) {
                                    resendBtn.style.backgroundColor = '#007BFF';
                                    resendBtn.style.color = 'white';
                                    resendBtn.style.border = 'none';
                                    resendBtn.style.padding = '5px 10px';
                                    resendBtn.style.borderRadius = '3px';
                                    resendBtn.style.cursor = 'pointer';
                                    resendBtn.style.marginTop = '10px';
                                }
                            }
                        }
                    })
                    .finally(() => {
                        // Восстановление кнопки
                        submitBtn.textContent = originalBtnText;
                        submitBtn.disabled = false;
                    });
            });
        }

        // Обработчик формы сброса пароля
        const forgotPasswordForm = document.getElementById('forgot-password-form');
        if (forgotPasswordForm) {
            console.log('Forgot password form found and initialized');

            forgotPasswordForm.addEventListener('submit', function (e) {
                e.preventDefault();
                console.log('Password reset form submitted');

                // Очистка предыдущих ошибок
                const errorElements = document.querySelectorAll('.error-message');
                errorElements.forEach(el => el.remove());

                // Добавление индикатора загрузки
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.textContent;
                submitBtn.textContent = 'Sending...';
                submitBtn.disabled = true;

                // Сбор данных формы
                const formData = new FormData(this);

                console.log('Password reset form submitted for email:', formData.get('email'));

                // AJAX запрос с улучшенной обработкой ошибок
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    credentials: 'same-origin'
                })
                    .then(response => {
                        console.log('Password reset response status:', response.status);

                        // Попытка обработать ответ как JSON независимо от статуса
                        return response.text().then(text => {
                            if (!text) return { error: 'Empty response' };

                            try {
                                return JSON.parse(text);
                            } catch (e) {
                                console.log('Non-JSON response:', text);
                                // Если это не JSON, возможно это HTML ошибки
                                return {
                                    error: 'Cannot process server response',
                                    html: text,
                                    status: response.status
                                };
                            }
                        });
                    })
                    .then(data => {
                        console.log('Password reset response data:', data);

                        if (data.error) {
                            throw new Error(data.error);
                        }

                        // Показываем сообщение об успехе
                        const successMessage = document.createElement('div');
                        successMessage.classList.add('success-message');
                        successMessage.style.backgroundColor = '#D4EDDA';
                        successMessage.style.color = '#155724';
                        successMessage.style.padding = '10px';
                        successMessage.style.borderRadius = '4px';
                        successMessage.style.marginBottom = '15px';
                        successMessage.textContent = data.message || 'Password reset link has been sent to your email';
                        forgotPasswordForm.prepend(successMessage);

                        // Очищаем форму
                        forgotPasswordForm.reset();
                    })
                    .catch(error => {
                        console.error('Error during password reset:', error);

                        // Отображение общего сообщения об ошибке
                        const generalError = document.createElement('div');
                        generalError.classList.add('error-message');
                        generalError.style.backgroundColor = '#F8D7DA';
                        generalError.style.color = '#721C24';
                        generalError.style.padding = '10px';
                        generalError.style.borderRadius = '4px';
                        generalError.style.marginBottom = '15px';
                        generalError.textContent = 'Failed to send password reset link: ' + error.message;
                        forgotPasswordForm.prepend(generalError);
                    })
                    .finally(() => {
                        // Восстановление кнопки
                        submitBtn.textContent = originalBtnText;
                        submitBtn.disabled = false;
                    });
            });
        }

        // Проверка наличия шрифтов и предупреждение при необходимости
        setTimeout(() => {
            const fontErrors = performance.getEntriesByType('resource')
                .filter(entry => entry.name.includes('font') && entry.name.endsWith('.woff2') || entry.name.endsWith('.woff') || entry.name.endsWith('.ttf'))
                .filter(entry => !entry.responseEnd);

            if (fontErrors.length > 0) {
                console.warn('Отсутствуют файлы шрифтов:', fontErrors.map(e => e.name));
                console.info('Для решения проблемы сделайте следующее:');
                console.info('1. Убедитесь, что файлы шрифтов существуют в public/fonts/');
                console.info('2. Проверьте пути к шрифтам в CSS');
                console.info('3. Или используйте Google Fonts как временное решение');
            }
        }, 3000);
    });
</script>

<!-- Добавляем полифилл для fetch и Promise для старых браузеров -->
<script>
    // Проверка поддержки Fetch API
    if (!window.fetch) {
        console.log('Fetch API not supported, loading polyfill');
        document.write('<script src="https://cdn.jsdelivr.net/npm/whatwg-fetch@3.0.0/dist/fetch.umd.js"><\/script>');
    }

    // Проверка поддержки Promise
    if (typeof Promise === 'undefined') {
        console.log('Promise not supported, loading polyfill');
        document.write('<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"><\/script>');
    }
</script>

<style>
    /* Улучшенные стили для ошибок */
    #signup-errors {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 15px;
        animation: fadeIn 0.3s;
    }

    .field-error {
        color: #dc3545;
        font-size: 0.85em;
        margin-top: 5px;
        display: none;
        animation: fadeIn 0.3s;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Стили для подсветки полей с ошибками */
    .form-input.has-error {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    /* Стили для полей после успешной валидации */
    .form-input.is-valid {
        border-color: #28a745 !important;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }

    /* Контейнер для группы полей ввода */
    .form-group {
        margin-bottom: 15px;
        position: relative;
    }

    @keyframes spinner {
        to { transform: rotate(360deg); }
    }

    .spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 5px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spinner 0.8s linear infinite;
        vertical-align: middle;
    }
</style>