const countdowns = document.querySelectorAll('[data-countdown]');

function updateCountdown(element) {
    const target = new Date(element.dataset.countdown).getTime();

    if (Number.isNaN(target)) {
        return;
    }

    const distance = Math.max(0, target - Date.now());
    const days = Math.floor(distance / 86400000);
    const hours = Math.floor((distance % 86400000) / 3600000);
    const minutes = Math.floor((distance % 3600000) / 60000);
    const seconds = Math.floor((distance % 60000) / 1000);

    for (const [unit, value] of Object.entries({ days, hours, minutes, seconds })) {
        const node = element.querySelector(`[data-countdown-unit="${unit}"]`);

        if (node) {
            node.textContent = String(value).padStart(2, '0');
        }
    }

    element.dataset.countdownComplete = distance === 0 ? 'true' : 'false';
}

countdowns.forEach((element) => {
    updateCountdown(element);
    window.setInterval(() => updateCountdown(element), 1000);
});

function updateClock() {
    const el = document.getElementById('live-clock');

    if (!el) {
        return;
    }

    const now = new Date();
    const timeString = now.toLocaleTimeString();
    const dateString = now.toLocaleDateString(undefined, {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
    });

    el.textContent = `${dateString} - ${timeString}`;
}

updateClock();
setInterval(updateClock, 1000);