<section class="need-help">
    <h2>Need help?</h2>
    <p class="need-help-subtitle">
        We understand that buying or selling an app can be challenging. If you
        have any questions or need assistance, feel free to reach out to us
        anytime.
    </p>
    <div class="need-help-cards">
        <a href="/faq">
            <div class="need-help-card">
                <p><img src="img/need-help-icon-1.png" alt="" srcset="" /></p>
                <p>Visit<br />FAQ</p>
            </div>
        </a>
        <a href="/contacts">
            <div class="need-help-card">
                <p><img src="img/need-help-icon-2.png" alt="" srcset="" /></p>
                <p>Contact<br />Support</p>
            </div>
        </a>
        <a href="#" onclick="showPopup('msngrs-popup')">
            <div class="need-help-card">
                <p><img src="img/need-help-icon-3.png" alt="" srcset="" /></p>
                <p>Contact in messenger</p>
            </div>
        </a>
    </div>
</section>

<x-popup id="msngrs-popup" title="Messengers">
    <x-messengers />
    <x-slot name="footer">
    </x-slot>
</x-popup>