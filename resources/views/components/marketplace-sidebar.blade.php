<form action="{{ route('marketplace') }}" method="GET">
    <h3 class="underline">Filters:</h3>

    <div class="filter-group">
        <input type="text" name="keyword" placeholder="Enter keyword" class="search-input" value="{{ request('keyword') }}">
    </div>

    <div class="filter-group">
        <h4>Price</h4>
        <div class="price-range-inputs" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <div class="price-input-min">
                <label for="price_min">Min: <span id="priceMinValue">{{ request('price_min', 0) }}$</span></label>
            </div>
            <div class="price-input-max">
                <label for="price_max">Max: <span id="priceMaxValue">{{ request('price_max', 10000) }}$</span></label>
            </div>
        </div>
        <div class="range-slider-container" style="padding: 0 10px;">
            <input type="range" name="price_min" min="0" max="10000" value="{{ request('price_min', 0) }}" class="slider" id="priceMinRange" style="width: 100%;">
            <input type="range" name="price_max" min="0" max="10000" value="{{ request('price_max', 10000) }}" class="slider" id="priceMaxRange" style="width: 100%;">
        </div>
        <div class="checkbox-option" style="margin-top: 10px;">
            <input type="checkbox" name="hide_no_price" id="hideNoPrice" value="1" {{ request('hide_no_price') ? 'checked' : '' }}>
            <label for="hideNoPrice">Hide listings without price</label>
        </div>
    </div>


    <div class="filter-group">
        <h4>Platform</h4>
        @foreach(['ios', 'android'] as $platform)
        <div class="checkbox-option">
            <input type="checkbox" name="platform[]" value="{{ $platform }}" id="{{ $platform }}" {{ in_array($platform, request('platform', [])) ? 'checked' : '' }}>
            <label for="{{ $platform }}">{{ ucfirst($platform) }}</label>
        </div>
        @endforeach
    </div>

    <div class="filter-group">
        <h4>Type</h4>
        @foreach(['game', 'non-game'] as $type)
        <div class="checkbox-option">
            <input type="checkbox" name="type[]" value="{{ $type }}" id="{{ str_replace('-', '', $type) }}" {{ in_array($type, request('type', [])) ? 'checked' : '' }}>
            <label for="{{ str_replace('-', '', $type) }}">{{ ucfirst($type) }}</label>
        </div>
        @endforeach
    </div>

    <div class="filter-group">
        <h4>Last month earnings</h4>
        <div class="range-slider">
            <input type="range" name="earnings_min" min="0" max="5000" value="{{ request('earnings_min', 0) }}" class="slider" id="monthEarningsRange">
            <div class="range-values">
                <span id="monthEarningsValue">{{ request('earnings_min', 0) }}$</span>
                <span>5000$</span>
            </div>
        </div>
    </div>
    
    <div class="filter-group">
        <h4>Age (months)</h4>
        <div class="range-slider">
            <input type="range" name="age_min" min="0" max="120" value="{{ request('age_min', 0) }}" class="slider" id="ageRange">
            <div class="range-values">
                <span id="ageValue">{{ request('age_min', 0) }} months</span>
                <span>10+ years</span>
            </div>
        </div>
    </div>

    <div class="filter-group">
        <h4>Installs</h4>
        <div class="range-slider">
            <input type="range" name="installs_min" min="0" max="1000000" step="100" value="{{ request('installs_min', 0) }}" class="slider" id="installsRange">
            <div class="range-values">
                <span id="installsValue">{{ request('installs_min', 0) }}</span>
                <span>1M+</span>
            </div>
        </div>
    </div>

    <div class="filter-group">
        <h4>Monetization</h4>
        @foreach(['ads', 'in-app-purchases', 'subscriptions', 'paid'] as $monetization)
        <div class="checkbox-option">
            <input type="checkbox" name="monetization[]" value="{{ $monetization }}" id="{{ str_replace('-', '', $monetization) }}" {{ in_array($monetization, request('monetization', [])) ? 'checked' : '' }}>
            <label for="{{ str_replace('-', '', $monetization) }}">{{ str_replace('-', ' ', ucfirst($monetization)) }}</label>
        </div>
        @endforeach
    </div>

    <button type="submit" class="button green" style="width: 100%; margin-top: 20px;">Apply Filters</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Price Sliders ---
    const priceMinSlider = document.getElementById('priceMinRange');
    const priceMaxSlider = document.getElementById('priceMaxRange');
    const priceMinValue = document.getElementById('priceMinValue');
    const priceMaxValue = document.getElementById('priceMaxValue');

    function updatePriceSliders() {
        let min = parseInt(priceMinSlider.value);
        let max = parseInt(priceMaxSlider.value);

        if (min > max) {
            // Swap values if min is greater than max
            let temp = min;
            priceMinSlider.value = max;
            priceMaxSlider.value = temp;
        }

        priceMinValue.textContent = priceMinSlider.value + '$';
        priceMaxValue.textContent = priceMaxSlider.value + '$';
    }

    if (priceMinSlider && priceMaxSlider) {
        priceMinSlider.addEventListener('input', updatePriceSliders);
        priceMaxSlider.addEventListener('input', updatePriceSliders);
        updatePriceSliders(); // Initial call
    }

    // --- Other Sliders ---
    const otherSliders = {
        'monthEarningsRange': { el: document.getElementById('monthEarningsRange'), val: document.getElementById('monthEarningsValue'), template: (v) => v + '$' },
        'ageRange': { el: document.getElementById('ageRange'), val: document.getElementById('ageValue'), template: (v) => v + ' months' },
        'installsRange': { el: document.getElementById('installsRange'), val: document.getElementById('installsValue'), template: (v) => v },
    };

    for (const id in otherSliders) {
        const slider = otherSliders[id];
        if (slider.el) {
            const updateValue = () => slider.val.textContent = slider.template(slider.el.value);
            updateValue();
            slider.el.addEventListener('input', updateValue);
        }
    }
});
</script>