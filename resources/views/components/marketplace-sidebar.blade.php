<form id="filter-form" action="{{ route('marketplace') }}" method="GET">
    <h3 class="underline">Filters:</h3>

    <div class="filter-group">
        <input type="text" name="keyword" placeholder="Enter keyword" class="search-input" value="{{ request('keyword') }}">
    </div>

    <div class="filter-group">
        <h4>Price</h4>
        <div class="range-slider-wrapper">
            <div class="slider-track"></div>
            <div class="slider-range-fill" id="price-range-fill"></div>
            <input type="range" name="price_min" id="priceMinRange" min="0" max="10000" value="{{ request('price_min', 0) }}" class="thumb thumb-left">
            <input type="range" name="price_max" id="priceMaxRange" min="0" max="10000" value="{{ request('price_max', 10000) }}" class="thumb thumb-right">
        </div>
        <div class="range-values">
            <span id="priceMinValue">${{ request('price_min', 0) }}</span>
            <span id="priceMaxValue">${{ request('price_max', 10000) }}</span>
        </div>
        <div class="checkbox-option" style="margin-top: 15px;">
            <input type="checkbox" name="hide_no_price" id="hideNoPrice" value="1" {{ request('hide_no_price') ? 'checked' : '' }}>
            <label for="hideNoPrice">Hide listings without price</label>
        </div>
    </div>

    <div class="filter-group">
        <h4>Last month earnings</h4>
        <div class="range-slider-wrapper">
            <div class="slider-track"></div>
            <div class="slider-range-fill" id="earnings-range-fill"></div>
            <input type="range" name="earnings_min" id="earningsMinRange" min="0" max="5000" value="{{ request('earnings_min', 0) }}" class="thumb thumb-left">
            <input type="range" name="earnings_max" id="earningsMaxRange" min="0" max="5000" value="{{ request('earnings_max', 5000) }}" class="thumb thumb-right">
        </div>
        <div class="range-values">
            <span id="earningsMinValue">${{ request('earnings_min', 0) }}</span>
            <span id="earningsMaxValue">${{ request('earnings_max', 5000) }}</span>
        </div>
    </div>

    <div class="filter-group">
        <h4>Age (months)</h4>
        <div class="range-slider-wrapper">
            <div class="slider-track"></div>
            <div class="slider-range-fill" id="age-range-fill"></div>
            <input type="range" name="age_min" id="ageMinRange" min="0" max="120" value="{{ request('age_min', 0) }}" class="thumb thumb-left">
            <input type="range" name="age_max" id="ageMaxRange" min="0" max="120" value="{{ request('age_max', 120) }}" class="thumb thumb-right">
        </div>
        <div class="range-values">
            <span id="ageMinValue">{{ request('age_min', 0) }} months</span>
            <span id="ageMaxValue">{{ request('age_max', 120) }} months</span>
        </div>
    </div>

    <div class="filter-group">
        <h4>Installs</h4>
        <div class="range-slider-wrapper">
            <div class="slider-track"></div>
            <div class="slider-range-fill" id="installs-range-fill"></div>
            <input type="range" name="installs_min" id="installsMinRange" min="0" max="1000000" step="100" value="{{ request('installs_min', 0) }}" class="thumb thumb-left">
            <input type="range" name="installs_max" id="installsMaxRange" min="0" max="1000000" step="100" value="{{ request('installs_max', 1000000) }}" class="thumb thumb-right">
        </div>
        <div class="range-values">
            <span id="installsMinValue">{{ number_format(request('installs_min', 0)) }}</span>
            <span id="installsMaxValue">{{ number_format(request('installs_max', 1000000)) }}+</span>
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
        <h4>Monetization</h4>
        @foreach(['ads' => 'Ads', 'in-app' => 'In-App', 'paid_app' => 'Paid App', 'cpa' => 'CPA', 'other' => 'Other'] as $value => $label)
        <div class="checkbox-option">
            <input type="checkbox" name="monetization[]" value="{{ $value }}" id="{{ $value }}" {{ in_array($value, request('monetization', [])) ? 'checked' : '' }}>
            <label for="{{ $value }}">{{ $label }}</label>
        </div>
        @endforeach
    </div>  

    <button type="button" id="reset-filters" class="button dark-green" style="width: 100%; margin-top: 10px; background-color: #6c757d;">Reset Filters</button>
</form>

<style>
    .range-slider-wrapper {
        position: relative;
        height: 20px;
        margin-bottom: 10px;
    }
    .slider-track, .slider-range-fill {
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        height: 4px;
        border-radius: 2px;
    }
    .slider-track {
        background-color: #ddd;
        z-index: 1;
    }
    .slider-range-fill {
        background-color: #00996f;
        z-index: 2;
    }
    .thumb {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        width: 100%;
        height: 20px;
        background: transparent;
        position: absolute;
        top: 0;
        left: 0;
        margin: 0;
        pointer-events: none;
    }
    .thumb-left { z-index: 3; }
    .thumb-right { z-index: 4; }

    .thumb::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #00996f;
        cursor: pointer;
        pointer-events: all;
        position: relative;
    }
    .thumb::-moz-range-thumb {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #00996f;
        cursor: pointer;
        pointer-events: all;
        border: none;
    }
    .range-values {
        display: flex;
        justify-content: space-between;
        color: #555;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('filter-form');
    const allFilters = filterForm.querySelectorAll('input');
    const resetBtn = document.getElementById('reset-filters');
    
    let submissionTimer;
    const submissionDelay = 1000; // 1000ms = 1 секунда задержки для фильтрации

    function scheduleSubmission() {
        clearTimeout(submissionTimer);
        
        submissionTimer = setTimeout(() => {
            filterForm.submit();
        }, submissionDelay);
    }


    allFilters.forEach(filter => {
        if (filter.type === 'checkbox') {
            filter.addEventListener('change', scheduleSubmission);
        } else {
            filter.addEventListener('input', scheduleSubmission);
        }
    });
    
    resetBtn.addEventListener('click', function() {
        window.location.href = "{{ route('marketplace') }}";
    });


    function createDualRangeSlider(config) {
        const minRange = document.getElementById(config.minRangeId);
        const maxRange = document.getElementById(config.maxRangeId);
        const minValDisplay = document.getElementById(config.minValDisplayId);
        const maxValDisplay = document.getElementById(config.maxValDisplayId);
        const rangeFill = document.getElementById(config.rangeFillId);

        if (!minRange || !maxRange || !minValDisplay || !maxValDisplay || !rangeFill) {
            return;
        }

        const minVal = parseInt(minRange.min);
        const maxVal = parseInt(minRange.max);
        const range = maxVal - minVal;
        const minGap = config.minGap || 0;

        function updateSliderFill() {
            const min = parseInt(minRange.value);
            const max = parseInt(maxRange.value);
            const minPercent = ((min - minVal) / range) * 100;
            const maxPercent = ((max - minVal) / range) * 100;
            rangeFill.style.left = `${minPercent}%`;
            rangeFill.style.width = `${maxPercent - minPercent}%`;
        }

        function syncMinRange() {
            let minValue = parseInt(minRange.value);
            let maxValue = parseInt(maxRange.value);
            if (minValue > maxValue - minGap) {
                minRange.value = maxValue - minGap;
                minValue = maxValue - minGap;
            }
            minValDisplay.textContent = config.formatValue(minValue, 'min');
            updateSliderFill();
        }

        function syncMaxRange() {
            let minValue = parseInt(minRange.value);
            let maxValue = parseInt(maxRange.value);
            if (maxValue < minValue + minGap) {
                maxRange.value = minValue + minGap;
                maxValue = minValue + minGap;
            }
            maxValDisplay.textContent = config.formatValue(maxValue, 'max');
            updateSliderFill();
        }
        
        minRange.addEventListener('input', syncMinRange);
        maxRange.addEventListener('input', syncMaxRange);

        updateSliderFill();
    }
    
    createDualRangeSlider({
        minRangeId: 'priceMinRange',
        maxRangeId: 'priceMaxRange',
        minValDisplayId: 'priceMinValue',
        maxValDisplayId: 'priceMaxValue',
        rangeFillId: 'price-range-fill',
        minGap: 100,
        formatValue: (value) => `$${value}`
    });

    createDualRangeSlider({
        minRangeId: 'earningsMinRange',
        maxRangeId: 'earningsMaxRange',
        minValDisplayId: 'earningsMinValue',
        maxValDisplayId: 'earningsMaxValue',
        rangeFillId: 'earnings-range-fill',
        minGap: 50,
        formatValue: (value) => `$${value}`
    });
    
    createDualRangeSlider({
        minRangeId: 'ageMinRange',
        maxRangeId: 'ageMaxRange',
        minValDisplayId: 'ageMinValue',
        maxValDisplayId: 'ageMaxValue',
        rangeFillId: 'age-range-fill',
        minGap: 1,
        formatValue: (value) => `${value} months`
    });

    createDualRangeSlider({
        minRangeId: 'installsMinRange',
        maxRangeId: 'installsMaxRange',
        minValDisplayId: 'installsMinValue',
        maxValDisplayId: 'installsMaxValue',
        rangeFillId: 'installs-range-fill',
        minGap: 1000,
        formatValue: (value, type) => {
            const formatted = new Intl.NumberFormat().format(value);
            return type === 'max' ? `${formatted}+` : formatted;
        }
    });
});
</script>