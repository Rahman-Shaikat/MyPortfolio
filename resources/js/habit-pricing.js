const prices = {
    USD: { offer: '$5', regular: '$15', regularFull: '$15.00', decimals: '.00', discount: '67% OFF', currency: 'USD' },
    BDT: { offer: '\u09f3500', regular: '\u09f31,800', regularFull: '\u09f31,800', decimals: '', discount: '72% OFF', currency: 'BDT' },
};

export function initHabitPricing() {
    const page = document.querySelector('[data-habit-pricing]');
    if (!page) {
        return;
    }

    const selector = page.querySelector('.habit-currency');
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
