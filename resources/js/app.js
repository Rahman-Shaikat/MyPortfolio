import { initContactPrompts } from './contact-prompts';
import { initHabitPricing } from './habit-pricing';

initHabitPricing();

document.documentElement.classList.add('js');

const whenNearViewport = (element, callback, rootMargin = '320px 0px') => {
    if (!element || !('IntersectionObserver' in window)) {
        callback();

        return;
    }

    const observer = new IntersectionObserver(([entry]) => {
        if (!entry.isIntersecting) {
            return;
        }

        observer.disconnect();
        callback();
    }, { rootMargin });

    observer.observe(element);
};

const experienceTree = document.querySelector('[data-experience-tree]');
if (experienceTree) {
    whenNearViewport(experienceTree, () => {
        import('./experience-tree').then(({ initExperienceTree }) => {
            initExperienceTree(experienceTree);
        }).catch(() => {});
    });
}

const header = document.querySelector('[data-header]');
const suedeButton = header?.querySelector('.nav-link-cta');
if (suedeButton) {
    const initializeSuedeButton = () => {
        suedeButton.removeEventListener('pointerenter', initializeSuedeButton);
        suedeButton.removeEventListener('focus', initializeSuedeButton);
        import('./fabric-button').then(({ initFabricButton }) => {
            initFabricButton(suedeButton);
        }).catch(() => {});
    };

    suedeButton.addEventListener('pointerenter', initializeSuedeButton, { once: true });
    suedeButton.addEventListener('focus', initializeSuedeButton, { once: true });
}
const menu = document.querySelector('[data-menu]');
const menuToggle = document.querySelector('[data-menu-toggle]');
const navLinks = Array.from(document.querySelectorAll('.nav-link'));
const sections = Array.from(document.querySelectorAll('main section[id]'));
const revealItems = Array.from(document.querySelectorAll('.reveal'));
const heroRevealItems = Array.from(document.querySelectorAll('.hero .reveal'));
const backToTop = document.querySelector('[data-back-to-top]');
const contactForm = document.querySelector('[data-contact-form]');
if (contactForm) initContactPrompts(contactForm);
const formNote = document.querySelector('[data-form-note]');
const researchVideo = document.querySelector('[data-research-video]');
const wowItems = document.querySelectorAll('.wow');
const skillCloud = document.querySelector('.skill-cloud');

if (skillCloud) {
    let skillsVisible = false;
    const updateSkillsMotion = () => {
        skillCloud.classList.toggle('is-floating', skillsVisible && !document.hidden);
    };
    if ('IntersectionObserver' in window) {
        const skillsObserver = new IntersectionObserver(([entry]) => {
            skillsVisible = entry.isIntersecting;
            updateSkillsMotion();
        });
        skillsObserver.observe(skillCloud);
    } else {
        skillsVisible = true;
        updateSkillsMotion();
    }
    document.addEventListener('visibilitychange', updateSkillsMotion);
}

if (wowItems.length && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    whenNearViewport(wowItems[0], () => {
        Promise.all([
            import('wowjs'),
            import('wowjs/css/libs/animate.css'),
        ]).then(([wowModule]) => {
            const Wow = wowModule.WOW ?? wowModule.default?.WOW;

            if (Wow) {
                new Wow({
                    boxClass: 'wow',
                    animateClass: 'animated',
                    offset: 48,
                    mobile: true,
                    live: false,
                }).init();
            }
        }).catch(() => {});
    });
}

const closeMenu = () => {
    if (!menu || !menuToggle) {
        return;
    }

    menu.classList.remove('is-open');
    document.body.classList.remove('menu-open');
    menuToggle.setAttribute('aria-expanded', 'false');
};

const setHeaderState = () => {
    header?.classList.toggle('is-scrolled', window.scrollY > 18);
};

const setBackToTopState = () => {
    backToTop?.classList.toggle('is-visible', window.scrollY > 520);
};

const setActiveLink = () => {
    const currentSection = sections
        .filter((section) => section.getBoundingClientRect().top <= 140)
        .at(-1);

    if (!currentSection) {
        return;
    }

    const activeHash = `#${currentSection.id}`;
    const hasMatchingLink = navLinks.some((link) => link.hash === activeHash);

    if (!hasMatchingLink) {
        return;
    }

    navLinks.forEach((link) => {
        link.classList.toggle('is-active', link.hash === activeHash);
    });
};

menuToggle?.addEventListener('click', () => {
    const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';

    menu?.classList.toggle('is-open', !isExpanded);
    document.body.classList.toggle('menu-open', !isExpanded);
    menuToggle.setAttribute('aria-expanded', String(!isExpanded));
});

navLinks.forEach((link) => {
    link.addEventListener('click', closeMenu);
});

window.addEventListener('scroll', () => {
    setHeaderState();
    setBackToTopState();
    setActiveLink();
}, { passive: true });

if ('IntersectionObserver' in window) {
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            entry.target.classList.add('is-visible');
            revealObserver.unobserve(entry.target);
        });
    }, { rootMargin: '0px 0px -12% 0px', threshold: 0.12 });

    revealItems.forEach((item) => {
        if (heroRevealItems.includes(item)) {
            item.classList.add('is-visible');

            return;
        }

        revealObserver.observe(item);
    });
} else {
    revealItems.forEach((item) => item.classList.add('is-visible'));
}

backToTop?.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

contactForm?.addEventListener('submit', () => {
    if (formNote) {
        formNote.textContent = 'Sending your inquiry...';
    }
});

if (researchVideo) {
    researchVideo.muted = true;
    let isVideoVisible = false;
    let isVideoLoaded = false;

    const loadResearchVideo = () => {
        if (isVideoLoaded) {
            return;
        }

        isVideoLoaded = true;
        researchVideo.src = researchVideo.dataset.src;
        researchVideo.load();

        import('./research-video').then(({ initResearchVideo }) => {
            initResearchVideo(researchVideo);
        }).catch(() => {});
    };

    const updateVideoPlayback = () => {
        if (isVideoVisible && !document.hidden) {
            researchVideo.play().catch(() => {});
        } else {
            researchVideo.pause();
        }
    };

    if ('IntersectionObserver' in window) {
        const videoObserver = new IntersectionObserver(([entry]) => {
            isVideoVisible = entry.isIntersecting;
            if (isVideoVisible) {
                loadResearchVideo();
            }
            updateVideoPlayback();
        }, { rootMargin: '240px 0px', threshold: 0.01 });

        videoObserver.observe(researchVideo);
    } else {
        isVideoVisible = true;
        loadResearchVideo();
        updateVideoPlayback();
    }

    document.addEventListener('visibilitychange', updateVideoPlayback);
}

setHeaderState();
setBackToTopState();
setActiveLink();
