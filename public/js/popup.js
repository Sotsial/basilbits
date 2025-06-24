document.addEventListener('DOMContentLoaded', function () {
    // Показать попап по ID
    window.showPopup = function (popupId) {
        const popup = document.getElementById(popupId);
        if (popup) {
            popup.style.display = 'flex';
            setTimeout(() => {
                popup.classList.add('active');
            }, 10);
            document.body.style.overflow = 'hidden'; // Отключаем прокрутку страницы
        }
    };

    // Скрыть попап
    window.hidePopup = function (popupId) {
        const popup = document.getElementById(popupId);
        if (popup) {
            popup.classList.remove('active');
            setTimeout(() => {
                popup.style.display = 'none';
            }, 300);
            document.body.style.overflow = ''; // Включаем прокрутку страницы
        }
    };

    // Закрыть попап при клике на крестик
    const closeButtons = document.querySelectorAll('.popup-close');
    closeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const popup = this.closest('.popup-overlay');
            const popupId = popup.id;
            hidePopup(popupId);
        });
    });

    // Закрыть попап при клике на overlay (вне окна попапа)
    const popups = document.querySelectorAll('.popup-overlay');
    popups.forEach(popup => {
        popup.addEventListener('click', function (e) {
            if (e.target === this) {
                hidePopup(this.id);
            }
        });
    });

    // Закрыть попап при нажатии ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const activePopup = document.querySelector('.popup-overlay.active');
            if (activePopup) {
                hidePopup(activePopup.id);
            }
        }
    });
});