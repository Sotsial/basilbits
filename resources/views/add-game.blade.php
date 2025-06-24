<x-layout>
    <link rel="stylesheet" href="{{ asset('css/game-form.css') }}">

    <section>
        <h1>Add a game</h1>

        <!-- Заменяем alert-контейнер на стандартный дизайн как на скриншоте -->
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <!-- Отображение ошибок валидации стандартным способом Laravel -->
        @if ($errors->any())
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            Something went wrong. Please try again.
        </div>
        @endif

        <!-- Изменяем форму на обычный метод отправки без AJAX -->
        <form method="POST" action="{{ route('games.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title">Title*</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="price">Price*</label>
                <input type="text" id="price" name="price" class="form-control"
                    style="width: 160px; display: inline-block;">
                <label style="margin-left: 10px;">
                    <input type="checkbox" id="on_request" name="on_request"> On Request
                </label>
            </div>

            <div class="form-group">
                <label for="title_image">Title image*</label>
                <div class="file-input-wrapper">
                    <input type="text" readonly placeholder="app-logo.png" style="width: 150px;">
                    <button type="button" class="btn btn-secondary btn-sm"
                        onclick="document.getElementById('title_image').click()">Выберите файл</button>
                    <input type="file" id="title_image" name="title_image" class="d-none">
                </div>
            </div>

            <div class="form-group">
                <label>Screenshots</label>
                <div class="screenshots-container">
                    @for ($i = 1; $i <= 5; $i++) <div class="screenshot-item">
                        <div class="number-label">{{ $i }}</div>
                        <button type="button" class="btn btn-secondary btn-sm"
                            onclick="document.getElementById('screenshot_{{ $i }}').click()">Выберите файл</button>
                        <span class="filename-display">Файл не выбран</span>
                        <input type="file" name="screenshots[]" id="screenshot_{{ $i }}" class="d-none"
                            onchange="updateFileName(this)">
                </div>
                @endfor
            </div>
            </div>

            <div class="form-group">
                <label>Platform*</label>
                <div class="row">
                    <label style="margin-right: 20px;">
                        <input type="radio" name="platform" value="ios"> iOS
                    </label>
                    <label>
                        <input type="radio" name="platform" value="android"> Android
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>Last month earnings*</label>
                <div class="row">
                    <label style="margin-right: 10px;">
                        <input type="radio" name="earnings" value="unprofitable"> Unprofitable
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="radio" name="earnings" value="less_than_100$"> Less than 100$
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="radio" name="earnings" value="100-1000$"> 100-1000$
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="radio" name="earnings" value="1k-5k"> 1k-5k
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="radio" name="earnings" value="5k-10k"> 5k-10k
                    </label>
                    <label>
                        <input type="radio" name="earnings" value="10k+"> 10k+
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>Age*</label>
                <div class="row">
                    <label style="margin-right: 10px;">
                        <input type="radio" name="age" value="less_than_1_month"> Less than 1 month
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="radio" name="age" value="1-6_months"> 1-6 Months
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="radio" name="age" value="6-12_months"> 6-12 months
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="radio" name="age" value="1-3_years"> 1-3 years
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="radio" name="age" value="3-5_years"> 3-5 years
                    </label>
                    <label>
                        <input type="radio" name="age" value="5+"> 5y+
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>Installs*</label>
                <div class="row">
                    <label style="margin-right: 10px;">
                        <input type="radio" name="installs" value="less_than_100"> Less than 100
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="radio" name="installs" value="100-1000"> 100-1000
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="radio" name="installs" value="1-10k"> 1-10k
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="radio" name="installs" value="10k-100k"> 10k-100k
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="radio" name="installs" value="100k-1m"> 100k-1M
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="radio" name="installs" value="1m-10m+"> 1M-10M+
                    </label>
                    <label>
                        <input type="radio" name="installs" value="10m+"> 10M+
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>Monetization*</label>
                <div class="row">
                    <label style="margin-right: 10px;">
                        <input type="checkbox" name="monetization[]" value="ads"> Ads
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="checkbox" name="monetization[]" value="in-app"> In-App
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="checkbox" name="monetization[]" value="paid_app"> Paid App
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="checkbox" name="monetization[]" value="cpa"> CPA
                    </label>
                    <label>
                        <input type="checkbox" name="monetization[]" value="other"> Other
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>Attached Files</label>
                <div class="">
                    @for ($i = 1; $i <= 8; $i++) <div class="col-md-1">
                        <button type="button" class="btn btn-secondary attachment-btn" data-id="{{ $i }}">{{ $i
                            }}</button>
                        <input type="file" name="attachments[]" id="attachment_{{ $i }}" class="d-none">
                </div>
                @endfor
            </div>
            </div>

            <div class="form-group">
                <label>Financials</label>
                <div class="">
                    @for ($i = 1; $i <= 8; $i++) <div class="col-md-1">
                        <button type="button" class="btn btn-secondary financial-btn" data-id="{{ $i }}">{{ $i
                            }}</button>
                        <input type="file" name="financials[]" id="financial_{{ $i }}" class="d-none">
                </div>
                @endfor
            </div>
            </div>

            <div class="form-group">
                <label for="description">Description*</label>
                <textarea id="description" name="description" class="form-control" rows="8"
                    placeholder="Bold and links supported"></textarea>
            </div>

            <div class="form-group">
                <label for="link">Link</label>
                <input type="url" id="link" name="link" class="form-control">
            </div>

            <div class="form-group">
                <label>Payment methods</label>
                <div class="row">
                    <label style="margin-right: 10px;">
                        <input type="checkbox" name="payment_methods[]" value="escrow"> Escrow.com
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="checkbox" name="payment_methods[]" value="crypto"> Crypto
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="checkbox" name="payment_methods[]" value="payoneer"> Payoneer
                    </label>
                    <label>
                        <input type="checkbox" name="payment_methods[]" value="wire_swift"> Wire/Swift
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="seller">Seller</label>
                <div class="input-group seller-buttons">
                    <input type="text" id="seller_display" class="form-control seller-input" readonly
                        placeholder="Choose from the list">
                    <div class="input-group-append">
                        <button class="btn btn-link seller-btn" type="button" id="seller_select_btn">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                </div>
                <input type="hidden" id="seller" name="seller">
            </div>

            <div class="form-group">
                <label for="video_link">Link to video</label>
                <input type="url" id="video_link" name="video_link" class="form-control">
            </div>

            <div class="form-group">
                <label>Specials</label>
                <div class="row">
                    <label style="margin-right: 20px;">
                        <input type="checkbox" name="specials[]" value="verified_seller"> Verified Seller
                    </label>
                    <label>
                        <input type="checkbox" name="specials[]" value="account_included"> Account Included
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </section>

    <!-- Используем существующий компонент popup вместо прямого определения модального окна -->
    <x-popup id="sellerModal" title="Select a Seller">
        <input type="text" id="sellerSearch" class="form-control mb-3" placeholder="Search sellers...">
        <div id="sellersList" class="list-group">
            <!-- Здесь будет список продавцов -->
            <div class="text-center py-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </x-popup>

    <script>
        // Функция для отладки
        function debug(message, data = null) {
            const timestamp = new Date().toISOString().split('T')[1].substring(0, 12);
            if (data) {
                console.log(`[${timestamp}] DEBUG: ${message}`, data);
            } else {
                console.log(`[${timestamp}] DEBUG: ${message}`);
            }
        }

        // Инициализация формы
        document.addEventListener('DOMContentLoaded', function () {
            debug('Форма загружена, инициализация скриптов');

            // Проверка наличия всех необходимых элементов
            const formElements = {
                form: document.querySelector('form'),
                titleInput: document.getElementById('title'),
                priceInput: document.getElementById('price'),
                titleImageInput: document.getElementById('title_image'),
                submitButton: document.querySelector('button[type="submit"]')
            };

            // Проверка наличия всех элементов формы
            for (const [key, element] of Object.entries(formElements)) {
                if (!element) {
                    console.error(`Ошибка: Элемент ${key} не найден на странице`);
                }
            }

            // Проверка маршрута отправки формы
            if (formElements.form) {
                debug(`Форма настроена на отправку по адресу: ${formElements.form.action}`);
            }
        });

        // Функция для отображения имени выбранного файла
        function updateFileName(input) {
            debug('Выбор файла:', input.id);
            if (input.files && input.files[0]) {
                const label = input.parentElement.querySelector('.filename-display');
                if (label) {
                    label.textContent = input.files[0].name;
                    debug(`Файл выбран: ${input.files[0].name}, размер: ${input.files[0].size} байт`);
                    // Визуальное подтверждение выбора файла
                    input.parentElement.classList.add('file-selected');
                } else {
                    console.error('Элемент для отображения имени файла не найден');
                }
            }
        }

        // Обработка загрузки изображения заголовка
        document.getElementById('title_image')?.addEventListener('change', function () {
            debug('Загрузка изображения заголовка');
            if (this.files && this.files[0]) {
                const fileNameDisplay = this.parentElement.querySelector('input[readonly]');
                if (fileNameDisplay) {
                    fileNameDisplay.value = this.files[0].name;
                    debug(`Выбрано изображение заголовка: ${this.files[0].name}`);
                } else {
                    console.error('Элемент для отображения имени файла заголовка не найден');
                }
            }
        });

        // При отправке формы показать индикатор загрузки и убедиться, что форма отправляется
        document.querySelector('form')?.addEventListener('submit', function (e) {
            debug('Попытка отправки формы');

            // Собираем данные формы для отладки
            const formData = new FormData(this);
            const formDataObj = {};
            for (const [key, value] of formData.entries()) {
                if (key.includes('file') || key.includes('image')) {
                    formDataObj[key] = value.name || 'Файл не выбран';
                } else {
                    formDataObj[key] = value;
                }
            }
            debug('Данные формы:', formDataObj);

            // Предотвращаем отправку формы, если есть ошибки валидации
            if (!validateForm()) {
                debug('Ошибка валидации формы, отправка отменена');
                e.preventDefault();
                return false;
            }

            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Sending...';
                debug('Форма валидна, отправляем данные на сервер');
            }

            debug(`Форма отправляется на ${this.action} методом ${this.method}`);

            // Добавим доп. отладку для обнаружения проблем с отправкой формы
            setTimeout(() => {
                if (submitBtn.disabled) {
                    debug('Форма все еще в процессе отправки после 5 секунд');
                }
            }, 5000);

            return true;
        });

        // Простая валидация формы
        function validateForm() {
            debug('Валидация формы');
            let isValid = true;

            // Проверяем обязательные поля
            const requiredFields = ['title', 'description'];
            for (const field of requiredFields) {
                const element = document.getElementById(field);
                if (!element || !element.value) {
                    showError(`Поле ${field} обязательно для заполнения`);
                    debug(`Ошибка валидации: поле ${field} не заполнено`);
                    isValid = false;
                }
            }

            // Проверяем загрузку изображения
            const titleImageInput = document.getElementById('title_image');
            if (titleImageInput && (!titleImageInput.files || !titleImageInput.files[0])) {
                showError('Необходимо загрузить изображение заголовка');
                debug('Ошибка валидации: изображение заголовка не выбрано');
                isValid = false;
            }

            // Проверяем, выбрана ли платформа
            const platformSelected = document.querySelector('input[name="platform"]:checked');
            if (!platformSelected) {
                showError('Выберите платформу');
                debug('Ошибка валидации: платформа не выбрана');
                isValid = false;
            }

            // Проверяем другие обязательные селекторы
            const earningsSelected = document.querySelector('input[name="earnings"]:checked');
            if (!earningsSelected) {
                showError('Укажите месячный доход');
                debug('Ошибка валидации: месячный доход не выбран');
                isValid = false;
            }

            const ageSelected = document.querySelector('input[name="age"]:checked');
            if (!ageSelected) {
                showError('Укажите возраст приложения');
                debug('Ошибка валидации: возраст приложения не выбран');
                isValid = false;
            }

            const installsSelected = document.querySelector('input[name="installs"]:checked');
            if (!installsSelected) {
                showError('Укажите количество установок');
                debug('Ошибка валидации: количество установок не выбрано');
                isValid = false;
            }

            debug(`Результат валидации: ${isValid ? 'форма валидна' : 'форма содержит ошибки'}`);
            return isValid;
        }

        function showError(message) {
            debug(`Отображение ошибки: ${message}`);
            // Создаем флеш-сообщение с ошибкой
            const errorContainer = document.createElement('div');
            errorContainer.className = 'alert alert-danger mt-3';
            errorContainer.textContent = message;

            // Добавляем сообщение в начало формы
            const form = document.querySelector('form');
            if (form) {
                form.insertAdjacentElement('afterbegin', errorContainer);

                // Удаляем сообщение через 5 секунд
                setTimeout(() => {
                    errorContainer.remove();
                }, 5000);

                // Прокручиваем к сообщению
                errorContainer.scrollIntoView({ behavior: 'smooth' });
            } else {
                console.error('Форма не найдена для отображения ошибки');
            }
        }
    </script>

    <script>
        // События загрузки для диагностики
        window.addEventListener('load', function () {
            debug('Страница полностью загружена');
        });

        // Отслеживание ошибок JS
        window.addEventListener('error', function (e) {
            console.error('JS ошибка:', e.error?.message || e.message, e.error?.stack || '');
        });

        // Отслеживание отправки формы глобально
        window.addEventListener('submit', function (e) {
            debug(`Событие отправки формы на ${e.target.action}`, e);
        });

        // Отслеживание запросов к серверу
        const originalFetch = window.fetch;
        window.fetch = function () {
            debug('Fetch запрос:', arguments);
            return originalFetch.apply(this, arguments).then(
                response => {
                    debug('Fetch ответ:', {
                        url: response.url,
                        status: response.status,
                        ok: response.ok
                    });
                    return response;
                },
                error => {
                    debug('Fetch ошибка:', error);
                    throw error;
                }
            );
        };

        // Отслеживание XHR запросов
        const originalXHROpen = XMLHttpRequest.prototype.open;
        XMLHttpRequest.prototype.open = function () {
            debug('XHR запрос открыт:', arguments);
            this.addEventListener('load', function () {
                debug('XHR ответ получен:', {
                    url: this._url,
                    status: this.status,
                    responseType: this.responseType
                });
            });
            this.addEventListener('error', function (e) {
                debug('XHR ошибка:', e);
            });
            this._url = arguments[1];
            return originalXHROpen.apply(this, arguments);
        };
    </script>

    <script>
        // Обработка выбора продавца
        document.addEventListener('DOMContentLoaded', function () {
            // Загружаем jQuery, если его нет
            if (typeof $ === 'undefined') {
                console.error('jQuery не загружен! Использую нативный JavaScript');

                // Обработка клика по кнопке выбора продавца
                document.getElementById('seller_select_btn').addEventListener('click', function () {
                    loadSellers();
                    // Пробуем различные способы открыть popup
                    if (typeof showPopup === 'function') {
                        showPopup('sellerModal');
                    } else if (typeof window.showPopup === 'function') {
                        window.showPopup('sellerModal');
                    } else {
                        console.error('Функция showPopup не найдена');
                        // Fallback к jQuery, если он все же доступен
                        if ($ && $.fn && $.fn.modal) {
                            $('#sellerModal').modal('show');
                        }
                    }
                });

                // Поиск в реальном времени
                document.getElementById('sellerSearch').addEventListener('keyup', function () {
                    var value = this.value.toLowerCase();
                    document.querySelectorAll("#sellersList .list-group-item").forEach(function (item) {
                        if (item.textContent.toLowerCase().indexOf(value) > -1) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            } else {
                // Используем jQuery если доступен
                $('#seller_select_btn').click(function () {
                    loadSellers();

                    // Пробуем различные способы открыть popup
                    if (typeof showPopup === 'function') {
                        showPopup('sellerModal');
                    } else if (typeof window.showPopup === 'function') {
                        window.showPopup('sellerModal');
                    } else if ($.fn.modal) {
                        $('#sellerModal').modal('show');
                    } else {
                        console.error('Не удалось найти способ открыть модальное окно');
                    }
                });

                $('#sellerSearch').on('keyup', function () {
                    var value = $(this).val().toLowerCase();
                    $("#sellersList .list-group-item").filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    });
                });
            }
        });

        // Загрузка списка продавцов с сервера
        function loadSellers() {
            console.log('Загрузка списка продавцов...');

            // Получаем элемент списка разными способами для надежности
            var sellersList = document.getElementById('sellersList') ||
                document.querySelector('#sellersList') ||
                document.querySelector('[id="sellersList"]');

            // Показываем индикатор загрузки
            if (sellersList) {
                sellersList.innerHTML = '<div class="text-center py-3"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>';
            }

            // AJAX-запрос
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/api/sellers/list', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    var data;
                    try {
                        data = JSON.parse(xhr.responseText);
                        console.log('Список продавцов получен:', data);
                        renderSellersList(data);
                    } catch (e) {
                        console.error('Ошибка разбора JSON:', e);
                        showSellerError('Некорректный ответ сервера');
                    }
                } else {
                    console.error('Ошибка запроса:', xhr.status);
                    showSellerError('Ошибка загрузки: ' + xhr.statusText);
                }
            };

            xhr.onerror = function () {
                console.error('Ошибка сети при запросе к серверу');
                showSellerError('Ошибка сети. Проверьте подключение.');
            };

            xhr.send();
        }

        function renderSellersList(data) {
            var sellersList = document.getElementById('sellersList');
            if (!sellersList) {
                console.error('Элемент sellersList не найден');
                return;
            }

            sellersList.innerHTML = '';

            if (!data || data.length === 0) {
                sellersList.innerHTML = '<div class="text-center py-3">Нет доступных продавцов</div>';
                return;
            }

            // Создаем HTML для списка продавцов
            data.forEach(function (seller) {
                var item = document.createElement('a');
                item.href = 'javascript:void(0)';
                item.className = 'list-group-item list-group-item-action seller-item';
                item.dataset.id = seller.id;
                item.dataset.name = seller.name;
                item.textContent = seller.name;

                // Обработчик клика на элементе списка
                item.addEventListener('click', function () {
                    selectSeller(seller.id, seller.name);
                });

                sellersList.appendChild(item);
            });
        }

        function selectSeller(id, name) {
            console.log('Выбран продавец:', name, id);

            // Устанавливаем значения в форму
            document.getElementById('seller').value = id;
            document.getElementById('seller_display').value = name;

            // Закрываем popup разными способами
            if (typeof hidePopup === 'function') {
                hidePopup('sellerModal');
            } else if (typeof window.hidePopup === 'function') {
                window.hidePopup('sellerModal');
            } else if (typeof $ !== 'undefined' && $.fn && $.fn.modal) {
                $('#sellerModal').modal('hide');
            } else {
                console.error('Не удалось найти способ закрыть модальное окно');
            }
        }

        function showSellerError(message) {
            var sellersList = document.getElementById('sellersList');
            if (sellersList) {
                sellersList.innerHTML = '<div class="alert alert-danger">' + message + '</div>';
            }
        }
    </script>

    <!-- Убедимся, что jQuery и Bootstrap загружены перед нашими скриптами -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        .alert {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 4px;
            position: relative;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .close {
            position: absolute;
            right: 10px;
            top: 10px;
            text-align: center;
            font-size: 1.5rem;
            background: none;
            border: none;
            cursor: pointer;
            color: white;
        }

        .file-input-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .screenshots-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .screenshot-item {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 10px;
        }

        .number-label {
            color: white;
            background-color: #6c757d;
            border-radius: 50%;
            line-height: 24px;
            text-align: center;
            height: 24px;
            width: 24px;
            display: inline-block;
        }

        .file-selected .filename-display {
            color: #28a745;
        }

        .filename-display {
            color: #666;
            font-size: 0.9em;
        }

        /* Стили для Select2 */
        .select2-container--default .select2-selection--single {
            height: 38px;
            line-height: 38px;
            border: 1px solid #ced4da;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        /* Стили для поля выбора продавца */
        .seller-input {
            border-right: none;
        }

        .seller-btn {
            background-color: #fff;
            border-left: none;
            border-color: #ced4da;
            color: #495057;
            padding: 0.375rem 0.75rem;
        }

        .seller-btn:hover {
            color: #212529;
            background-color: #f8f9fa;
        }

        .input-group-append {
            margin-left: 0;
        }

        .seller-buttons {
            display: flex;
        }

        #sellersList {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 10px;
        }
    </style>
</x-layout>