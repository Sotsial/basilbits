<div id="{{ $id ?? 'popup-default' }}" class="popup-overlay {{ $class ?? '' }}" style="display: none;">
    <div class="popup-container">
        <div class="popup-header">
            <h3>{{ $title ?? 'Popup Title' }}</h3>
            <button class="popup-close" aria-label="Close popup">&times;</button>
        </div>
        <div class="popup-content">
            {{ $slot }}
        </div>
        @if(isset($footer))
        <div class="popup-footer">
            {{ $footer }}
        </div>
        @endif
    </div>
</div>