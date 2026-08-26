document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-password-toggle]').forEach((button) => {
    const input = document.querySelector(button.dataset.passwordToggle);
    const icon = button.querySelector('[data-password-toggle-icon]');

    if (!input || !icon) {
      return;
    }

    button.addEventListener('click', () => {
      const isHidden = input.getAttribute('type') === 'password';

      input.setAttribute('type', isHidden ? 'text' : 'password');
      icon.classList.toggle('ti-eye', isHidden);
      icon.classList.toggle('ti-eye-off', !isHidden);
    });
  });
});
