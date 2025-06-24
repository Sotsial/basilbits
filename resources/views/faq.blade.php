<x-layout>
    <section class="hero">
        <div>
            <h1>FAQ</h1>
            <p>
                We help developers monetize their projects and enable companies and buyers to explore new profitable
                investment opportunities.
            </p>
        </div>
        <div>
            <img src="img/hero.svg" alt="" srcset="" />
        </div>
    </section>
    <section class="faqs">
        <div class="faq-item">
            <button class="faq-question">
                Mauris eleifend tellus sit amet mollis venenatis?
                <span class="faq-arrow">&#9662;</span>
            </button>
            <div class="faq-answer">
                <p>Integer quis metus imperdiet, venenatis neque id, eleifend augue. Fusce dignissim fringilla sem et
                    dapibus. Morbi ullamcorper augue eros, tempus molestie odio tristique et.</p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">
                Mauris eleifend tellus sit amet mollis venenatis?
                <span class="faq-arrow">&#9662;</span>
            </button>
            <div class="faq-answer">
                <p>Integer quis metus imperdiet, venenatis neque id, eleifend augue. Fusce dignissim fringilla sem et
                    dapibus. Morbi ullamcorper augue eros, tempus molestie odio tristique et.</p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">
                Mauris eleifend tellus sit amet mollis venenatis?
                <span class="faq-arrow">&#9662;</span>
            </button>
            <div class="faq-answer">
                <p>Integer quis metus imperdiet, venenatis neque id, eleifend augue. Fusce dignissim fringilla sem et
                    dapibus. Morbi ullamcorper augue eros, tempus molestie odio tristique et.</p>
            </div>
        </div>
    </section>
    <x-need-help></x-need-help>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const faqItems = document.querySelectorAll(".faq-item");

            faqItems.forEach((item) => {
                const question = item.querySelector(".faq-question");
                question.addEventListener("click", () => {
                    item.classList.toggle("active");
                });
            });
        });
    </script>
</x-layout>