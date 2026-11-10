const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function whenVisible(elements, callback, threshold = 0.25) {
    if (! ('IntersectionObserver' in window)) {
        elements.forEach(callback);
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                observer.unobserve(entry.target);
                callback(entry.target);
            }
        });
    }, { threshold });

    elements.forEach((element) => observer.observe(element));
}

// ---------- 1. angka menghitung naik ----------
function countUp(element) {
    const target = Number.parseInt(element.dataset.count, 10);

    if (Number.isNaN(target) || target <= 0 || reduceMotion) {
        return; 
    }

    const duration = 900;
    const startedAt = performance.now();
    element.textContent = '0';

    const tick = (now) => {
        const progress = Math.min((now - startedAt) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);

        element.textContent = String(Math.round(target * eased));

        if (progress < 1) {
            requestAnimationFrame(tick);
        } else {
            element.textContent = String(target);
        }
    };

    requestAnimationFrame(tick);
}

// ---------- 2. muncul saat di-scroll ----------
function reveal(element) {
    element.classList.add('is-visible');
}

// ---------- 3. pesan sukses hilang sendiri ----------
function autoHideFlash(element) {
    let timer;

    const hide = () => {
        element.style.transition = 'opacity 0.4s ease, translate 0.4s ease';
        element.style.opacity = '0';
        element.style.translate = '0 -8px';
        setTimeout(() => element.remove(), 450);
    };

    const arm = () => { timer = setTimeout(hide, 5000); };

    element.addEventListener('mouseenter', () => clearTimeout(timer)); // jangan hilang saat sedang dibaca
    element.addEventListener('mouseleave', arm);
    arm();
}

// ---------- 4. tombol kirim ----------
function setupSubmitLoading() {
    document.addEventListener('submit', (event) => {
        const form = event.target;

        if (event.defaultPrevented || ! (form instanceof HTMLFormElement) || form.method.toLowerCase() === 'get') {
            return;
        }

        const button = form.querySelector('button[type="submit"], button:not([type])');

        if (! button || button.disabled || button.textContent.trim() === '') {
            return;
        }

        setTimeout(() => {
            button.setAttribute('data-loading', '');
            button.disabled = true;
        }, 0);
    });

    window.addEventListener('pageshow', (event) => {
        if (event.persisted) {
            document.querySelectorAll('button[data-loading]').forEach((button) => {
                button.removeAttribute('data-loading');
                button.disabled = false;
            });
        }
    });
}

function init() {
    const bookingForm = document.querySelector('[data-booking-calendar]');
    if (bookingForm) {
        import('./booking-calendar.js').then(({ initBookingCalendar }) => initBookingCalendar(bookingForm));
    }

    whenVisible([...document.querySelectorAll('[data-count]')], countUp);

    const revealables = [...document.querySelectorAll('[data-reveal]')];
    if (reduceMotion) {
        revealables.forEach(reveal);
    } else {
        whenVisible(revealables, reveal, 0.15);
    }

    document.querySelectorAll('[data-flash]').forEach(autoHideFlash);
    setupSubmitLoading();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
