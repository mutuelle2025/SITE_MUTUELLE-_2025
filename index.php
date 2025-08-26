<?php
$page_title = "Accueil";
include 'includes/header.php';
?>
<style>
    .hero {
        background-image: url('assets/img/Plan UDM.png');
        /* <section class="hero" style="position: relative;"> */
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        /* min-height: 100vh; */
        /* width: 100%; */
        position: relative;
    }

    .testimonials-scroll {
        overflow-x: hidden;
        white-space: nowrap;
        position: relative;
        padding-bottom: 0;
        /* Masquer la scrollbar sur tous les navigateurs */
        scrollbar-width: none;
    }

    .testimonials-scroll::-webkit-scrollbar {
        display: none;
    }

    .testimonials-scroll-inner {
        display: inline-block;
        white-space: nowrap;
        animation: scroll-testimonials 40s linear infinite;
    }

    @keyframes scroll-testimonials {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    .testimonial-card {
        display: inline-block;
        vertical-align: top;
        width: 340px;
        max-width: 340px;
        margin-right: 2rem;
        box-sizing: border-box;
        /* Garder le style original */
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        text-align: center;
        position: relative;
        overflow: hidden;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    .testimonial-card p {
        white-space: normal;
        overflow-wrap: break-word;
        word-break: break-word;
        margin-bottom: 1.5rem;
        line-height: 1.6;
        max-width: 100%;
    }

    /* .testimonial-card p {
    overflow-wrap: break-word;
    word-break: break-word;
    margin-bottom: 1.5rem;
    line-height: 1.6;
    max-width: 100%;
} */
    .testimonial-card:last-child {
        margin-right: 0;
    }

    /* Responsive: sur mobile, largeur plus petite */
    @media (max-width: 600px) {
        .testimonial-card {
            width: 90vw;
            min-width: 260px;
            max-width: 95vw;
            margin-right: 1rem;
            padding: 1rem;
        }
    }
</style>

<main class="main-content">
    <!-- Section Hero -->
    <section class="hero"
        style="background-image: url('assets/img/Plan UDM.png'), background-position: center, background-size:contain no-repeat; position: relative;">
        <!-- Overlay sombre sur le fond -->
        <div style="position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.45); z-index:1;">
        </div>
        <div class="hero-container" style="position: relative; z-index:2;">
            <div class="hero-content">
                <h1 class="hero-title">Bienvenue à la Mutuelle des Étudiants UDM</h1>
                <p class="hero-subtitle">Votre plateforme dédiée à la réussite académique et à l'entraide étudiante</p>
                <div class="hero-buttons">
                    <a href="register.php" class="btn btn-primary">Rejoindre la mutuelle</a>
                    <a href="bank.php" class="btn btn-secondary">Explorer les ressources</a>
                    <a href="guide_demarrage.php" class="btn btn-outline" style="color: white; border-color: white;">
                        <i class="fas fa-rocket" style="color: white;"></i> Guide de démarrage
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <!-- Image d'étudiants collaborant -->
                <div
                    style="position: relative; width: 100%; height: 300px; background: linear-gradient(135deg, rgba(46, 125, 50, 0.1), rgba(129, 199, 132, 0.1)); border-radius: 15px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                    <!-- Placeholder pour image d'étudiants -->
                    <div
                        style="background: url('assets/img/Communauté UDM.jpg') center/cover; width: 100%; height: 100%; border-radius: 15px; position: relative;">
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; border-radius: 15px;">
                        </div>
                        <div
                            style="position: absolute; bottom: 20px; left: 20px; color: white; font-weight: bold; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                            <i class="fas fa-users"></i> Burreau 2025
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Services -->
    <section class="services">
        <div class="container">
            <h2 class="section-title">Nos Services</h2>
            <div class="services-grid">
                <div class="service-card hover-lift">
                    <!-- Image de fond pour la banque d'épreuves -->
                    <div
                        style="height: 150px; background: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80') center/cover; border-radius: 10px 10px 0 0; position: relative; margin: -2rem -2rem 1rem -2rem;">
                        <div
                            style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(46, 125, 50, 0.8), rgba(129, 199, 132, 0.6)); border-radius: 10px 10px 0 0; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-book icon-animate" style="color: white; font-size: 3rem;"></i>
                        </div>
                    </div>
                    <h3>Banque d'Épreuves</h3>
                    <p>Accédez à une vaste collection d'examens passés et de cours partagés par la communauté étudiante.
                    </p>
                    <a href="bank.php" class="service-link btn-animate">Découvrir <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="service-card">
                    <!-- Image de fond pour les résultats -->
                    <div
                        style="height: 150px; background: url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80') center/cover; border-radius: 10px 10px 0 0; position: relative; margin: -2rem -2rem 1rem -2rem;">
                        <div
                            style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(33, 150, 243, 0.8), rgba(100, 181, 246, 0.6)); border-radius: 10px 10px 0 0; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-chart-line" style="color: white; font-size: 3rem;"></i>
                        </div>
                    </div>
                    <h3>Consultation des Résultats</h3>
                    <p>Consultez vos résultats académiques de manière sécurisée et suivez votre progression.</p>
                    <a href="results.php" class="service-link">Consulter <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="service-card">
                    <!-- Image de fond pour la messagerie -->
                    <div
                        style="height: 150px; background: url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80') center/cover; border-radius: 10px 10px 0 0; position: relative; margin: -2rem -2rem 1rem -2rem;">
                        <div
                            style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(255, 152, 0, 0.8), rgba(255, 183, 77, 0.6)); border-radius: 10px 10px 0 0; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-comments" style="color: white; font-size: 3rem;"></i>
                        </div>
                    </div>
                    <h3>Messagerie Étudiante</h3>
                    <p>Communiquez avec vos collègues, partagez des informations et créez des groupes d'étude.</p>
                    <a href="messages.php" class="service-link">Messagerie <i class="fas fa-arrow-right"></i></a>
                </div>

                <!-- <div class="service-card"> -->
                    <!-- Image de fond pour l'email -->
                    <!-- <div
                        style="height: 150px; background: url('https://images.unsplash.com/photo-1596526131083-e8c633c948d2?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80') center/cover; border-radius: 10px 10px 0 0; position: relative; margin: -2rem -2rem 1rem -2rem;">
                        <div
                            style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(156, 39, 176, 0.8), rgba(186, 104, 200, 0.6)); border-radius: 10px 10px 0 0; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-envelope" style="color: white; font-size: 3rem;"></i>
                        </div>
                    </div>
                    <h3>Email Professionnel</h3>
                    <p>Obtenez votre adresse email professionnelle UDM pour vos communications académiques.</p>
                    <a href="dashboard.php" class="service-link">Générer <i class="fas fa-arrow-right"></i></a>
                </div> -->
            </div>
        </div>
    </section>

    <!-- Section À propos -->
    <section class="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>À propos de la Mutuelle UDM</h2>
                    <p>La Mutuelle des Étudiants de l'<a href="https://www.google.com/maps/place/Universit%C3%A9+des+Montagnes+(UdM)/@5.1345717,10.5899567,769m/data=!3m1!1e3!4m10!1m2!2m1!1sudm!3m6!1s0x105ff826fac3d22b:0x3166f3a8f1de1dea!8m2!3d5.1350303!4d10.5893208!15sCgN1ZG2SAQZzY2hvb2yqASsQATIeEAEiGkNYI2oyhe28GmccMFdHMiBiJQ5XfDDAexXFMgcQAiIDdWRt4AEA!16s%2Fg%2F11fx_5qp_d?entry=ttu&g_ep=EgoyMDI1MDgxOS4wIKXMDSoASAFQAw%3D%3D"
                            target="_blank" style="color: var(--primary-color); text-decoration: none;">Université des
                            Montagnes</a> est une initiative étudiante visant à créer une communauté solidaire et
                        collaborative.</p>

                    <!-- Images illustratives de la vie étudiante -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin: 2rem 0;">
                        <div style="position: relative; height: 120px; border-radius: 10px; overflow: hidden;">
                            <div
                                style="background: url('assets/img/Art oratoire et éloquence.jpg') center/cover; width: 100%; height: 100%;">
                            </div>
                            <div
                                style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); color: white; padding: 0.5rem; font-size: 0.9rem; font-weight: bold;">
                                <i class="fas fa-users"></i> Art oratoire et éloquence
                            </div>
                        </div>
                        <div style="position: relative; height: 120px; border-radius: 10px; overflow: hidden;">
                            <div
                                style="background: url('assets/img/Foire interculturelle.jpg') center/cover; width: 100%; height: 100%;">
                            </div>
                            <div
                                style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); color: white; padding: 0.5rem; font-size: 0.9rem; font-weight: bold;">
                                <i class="fas fa-book-open"></i> Foire interculturelle
                            </div>
                        </div>
                    </div>

                    <ul class="about-features">
                        <li><i class="fas fa-check"></i> Partage de ressources académiques</li>
                        <li><i class="fas fa-check"></i> Entraide entre étudiants</li>
                        <li><i class="fas fa-check"></i> Suivi personnalisé des résultats</li>
                        <li><i class="fas fa-check"></i> Communication facilitée</li>
                    </ul>

                    <h3 style="margin-top: 1.5rem; color: var(--primary-color);">Activités menées</h3>
                    <ul class="about-features">
                        <li><i class="fas fa-users"></i> Séances de révision collectives et tutorat entre promotions
                        </li>
                        <li><i class="fas fa-chalkboard-teacher"></i> Ateliers thématiques (méthodologie, orientation,
                            stages)</li>
                        <li><i class="fas fa-hands-helping"></i> Actions de solidarité (prêts d’ouvrages, dons de
                            polycopiés)</li>
                        <li><i class="fas fa-lightbulb"></i> Groupes d’étude, clubs et projets collaboratifs
                            interdisciplinaires</li>
                        <li><i class="fas fa-calendar-check"></i> Journées d’intégration et événements communautaires
                        </li>
                    </ul>

                    <div style="margin-top: 1rem;">
                        <a href="https://drive.google.com/drive/folders/1pZy_7N-lmJyPmm5G7L-uZPUY_tlnoGRj"
                            target="_blank" class="btn btn-secondary">
                            <i class="fas fa-external-link-alt"></i> Voir la galerie photo
                        </a>
                    </div>
                </div>
                <div class="about-stats">
                    <div class="stat-item">
                        <div class="stat-number">847</div>
                        <div class="stat-label">Étudiants membres actifs</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">2,341</div>
                        <div class="stat-label">Documents partagés</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">92%</div>
                        <div class="stat-label">Taux de réussite</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Témoignages -->
    <section class="testimonials"
        style="padding: 4rem 0; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container">
            <h2 class="section-title">Ce que disent nos membres</h2>
            <div class="testimonials-scroll">
                <div class="testimonials-scroll-inner">
                    <!-- Cartes originales -->
                    <div class="testimonial-card">
                        <!-- Décoration de fond -->
                        <div
                            style="position: absolute; top: -50px; right: -50px; width: 100px; height: 100px; background: linear-gradient(135deg, var(--primary-color), var(--accent-color)); border-radius: 50%; opacity: 0.1;">
                        </div>

                        <!-- Avatar -->
                        <div
                            style="width: 80px; height: 80px; border-radius: 50%; background: url('assets/img/Uriche.jpg') center/cover; margin: 0 auto 1rem; border: 4px solid var(--primary-color);">
                        </div>

                        <div style="color: var(--primary-color); font-size: 2rem; margin-bottom: 1rem;">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p
                            style="color: var(--text-dark); font-style: italic; margin-bottom: 1.5rem; line-height: 1.6;">
                            "Grâce à la mutuelle, j'ai pu accéder à tous les anciens examens de ma filière.
                            Cela m'a énormément aidé à réussir mes partiels !"
                        </p>
                        <div style="color: var(--primary-color); font-weight: bold; font-size: 1.1rem;">Uriche.F
                        </div>
                        <div style="color: var(--text-light); font-size: 0.9rem;">Étudiant en pharmacie 6</div>
                        <div style="margin-top: 1rem;">
                            <span style="color: #ffc107;">★★★★★</span>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <!-- Décoration de fond -->
                        <div
                            style="position: absolute; top: -50px; right: -50px; width: 100px; height: 100px; background: linear-gradient(135deg, #2196f3, #64b5f6); border-radius: 50%; opacity: 0.1;">
                        </div>

                        <!-- Avatar -->
                        <div
                            style="width: 80px; height: 80px; border-radius: 50%; background: url('assets/img/Ulrich.jpg') center/cover; margin: 0 auto 1rem; border: 4px solid #2196f3;">
                        </div>

                        <div style="color: #2196f3; font-size: 2rem; margin-bottom: 1rem;">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p
                            style="color: var(--text-dark); font-style: italic; margin-bottom: 1.5rem; line-height: 1.6;">
                            "L'entraide entre étudiants est formidable. J'ai trouvé un groupe d'étude
                            grâce à la messagerie et nous nous soutenons mutuellement."
                        </p>
                        <div style="color: #2196f3; font-weight: bold; font-size: 1.1rem;">Ullrich.W</div>
                        <div style="color: var(--text-light); font-size: 0.9rem;">Étudiante en Informatique M1</div>
                        <div style="margin-top: 1rem;">
                            <span style="color: #ffc107;">★★★★★</span>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <!-- Décoration de fond -->
                        <div
                            style="position: absolute; top: -50px; right: -50px; width: 100px; height: 100px; background: linear-gradient(135deg, #ff0040ff, #ec6385ff); border-radius: 50%; opacity: 0.1;">
                        </div>

                        <!-- Avatar -->
                        <div
                            style="width: 80px; height: 80px; border-radius: 50%; background: url('assets/img/Joyce.jpg') center/cover; margin: 0 auto 1rem; border: 4px solid #ff0040ff;">
                        </div>

                        <div style="color: #ff0040ff; font-size: 2rem; margin-bottom: 1rem;">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p
                            style="color: var(--text-dark); font-style: italic; margin-bottom: 1.5rem; line-height: 1.6;">
                            "Partager mes cours m'a permis d'aider d'autres étudiants tout en
                            renforçant mes propres connaissances. C'est un cercle vertueux !"
                        </p>
                        <div style="color: #ff0040ff; font-weight: bold; font-size: 1.1rem;">Joyce.F</div>
                        <div style="color: var(--text-light); font-size: 0.9rem;">Étudiant en biologie 3</div>
                        <div style="margin-top: 1rem;">
                            <span style="color: #ffc107;">★★★★★</span>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <!-- Décoration de fond -->
                        <div
                            style="position: absolute; top: -50px; right: -50px; width: 100px; height: 100px; background: linear-gradient(135deg, #ff9800, #ffb74d); border-radius: 50%; opacity: 0.1;">
                        </div>

                        <!-- Avatar -->
                        <div
                            style="width: 80px; height: 80px; border-radius: 50%; background: url('assets/img/Nkamwa Nouhan Marc Ivan.jpg') center/cover; margin: 0 auto 1rem; border: 4px solid #ff9800;">
                        </div>

                        <div style="color: #ff9800; font-size: 2rem; margin-bottom: 1rem;">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p
                            style="color: var(--text-dark); font-style: italic; margin-bottom: 1.5rem; line-height: 1.6;">
                            "Le système mis en place a réellement facilité la communication. Il a ouvert un espace d’échange plus accessible et dynamique."
                        </p>
                        <div style="color: #ff9800; font-weight: bold; font-size: 1.1rem;">Ivan.N</div>
                        <div style="color: var(--text-light); font-size: 0.9rem;">Étudiant en Den 6</div>
                        <div style="margin-top: 1rem;">
                            <span style="color: #ffc107;">★★★★</span>★
                        </div>
                    </div>
                    <!-- Répétition des cartes pour effet continu -->
                    <div class="testimonial-card">
                        <!-- Décoration de fond -->
                        <div
                            style="position: absolute; top: -50px; right: -50px; width: 100px; height: 100px; background: linear-gradient(135deg, var(--primary-color), var(--accent-color)); border-radius: 50%; opacity: 0.1;">
                        </div>

                        <!-- Avatar -->
                        <div
                            style="width: 80px; height: 80px; border-radius: 50%; background: url('assets/img/Uriche.jpg') center/cover; margin: 0 auto 1rem; border: 4px solid var(--primary-color);">
                        </div>

                        <div style="color: var(--primary-color); font-size: 2rem; margin-bottom: 1rem;">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p
                            style="color: var(--text-dark); font-style: italic; margin-bottom: 1.5rem; line-height: 1.6;">
                            "Grâce à la mutuelle, j'ai pu accéder à tous les anciens examens de ma filière.
                            Cela m'a énormément aidé à réussir mes partiels !"
                        </p>
                        <div style="color: var(--primary-color); font-weight: bold; font-size: 1.1rem;">Uriche.F
                        </div>
                        <div style="color: var(--text-light); font-size: 0.9rem;">Étudiant en pharmacie 6</div>
                        <div style="margin-top: 1rem;">
                            <span style="color: #ffc107;">★★★★★</span>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <!-- Décoration de fond -->
                        <div
                            style="position: absolute; top: -50px; right: -50px; width: 100px; height: 100px; background: linear-gradient(135deg, #2196f3, #64b5f6); border-radius: 50%; opacity: 0.1;">
                        </div>

                        <!-- Avatar -->
                        <div
                            style="width: 80px; height: 80px; border-radius: 50%; background: url('assets/img/Ulrich.jpg') center/cover; margin: 0 auto 1rem; border: 4px solid #2196f3;">
                        </div>

                        <div style="color: #2196f3; font-size: 2rem; margin-bottom: 1rem;">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p
                            style="color: var(--text-dark); font-style: italic; margin-bottom: 1.5rem; line-height: 1.6;">
                            "L'entraide entre étudiants est formidable. J'ai trouvé un groupe d'étude
                            grâce à la messagerie et nous nous soutenons mutuellement."
                        </p>
                        <div style="color: #2196f3; font-weight: bold; font-size: 1.1rem;">Ullrich.W</div>
                        <div style="color: var(--text-light); font-size: 0.9rem;">Étudiante en Informatique M1</div>
                        <div style="margin-top: 1rem;">
                            <span style="color: #ffc107;">★★★★★</span>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <!-- Décoration de fond -->
                        <div
                            style="position: absolute; top: -50px; right: -50px; width: 100px; height: 100px; background: linear-gradient(135deg, #ff0040ff, #ec6385ff); border-radius: 50%; opacity: 0.1;">
                        </div>

                        <!-- Avatar -->
                        <div
                            style="width: 80px; height: 80px; border-radius: 50%; background: url('assets/img/Joyce.jpg') center/cover; margin: 0 auto 1rem; border: 4px solid #ff0040ff;">
                        </div>

                        <div style="color: #ff0040ff; font-size: 2rem; margin-bottom: 1rem;">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p
                            style="color: var(--text-dark); font-style: italic; margin-bottom: 1.5rem; line-height: 1.6;">
                            "Partager mes cours m'a permis d'aider d'autres étudiants tout en
                            renforçant mes propres connaissances. C'est un cercle vertueux !hxj"
                        </p>
                        <div style="color: #ff0040ff; font-weight: bold; font-size: 1.1rem;">Joyce.F</div>
                        <div style="color: var(--text-light); font-size: 0.9rem;">Étudiant en biologie 3</div>
                        <div style="margin-top: 1rem;">
                            <span style="color: #ffc107;">★★★★★</span>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <!-- Décoration de fond -->
                        <div
                            style="position: absolute; top: -50px; right: -50px; width: 100px; height: 100px; background: linear-gradient(135deg, #ff0040ff, #ff004077); border-radius: 50%; opacity: 0.1;">
                        </div>

                        <!-- Avatar -->
                        <div
                            style="width: 80px; height: 80px; border-radius: 50%; background: url('assets/img/Nkamwa Nouhan Marc Ivan.jpg') center/cover; margin: 0 auto 1rem; border: 4px solid #ff9800;">
                        </div>

                        <div style="color: #ff000dff; font-size: 2rem; margin-bottom: 1rem;">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p
                            style="color: var(--text-dark); font-style: italic; margin-bottom: 1.5rem; line-height: 1.6;">
                            "Le système mis en place a réellement facilité la communication. Il a ouvert un espace d’échange plus accessible et dynamique."
                        </p>
                        <div style="color: #ff9800; font-weight: bold; font-size: 1.1rem;">Ivan.N</div>
                        <div style="color: var(--text-light); font-size: 0.9rem;">Étudiant en Den 6</div>
                        <div style="margin-top: 1rem;">
                            <span style="color: #ffc107;">★★★★</span>★
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- Section Galerie Vie Universitaire -->
    <section style="padding: 4rem 0; background: white;">
        <div class="container">
            <h2 class="section-title">La Vie à l'UDM</h2>
            <p style="text-align: center; color: var(--text-light); margin-bottom: 3rem; font-size: 1.1rem;">
                Découvrez l'ambiance chaleureuse et collaborative de notre université
            </p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <!-- Image 1: Bibliothèque -->
                <div style="position: relative; height: 200px; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: transform 0.3s ease;"
                    onmouseover="this.style.transform='translateY(-5px)'"
                    onmouseout="this.style.transform='translateY(0)'">
                    <div
                        style="background: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80') center/cover; width: 100%; height: 100%;">
                    </div>
                    <div
                        style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); color: white; padding: 1rem;">
                        <h4 style="margin: 0; font-size: 1.1rem;"><i class="fas fa-book"></i> Bibliothèque Moderne</h4>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; opacity: 0.9;">Espace d'étude calme et équipé
                        </p>
                    </div>
                </div>

                <!-- Image 2: Amphithéâtre -->
                <div style="position: relative; height: 200px; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: transform 0.3s ease;"
                    onmouseover="this.style.transform='translateY(-5px)'"
                    onmouseout="this.style.transform='translateY(0)'">
                    <div
                        style="background: url('assets/img/amphi.jpg') center/cover; width: 100%; height: 100%;">
                    </div>
                    <div
                        style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); color: white; padding: 1rem;">
                        <h4 style="margin: 0; font-size: 1.1rem;"><i class="fas fa-chalkboard-teacher"></i>
                            Amphithéâtres</h4>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; opacity: 0.9;">Cours magistraux interactifs
                        </p>
                    </div>
                </div>

                <!-- Image 3: Laboratoire -->
                <div style="position: relative; height: 200px; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: transform 0.3s ease;"
                    onmouseover="this.style.transform='translateY(-5px)'"
                    onmouseout="this.style.transform='translateY(0)'">
                    <div
                        style="background: url('assets/img/labo.jpg') center/cover; width: 100%; height: 100%;">
                    </div>
                    <div
                        style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); color: white; padding: 1rem;">
                        <h4 style="margin: 0; font-size: 1.1rem;"><i class="fas fa-flask"></i> Laboratoires</h4>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; opacity: 0.9;">Équipements de pointe</p>
                    </div>
                </div>

                <!-- Image 4: Campus -->
                <div style="position: relative; height: 200px; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: transform 0.3s ease;"
                    onmouseover="this.style.transform='translateY(-5px)'"
                    onmouseout="this.style.transform='translateY(0)'">
                    <div
                        style="background: url('assets/img/campus verdoyant.jpg') center/cover; width: 100%; height: 100%;">
                    </div>
                    <div
                        style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); color: white; padding: 1rem;">
                        <h4 style="margin: 0; font-size: 1.1rem;"><i class="fas fa-university"></i> Campus Verdoyant
                        </h4>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; opacity: 0.9;">Environnement inspirant</p>
                    </div>
                </div>

                <!-- Image 5: Étudiants collaborant -->
                <div style="position: relative; height: 200px; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: transform 0.3s ease;"
                    onmouseover="this.style.transform='translateY(-5px)'"
                    onmouseout="this.style.transform='translateY(0)'">
                    <div
                        style="background: url('assets/img/collaboration.jpg') center/cover; width: 100%; height: 100%;">
                    </div>
                    <div
                        style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); color: white; padding: 1rem;">
                        <h4 style="margin: 0; font-size: 1.1rem;"><i class="fas fa-users"></i> Travail Collaboratif</h4>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; opacity: 0.9;">Esprit d'équipe et entraide
                        </p>
                    </div>
                </div>

                <!-- Image 6: Événements -->
                <div style="position: relative; height: 200px; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: transform 0.3s ease;"
                    onmouseover="this.style.transform='translateY(-5px)'"
                    onmouseout="this.style.transform='translateY(0)'">
                    <div
                        style="background: url('assets/img/conference.jpg') center/cover; width: 100%; height: 100%;">
                    </div>
                    <div
                        style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); color: white; padding: 1rem;">
                        <h4 style="margin: 0; font-size: 1.1rem;"><i class="fas fa-calendar-alt"></i> Événements</h4>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; opacity: 0.9;">Conférences et activités</p>
                    </div>
                </div>
                
                <!-- Image 7: stade -->
                <div style="position: relative; height: 200px; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: transform 0.3s ease;"
                    onmouseover="this.style.transform='translateY(-5px)'"
                    onmouseout="this.style.transform='translateY(0)'">
                    <div
                        style="background: url('assets/img/stade.jpg') center/cover; width: 100%; height: 100%;">
                    </div>
                    <div
                        style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); color: white; padding: 1rem;">
                        <h4 style="margin: 0; font-size: 1.1rem;"><i class="fas fa-futbol"></i> Stade Sportif</h4>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; opacity: 0.9;">Football et activités sportives</p>
                        <!-- <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; opacity: 0.9;">Activités sportives</p> -->
                    </div>
                </div>
                <!-- Image 8: diplome -->
                <div style="position: relative; height: 200px; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: transform 0.3s ease;"
                    onmouseover="this.style.transform='translateY(-5px)'"
                    onmouseout="this.style.transform='translateY(0)'">
                    <div
                        style="background: url('assets/img/diplome.jpg') center/cover; width: 100%; height: 100%;">
                    </div>
                    <div
                        style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); color: white; padding: 1rem;">
                        <h4 style="margin: 0; font-size: 1.1rem;"><i class="fas fa-graduation-cap"></i> Diplômes</h4>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; opacity: 0.9;">Obtenez votre diplome</p>
                        <!-- <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; opacity: 0.9;">Activités sportives</p> -->
                    </div>
                </div>
                <!-- Image 9: fst -->
                <div style="position: relative; height: 200px; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: transform 0.3s ease;"
                    onmouseover="this.style.transform='translateY(-5px)'"
                    onmouseout="this.style.transform='translateY(0)'">
                    <div
                        style="background: url('assets/img/fst.jpg') center/cover; width: 100%; height: 100%;">
                    </div>
                    <div
                        style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); color: white; padding: 1rem;">
                        <h4 style="margin: 0; font-size: 1.1rem;"><i class="fas fa-tools"></i> Pratiques étudiantes</h4>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; opacity: 0.9;">Pratiquez vos compétences</p>
                        <!-- <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; opacity: 0.9;">Activités sportives</p> -->
                    </div>
                </div>
                <!-- Image 10: projet d'etude -->
                <div style="position: relative; height: 200px; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: transform 0.3s ease;"
                    onmouseover="this.style.transform='translateY(-5px)'"
                    onmouseout="this.style.transform='translateY(0)'">
                    <div
                        style="background: url('assets/img/projet de fin d\'etude.jpg') center/cover; width: 100%; height: 100%;">
                    </div>
                    <div
                        style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); color: white; padding: 1rem;">
                        <h4 style="margin: 0; font-size: 1.1rem;"><i class="fas fa-project-diagram"></i> Projets d'étude</h4>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; opacity: 0.9;">Participez à des projets d'etude</p>
                        <!-- <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; opacity: 0.9;">Activités sportives</p> -->
                    </div>
                </div>
                <!-- Image 11:patriotisme -->
                <div style="position: relative; height: 200px; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: transform 0.3s ease;"
                    onmouseover="this.style.transform='translateY(-5px)'"
                    onmouseout="this.style.transform='translateY(0)'">
                    <div
                        style="background: url('assets/img/patriotisme.jpg') center/cover; width: 100%; height: 100%;">
                    </div>
                    <div
                        style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); color: white; padding: 1rem;">
                        <h4 style="margin: 0; font-size: 1.1rem;"><i class="fas fa-flag"></i> Patriotisme</h4>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; opacity: 0.9;">defiler et autres</p>
                        <!-- <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; opacity: 0.9;">Activités sportives</p> -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section CTA -->
    <section class="cta">
        <div class="container">
            <div class="cta-content">
                <h2>Prêt à rejoindre notre communauté ?</h2>
                <p>Inscrivez-vous dès maintenant et bénéficiez de tous nos services</p>
                <a href="register.php" class="btn btn-primary btn-large">S'inscrire maintenant</a>
            </div>
        </div>
    </section>

    <!-- Section Sponsors -->
    <section class="sponsors" style="padding: 3rem 0; background: #f8f9fa; border-top: 1px solid var(--border-color);">
        <div class="container">
            <h2 class="section-title" style="margin-bottom: 1.5rem;">Nos Sponsors</h2>
            <p style="text-align:center; color: var(--text-light); margin-bottom: 2rem;">Ils soutiennent notre communauté</p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem; align-items: center;">
                <!-- YABA -->
                <div class="sponsor-card" style="background: white; border: 1px solid var(--border-color); border-radius: 10px; padding: 1rem; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                    <img src="assets/img/YABA.png" alt="YABA" style="max-width: 120px; max-height: 50px; object-fit: contain;" />
                    <div style="font-weight: 600; color: var(--text-dark); font-size: 0.95rem; text-align:center;">Yaba-In</div>
                </div>

                <!-- Les Different Global -->
                <div class="sponsor-card" style="background: white; border: 1px solid var(--border-color); border-radius: 10px; padding: 1rem; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                    <!-- Remplacer par: assets/img/les-different-global.png -->
                    <img src="assets/img/global connect consulting.jpg" alt="" style="max-width: 120px; max-height: 50px; object-fit: contain;" />
                    <div style="font-weight: 600; color: var(--text-dark); font-size: 0.95rem; text-align:center;">Global connect consulting</div>
                </div>
                <div class="sponsor-card" style="background: white; border: 1px solid var(--border-color); border-radius: 10px; padding: 1rem; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                    <!-- Remplacer par: assets/img/les-different-global.png -->
                    <img src="assets/img/global connect food.jpg" alt="" style="max-width: 120px; max-height: 50px; object-fit: contain;" />
                    <div style="font-weight: 600; color: var(--text-dark); font-size: 0.95rem; text-align:center;">Global connect food</div>
                </div>
                <div class="sponsor-card" style="background: white; border: 1px solid var(--border-color); border-radius: 10px; padding: 1rem; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                    <!-- Remplacer par: assets/img/les-different-global.png -->
                    <img src="assets/img/global connect sarl.jpg" alt="" style="max-width: 120px; max-height: 50px; object-fit: contain;" />
                    <div style="font-weight: 600; color: var(--text-dark); font-size: 0.95rem; text-align:center;">Global connect sarl</div>
                </div>

                <!-- Moussa -->
                <div class="sponsor-card" style="background: white; border: 1px solid var(--border-color); border-radius: 10px; padding: 1rem; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                    <!-- Remplacer par: assets/img/moussa.png -->
                    <img src="assets/img/mousan.jpg" alt="" style="max-width: 120px; max-height: 50px; object-fit: contain;" />
                    <div style="font-weight: 600; color: var(--text-dark); font-size: 0.95rem; text-align:center;">Mousan</div>
                </div>

                <!-- Your's -->
                <div class="sponsor-card" style="background: white; border: 1px solid var(--border-color); border-radius: 10px; padding: 1rem; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                    <!-- Remplacer par: assets/img/yours.png -->
                    <img src="assets/img/your's.jpg" alt="" style="max-width: 120px; max-height: 50px; object-fit: contain;" />
                    <div style="font-weight: 600; color: var(--text-dark); font-size: 0.95rem; text-align:center;">Your's</div>
                </div>

                <!-- TK-MEX -->
                <div class="sponsor-card" style="background: white; border: 1px solid var(--border-color); border-radius: 10px; padding: 1rem; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                    <!-- Remplacer par: assets/img/tk-mex.png -->
                    <img src="assets/img/tk-mex.jpg" alt="" style="max-width: 120px; max-height: 50px; object-fit: contain;" />
                    <div style="font-weight: 600; color: var(--text-dark); font-size: 0.95rem; text-align:center;">TK-MEX</div>
                </div>

                <!-- UDM -->
                <div class="sponsor-card" style="background: white; border: 1px solid var(--border-color); border-radius: 10px; padding: 1rem; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                    <img src="assets/img/udm.jpg" alt="UDM" style="max-width: 120px; max-height: 50px; object-fit: contain;" />
                    <div style="font-weight: 600; color: var(--text-dark); font-size: 0.95rem; text-align:center;">UDM</div>
                </div>
            </div>
        </div>
    </section>

</main>

<?php include 'includes/footer.php'; ?>