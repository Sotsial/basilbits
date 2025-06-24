@php
    $apps = [
        [
            'title' => 'Pixel Quest',
            'platform' => ['ios'],
            'images' => [
                'img/app-screen-1.jpg',
                'img/app-screen-2.jpg',
                'img/app-screen-3.jpg',
                'img/app-screen-4.jpg',
            ],
            'description' =>
                'All-in-one app for Speech Notes, Recorder, Speaker and Translator. 100% automated. Great investments opportunity!',
            'monetization' => 'In-App',
            'type' => 'game',
            'lastMonthProfit' => '1k-5k',
            'lastYearProfit' => '10k+',
            'age' => '1-3 years',
            'installs' => '100k-1M',
            'price' => 4.99,
        ],
        [
            'title' => 'TaskMaster Pro',
            'platform' => ['android'],
            'images' => [
                'img/app-screen-1.jpg',
                'img/app-screen-2.jpg',
                'img/app-screen-3.jpg',
                'img/app-screen-4.jpg',
            ],
            'description' =>
                'All-in-one app for Speech Notes, Recorder, Speaker and Translator. 100% automated. Great investments opportunity!',
            'monetization' => 'Paid App',
            'type' => 'non-game',
            'lastMonthProfit' => '100-1000',
            'lastYearProfit' => '5k-10k',
            'age' => '6-12 month',
            'installs' => '10k-100k',
            'price' => 9.99,
        ],
        [
            'title' => 'Fitness Tracker+',
            'platform' => ['ios'],
            'images' => [
                'img/app-screen-1.jpg',
                'img/app-screen-2.jpg',
                'img/app-screen-3.jpg',
                'img/app-screen-4.jpg',
            ],
            'description' =>
                'All-in-one app for Speech Notes, Recorder, Speaker and Translator. 100% automated. Great investments opportunity!',
            'monetization' => 'Ads',
            'type' => 'non-game',
            'lastMonthProfit' => 'Less than 100$',
            'lastYearProfit' => '1k-5k',
            'age' => 'Less than 1 month',
            'installs' => '1-10k',
            'price' => 0.0,
        ],
        [
            'title' => 'Travel Planner',
            'platform' => ['android', 'ios'],
            'images' => [
                'img/app-screen-1.jpg',
                'img/app-screen-2.jpg',
                'img/app-screen-3.jpg',
                'img/app-screen-4.jpg',
            ],
            'description' =>
                'All-in-one app for Speech Notes, Recorder, Speaker and Translator. 100% automated. Great investments opportunity!',
            'monetization' => 'Subscription',
            'type' => 'non-game',
            'lastMonthProfit' => '500-1000',
            'lastYearProfit' => '2k-5k',
            'age' => '3-6 month',
            'installs' => '10k-50k',
            'price' => 19.99,
        ],
        [
            'title' => 'Photo Editor Pro',
            'platform' => ['ios'],
            'images' => [
                'img/app-screen-1.jpg',
                'img/app-screen-2.jpg',
                'img/app-screen-3.jpg',
                'img/app-screen-4.jpg',
            ],
            'description' =>
                'All-in-one app for Speech Notes, Recorder, Speaker and Translator. 100% automated. Great investments opportunity!',
            'monetization' => 'In-App',
            'type' => 'non-game',
            'lastMonthProfit' => '1k-5k',
            'lastYearProfit' => '10k+',
            'age' => '1-3 years',
            'installs' => '100k-1M',
            'price' => 4.99,
        ],
        [
            'title' => 'Language Translator',
            'platform' => ['android'],
            'images' => [
                'img/app-screen-1.jpg',
                'img/app-screen-2.jpg',
                'img/app-screen-3.jpg',
                'img/app-screen-4.jpg',
            ],
            'description' =>
                'All-in-one app for Speech Notes, Recorder, Speaker and Translator. 100% automated. Great investments opportunity!',
            'monetization' => 'Ads',
            'type' => 'non-game',
            'lastMonthProfit' => 'Less than 100$',
            'lastYearProfit' => '1k-5k',
            'age' => 'Less than 1 month',
            'installs' => '1-10k',
            'price' => 0.0,
        ],
        [
            'title' => 'Weather Forecast',
            'platform' => ['ios'],
            'images' => [
                'img/app-screen-1.jpg',
                'img/app-screen-2.jpg',
                'img/app-screen-3.jpg',
                'img/app-screen-4.jpg',
            ],
            'description' =>
                'All-in-one app for Speech Notes, Recorder, Speaker and Translator. 100% automated. Great investments opportunity!',
            'monetization' => 'Subscription',
            'type' => 'non-game',
            'lastMonthProfit' => '500-1000',
            'lastYearProfit' => '2k-5k',
            'age' => '3-6 month',
            'installs' => '10k-50k',
            'price' => 19.99,
        ],
        [
            'title' => 'Recipe Finder',
            'platform' => ['android', 'ios'],
            'images' => [
                'img/app-screen-1.jpg',
                'img/app-screen-2.jpg',
                'img/app-screen-3.jpg',
                'img/app-screen-4.jpg',
            ],
            'description' =>
                'All-in-one app for Speech Notes, Recorder, Speaker and Translator. 100% automated. Great investments opportunity!',
            'monetization' => 'In-App',
            'type' => 'non-game',
            'lastMonthProfit' => '1k-5k',
            'lastYearProfit' => '10k+',
            'age' => '1-3 years',
            'installs' => '100k-1M',
            'price' => 4.99,
        ],
    ];
@endphp

<x-layout>
    <section>
        <div class="marketplace-description">You can find available apps here:</div>
        <div class="archive-page">
            <div class="marketplace-sidebar">
                <x-marketplace-sidebar />
            </div>
            <div class="marketplace-content">
                <div class="sort-area">
                    <h3 class="underline">Sort by:</h3>
                </div>
                <div class="marketplace-grid">
                    @if (isset($apps) && is_array($apps) && count($apps) > 0)
                        @foreach ($apps as $app)
                            <x-app-card :title="$app['title']" :platform="$app['platform']" :images="$app['images']" :description="$app['description']"
                                :monetization="$app['monetization']" :type="$app['type']" :lastMonthProfit="$app['lastMonthProfit']" :lastYearProfit="$app['lastYearProfit']"
                                :age="$app['age']" :installs="$app['installs']" :price="$app['price']" />
                        @endforeach
                    @else
                        <p>No other apps available</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-layout>
