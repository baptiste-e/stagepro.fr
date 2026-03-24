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
});