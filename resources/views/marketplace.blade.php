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
                    @if (isset($games) && $games->count() > 0)
                        @foreach ($games as $game)
                            @php
                                // Подготовка данных для компонента
                                $platform = [$game->platform];
                                
                                // Создаем URL только для главного изображения (title_image)
                                // и передаем его в виде массива из одного элемента.
                                $titleImageUrl = $game->title_image ? Illuminate\Support\Facades\Storage::url($game->title_image) : ''; // Можно добавить URL заглушки по умолчанию
                                $images = [$titleImageUrl];

                                $monetization = implode(', ', json_decode($game->monetization, true) ?? []);
                            @endphp
                            <x-app-card 
                                :title="$game->title"
                                :platform="$platform"
                                :images="$images"  {{-- Теперь здесь только обложка --}}
                                :description="$game->description"
                                :monetization="$monetization"
                                :type="'Game'"
                                :lastMonthProfit="$game->earnings"
                                :lastYearProfit="'N/A'"
                                :age="$game->age"
                                :installs="$game->installs"
                                :price="(float)$game->price"
                             />
                        @endforeach
                    @else
                        <p>No games available for sale.</p>
                    @endif
                </div>
                 <div class="pagination-links" style="margin-top: 20px;">
               {{ $games->links() }}
                </div>
            </div>
        </div>
    </section>
</x-layout>