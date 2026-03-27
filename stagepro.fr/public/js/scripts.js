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

    // 2. Gestion du menu burger (Navigation mobile)
    // Assurez-vous que votre HTML contient bien les éléments .nav-toggle
    const navToggle = document.querySelector('.nav-toggle');
    if (navToggle) {
        navToggle.addEventListener('change', () => {
            if (navToggle.checked) {
                console.log("Menu ouvert");
                // Optionnel : ajouter une classe pour styliser le menu mobile
            } else {
                console.log("Menu fermé");
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

        const header = document.querySelector('header');

        function updateHeaderHeight() {
        if (header) {
            document.documentElement.style.setProperty('--header-height', `${header.offsetHeight}px`);
        }
    }
        updateHeaderHeight();
        window.addEventListener('resize', updateHeaderHeight);
    
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
});