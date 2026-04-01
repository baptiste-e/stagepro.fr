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

    // 3. Exemple de validation de formulaire simple (STx 3)
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            // Ici, vous ajouteriez la logique de vérification côté client
            console.log("Formulaire soumis : validation en cours...");
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

        function showTestimonial(index) {
            testimonialCards.forEach((card, i) => {
                card.classList.toggle('active', i === index);
            });
        }

        function animateProgress() {
            progressBar.style.transition = 'none';
            progressBar.style.width = '0%';

            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    progressBar.style.transition = `width ${duration}ms linear`;
                    progressBar.style.width = '100%';
                });
            });
        }

        function nextTestimonial() {
            currentIndex = (currentIndex + 1) % testimonialCards.length;
            showTestimonial(currentIndex);
            animateProgress();
        }

        showTestimonial(currentIndex);
        animateProgress();

        setInterval(nextTestimonial, duration);
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