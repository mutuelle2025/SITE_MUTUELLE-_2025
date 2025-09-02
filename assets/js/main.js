// Navigation mobile
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');

    if (hamburger && navMenu) {
        hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        // Fermer le menu quand on clique sur un lien
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });
    }
});

// Animation au scroll
function animateOnScroll() {
    const elements = document.querySelectorAll('.service-card, .stat-item');

    elements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const elementVisible = 150;

        if (elementTop < window.innerHeight - elementVisible) {
            element.classList.add('animate');
        }
    });
}

window.addEventListener('scroll', animateOnScroll);

// Smooth scroll pour les liens d'ancrage
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Effet de typing pour le titre hero (optionnel)
function typeWriter(element, text, speed = 100) {
    let i = 0;
    element.innerHTML = '';

    function type() {
        if (i < text.length) {
            element.innerHTML += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }

    type();
}

// Initialiser l'effet typing si l'élément existe
window.addEventListener('load', function() {
    const heroTitle = document.querySelector('.hero-title');
    if (heroTitle) {
        const originalText = heroTitle.textContent;
        // Décommenter la ligne suivante pour activer l'effet typing
        // typeWriter(heroTitle, originalText, 50);
    }
});

// Gestion des formulaires (pour les futures pages)
function handleFormSubmission(formId, successMessage) {
    const form = document.getElementById(formId);
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Ici vous pouvez ajouter la logique de validation
            // et d'envoi des données

            // Exemple de feedback utilisateur
            showNotification(successMessage, 'success');
        });
    }
}

// Système de notifications
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;

    // Styles inline pour la notification
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background-color: ${type === 'success' ? '#4caf50' : type === 'error' ? '#f44336' : '#2196f3'};
        color: white;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        z-index: 10000;
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;

    document.body.appendChild(notification);

    // Animation d'entrée
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);

    // Suppression automatique
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Supprimer un document
function deleteDocument(documentId, cardElement) {
    console.log('Fonction deleteDocument appelée avec ID:', documentId);
    
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce document ? Cette action est irréversible.')) {
        console.log('Suppression annulée par l\'utilisateur');
        return;
    }

    const apiUrl = '/SITE_MUTUELLE-_2025/api/delete_document.php';
    const requestData = {
        document_id: documentId
    };
    
    console.log('Envoi de la requête à:', apiUrl, 'avec les données:', requestData);
    
    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(requestData),
        credentials: 'same-origin' // Important pour envoyer les cookies de session
    })
    .then(response => {
        console.log('Réponse reçue - Status:', response.status);
        if (!response.ok) {
            console.error('Erreur HTTP:', response.status);
            return response.text().then(text => {
                console.error('Réponse d\'erreur:', text);
                try {
                    return JSON.parse(text);
                } catch (e) {
                    throw new Error(text || 'Erreur inconnue');
                }
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Supprimer la carte du DOM avec une animation
            cardElement.style.opacity = '0';
            cardElement.style.transform = 'translateX(100%)';
            setTimeout(() => {
                cardElement.remove();
                showNotification('Document supprimé avec succès', 'success');
                
                // Vérifier s'il reste des documents
                const container = document.querySelector('.documents-container') || document.querySelector('.bank-documents');
                if (container && container.children.length === 0) {
                    container.innerHTML = '<p class="no-documents">Aucun document disponible</p>';
                }
            }, 300);
        } else {
            throw new Error(data.error || 'Erreur lors de la suppression du document');
        }
    })
    .catch(error => {
        console.error('Erreur lors de la suppression:', error);
        showNotification('Erreur lors de la suppression: ' + (error.message || 'Erreur inconnue'), 'error');
    });
}

// Utilitaires
const Utils = {
    // Debounce function pour optimiser les événements
    debounce: function(func, wait, immediate) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                timeout = null;
                if (!immediate) func(...args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func(...args);
        };
    },

    // Vérifier si un élément est visible
    isElementVisible: function(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }
};