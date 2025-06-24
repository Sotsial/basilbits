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
];
@endphp

<x-layout>
    <section>
        <div class="go-back"><a href="#">Go back</a></div>
        <div class="app-title">
            <h1>Recording & Transcribing app</h1> <img src="img/android.png" alt="Android logo" srcset="">
        </div>
        <div class="app-description">
            <div class="app-description-header">
                <div class="app-logo-area"><img src="img/app-logo.png" alt="App logo">
                    <div class="gray-block store-link"><a href="#">View app in Google Play <img src="img/link-out.png"
                                alt="Link out icon" srcset=""></a></div>
                </div>
                <div class="app-screens">
                    <img src="img/app-screen-1.jpg" alt="App screen 1">
                    <img src="img/app-screen-2.jpg" alt="App screen 2">
                    <img src="img/app-screen-3.jpg" alt="App screen 3">
                    <img src="img/app-screen-4.jpg" alt="App screen 4">
                </div>
                <div class="app-info">
                    <div class="sidebar-stats">
                        Monetization: <strong>Ads</strong> <strong>Non-Games</strong><br>
                        Last month profit: <strong>NA</strong> Last year profit: <strong>NA</strong><br>
                        Age: <strong>less than 1 month</strong> Installs: <strong>less than 100</strong><br>
                    </div>
                    <button class="included-account">Account included <span class="question-hint">?
                            <span class="tooltip-text">This app is sold together with a full-access developer account.
                                The account may include saved progress, subscriptions, or premium features already
                                activated.</span>
                        </span></button>
                    <div class="deal-button-area">
                        <div>
                            <div class="asking-price">Asking price</div>
                            <div class="price">USD 400</div>
                        </div>
                        <div><a href="#">Make a deal</a></div>
                    </div>
                </div>
            </div>
            <div class="app-description-body">
                <div class="app-description-text">
                    <h3 class="app-headings">Description</h3>
                    <p>Transform your speech into text instantly with all-in-one SpeechHQ. Whether you're transcribing
                        messages, jotting down ideas or writing notes, this app captures your voice with high accuracy
                        and converts it into text. Save your transcriptions, recordings to easily refer to them
                        later.<br><br>
                    </p>

                    <p>Key Highlights<br>
                        - Speech to text transcriber.<br>
                        - HQ voice recorder.<br>
                        - Multi-language translator.<br>
                        - Text to voice speaker.<br>
                        - 100% automated.<br>
                        - No expenses.
                    </p>
                    <p>
                        Operations<br>
                        The app is 100% automated.<br><br>
                    </p>
                    <p>
                        Users<br>
                        The app is ready for promotions to collect more users. I didn’t promote the app because I'm not
                        a marketing expert.<br><br>
                    </p>
                    <p>
                        Financials<br>
                        The app is ready to make money from Admob ads. No expenses required for app management.
                    </p>
                    <p>Additional notes<br>
                        Send me a PM before placing a bid to discuss a payment method because Escrow has limitations in
                        my
                        country. For example, we can use PayPal or Payoneer.
                    </p>
                </div>
                <div class="sellers-info">
                    <div class="block gray-block"><strong>Sellers info</strong>
                        <div class="seller-info">
                            <div><img src="img/user-avatar.png" alt="User avatar" srcset=""></div>
                            <div>
                                <p>Alexey Rishkin</p>
                                <p>Philippines</p>
                            </div>
                        </div>
                        <div class="verif-button"><img src="img/mark.png" alt="" srcset="">Verified seller</div>
                    </div>
                    <div class="block gray-block"><strong>Payment methods</strong>
                        <ul class="payment-methods-list">
                            <li>Crypto</li>
                            <li>Escrow.com</li>
                            <li>Payoneer</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <div class="app-media">
            <h3 class="app-headings">Attached Files</h3>
            <img src="img/attach-1.jpg" alt="Attachment 1">
            <img src="img/attach-1.jpg" alt="Attachment 2">
            <img src="img/attach-1.jpg" alt="Attachment 3">
            <h3 class="app-headings">Video</h3>
            <img src="img/app-video.jpg" alt="App Video">
            <h3 class="app-headings">Financials</h3>
            <img src="img/financial.jpg" alt="Financial Details">

        </div>
        <h3 class="app-headings">Other apps</h3>
        <div class="other-apps-list">
            @if (isset($apps) && is_array($apps) && count($apps) > 0)
            @foreach ($apps as $app)
            <x-app-card :title="$app['title']" :platform="$app['platform']" :images="$app['images']"
                :description="$app['description']" :monetization="$app['monetization']" :type="$app['type']"
                :lastMonthProfit="$app['lastMonthProfit']" :lastYearProfit="$app['lastYearProfit']" :age="$app['age']"
                :installs="$app['installs']" :price="$app['price']" />
            @endforeach
            @else
            <p>No other apps available</p>
            @endif
        </div>
    </section>
</x-layout>