export function initHabitPricing() {
    const page = document.querySelector('[data-habit-pricing]');
    if (!page) {
        return;
    }

    const selector = page.querySelector('.habit-currency');
    const prices = JSON.parse(page.dataset.prices);
    const updatePrices = (currency) => {
        const price = prices[currency];
        if (!price) {
            return;
        }

        page.dataset.currency = currency;
        page.querySelectorAll('[data-habit-price]').forEach((element) => {
            element.textContent = price[element.dataset.habitPrice];
        });
    };

    selector.addEventListener('change', (event) => {
        if (event.target.matches('input[name="habit-currency"]')) {
            updatePrices(event.target.value);
        }
    });

    updatePrices(selector.querySelector('input:checked').value);
    selector.hidden = false;
}
