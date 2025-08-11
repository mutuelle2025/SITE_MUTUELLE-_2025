/**
 * Script d'animations pour la Mutuelle UDM
 */

document.addEventListener('DOMContentLoaded', function() {

    // ===== ANIMATIONS SÉCURISÉES SEULEMENT =====

    console.log('🎬 Animations sécurisées initialisées pour la Mutuelle UDM');

    // Observer pour les compteurs seulement (animations sûres)
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Animation spéciale pour les compteurs seulement
                if (entry.target.classList.contains('stat-counter')) {
                    animateCounter(entry.target);
                }

                // Animation manuelle pour les éléments qui le demandent explicitement
                if (entry.target.classList.contains('manual-fade-in')) {
                    entry.target.style.animation = 'fadeIn 0.8s ease-out forwards';
                }
            }
        });
    }, observerOptions);

    // Observer seulement les compteurs et animations manuelles
    const safeElements = document.querySelectorAll('.stat-counter, .manual-fade-in, .manual-slide-in');
    safeElements.forEach(el => observer.observe(el));
    
    // ===== ANIMATION DES COMPTEURS =====
    
    function animateCounter(element) {
        const target = parseInt(element.dataset.target) || parseInt(element.textContent.replace(/\D/g, ''));
        const duration = 2000; // 2 secondes
        const increment = target / (duration / 16); // 60 FPS
        let current = 0;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            
            // Formater le nombre avec des séparateurs
            const formatted = Math.floor(current).toLocaleString();
            const suffix = element.textContent.replace(/[\d,\s]/g, '');
            element.textContent = formatted + suffix;
        }, 16);
    }
    
    // ===== ANIMATIONS DES BOUTONS =====
    
    // Ajouter la classe d'animation aux boutons
    const buttons = document.querySelectorAll('.btn, .service-link, .nav-link');
    buttons.forEach(btn => {
        btn.classList.add('btn-animate');
        
        // Effet de ripple au clic
        btn.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // ===== ANIMATIONS DES CARTES =====
    
    // ===== ANIMATIONS DE SURVOL SÉCURISÉES =====

    // Animations hover-lift (sécurisées)
    const hoverElements = document.querySelectorAll('.hover-lift');
    hoverElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.2)';
            this.style.transition = 'all 0.3s ease';
        });

        element.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });

    // Animations hover-scale (sécurisées)
    const scaleElements = document.querySelectorAll('.hover-scale');
    scaleElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
            this.style.transition = 'transform 0.3s ease';
        });

        element.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // ===== ANIMATIONS DES ICÔNES =====
    
    const icons = document.querySelectorAll('i[class*="fa"]');
    icons.forEach(icon => {
        icon.classList.add('icon-animate');
        
        // Animation de rotation pour certaines icônes
        if (icon.classList.contains('fa-cog') || icon.classList.contains('fa-sync')) {
            icon.addEventListener('mouseenter', function() {
                this.style.animation = 'rotate 1s linear infinite';
            });
            
            icon.addEventListener('mouseleave', function() {
                this.style.animation = '';
            });
        }
    });
    
    // ===== ANIMATION DE LA NAVIGATION =====
    
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach((item, index) => {
        item.style.animationDelay = (index * 0.1) + 's';
        item.classList.add('animate-fade-in');
    });
    
    // ===== ANIMATION DU HERO =====
    
    const heroTitle = document.querySelector('.hero-title');
    const heroSubtitle = document.querySelector('.hero-subtitle');
    const heroButtons = document.querySelector('.hero-buttons');
    
    if (heroTitle) heroTitle.classList.add('animate-fade-in');
    if (heroSubtitle) heroSubtitle.classList.add('animate-fade-in', 'animate-delay-2');
    if (heroButtons) heroButtons.classList.add('animate-fade-in', 'animate-delay-4');
    
    // ===== ANIMATIONS DES FORMULAIRES =====
    
    const formGroups = document.querySelectorAll('.form-group');
    formGroups.forEach((group, index) => {
        group.style.animationDelay = (index * 0.1) + 's';
        group.classList.add('animate-slide-in-left');
    });
    
    // Animation des champs de formulaire au focus
    const formControls = document.querySelectorAll('.form-control');
    formControls.forEach(control => {
        control.addEventListener('focus', function() {
            this.parentElement.classList.add('animate-pulse');
        });
        
        control.addEventListener('blur', function() {
            this.parentElement.classList.remove('animate-pulse');
        });
    });
    
    // ===== ANIMATIONS DES NOTIFICATIONS =====
    
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} notification-slide`;
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            padding: 1rem 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        `;
        
        document.body.appendChild(notification);
        
        // Supprimer après 3 secondes
        setTimeout(() => {
            notification.classList.add('notification-fade-out');
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }
    
    // ===== ANIMATION DE CHARGEMENT =====
    
    function showLoading() {
        const loading = document.createElement('div');
        loading.className = 'loading-spinner';
        loading.id = 'global-loading';
        loading.style.cssText = `
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        `;
        document.body.appendChild(loading);
    }
    
    function hideLoading() {
        const loading = document.getElementById('global-loading');
        if (loading) loading.remove();
    }
    
    // ===== ANIMATIONS SPÉCIALES =====
    
    // Animation de typing pour certains textes
    const typingElements = document.querySelectorAll('.typing-text');
    typingElements.forEach(element => {
        const text = element.textContent;
        element.textContent = '';
        element.style.borderRight = '2px solid #2e7d32';
        
        let i = 0;
        const typeWriter = () => {
            if (i < text.length) {
                element.textContent += text.charAt(i);
                i++;
                setTimeout(typeWriter, 100);
            } else {
                // Faire clignoter le curseur
                setInterval(() => {
                    element.style.borderRight = element.style.borderRight === 'none' ? '2px solid #2e7d32' : 'none';
                }, 500);
            }
        };
        
        // Démarrer l'animation quand l'élément est visible
        observer.observe(element);
        element.addEventListener('visible', typeWriter);
    });
    
    // ===== ANIMATIONS AU SCROLL DE LA PAGE =====
    
    let lastScrollTop = 0;
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Animation de la navbar au scroll
        const navbar = document.querySelector('.navbar');
        if (navbar) {
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scroll vers le bas
                navbar.style.transform = 'translateY(-100%)';
            } else {
                // Scroll vers le haut
                navbar.style.transform = 'translateY(0)';
            }
        }
        
        lastScrollTop = scrollTop;
    });
    
    // ===== ANIMATIONS PARALLAX =====
    
    const parallaxElements = document.querySelectorAll('.parallax');
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        
        parallaxElements.forEach(element => {
            const rate = scrolled * -0.5;
            element.style.transform = `translateY(${rate}px)`;
        });
    });
    
    // ===== FONCTIONS UTILITAIRES =====
    
    // Fonction pour ajouter une animation à un élément
    window.addAnimation = function(element, animationClass, delay = 0) {
        setTimeout(() => {
            if (typeof element === 'string') {
                element = document.querySelector(element);
            }
            if (element) {
                element.classList.add(animationClass);
            }
        }, delay);
    };
    
    // Fonction pour déclencher une notification
    window.showNotification = showNotification;
    
    // Fonctions de chargement
    window.showLoading = showLoading;
    window.hideLoading = hideLoading;
    
    // ===== INITIALISATION =====
    
    console.log('🎬 Animations initialisées pour la Mutuelle UDM');
    
    // Ajouter des styles CSS pour les effets de ripple
    const style = document.createElement('style');
    style.textContent = `
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        .btn-animate {
            position: relative;
            overflow: hidden;
        }
    `;
    document.head.appendChild(style);
});

// ===== ANIMATIONS POUR LES PAGES SPÉCIFIQUES =====

// Animation spéciale pour la page Alumni
if (window.location.pathname.includes('alumni.php')) {
    document.addEventListener('DOMContentLoaded', function() {
        const bureauCards = document.querySelectorAll('[style*="border-top"]');
        bureauCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.6s ease';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 150);
        });
    });
}
