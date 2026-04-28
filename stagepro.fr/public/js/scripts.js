console.log("JS chargé");
/* --- script.js : Gestion de l'interactivité --- */

document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Gestion du message de bienvenue dynamique
    // On simule une récupération de nom (à remplacer par une valeur PHP plus tard)
    const welcomeElement = document.querySelector('.hero h1');
    const userFirstName = "Étudiant"; // Cette valeur viendrait de votre session PHP

    if (welcomeElement && localStorage.getItem('isLoggedIn')) {
        welcomeElement.textContent = `Bonjour ${userFirstName}, prêt pour une nouvelle recherche ?`;
    }

    // 2. Gestion du vrai menu burger
    const burgerButton = document.querySelector('.burger-button');
    const siteNav = document.querySelector('.site-nav');

    if (burgerButton && siteNav) {
        const closeMenu = () => {
            burgerButton.classList.remove('is-active');
            burgerButton.setAttribute('aria-expanded', 'false');
            burgerButton.setAttribute('aria-label', 'Ouvrir le menu');
            siteNav.classList.remove('is-open');
            document.body.classList.remove('menu-open');
        };

        const openMenu = () => {
            burgerButton.classList.add('is-active');
            burgerButton.setAttribute('aria-expanded', 'true');
            burgerButton.setAttribute('aria-label', 'Fermer le menu');
            siteNav.classList.add('is-open');
            document.body.classList.add('menu-open');
        };

        burgerButton.addEventListener('click', () => {
            if (siteNav.classList.contains('is-open')) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        siteNav.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 992) {
                    closeMenu();
                }
            });
        });

        document.addEventListener('click', (event) => {
            if (!siteNav.contains(event.target) && !burgerButton.contains(event.target)) {
                closeMenu();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeMenu();
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 992) {
                closeMenu();
            }
        });
    }

   // Validation simple des formulaires
const forms = document.querySelectorAll('form');

forms.forEach(form => {
    form.addEventListener('submit', (e) => {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (field.value.trim() === '') {
                isValid = false;
                field.style.borderColor = '#ef4444';
            } else {
                field.style.borderColor = '';
            }
        });

        const emailFields = form.querySelectorAll('input[type="email"]');
        emailFields.forEach(field => {
            if (field.value.trim() !== '' && !field.value.includes('@')) {
                isValid = false;
                field.style.borderColor = '#ef4444';
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert("Veuillez remplir correctement les champs obligatoires.");
        }
    });
});

    const header = document.querySelector('.site-header');

    function updateHeaderHeight() {
        if (header) {
            document.documentElement.style.setProperty('--header-height', `${header.offsetHeight}px`);
        }
    }

    updateHeaderHeight();
    window.addEventListener('resize', updateHeaderHeight);
    
    if (header && window.scrollY === 0) {
    header.classList.remove('scrolled');
}

    if (header) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 0) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }

const testimonialCards = document.querySelectorAll('.testimonial-card');
const progressBar = document.querySelector('.testimonial-progress-bar');

if (testimonialCards.length > 0 && progressBar) {
    let currentIndex = 0;
    const duration = 10000;

    let timeoutId = null;
    let startTime = null;
    let remainingTime = duration;
    let isPaused = false;

    const pauseBtn = document.getElementById('pause-carousel');

    function showTestimonial(index) {
        testimonialCards.forEach((card, i) => {
            card.classList.toggle('active', i === index);
        });
    }

    function startProgress(time) {
        progressBar.style.transition = 'none';

        requestAnimationFrame(() => {
            progressBar.style.transition = `width ${time}ms linear`;
            progressBar.style.width = '100%';
        });
    }

    function resetProgress() {
        progressBar.style.transition = 'none';
        progressBar.style.width = '0%';
    }

    function nextTestimonial() {
        currentIndex = (currentIndex + 1) % testimonialCards.length;
        showTestimonial(currentIndex);

        remainingTime = duration;
        resetProgress();

        requestAnimationFrame(() => {
            startCarousel();
        });
    }

    function startCarousel() {
        startTime = Date.now();
        startProgress(remainingTime);

        clearTimeout(timeoutId);
        timeoutId = setTimeout(nextTestimonial, remainingTime);
    }

    function pauseCarousel() {
        isPaused = true;
        clearTimeout(timeoutId);

        const elapsed = Date.now() - startTime;
        remainingTime = Math.max(0, remainingTime - elapsed);

        const currentWidth = getComputedStyle(progressBar).width;
        progressBar.style.transition = 'none';
        progressBar.style.width = currentWidth;

        if (pauseBtn) {
            pauseBtn.textContent = "Reprendre";
            pauseBtn.setAttribute('aria-label', 'Reprendre le carrousel');
        }
    }

    function resumeCarousel() {
        isPaused = false;
        startCarousel();

        if (pauseBtn) {
            pauseBtn.textContent = "Pause";
            pauseBtn.setAttribute('aria-label', 'Mettre en pause le carrousel');
        }
    }

    showTestimonial(currentIndex);
    resetProgress();
    startCarousel();

    if (pauseBtn) {
        pauseBtn.addEventListener('click', () => {
            if (isPaused) {
                resumeCarousel();
            } else {
                pauseCarousel();
            }
        });
    }
}
    
    const fadeElements = document.querySelectorAll('.fade-in');

    if (fadeElements.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.2
        });

        fadeElements.forEach((element) => {
            observer.observe(element);
        });
    }

    const statsSection = document.querySelector('.stats-section');
    const stats = document.querySelectorAll('.stats-container .stat');

    function clamp(value, min, max) {
        return Math.max(min, Math.min(max, value));
    }

    function updateStatsOnScroll() {
        if (!statsSection || stats.length === 0) return;

        const rect = statsSection.getBoundingClientRect();
        const windowHeight = window.innerHeight;

        // progression de la section dans l'écran
        const start = windowHeight * 0.85;
        const end = windowHeight * 0.3;
        const total = start - end;

        const progress = clamp((start - rect.top) / total, 0, 1);

        stats.forEach((stat, index) => {
            const itemStart = index / stats.length;
            const itemEnd = (index + 1) / stats.length;

            let itemProgress = (progress - itemStart) / (itemEnd - itemStart);
            itemProgress = clamp(itemProgress, 0, 1);

            const opacity = itemProgress;
            const translateY = 60 * (1 - itemProgress);

            stat.style.opacity = opacity;
            stat.style.transform = `translateY(${translateY}px)`;
        });
    }

    window.addEventListener('scroll', updateStatsOnScroll);
    window.addEventListener('resize', updateStatsOnScroll);
    updateStatsOnScroll();

    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const button = item.querySelector('.faq-question');

        button.addEventListener('click', () => {
            const isOpen = item.classList.contains('active');

            // fermer tous
            faqItems.forEach(i => {
                i.classList.remove('active');
                i.querySelector('.faq-answer').style.maxHeight = null;
            });

            // ouvrir celui cliqué
            if (!isOpen) {
                item.classList.add('active');
                const answer = item.querySelector('.faq-answer');
                answer.style.maxHeight = answer.scrollHeight + 'px';
            }
        });
    });

    // LOGIQUE DU BOUTON RETOUR EN HAUT AJOUTÉE ICI
    const scrollTopBtn = document.getElementById('scroll-to-top');

    if (scrollTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                scrollTopBtn.style.display = 'flex';
            } else {
                scrollTopBtn.style.display = 'none';
            }
        });

        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        scrollTopBtn.addEventListener('mouseenter', () => {
            scrollTopBtn.style.transform = 'scale(1.1)';
            scrollTopBtn.style.backgroundColor = '#1d4ed8';
        });
        
        scrollTopBtn.addEventListener('mouseleave', () => {
            scrollTopBtn.style.transform = 'scale(1)';
            scrollTopBtn.style.backgroundColor = '#2563eb';
        });
    }
});