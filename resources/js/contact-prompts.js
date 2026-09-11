export function initContactPrompts(form) {
    const motion = matchMedia('(prefers-reduced-motion: reduce)');
    const prompts = [...form.querySelectorAll('input, select, textarea')].map((field) => ({
        field,
        option: field.matches('select') ? field.options[0] : null,
        text: field.matches('select') ? field.options[0].textContent : field.placeholder,
        settled: false,
        mirror: field.parentElement.querySelector('.name-placeholder'),
    }));
    const write = (prompt, text) => {
        if (prompt.option) prompt.option.textContent = text;
        else prompt.field.placeholder = text;
        if (prompt.mirror) prompt.mirror.dataset.text = text;
    };
    let timer;
    let started = false;
    let index = 0;
    let character = 0;
    const finish = () => {
        clearTimeout(timer);
        prompts.forEach((prompt) => { prompt.settled = true; write(prompt, prompt.text); });
    };
    const tick = () => {
        if (motion.matches) { finish(); return; }
        if (document.hidden) { timer = setTimeout(tick, 250); return; }
        const prompt = prompts[index];
        if (!prompt) return;
        if (prompt.settled || prompt.field.value || document.activeElement === prompt.field) {
            write(prompt, prompt.text);
            index++;
            character = 0;
            timer = setTimeout(tick, 120);
            return;
        }
        write(prompt, prompt.text.slice(0, ++character));
        if (character >= prompt.text.length) {
            prompt.settled = true;
            index++;
            character = 0;
            timer = setTimeout(tick, 220);
        } else timer = setTimeout(tick, 45);
    };
    prompts.forEach((prompt) => {
        const settle = () => { prompt.settled = true; write(prompt, prompt.text); };
        prompt.field.addEventListener('focus', settle);
        prompt.field.addEventListener('input', settle);
    });
    if (!motion.matches && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(([entry]) => {
            if (!entry.isIntersecting || started) return;
            started = true;
            prompts.forEach((prompt) => { if (!prompt.settled && !prompt.field.value) write(prompt, ''); });
            tick();
            observer.disconnect();
        }, { threshold: 0.15 });
        observer.observe(form);
    }
    motion.addEventListener('change', () => { if (motion.matches) finish(); });
    window.addEventListener('pagehide', finish, { once: true });
}
