<?php
require_once 'includes/auth_middleware.php';

// Vérification de l'authentification et des permissions
$user = checkAuth('view_bank', 'etudiant');

// Logger l'accès aux informations sur les filières
logAction($_SESSION['user_id'], 'access_filieres_info', 'Accès aux informations filières et admissions');

// Récupération des filtres pour les documents d'information
$filters = array(
    'search' => trim(isset($_GET['search']) ? $_GET['search'] : ''),
    'filiere' => isset($_GET['filiere']) ? $_GET['filiere'] : '',
    'type_document' => 'information', // Filtrer uniquement les documents d'information
    'sort' => isset($_GET['sort']) ? $_GET['sort'] : 'recent'
);

// Pagination
$page = max(1, intval(isset($_GET['page']) ? $_GET['page'] : 1));
$limit = 12;

// Récupération des documents d'information sur les filières
$documents = getDocuments($filters, $page, $limit);
$total_documents = countDocuments($filters);
$total_pages = ceil($total_documents / $limit);

// Récupération des options pour les filtres
$filieres = getAvailableFilieres();
$stats = getBankStatistics();

$page_title = "Filières et Admissions UDM";
include 'includes/header.php';
?>

<main class="main-content">
    <!-- En-tête des filières et admissions -->
    <section style="background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%); color: white; padding: 3rem 0;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">
                    <i class="fas fa-graduation-cap"></i> Filières et Admissions UDM
                </h1>
                <p style="font-size: 1.2rem; opacity: 0.9;">
                    Découvrez les filières disponibles et les informations d'admission à l'Université des Montagnes
                </p>
            </div>

            <!-- Statistiques rapides -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div style="background: rgba(255,255,255,0.2); padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">
                        <?php echo number_format($total_documents); ?>
                    </div>
                    <div style="opacity: 0.9;">Documents d'information</div>
                </div>
                <div style="background: rgba(255,255,255,0.2); padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">
                        <?php echo count($filieres); ?>
                    </div>
                    <div style="opacity: 0.9;">Filières disponibles</div>
                </div>
                <div style="background: rgba(255,255,255,0.2); padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">
                        <?php echo number_format($stats['total_downloads']); ?>
                    </div>
                    <div style="opacity: 0.9;">Téléchargements</div>
                </div>
                <div style="background: rgba(255,255,255,0.2); padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">
                        2025
                    </div>
                    <div style="opacity: 0.9;">Année académique</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filtres et recherche -->
    <section style="background: #f8f9fa; padding: 2rem 0;">
        <div class="container">
            <form method="GET" action="" id="filterForm">
                <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: var(--shadow);">
                    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">
                        <i class="fas fa-filter"></i> Rechercher et filtrer
                    </h3>

                    <!-- Barre de recherche -->
                    <div style="margin-bottom: 1.5rem;">
                        <div style="position: relative;">
                            <input
                                type="text"
                                name="search"
                                placeholder="Rechercher des documents d'information..."
                                value="<?php echo htmlspecialchars($filters['search']); ?>"
                                style="width: 100%; padding: 1rem 3rem 1rem 1rem; border: 2px solid var(--border-color); border-radius: 5px; font-size: 1rem;"
                            >
                            <button type="submit" style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: var(--primary-color); color: white; border: none; padding: 0.5rem 1rem; border-radius: 3px; cursor: pointer;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Filtres -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: bold; color: var(--text-dark);">Filière</label>
                            <select name="filiere" style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 5px;">
                                <option value="">Toutes les filières</option>
                                <?php foreach ($filieres as $filiere): ?>
                                    <option value="<?php echo htmlspecialchars($filiere); ?>"
                                            <?php echo $filters['filiere'] === $filiere ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars(ucfirst($filiere)); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: bold; color: var(--text-dark);">Trier par</label>
                            <select name="sort" style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 5px;">
                                <option value="recent" <?php echo $filters['sort'] === 'recent' ? 'selected' : ''; ?>>Plus récent</option>
                                <option value="popular" <?php echo $filters['sort'] === 'popular' ? 'selected' : ''; ?>>Plus téléchargé</option>
                                <option value="title" <?php echo $filters['sort'] === 'title' ? 'selected' : ''; ?>>Titre A-Z</option>
                            </select>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div style="display: flex; gap: 1rem; justify-content: space-between; align-items: center;">
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Rechercher
                            </button>
                            <a href="results.php" class="btn btn-secondary" style="margin-left: 0.5rem;">
                                <i class="fas fa-times"></i> Réinitialiser
                            </a>
                        </div>
                        <div style="color: var(--text-light); font-size: 0.9rem;">
                            <?php echo number_format($total_documents); ?> document(s) trouvé(s)
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Documents d'information -->
    <section style="padding: 2rem 0;">
        <div class="container">
            <?php if (empty($documents)): ?>
                <!-- Aucun document -->
                <div style="text-align: center; padding: 3rem; background: white; border-radius: 10px; box-shadow: var(--shadow);">
                    <div style="font-size: 4rem; color: var(--text-light); margin-bottom: 1rem;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 style="color: var(--text-dark); margin-bottom: 1rem;">Aucun document disponible</h3>
                    <p style="color: var(--text-light); margin-bottom: 2rem;">
                        Aucun document d'information sur les filières et admissions n'a été trouvé.
                        Essayez de modifier vos critères de recherche.
                    </p>
                    <a href="results.php" class="btn btn-primary">Réinitialiser les filtres</a>
                </div>
            <?php else: ?>
                <!-- Grille des documents -->
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                    <?php foreach ($documents as $document): ?>
                        <div style="background: white; border-radius: 15px; box-shadow: var(--shadow); overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease;" 
                             onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.15)';"
                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow)';">
                            
                            <!-- En-tête du document -->
                            <div style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color)); color: white; padding: 1.5rem; position: relative;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                                    <div style="flex: 1;">
                                        <h3 style="margin: 0 0 0.5rem 0; font-size: 1.2rem; line-height: 1.3;">
                                            <?php echo htmlspecialchars($document['title']); ?>
                                        </h3>
                                        <div style="opacity: 0.9; font-size: 0.9rem;">
                                            <i class="fas fa-user"></i> <?php echo htmlspecialchars($document['prenom'] . ' ' . $document['nom']); ?>
                                        </div>
                                    </div>
                                    <div style="background: rgba(255,255,255,0.2); padding: 0.5rem; border-radius: 50%; margin-left: 1rem;">
                                        <i class="fas fa-file-alt" style="font-size: 1.5rem;"></i>
                                    </div>
                                </div>
                                
                                <!-- Badges -->
                                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                    <span style="background: rgba(255,255,255,0.2); padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem;">
                                        <i class="fas fa-graduation-cap"></i> <?php echo htmlspecialchars(ucfirst($document['filiere'])); ?>
                                    </span>
                                    <?php if ($document['niveau']): ?>
                                        <span style="background: rgba(255,255,255,0.2); padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem;">
                                            <i class="fas fa-layer-group"></i> <?php echo htmlspecialchars($document['niveau']); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Contenu du document -->
                            <div style="padding: 1.5rem;">
                                <p style="color: var(--text-light); margin-bottom: 1.5rem; line-height: 1.6; font-size: 0.95rem;">
                                    <?php echo htmlspecialchars(substr($document['description'], 0, 120)) . (strlen($document['description']) > 120 ? '...' : ''); ?>
                                </p>

                                <!-- Métadonnées -->
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                                    <div style="text-align: center;">
                                        <div style="font-weight: bold; color: var(--primary-color); font-size: 1.1rem;">
                                            <?php echo number_format($document['downloads']); ?>
                                        </div>
                                        <div style="font-size: 0.8rem; color: var(--text-light);">
                                            <i class="fas fa-download"></i> Téléchargements
                                        </div>
                                    </div>
                                    <div style="text-align: center;">
                                        <div style="font-weight: bold; color: var(--primary-color); font-size: 1.1rem;">
                                            <?php echo number_format($document['file_size'] / 1024 / 1024, 1); ?> MB
                                        </div>
                                        <div style="font-size: 0.8rem; color: var(--text-light);">
                                            <i class="fas fa-file"></i> Taille
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="api/download_document.php?id=<?php echo $document['id']; ?>" 
                                       class="btn btn-primary" style="flex: 1; text-align: center; text-decoration: none;">
                                        <i class="fas fa-download"></i> Télécharger
                                    </a>
                                    <button onclick="showDocumentPreview(<?php echo $document['id']; ?>)" 
                                            class="btn btn-secondary" style="padding: 0.75rem;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                                <!-- Date -->
                                <div style="text-align: center; margin-top: 1rem; font-size: 0.8rem; color: var(--text-light);">
                                    <i class="fas fa-calendar"></i> Ajouté le <?php echo date('d/m/Y', strtotime($document['created_at'])); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <div style="display: flex; justify-content: center; align-items: center; gap: 0.5rem; margin-top: 2rem;">
                        <?php if ($page > 1): ?>
                            <a href="?<?php echo http_build_query(array_merge($filters, ['page' => $page - 1])); ?>" 
                               class="btn btn-secondary">
                                <i class="fas fa-chevron-left"></i> Précédent
                            </a>
                        <?php endif; ?>

                        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                            <a href="?<?php echo http_build_query(array_merge($filters, ['page' => $i])); ?>" 
                               class="btn <?php echo $i === $page ? 'btn-primary' : 'btn-secondary'; ?>" 
                               style="min-width: 40px;">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="?<?php echo http_build_query(array_merge($filters, ['page' => $page + 1])); ?>" 
                               class="btn btn-secondary">
                                Suivant <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>
</main>

<!-- Modal pour prévisualisation des documents -->
<div id="previewModal" class="modal" style="display: none;">
    <div class="modal-content" style="max-width: 800px;">
        <div class="modal-header">
            <h3><i class="fas fa-eye"></i> Aperçu du document</h3>
            <span class="modal-close">&times;</span>
        </div>
        <div class="modal-body" id="previewModalBody">
            <!-- Contenu chargé dynamiquement -->
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
// Fonction pour prévisualiser un document
function showDocumentPreview(documentId) {
    const modal = document.getElementById('previewModal');
    const modalBody = document.getElementById('previewModalBody');

    // Afficher un loader
    modalBody.innerHTML = '<div style="text-align: center; padding: 2rem;"><i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--primary-color);"></i><br><br>Chargement de l\'aperçu...</div>';
    modal.style.display = 'flex';

    // Charger l'aperçu via AJAX
    fetch(`api/get_document_preview.php?id=${documentId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                modalBody.innerHTML = data.html;
            } else {
                modalBody.innerHTML = '<div style="text-align: center; padding: 2rem; color: var(--text-light);">Aperçu non disponible pour ce document.</div>';
            }
        })
        .catch(error => {
            modalBody.innerHTML = '<div style="text-align: center; padding: 2rem; color: #f44336;">Erreur lors du chargement de l\'aperçu.</div>';
        });
}

// Gestion des modals
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('previewModal');
    const closeButton = document.querySelector('.modal-close');

    if (closeButton) {
        closeButton.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }

    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Animation des cartes au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observer toutes les cartes de documents
    document.querySelectorAll('[style*="background: white"][style*="border-radius: 15px"]').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});

// Fonction de notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;

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

    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);

    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}
</script>
                                                    EN COURS
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Progression visuelle -->
                                        <div style="width: 60px;">
                                            <?php if ($matiere['moyenne_matiere']): ?>
                                                <div style="background: #e0e0e0; height: 8px; border-radius: 4px; overflow: hidden;">
                                                    <div style="background: <?php echo $matiere['moyenne_matiere'] >= 10 ? '#4caf50' : '#f44336'; ?>;
                                                                height: 100%; width: <?php echo min(100, ($matiere['moyenne_matiere'] / 20) * 100); ?>%;
                                                                transition: width 0.3s ease;"></div>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Actions -->
                                        <div>
                                            <button onclick="showDetailedNotes(<?php echo $matiere['inscription_id']; ?>)"
                                                    class="btn btn-secondary" style="padding: 0.5rem;">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</main>

<!-- Modal pour les notes détaillées -->
<div id="notesModal" class="modal" style="display: none;">
    <div class="modal-content" style="max-width: 800px;">
        <div class="modal-header">
            <h3><i class="fas fa-list-alt"></i> Notes détaillées</h3>
            <span class="modal-close">&times;</span>
        </div>
        <div class="modal-body" id="notesModalBody">
            <!-- Contenu chargé dynamiquement -->
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
// Fonction pour filtrer par semestre
function filterBySemestre(semestreId) {
    const url = new URL(window.location);
    if (semestreId) {
        url.searchParams.set('semestre', semestreId);
    } else {
        url.searchParams.delete('semestre');
    }
    window.location.href = url.toString();
}

// Fonction pour exporter en PDF
function exportResults() {
    // TODO: Implémenter l'export PDF
    showNotification('Fonctionnalité d\'export PDF en cours de développement', 'info');
}

// Fonction pour afficher les notes détaillées
function showDetailedNotes(inscriptionId) {
    const modal = document.getElementById('notesModal');
    const modalBody = document.getElementById('notesModalBody');

    // Afficher un loader
    modalBody.innerHTML = '<div style="text-align: center; padding: 2rem;"><i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--primary-color);"></i><br><br>Chargement des notes...</div>';
    modal.style.display = 'flex';

    // Charger les notes via AJAX
    fetch(`api/get_detailed_notes.php?inscription_id=${inscriptionId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                modalBody.innerHTML = data.html;
            } else {
                modalBody.innerHTML = '<div style="text-align: center; padding: 2rem; color: var(--text-light);">Aucune note disponible pour cette matière.</div>';
            }
        })
        .catch(error => {
            modalBody.innerHTML = '<div style="text-align: center; padding: 2rem; color: #f44336;">Erreur lors du chargement des notes.</div>';
        });
}

// Gestion des modals
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('notesModal');
    const closeButton = document.querySelector('.modal-close');

    closeButton.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});

// Fonction de notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;

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

    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);

    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            {{ ... }}
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}
</script>