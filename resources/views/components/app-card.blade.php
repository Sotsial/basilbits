<div class="gray-block app-card">
    <div class="card-title-area">
        @if (isset($platform) && is_array($platform))
            @foreach ($platform as $p)
                @if ($p == 'ios')
                    <img src="img/ios.png" alt="iOS logo" srcset="">
                @elseif($p == 'android')
                    <img src="img/android.png" alt="Android logo" srcset="">
                @endif
            @endforeach
        @endif

        <h3>{{ $title }}</h3>
    </div>
    <div class="card-images">
        @if (isset($images) && is_array($images))
            @foreach ($images as $screen)
                <img src="{{ $screen }}" alt="Android logo" srcset="">
            @endforeach
        @endif
    </div>
    <div class="card-description">{{ $description }}</div>
    <div class="card-stats">
        <p>Monetization: <strong>{{ $monetization }}</strong> <strong>{{ $type }}</strong></p>
        <p>Last month profit: <strong>{{ $lastMonthProfit }}</strong> Last year profit:
            <strong>{{ $lastYearProfit }}</strong>
        </p>
        <p>Age: <strong>{{ $age }}</strong> Installs: <strong>{{ $installs }}</strong></p>
    </div>
    <div class="deal-button-area">
        <div>
            <div class="asking-price">Asking price</div>
            <div class="price">USD {{ $price }}$</div>
        </div>
        <div><a href="#">Make a deal</a></div>
    </div>
</div>
