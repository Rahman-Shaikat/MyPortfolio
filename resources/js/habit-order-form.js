export function initHabitOrderForm() {
    const form = document.querySelector('[data-habit-order-form]');
    if (!form) {
        return;
    }
    const method = form.querySelector('[data-payment-method]');
    const bankFields = form.querySelector('[data-bank-fields]');
    const updateBankFields = () => {
        const isBank = method.selectedOptions[0]?.dataset.type === 'bank';
        bankFields.hidden = !isBank;
        bankFields.querySelectorAll('input').forEach((input) => {
            input.disabled = !isBank;
            input.required = isBank && input.name === 'bank_sender_name';
        });
    };
    method.addEventListener('change', updateBankFields);
    updateBankFields();
    const submit = form.querySelector('[data-order-submit]');
    form.addEventListener('submit', () => {
        submit.disabled = true;
        submit.textContent = 'Submitting...';
    });
    window.addEventListener('pageshow', () => {
        submit.disabled = false;
        submit.textContent = 'Submit payment details';
    });
}
