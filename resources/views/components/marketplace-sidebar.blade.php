<h3 class="underline">Filters:</h3>

<!-- Search field -->
<div class="filter-group">
    <input type="text" placeholder="Enter keyword" class="search-input">
</div>

<!-- Price filter -->
<div class="filter-group">
    <h4>Price</h4>
    <div class="range-slider">
        <input type="range" min="0" max="1000" value="100" class="slider" id="priceRange">
        <div class="range-values">
            <span>100$</span>
            <span>1,000$</span>
        </div>
    </div>
    <div class="checkbox-option">
        <input type="checkbox" id="hideNoPrice" checked>
        <label for="hideNoPrice">Hide listings without price</label>
    </div>
</div>

<!-- Platform filter -->
<div class="filter-group">
    <h4>Platform</h4>
    <div class="checkbox-option">
        <input type="checkbox" id="ios" checked>
        <label for="ios">iOS</label>
    </div>
    <div class="checkbox-option">
        <input type="checkbox" id="android">
        <label for="android">Android</label>
    </div>
</div>

<!-- Type filter -->
<div class="filter-group">
    <h4>Type</h4>
    <div class="checkbox-option">
        <input type="checkbox" id="game">
        <label for="game">Game</label>
    </div>
    <div class="checkbox-option">
        <input type="checkbox" id="nonGame" checked>
        <label for="nonGame">Non-Game</label>
    </div>
</div>

<!-- Last month earnings -->
<div class="filter-group">
    <h4>Last month earnings</h4>
    <div class="range-slider">
        <input type="range" min="0" max="100" class="slider" id="monthEarningsRange">
        <div class="range-values">
            <span>0$</span>
            <span>100$</span>
        </div>
    </div>
</div>

<!-- Last year earnings -->
<div class="filter-group">
    <h4>Last year earnings</h4>
    <div class="range-slider">
        <input type="range" min="0" max="100" class="slider" id="yearEarningsRange">
        <div class="range-values">
            <span>0$</span>
            <span>100$</span>
        </div>
    </div>
</div>

<!-- Age -->
<div class="filter-group">
    <h4>Age</h4>
    <div class="range-slider">
        <input type="range" min="0" max="100" class="slider" id="ageRange">
        <div class="range-values">
            <span>less than 1 month</span>
            <span>10 years+</span>
        </div>
    </div>
</div>

<!-- Installs -->
<div class="filter-group">
    <h4>Installs</h4>
    <div class="range-slider">
        <input type="range" min="0" max="100" class="slider" id="installsRange">
        <div class="range-values">
            <span>Less than 100</span>
            <span>1M+</span>
        </div>
    </div>
</div>

<!-- Specials -->
<div class="filter-group">
    <h4>Specials</h4>
    <div class="checkbox-option">
        <input type="checkbox" id="verifiedSellers">
        <label for="verifiedSellers">Verified Sellers</label>
    </div>
    <div class="checkbox-option">
        <input type="checkbox" id="accountIncluded" checked>
        <label for="accountIncluded">Account included</label>
    </div>
</div>

<!-- Monetization -->
<div class="filter-group">
    <h4>Monetization</h4>
    <div class="checkbox-option">
        <input type="checkbox" id="ads">
        <label for="ads">Ads</label>
    </div>
    <div class="checkbox-option">
        <input type="checkbox" id="inAppPurchases">
        <label for="inAppPurchases">In-app Purchases</label>
    </div>
</div>

<script>
    /* filepath: c:\Users\muham\Herd\basilbits\public\js\marketplace-filters.js */
    document.addEventListener('DOMContentLoaded', function () {
        // Обновление значений для ползунков
        const sliders = document.querySelectorAll('.slider');

        sliders.forEach(slider => {
            const valueDisplay = slider.nextElementSibling.querySelector('span:first-child');

            // Начальное значение
            if (slider.id === 'priceRange') {
                valueDisplay.textContent = slider.value + '$';
            }

            // Обработчик изменения ползунка
            slider.addEventListener('input', function () {
                if (this.id === 'priceRange') {
                    valueDisplay.textContent = this.value + '$';
                }

                // Можно добавить другие ползунки по мере необходимости
            });
        });

        // Обработка фильтров
        const filterForm = document.getElementById('filterForm');
        if (filterForm) {
            filterForm.addEventListener('submit', function (e) {
                e.preventDefault();
                // Логика фильтрации
                // Можно собрать все данные формы и отправить AJAX запрос
            });
        }
    });
</script>