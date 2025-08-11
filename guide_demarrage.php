<?php
$page_title = "Guide de démarrage";
include 'includes/header.php';
?>

<main class="main-content">
    <!-- En-tête du guide -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%); color: white; padding: 3rem 0;">
        <div class="container">
            <div style="text-align: center;">
                <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">
                    <i class="fas fa-rocket"></i> Guide de démarrage
                </h1>
                <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">
                    Découvrez comment tirer le meilleur parti de la plateforme Mutuelle UDM en quelques étapes simples
                </p>
            </div>
        </div>
    </section>

    <!-- Contenu du guide -->
    <section style="padding: 3rem 0;">
        <div class="container">
            <!-- Étapes du guide -->
            <div style="max-width: 800px; margin: 0 auto;">
                
                <!-- Étape 1 : Inscription -->
                <div style="background: white; border-radius: 10px; box-shadow: var(--shadow); margin-bottom: 2rem; overflow: hidden;">
                    <div style="background: #e3f2fd; padding: 1.5rem; border-left: 4px solid var(--primary-color);">
                        <h2 style="color: var(--primary-color); margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="background: var(--primary-color); color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: bold;">1</span>
                            Créer votre compte
                        </h2>
                    </div>
                    <div style="padding: 2rem;">
                        <p style="margin-bottom: 1.5rem; line-height: 1.6;">
                            Commencez par créer votre compte étudiant pour accéder à tous les services de la Mutuelle UDM.
                        </p>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                            <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px;">
                                <h4 style="color: var(--text-dark); margin: 0 0 0.5rem 0;">
                                    <i class="fas fa-user-plus"></i> Informations requises
                                </h4>
                                <ul style="margin: 0; padding-left: 1rem; color: var(--text-light);">
                                    <li>Nom et prénom</li>
                                    <li>Email valide</li>
                                    <li>Numéro étudiant</li>
                                    <li>Filière et niveau</li>
                                </ul>
                            </div>
                            <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px;">
                                <h4 style="color: var(--text-dark); margin: 0 0 0.5rem 0;">
                                    <i class="fas fa-shield-alt"></i> Sécurité
                                </h4>
                                <ul style="margin: 0; padding-left: 1rem; color: var(--text-light);">
                                    <li>Mot de passe sécurisé</li>
                                    <li>Vérification email</li>
                                    <li>Données protégées</li>
                                </ul>
                            </div>
                        </div>
                        <a href="register.php" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> S'inscrire maintenant
                        </a>
                    </div>
                </div>

                <!-- Étape 2 : Explorer la banque d'épreuves -->
                <div style="background: white; border-radius: 10px; box-shadow: var(--shadow); margin-bottom: 2rem; overflow: hidden;">
                    <div style="background: #e8f5e8; padding: 1.5rem; border-left: 4px solid #4caf50;">
                        <h2 style="color: #4caf50; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="background: #4caf50; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: bold;">2</span>
                            Explorer la banque d'épreuves
                        </h2>
                    </div>
                    <div style="padding: 2rem;">
                        <p style="margin-bottom: 1.5rem; line-height: 1.6;">
                            Accédez à des milliers de documents partagés par la communauté étudiante : examens, cours, TD, TP et plus encore.
                        </p>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                            <div style="text-align: center; padding: 1rem;">
                                <div style="font-size: 2rem; color: #ff9800; margin-bottom: 0.5rem;">
                                    <i class="fas fa-search"></i>
                                </div>
                                <h4 style="margin: 0 0 0.5rem 0;">Rechercher</h4>
                                <p style="font-size: 0.9rem; color: var(--text-light); margin: 0;">Par filière, niveau, matière</p>
                            </div>
                            <div style="text-align: center; padding: 1rem;">
                                <div style="font-size: 2rem; color: #2196f3; margin-bottom: 0.5rem;">
                                    <i class="fas fa-download"></i>
                                </div>
                                <h4 style="margin: 0 0 0.5rem 0;">Télécharger</h4>
                                <p style="font-size: 0.9rem; color: var(--text-light); margin: 0;">Documents gratuits</p>
                            </div>
                            <div style="text-align: center; padding: 1rem;">
                                <div style="font-size: 2rem; color: #9c27b0; margin-bottom: 0.5rem;">
                                    <i class="fas fa-share"></i>
                                </div>
                                <h4 style="margin: 0 0 0.5rem 0;">Partager</h4>
                                <p style="font-size: 0.9rem; color: var(--text-light); margin: 0;">Vos propres documents</p>
                            </div>
                        </div>
                        <a href="bank.php" class="btn btn-primary" style="background-color: #4caf50;">
                            <i class="fas fa-book"></i> Explorer la banque
                        </a>
                    </div>
                </div>

                <!-- Étape 3 : Consulter vos résultats -->
                <div style="background: white; border-radius: 10px; box-shadow: var(--shadow); margin-bottom: 2rem; overflow: hidden;">
                    <div style="background: #fff3e0; padding: 1.5rem; border-left: 4px solid #ff9800;">
                        <h2 style="color: #ff9800; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="background: #ff9800; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: bold;">3</span>
                            Suivre vos résultats
                        </h2>
                    </div>
                    <div style="padding: 2rem;">
                        <p style="margin-bottom: 1.5rem; line-height: 1.6;">
                            Consultez vos notes, moyennes et progression académique en temps réel.
                        </p>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                            <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px; text-align: center;">
                                <div style="font-size: 1.5rem; color: #ff9800; margin-bottom: 0.5rem;">📊</div>
                                <h5 style="margin: 0;">Moyennes</h5>
                            </div>
                            <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px; text-align: center;">
                                <div style="font-size: 1.5rem; color: #ff9800; margin-bottom: 0.5rem;">📈</div>
                                <h5 style="margin: 0;">Progression</h5>
                            </div>
                            <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px; text-align: center;">
                                <div style="font-size: 1.5rem; color: #ff9800; margin-bottom: 0.5rem;">🏆</div>
                                <h5 style="margin: 0;">Crédits</h5>
                            </div>
                        </div>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="results.php" class="btn btn-primary" style="background-color: #ff9800;">
                                <i class="fas fa-chart-line"></i> Voir mes résultats
                            </a>
                        <?php else: ?>
                            <p style="color: var(--text-light); font-style: italic;">
                                <i class="fas fa-info-circle"></i> Connectez-vous pour accéder à vos résultats
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Étape 4 : Communiquer -->
                <div style="background: white; border-radius: 10px; box-shadow: var(--shadow); margin-bottom: 2rem; overflow: hidden;">
                    <div style="background: #f3e5f5; padding: 1.5rem; border-left: 4px solid #9c27b0;">
                        <h2 style="color: #9c27b0; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="background: #9c27b0; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: bold;">4</span>
                            Rejoindre la communauté
                        </h2>
                    </div>
                    <div style="padding: 2rem;">
                        <p style="margin-bottom: 1.5rem; line-height: 1.6;">
                            Échangez avec d'autres étudiants, posez vos questions et participez à la vie de la communauté.
                        </p>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                            <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px;">
                                <h4 style="color: var(--text-dark); margin: 0 0 0.5rem 0;">
                                    <i class="fas fa-comments"></i> Messagerie
                                </h4>
                                <p style="font-size: 0.9rem; color: var(--text-light); margin: 0;">
                                    Échangez en privé avec d'autres étudiants
                                </p>
                            </div>
                            <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px;">
                                <h4 style="color: var(--text-dark); margin: 0 0 0.5rem 0;">
                                    <i class="fas fa-bullhorn"></i> Annonces
                                </h4>
                                <p style="font-size: 0.9rem; color: var(--text-light); margin: 0;">
                                    Restez informé des actualités
                                </p>
                            </div>
                        </div>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="messages.php" class="btn btn-primary" style="background-color: #9c27b0;">
                                <i class="fas fa-comments"></i> Accéder à la messagerie
                            </a>
                        <?php else: ?>
                            <p style="color: var(--text-light); font-style: italic;">
                                <i class="fas fa-info-circle"></i> Connectez-vous pour accéder à la messagerie
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Conseils et astuces -->
                <div style="background: linear-gradient(135deg, #e3f2fd, #f8f9fa); border-radius: 10px; padding: 2rem; margin-bottom: 2rem;">
                    <h2 style="color: var(--primary-color); margin: 0 0 1.5rem 0; text-align: center;">
                        <i class="fas fa-lightbulb"></i> Conseils pour bien commencer
                    </h2>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                        <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                            <h4 style="color: var(--primary-color); margin: 0 0 1rem 0;">
                                <i class="fas fa-user-friends"></i> Soyez actif
                            </h4>
                            <p style="margin: 0; line-height: 1.5; color: var(--text-light);">
                                Plus vous participez en partageant des documents et en aidant les autres, plus vous bénéficierez de la communauté.
                            </p>
                        </div>
                        <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                            <h4 style="color: var(--primary-color); margin: 0 0 1rem 0;">
                                <i class="fas fa-heart"></i> Respectez les autres
                            </h4>
                            <p style="margin: 0; line-height: 1.5; color: var(--text-light);">
                                Maintenez un environnement respectueux et bienveillant pour tous les membres de la communauté.
                            </p>
                        </div>
                        <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                            <h4 style="color: var(--primary-color); margin: 0 0 1rem 0;">
                                <i class="fas fa-question-circle"></i> Demandez de l'aide
                            </h4>
                            <p style="margin: 0; line-height: 1.5; color: var(--text-light);">
                                N'hésitez pas à poser vos questions. La communauté est là pour s'entraider !
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contact et support -->
                <div style="background: white; border-radius: 10px; box-shadow: var(--shadow); padding: 2rem; text-align: center;">
                    <h2 style="color: var(--primary-color); margin: 0 0 1rem 0;">
                        <i class="fas fa-headset"></i> Besoin d'aide ?
                    </h2>
                    <p style="margin-bottom: 1.5rem; color: var(--text-light);">
                        Notre équipe est là pour vous accompagner dans votre découverte de la plateforme.
                    </p>
                    <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                        <a href="mailto:mutuelledesetudiant.udm2025@gmail.com" class="btn btn-secondary">
                            <i class="fas fa-envelope"></i> Email
                        </a>
                        <a href="https://wa.me/237692663126" target="_blank" class="btn btn-secondary">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="messages.php" class="btn btn-primary">
                                <i class="fas fa-comments"></i> Messagerie interne
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
