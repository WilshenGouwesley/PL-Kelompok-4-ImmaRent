const TITLE = new Intl.DateTimeFormat('en-US', { month: 'long', year: 'numeric', timeZone: 'UTC' });
const LONG_DATE = new Intl.DateTimeFormat('en-GB', {
    weekday: 'long', day: 'numeric', month: 'long', year: 'numeric', timeZone: 'UTC',
});

const MAX_MONTHS_AHEAD = 12;

const pad = (number) => String(number).padStart(2, '0');
const isoDate = (year, month, day) => `${year}-${pad(month + 1)}-${pad(day)}`; // month: 0-11
const toMinutes = (hhmm) => { const [h, m] = hhmm.split(':').map(Number); return h * 60 + m; };
const utcDate = (iso) => { const [y, m, d] = iso.split('-').map(Number); return new Date(Date.UTC(y, m - 1, d)); };

export function initBookingCalendar(form) {
    const doc = form.ownerDocument;
    const find = (selector) => form.querySelector(selector);

    const grid = find('[data-cal-grid]');
    const title = find('[data-cal-title]');
    const prev = find('[data-cal-prev]');
    const next = find('[data-cal-next]');
    const input = find('[data-cal-input]');
    const display = find('[data-cal-display]');
    const error = find('[data-cal-error]');
    const note = find('[data-busy-note]');
    const start = find('#start_time');
    const end = find('#end_time');

    if (! grid || ! input || ! start || ! end) {
        return;
    }

    const busy = JSON.parse(form.dataset.busy || '{}');
    const today = form.dataset.today;
    const nowMinutes = toMinutes(form.dataset.now || '00:00');
    const [todayYear, todayMonth] = today.split('-').map(Number);

    const state = { year: todayYear, month: todayMonth - 1, selected: null };
    const monthsFromToday = () => (state.year - todayYear) * 12 + (state.month - (todayMonth - 1));

    // ---------- kalender ----------
    function dayButton(day) {
        const date = isoDate(state.year, state.month, day);
        const isPast = date < today;
        const isSelected = date === state.selected;
        const hasBusy = (busy[date] || []).length > 0;

        const button = doc.createElement('button');
        button.type = 'button';
        button.dataset.date = date;
        button.textContent = String(day);
        button.setAttribute('aria-label', LONG_DATE.format(utcDate(date)));
        button.setAttribute('aria-pressed', String(isSelected));

        const classes = ['relative mx-auto flex h-[46px] w-[46px] items-center justify-center rounded-full text-[16px] font-semibold transition duration-200'];
        if (isPast) {
            classes.push('cursor-not-allowed text-white/25');
            button.disabled = true;
        } else if (isSelected) {
            classes.push('animate-pop-in bg-[#639178] text-white');
        } else {
            classes.push('text-white hover:bg-white/10');
        }
        if (date === today && ! isSelected) {
            classes.push('ring-1 ring-[#639178]');
        }
        button.className = classes.join(' ');

        if (hasBusy && ! isPast) {
            const dot = doc.createElement('span');
            dot.className = 'absolute bottom-[5px] h-[4px] w-[4px] rounded-full bg-amber-300';
            dot.setAttribute('aria-hidden', 'true');
            button.append(dot);
            button.title = 'Some hours are already booked';
        }

        button.addEventListener('click', () => select(date));

        return button;
    }

    function render({ animate = false } = {}) {
        title.textContent = TITLE.format(new Date(Date.UTC(state.year, state.month, 1)));

        const leading = new Date(Date.UTC(state.year, state.month, 1)).getUTCDay(); // 0 = Minggu
        const totalDays = new Date(Date.UTC(state.year, state.month + 1, 0)).getUTCDate();

        const cells = [];
        for (let i = 0; i < leading; i++) {
            cells.push(doc.createElement('span'));
        }
        for (let day = 1; day <= totalDays; day++) {
            cells.push(dayButton(day));
        }
        grid.replaceChildren(...cells);

        prev.disabled = monthsFromToday() <= 0;
        next.disabled = monthsFromToday() >= MAX_MONTHS_AHEAD;

        if (animate) {
            grid.classList.remove('animate-fade-in');
            void grid.offsetWidth; 
            grid.classList.add('animate-fade-in');
        }
    }

    function shiftMonth(delta) {
        const offset = monthsFromToday() + delta;
        if (offset < 0 || offset > MAX_MONTHS_AHEAD) {
            return;
        }

        const target = new Date(Date.UTC(state.year, state.month + delta, 1));
        state.year = target.getUTCFullYear();
        state.month = target.getUTCMonth();
        render({ animate: true });
    }

    function select(date) {
        if (date < today) {
            return; 
        }

        state.selected = date;
        input.value = date;
        if (display) {
            display.value = LONG_DATE.format(utcDate(date));
        }
        if (error) {
            error.textContent = '';
        }
        render();
        refreshTimes();
    }

    // ---------- pilihan jam ----------
    function setBlocked(option, blocked, suffix = '') {
        option.disabled = blocked;
        option.textContent = option.dataset.label + (blocked ? suffix : '');
    }

    function refreshTimes() {
        const date = state.selected;
        const ranges = (busy[date] || []).map(([from, to]) => [toMinutes(from), toMinutes(to)]);

        start.disabled = ! date;
        end.disabled = ! date || ! start.value;

        let availableStarts = 0;
        for (const option of start.options) {
            if (! option.value) continue;
            option.dataset.label ??= option.textContent;

            const minute = toMinutes(option.value);
            const inBusy = ranges.some(([from, to]) => minute >= from && minute < to);
            const passed = date === today && minute <= nowMinutes;

            setBlocked(option, inBusy || passed, inBusy ? ' · booked' : '');
            if (! option.disabled) availableStarts++;
        }
        if (start.value && start.selectedOptions[0]?.disabled) {
            start.value = '';
        }
        end.disabled = ! date || ! start.value;

        const from = start.value ? toMinutes(start.value) : null;
        for (const option of end.options) {
            if (! option.value) continue;
            option.dataset.label ??= option.textContent;

            const minute = toMinutes(option.value);
            const crosses = from !== null && ranges.some(([busyFrom, busyTo]) => busyFrom < minute && busyTo > from);

            setBlocked(option, from === null || minute <= from || crosses, crosses ? ' · booked' : '');
        }
        if (end.value && end.selectedOptions[0]?.disabled) {
            end.value = '';
        }

        updateNote(ranges, availableStarts);
    }

    function updateNote(ranges, availableStarts) {
        if (! note) return;

        if (! state.selected) {
            note.textContent = 'Pick a day to see which hours are available.';
            return;
        }

        let text = ranges.length
            ? 'Already booked: ' + ranges.map(([a, b]) => `${pad(Math.floor(a / 60))}:${pad(a % 60)} – ${pad(Math.floor(b / 60))}:${pad(b % 60)}`).join(', ')
            : 'No bookings yet on this day. All hours are open.';

        if (availableStarts === 0) {
            text += ' No start times are left on this day.';
        }
        note.textContent = text;
    }

    // ---------- event ----------
    prev.addEventListener('click', () => shiftMonth(-1));
    next.addEventListener('click', () => shiftMonth(1));
    start.addEventListener('change', refreshTimes);

    form.addEventListener('submit', (event) => {
        const missing = [];
        if (! input.value) missing.push('a day');
        if (! start.value) missing.push('a start time');
        if (! end.value) missing.push('an end time');

        if (missing.length > 0) {
            event.preventDefault();
            error.textContent = 'Please choose ' + missing.join(', ') + '.';
        }
    });

    const initial = form.dataset.initialDate || input.value;
    let restorable = false;

    if (/^\d{4}-\d{2}-\d{2}$/.test(initial) && initial >= today) {
        const [year, month] = initial.split('-').map(Number);
        const offset = (year - todayYear) * 12 + (month - todayMonth);

        if (offset >= 0 && offset <= MAX_MONTHS_AHEAD) {
            restorable = true;
            state.year = year;
            state.month = month - 1;
        }
    }

    render();
    refreshTimes();

    if (restorable) {
        select(initial);
    }
}
