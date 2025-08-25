<?php
$page_title = "Alumni - Bureau 2020-2025";
include 'includes/header.php';
?>
<h1 style="display:flex;align-items:center;gap:.5rem">
  <!-- Exemple d’icône SVG “graduation hat” -->
  <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
    <path d="M12 3L1 8l11 5 9-4.09V17h2V8L12 3zm0 9L4.5 8.75 12 6l7.5 2.75L12 12zm-5 2.5V18c0 1.66 3.13 3 5 3s5-1.34 5-3v-3.5l-5 2.27-5-2.27z"/>
  </svg>
  <span><?= htmlspecialchars($page_title) ?></span>
</h1>

<!-- CSS spécifique pour Alumni -->
<link rel="stylesheet" href="assets/css/alumni.css">

<main class="main-content">
    <!-- En-tête Alumni -->
    <section style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; padding: 4rem 0;">
        <div class="container">
            <div style="text-align: center;">
                <h1 style="font-size: 3rem; margin-bottom: 1rem; font-weight: bold;">
                    <i class="fas fa-graduation-cap"></i> Alumni UDM
                </h1>
                <p style="font-size: 1.3rem; opacity: 0.9; max-width: 800px; margin: 0 auto 2rem;">
                    Présentation du Bureau de la Mutuelle des Étudiants de l'Université des Montagnes
                </p>
                <div style="background: rgba(255,255,255,0.1); padding: 1rem 2rem; border-radius: 50px; display: inline-block;">
                    <strong style="font-size: 1.2rem;">Mandat 2020 - 2025</strong>
                </div>
            </div>
        </div>
    </section>

    <!-- Bureau Exécutif -->
    <section style="padding: 4rem 0; background: #f8f9fa;">
        <div class="container">
            <h2 style="text-align: center; color: #1e3c72; margin-bottom: 3rem; font-size: 2.5rem;">
                <i class="fas fa-users"></i> Bureau Exécutif 2020-2025
            </h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; max-width: 1200px; margin: 0 auto;">
                
                <!-- Président -->
                <div class="hover-lift" style="background: white; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); overflow: hidden; border-top: 5px solid #ff6b35;">
                    <div style="padding: 2rem;">
                        <div style="text-align: center; margin-bottom: 1.5rem;">
                            <div class="animate-pulse-safe" style="width: 80px; height: 80px; background: linear-gradient(135deg, #ff6b35, #f7931e); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                                <i class="fas fa-crown icon-animate"></i>
                            </div>
                            <h3 style="color: #ff6b35; margin: 0; font-size: 1.1rem; font-weight: bold;">PRÉSIDENT</h3>
                        </div>
                        <div style="text-align: center;">
                            <h4 style="color: #333; margin: 0 0 0.5rem 0; font-size: 1.2rem;">FOSSI FONKOUA JOSPING URICH</h4>
                            <p style="color: #666; margin: 0 0 0.5rem 0;"><strong>Filière :</strong> Pharmacie 5ème année</p>
                            <p style="color: #666; margin: 0;"><strong>Région :</strong> OUEST</p>
                        </div>
                    </div>
                </div>

                <!-- Vice-président N°1 -->
                <div class="hover-lift" style="background: white; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); overflow: hidden; border-top: 5px solid #4ecdc4;">
                    <div style="padding: 2rem;">
                        <div style="text-align: center; margin-bottom: 1.5rem;">
                            <div class="animate-pulse-safe" style="width: 80px; height: 80px; background: linear-gradient(135deg, #4ecdc4, #44a08d); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                                <i class="fas fa-user-tie icon-animate"></i>
                            </div>
                            <h3 style="color: #4ecdc4; margin: 0; font-size: 1.1rem; font-weight: bold;">VICE-PRÉSIDENT N°1</h3>
                        </div>
                        <div style="text-align: center;">
                            <h4 style="color: #333; margin: 0 0 0.5rem 0; font-size: 1.2rem;">FANLE FOTSO ANGE JOYCE</h4>
                            <p style="color: #666; margin: 0 0 0.5rem 0;"><strong>Filière :</strong> Biologie 3ème année</p>
                            <p style="color: #666; margin: 0;"><strong>Région :</strong> OUEST</p>
                        </div>
                    </div>
                </div>

                <!-- Vice-président N°2 -->
                <div style="background: white; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); overflow: hidden; border-top: 5px solid #45b7d1;">
                    <div style="padding: 2rem;">
                        <div style="text-align: center; margin-bottom: 1.5rem;">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #45b7d1, #2196f3); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <h3 style="color: #45b7d1; margin: 0; font-size: 1.1rem; font-weight: bold;">VICE-PRÉSIDENT N°2</h3>
                        </div>
                        <div style="text-align: center;">
                            <h4 style="color: #333; margin: 0 0 0.5rem 0; font-size: 1.2rem;">SALIOU BEN AHMED M. O.</h4>
                            <p style="color: #666; margin: 0 0 0.5rem 0;"><strong>Filière :</strong> FST 4ème année</p>
                            <p style="color: #666; margin: 0;"><strong>Région :</strong> EXTRÊME NORD</p>
                        </div>
                    </div>
                </div>

                <!-- Secrétaire général N°1 -->
                <div style="background: white; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); overflow: hidden; border-top: 5px solid #96ceb4;">
                    <div style="padding: 2rem;">
                        <div style="text-align: center; margin-bottom: 1.5rem;">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #96ceb4, #4caf50); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                                <i class="fas fa-pen"></i>
                            </div>
                            <h3 style="color: #96ceb4; margin: 0; font-size: 1.1rem; font-weight: bold;">SECRÉTAIRE GÉNÉRAL N°1</h3>
                        </div>
                        <div style="text-align: center;">
                            <h4 style="color: #333; margin: 0 0 0.5rem 0; font-size: 1.2rem;">TEKA KANA NOEL MAMU</h4>
                            <p style="color: #666; margin: 0 0 0.5rem 0;"><strong>Filière :</strong> Dentaire 2ème année</p>
                            <p style="color: #666; margin: 0;"><strong>Région :</strong> OUEST</p>
                        </div>
                    </div>
                </div>

                <!-- Secrétaire général N°2 -->
                <div style="background: white; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); overflow: hidden; border-top: 5px solid #feca57;">
                    <div style="padding: 2rem;">
                        <div style="text-align: center; margin-bottom: 1.5rem;">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #feca57, #ff9800); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                                <i class="fas fa-pen"></i>
                            </div>
                            <h3 style="color: #feca57; margin: 0; font-size: 1.1rem; font-weight: bold;">SECRÉTAIRE GÉNÉRAL N°2</h3>
                        </div>
                        <div style="text-align: center;">
                            <h4 style="color: #333; margin: 0 0 0.5rem 0; font-size: 1.2rem;">WABA KENNE MEJEST U.</h4>
                            <p style="color: #666; margin: 0 0 0.5rem 0;"><strong>Filière :</strong> Génie Logiciel 3ème année</p>
                            <p style="color: #666; margin: 0;"><strong>Région :</strong> OUEST</p>
                        </div>
                    </div>
                </div>

                <!-- Trésorier -->
                <div style="background: white; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); overflow: hidden; border-top: 5px solid #a55eea;">
                    <div style="padding: 2rem;">
                        <div style="text-align: center; margin-bottom: 1.5rem;">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #a55eea, #9c27b0); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                                <i class="fas fa-coins"></i>
                            </div>
                            <h3 style="color: #a55eea; margin: 0; font-size: 1.1rem; font-weight: bold;">TRÉSORIER</h3>
                        </div>
                        <div style="text-align: center;">
                            <h4 style="color: #333; margin: 0 0 0.5rem 0; font-size: 1.2rem;">NKAMWA NOUHAM M.I</h4>
                            <p style="color: #666; margin: 0 0 0.5rem 0;"><strong>Filière :</strong> Dentaire 6ème année</p>
                            <p style="color: #666; margin: 0;"><strong>Région :</strong> OUEST</p>
                        </div>
                    </div>
                </div>

                <!-- Trésorier adjoint -->
                <div style="background: white; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); overflow: hidden; border-top: 5px solid #fd79a8;">
                    <div style="padding: 2rem;">
                        <div style="text-align: center; margin-bottom: 1.5rem;">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #fd79a8, #e91e63); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                            <h3 style="color: #fd79a8; margin: 0; font-size: 1.1rem; font-weight: bold;">TRÉSORIER ADJOINT</h3>
                        </div>
                        <div style="text-align: center;">
                            <h4 style="color: #333; margin: 0 0 0.5rem 0; font-size: 1.2rem;">MAGNI BEMYA GRACIA</h4>
                            <p style="color: #666; margin: 0 0 0.5rem 0;"><strong>Filière :</strong> DCF 3ème année</p>
                            <p style="color: #666; margin: 0;"><strong>Région :</strong> OUEST</p>
                        </div>
                    </div>
                </div>

                <!-- Commissaire au compte N°1 -->
                <div style="background: white; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); overflow: hidden; border-top: 5px solid #74b9ff;">
                    <div style="padding: 2rem;">
                        <div style="text-align: center; margin-bottom: 1.5rem;">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #74b9ff, #0984e3); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                                <i class="fas fa-search-dollar"></i>
                            </div>
                            <h3 style="color: #74b9ff; margin: 0; font-size: 1.1rem; font-weight: bold;">COMMISSAIRE AU COMPTE N°1</h3>
                        </div>
                        <div style="text-align: center;">
                            <h4 style="color: #333; margin: 0 0 0.5rem 0; font-size: 1.2rem;">ADIDOUMBE ZAMBO JOSEE E.T</h4>
                            <p style="color: #666; margin: 0 0 0.5rem 0;"><strong>Filière :</strong> Médecine 4ème année</p>
                            <p style="color: #666; margin: 0;"><strong>Région :</strong> CENTRE</p>
                        </div>
                    </div>
                </div>

                <!-- Commissaire au compte N°2 -->
                <div style="background: white; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); overflow: hidden; border-top: 5px solid #55a3ff;">
                    <div style="padding: 2rem;">
                        <div style="text-align: center; margin-bottom: 1.5rem;">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #55a3ff, #2196f3); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                                <i class="fas fa-search-dollar"></i>
                            </div>
                            <h3 style="color: #55a3ff; margin: 0; font-size: 1.1rem; font-weight: bold;">COMMISSAIRE AU COMPTE N°2</h3>
                        </div>
                        <div style="text-align: center;">
                            <h4 style="color: #333; margin: 0 0 0.5rem 0; font-size: 1.2rem;">TETSONK WOA BLESSING</h4>
                            <p style="color: #666; margin: 0 0 0.5rem 0;"><strong>Filière :</strong> Médecine 5ème année</p>
                            <p style="color: #666; margin: 0;"><strong>Région :</strong> SUD OUEST</p>
                        </div>
                    </div>
                </div>

                <!-- Conseiller -->
                <div style="background: white; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); overflow: hidden; border-top: 5px solid #00b894;">
                    <div style="padding: 2rem;">
                        <div style="text-align: center; margin-bottom: 1.5rem;">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #00b894, #00a085); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <h3 style="color: #00b894; margin: 0; font-size: 1.1rem; font-weight: bold;">CONSEILLER</h3>
                        </div>
                        <div style="text-align: center;">
                            <h4 style="color: #333; margin: 0 0 0.5rem 0; font-size: 1.2rem;">AKOUMBA NSOLA CHRISTINE F.</h4>
                            <p style="color: #666; margin: 0 0 0.5rem 0;"><strong>Filière :</strong> Pharmacie 5ème année</p>
                            <p style="color: #666; margin: 0;"><strong>Région :</strong> SUD</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Statistiques du Bureau -->
    <section style="padding: 3rem 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 3rem; font-size: 2.5rem;">
                <i class="fas fa-chart-bar"></i> Représentation Régionale
            </h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; max-width: 800px; margin: 0 auto;">
                <div style="text-align: center; background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 15px;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🏔️</div>
                    <h3 style="margin: 0 0 0.5rem 0; font-size: 1.5rem;">OUEST</h3>
                    <p style="margin: 0; font-size: 1.2rem; font-weight: bold;">7 membres</p>
                </div>
                
                <div style="text-align: center; background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 15px;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🏛️</div>
                    <h3 style="margin: 0 0 0.5rem 0; font-size: 1.5rem;">CENTRE</h3>
                    <p style="margin: 0; font-size: 1.2rem; font-weight: bold;">1 membre</p>
                </div>
                
                <div style="text-align: center; background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 15px;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🌴</div>
                    <h3 style="margin: 0 0 0.5rem 0; font-size: 1.5rem;">SUD</h3>
                    <p style="margin: 0; font-size: 1.2rem; font-weight: bold;">1 membre</p>
                </div>
                
                <div style="text-align: center; background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 15px;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🏜️</div>
                    <h3 style="margin: 0 0 0.5rem 0; font-size: 1.5rem;">EXTRÊME NORD</h3>
                    <p style="margin: 0; font-size: 1.2rem; font-weight: bold;">1 membre</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Activités 2025 -->
    <section style="padding: 4rem 0; background: white;">
        <div class="container">
            <h2 style="text-align: center; color: #1e3c72; margin-bottom: 3rem; font-size: 2.5rem;">
                <i class="fas fa-calendar-alt"></i> Activités Menées en 2025
            </h2>

            <div style="max-width: 1000px; margin: 0 auto;">

                <!-- Timeline des activités -->
                <div style="position: relative;">
                    <!-- Ligne de timeline -->
                    <div style="position: absolute; left: 50%; top: 0; bottom: 0; width: 4px; background: linear-gradient(to bottom, #ff6b35, #4ecdc4, #45b7d1, #96ceb4); transform: translateX(-50%);"></div>

                    <!-- Activité 1 -->
                    <div style="display: flex; align-items: center; margin-bottom: 4rem; position: relative;">
                        <div style="flex: 1; padding-right: 2rem; text-align: right;">
                            <div style="background: #fff; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); padding: 2rem; border-left: 5px solid #ff6b35;">
                                <h3 style="color: #ff6b35; margin: 0 0 1rem 0; font-size: 1.3rem;">
                                    <i class="fas fa-rocket"></i> Lancement de la Plateforme Numérique
                                </h3>
                                <p style="color: #666; margin: 0 0 1rem 0; line-height: 1.6;">
                                    Mise en ligne de la plateforme web de la Mutuelle UDM avec système de messagerie, banque d'épreuves et suivi des résultats académiques.
                                </p>
                                <div style="color: #ff6b35; font-weight: bold;">
                                    <i class="fas fa-calendar"></i> Janvier 2025
                                </div>
                            </div>
                        </div>
                        <div style="width: 60px; height: 60px; background: #ff6b35; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; position: relative; z-index: 2; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <div style="flex: 1; padding-left: 2rem;"></div>
                    </div>

                    <!-- Activité 2 -->
                    <div style="display: flex; align-items: center; margin-bottom: 4rem; position: relative;">
                        <div style="flex: 1; padding-right: 2rem;"></div>
                        <div style="width: 60px; height: 60px; background: #4ecdc4; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; position: relative; z-index: 2; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div style="flex: 1; padding-left: 2rem;">
                            <div style="background: #fff; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); padding: 2rem; border-right: 5px solid #4ecdc4;">
                                <h3 style="color: #4ecdc4; margin: 0 0 1rem 0; font-size: 1.3rem;">
                                    <i class="fas fa-hands-helping"></i> Campagne de Solidarité Étudiante
                                </h3>
                                <p style="color: #666; margin: 0 0 1rem 0; line-height: 1.6;">
                                    Organisation d'une collecte de fonds et de matériel scolaire pour soutenir les étudiants en difficulté financière. Plus de 150 étudiants bénéficiaires.
                                </p>
                                <div style="color: #4ecdc4; font-weight: bold;">
                                    <i class="fas fa-calendar"></i> Février 2025
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activité 3 -->
                    <div style="display: flex; align-items: center; margin-bottom: 4rem; position: relative;">
                        <div style="flex: 1; padding-right: 2rem; text-align: right;">
                            <div style="background: #fff; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); padding: 2rem; border-left: 5px solid #45b7d1;">
                                <h3 style="color: #45b7d1; margin: 0 0 1rem 0; font-size: 1.3rem;">
                                    <i class="fas fa-graduation-cap"></i> Séminaire de Formation Académique
                                </h3>
                                <p style="color: #666; margin: 0 0 1rem 0; line-height: 1.6;">
                                    Organisation de sessions de formation sur les méthodes d'étude efficaces, la gestion du stress et la préparation aux examens. 300+ participants.
                                </p>
                                <div style="color: #45b7d1; font-weight: bold;">
                                    <i class="fas fa-calendar"></i> Mars 2025
                                </div>
                            </div>
                        </div>
                        <div style="width: 60px; height: 60px; background: #45b7d1; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; position: relative; z-index: 2; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            <i class="fas fa-book"></i>
                        </div>
                        <div style="flex: 1; padding-left: 2rem;"></div>
                    </div>

                    <!-- Activité 4 -->
                    <div style="display: flex; align-items: center; margin-bottom: 4rem; position: relative;">
                        <div style="flex: 1; padding-right: 2rem;"></div>
                        <div style="width: 60px; height: 60px; background: #96ceb4; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; position: relative; z-index: 2; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <div style="flex: 1; padding-left: 2rem;">
                            <div style="background: #fff; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); padding: 2rem; border-right: 5px solid #96ceb4;">
                                <h3 style="color: #96ceb4; margin: 0 0 1rem 0; font-size: 1.3rem;">
                                    <i class="fas fa-seedling"></i> Projet Environnemental Campus Vert
                                </h3>
                                <p style="color: #666; margin: 0 0 1rem 0; line-height: 1.6;">
                                    Initiative de reboisement du campus avec plantation de 200 arbres et sensibilisation à l'écologie. Partenariat avec les autorités universitaires.
                                </p>
                                <div style="color: #96ceb4; font-weight: bold;">
                                    <i class="fas fa-calendar"></i> Avril 2025
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activité 5 -->
                    <div style="display: flex; align-items: center; margin-bottom: 4rem; position: relative;">
                        <div style="flex: 1; padding-right: 2rem; text-align: right;">
                            <div style="background: #fff; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); padding: 2rem; border-left: 5px solid #feca57;">
                                <h3 style="color: #feca57; margin: 0 0 1rem 0; font-size: 1.3rem;">
                                    <i class="fas fa-trophy"></i> Tournoi Sportif Inter-Filières
                                </h3>
                                <p style="color: #666; margin: 0 0 1rem 0; line-height: 1.6;">
                                    Organisation du premier tournoi sportif de la mutuelle avec football, basketball et volleyball. 20 équipes participantes, promotion de la cohésion.
                                </p>
                                <div style="color: #feca57; font-weight: bold;">
                                    <i class="fas fa-calendar"></i> Mai 2025
                                </div>
                            </div>
                        </div>
                        <div style="width: 60px; height: 60px; background: #feca57; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; position: relative; z-index: 2; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            <i class="fas fa-futbol"></i>
                        </div>
                        <div style="flex: 1; padding-left: 2rem;"></div>
                    </div>

                    <!-- Activité 6 -->
                    <div style="display: flex; align-items: center; margin-bottom: 4rem; position: relative;">
                        <div style="flex: 1; padding-right: 2rem;"></div>
                        <div style="width: 60px; height: 60px; background: #a55eea; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; position: relative; z-index: 2; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div style="flex: 1; padding-left: 2rem;">
                            <div style="background: #fff; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); padding: 2rem; border-right: 5px solid #a55eea;">
                                <h3 style="color: #a55eea; margin: 0 0 1rem 0; font-size: 1.3rem;">
                                    <i class="fas fa-handshake"></i> Forum Emploi et Entrepreneuriat
                                </h3>
                                <p style="color: #666; margin: 0 0 1rem 0; line-height: 1.6;">
                                    Organisation d'un forum avec 15 entreprises partenaires, ateliers CV, simulations d'entretiens et conférences sur l'entrepreneuriat étudiant.
                                </p>
                                <div style="color: #a55eea; font-weight: bold;">
                                    <i class="fas fa-calendar"></i> Juin 2025
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activité 7 -->
                    <div style="display: flex; align-items: center; margin-bottom: 2rem; position: relative;">
                        <div style="flex: 1; padding-right: 2rem; text-align: right;">
                            <div style="background: #fff; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); padding: 2rem; border-left: 5px solid #fd79a8;">
                                <h3 style="color: #fd79a8; margin: 0 0 1rem 0; font-size: 1.3rem;">
                                    <i class="fas fa-star"></i> Gala de Fin d'Année
                                </h3>
                                <p style="color: #666; margin: 0 0 1rem 0; line-height: 1.6;">
                                    Soirée de gala pour célébrer les réussites de l'année, remise de prix d'excellence académique et reconnaissance des membres actifs de la mutuelle.
                                </p>
                                <div style="color: #fd79a8; font-weight: bold;">
                                    <i class="fas fa-calendar"></i> Décembre 2025
                                </div>
                            </div>
                        </div>
                        <div style="width: 60px; height: 60px; background: #fd79a8; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; position: relative; z-index: 2; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            <i class="fas fa-glass-cheers"></i>
                        </div>
                        <div style="flex: 1; padding-left: 2rem;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bilan et Impact -->
    <section style="padding: 4rem 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 3rem; font-size: 2.5rem;">
                <i class="fas fa-chart-line"></i> Bilan d'Impact 2025
            </h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; max-width: 1000px; margin: 0 auto;">

                <div style="text-align: center; background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 15px; backdrop-filter: blur(10px);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">👥</div>
                    <h3 style="margin: 0 0 0.5rem 0; font-size: 2.5rem; font-weight: bold;">1,200+</h3>
                    <p style="margin: 0; opacity: 0.9;">Étudiants bénéficiaires</p>
                </div>

                <div style="text-align: center; background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 15px; backdrop-filter: blur(10px);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🎯</div>
                    <h3 style="margin: 0 0 0.5rem 0; font-size: 2.5rem; font-weight: bold;">15</h3>
                    <p style="margin: 0; opacity: 0.9;">Projets réalisés</p>
                </div>

                <div style="text-align: center; background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 15px; backdrop-filter: blur(10px);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">💰</div>
                    <h3 style="margin: 0 0 0.5rem 0; font-size: 2.5rem; font-weight: bold;">2.5M</h3>
                    <p style="margin: 0; opacity: 0.9;">FCFA mobilisés</p>
                </div>

                <div style="text-align: center; background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 15px; backdrop-filter: blur(10px);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🤝</div>
                    <h3 style="margin: 0 0 0.5rem 0; font-size: 2.5rem; font-weight: bold;">25</h3>
                    <p style="margin: 0; opacity: 0.9;">Partenariats établis</p>
                </div>

            </div>

            <div style="text-align: center; margin-top: 3rem;">
                <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">
                    "Une ouïe attentive au cri des Udmois" - Notre engagement continue pour le bien-être et la réussite de tous les étudiants de l'Université des Montagnes.
                </p>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
