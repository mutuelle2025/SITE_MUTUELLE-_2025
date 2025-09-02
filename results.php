<?php
require_once 'includes/auth_middleware.php';

// Vérification de l'authentification et des permissions
$user = checkAuth('view_bank', 'etudiant');

// Logger l'accès aux informations sur les filières
logAction($_SESSION['user_id'], 'access_filieres_info', 'Accès aux informations filières et admissions');

// Récupération des filtres pour les documents
$filters = array(
    'search' => trim(isset($_GET['search']) ? $_GET['search'] : ''),
    'filiere' => isset($_GET['filiere']) ? $_GET['filiere'] : '',
    'type_document' => 'information', 
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

            <!-- Actions et boutons -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div>
                    <button type="button" class="btn btn-secondary" onclick="refreshStats()" style="background: rgba(255,255,255,0.2); color:white; border:1px solid rgba(255,255,255,0.4);">
                        <i class="fas fa-sync"></i> Rafraîchir les statistiques
                    </button>
                </div>
                <?php if (isset($_SESSION['user_id']) && hasPermission($_SESSION['user_id'], 'upload_documents')): ?>
                <div>
                    <button type="button" class="btn btn-primary" onclick="showUploadModal()" style="background: rgba(255,255,255,0.2); color:white; border:1px solid rgba(255,255,255,0.4);">
                        <i class="fas fa-plus"></i> Ajouter un document
                    </button>
                </div>
                <?php endif; ?>
            </div>

            <!-- Statistiques rapides -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div style="background: rgba(255,255,255,0.2); padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <div id="stat-total-docs" style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">
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
                    <div id="stat-total-dl" style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">
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
                            <select name="sort" onchange="changeSorting(this.value)" style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 5px;">
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
                        <div class="document-card" style="background: white; border-radius: 15px; box-shadow: var(--shadow); overflow: hidden; transition: var(--transition); display: flex; flex-direction: column;">
                            
                            <!-- En-tête avec dégradé -->
                            <div style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color)); color: white; padding: 1.5rem; position: relative; text-align: center;">
                                <!-- Badge type document -->
                                <div style="position: absolute; top: 1rem; right: 1rem; background: rgba(255,255,255,0.2); padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; font-weight: bold;">
                                    <?php
                                    $types = array(
                                        'examen' => 'EXAMEN',
                                        'cours' => 'COURS',
                                        'td' => 'TD',
                                        'tp' => 'TP',
                                        'information' => 'INFO',
                                        'autre' => 'AUTRE'
                                    );
                                    echo isset($types[$document['type_document']]) ? $types[$document['type_document']] : 'DOCUMENT';
                                    ?>
                                </div>

                                <!-- Icône du type -->
                                <div style="font-size: 2.5rem; margin-bottom: 1rem;">
                                    <?php
                                    switch($document['type_document']) {
                                        case 'examen': echo '<i class="fas fa-file-alt"></i>'; break;
                                        case 'cours': echo '<i class="fas fa-book-open"></i>'; break;
                                        case 'td': echo '<i class="fas fa-tasks"></i>'; break;
                                        case 'tp': echo '<i class="fas fa-flask"></i>'; break;
                                        case 'information': echo '<i class="fas fa-info-circle"></i>'; break;
                                        default: echo '<i class="fas fa-file"></i>'; break;
                                    }
                                    ?>
                                </div>

                                <!-- Titre -->
                                <h3 style="margin: 0; font-size: 1.2rem; line-height: 1.3;">
                                    <?php echo htmlspecialchars($document['title']); ?>
                                </h3>
                            </div>

                            <!-- Contenu du document -->
                            <div style="padding: 1.5rem;">
                                <!-- Informations académiques -->
                                <div style="display: flex; gap: 1rem; margin-bottom: 1rem; font-size: 0.9rem;">
                                    <span style="background: #e3f2fd; color: #1565c0; padding: 0.25rem 0.75rem; border-radius: 15px;">
                                        <i class="fas fa-graduation-cap"></i> <?php echo htmlspecialchars($document['filiere']); ?>
                                    </span>
                                    <?php if (!empty($document['niveau'])): ?>
                                        <span style="background: #e8f5e8; color: #2e7d32; padding: 0.25rem 0.75rem; border-radius: 15px;">
                                            <i class="fas fa-layer-group"></i> <?php echo htmlspecialchars($document['niveau']); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <?php if (!empty($document['matiere'])): ?>
                                    <div style="margin-bottom: 1rem;">
                                        <span style="background: #fff3e0; color: #f57c00; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.9rem;">
                                            <i class="fas fa-book"></i> <?php echo htmlspecialchars($document['matiere']); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <!-- Description -->
                                <?php if (!empty($document['description'])): ?>
                                    <p style="color: var(--text-light); margin-bottom: 1rem; line-height: 1.5;">
                                        <?php echo htmlspecialchars(substr($document['description'], 0, 120)) . (strlen($document['description']) > 120 ? '...' : ''); ?>
                                    </p>
                                <?php endif; ?>

                                <!-- Métadonnées -->
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.9rem; color: var(--text-light);">
                                    <div>
                                        <i class="fas fa-user"></i> <?php echo htmlspecialchars($document['prenom'] . ' ' . substr($document['nom'], 0, 1) . '.'); ?>
                                    </div>
                                    <div>
                                        <i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($document['created_at'])); ?>
                                    </div>
                                </div>

                                <!-- Statistiques -->
                                <div style="display: flex; gap: 1rem; font-size: 0.9rem; color: var(--text-light); margin-bottom: 1.5rem;">
                                    <span><i class="fas fa-download"></i> <?php echo number_format($document['downloads']); ?></span>
                                    <span><i class="fas fa-file"></i> <?php echo strtoupper($document['file_type']); ?></span>
                                    <span><i class="fas fa-weight"></i> <?php echo formatFileSize($document['file_size']); ?></span>
                                </div>
                            </div>

                            <!-- Actions en bas de carte -->
                            <div style="padding: 0 1.5rem 1.5rem 1.5rem; border-top: 1px solid #eee; margin-top: auto;">
                                <div style="display: flex; gap: 0.5rem; justify-content: center; padding-top: 1rem;">
                                    <button onclick="previewDocument(<?php echo $document['id']; ?>)" class="btn btn-secondary" style="padding: 0.5rem 1rem;" title="Prévisualiser">
                                        <i class="fas fa-eye"></i> Prévisualiser
                                    </button>
                                    <?php if (isset($_SESSION['user_id'])): ?>
                                        <button onclick="downloadDocument(<?php echo $document['id']; ?>)" class="btn btn-primary" style="padding: 0.5rem 1rem;" title="Télécharger">
                                            <i class="fas fa-download"></i> Télécharger
                                        </button>
                                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'etudiant'): ?>
                                            <?php if ($_SESSION['user_role'] === 'moderateur'): ?>
                                                <?php if ($document['user_id'] == $_SESSION['user_id']): ?>
                                                    <button onclick="deleteDocument(<?php echo $document['id']; ?>, this.closest('.document-card'))" 
                                                            class="btn btn-danger" 
                                                            style="padding: 0.5rem 1rem;"
                                                            title="Supprimer">
                                                        <i class="fas fa-trash"></i> Supprimer
                                                    </button>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <!-- Admin et super_admin peuvent supprimer tous les documents -->
                                                <button onclick="deleteDocument(<?php echo $document['id']; ?>, this.closest('.document-card'))" 
                                                        class="btn btn-danger" 
                                                        style="padding: 0.5rem 1rem;"
                                                        title="Supprimer">
                                                    <i class="fas fa-trash"></i> Supprimer
                                                </button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a href="login.php" class="btn btn-secondary" style="padding: 0.5rem 1rem;" title="Se connecter">
                                            <i class="fas fa-lock"></i> Se connecter
                                        </a>
                                    <?php endif; ?>
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

<?php
// Fonction helper pour formater la taille des fichiers
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' B';
    }
}
?>

<script>
// Aperçu des documents (utilise la même méthode que bank.php)
function previewDocument(documentId) {
    const width = Math.min(window.innerWidth * 0.9, 1000);
    const height = Math.min(window.innerHeight * 0.9, 800);
    const w = window.open('', '_blank', `width=${width},height=${height},resizable=yes,scrollbars=yes`);
    if (!w) {
        showNotification("Veuillez autoriser les fenêtres pop-up pour l'aperçu.", 'error');
        return;
    }
    w.document.write('<!doctype html><title>Aperçu</title><style>html,body{height:100%;margin:0}iframe{width:100%;height:100%;border:0}</style><iframe src="about:blank"></iframe>');
    const iframe = w.document.querySelector('iframe');
    iframe.src = 'api/preview_content.php?document_id=' + encodeURIComponent(documentId);
}

// Fonction pour changer le tri
function changeSorting(sortBy) {
    const url = new URL(window.location);
    url.searchParams.set('sort', sortBy);
    url.searchParams.delete('page'); // Reset pagination
    window.location.href = url.toString();
}

// Auto-submit du formulaire de filtre quand on change les sélections
document.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('#filterForm select');
    selects.forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });

    // Effet hover sur les cartes de documents
    const cards = document.querySelectorAll('[style*="background: white"][style*="border-radius: 15px"]');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 10px 30px rgba(0,0,0,0.15)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'var(--shadow)';
        });
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

    // Observer toutes les cartes de documents avec animation d'entrée
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});

// Rafraîchir les stats
function refreshStats() {
    fetch('api/refresh_bank_stats.php', { credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                document.getElementById('stat-total-docs').textContent = new Intl.NumberFormat().format(data.stats.total_documents);
                document.getElementById('stat-total-dl').textContent = new Intl.NumberFormat().format(data.stats.total_downloads);
                showNotification('Statistiques mises à jour', 'success');
            } else {
                showNotification(data.message || 'Échec de la mise à jour des statistiques', 'error');
            }
        })
        .catch(() => showNotification('Erreur réseau lors de la mise à jour', 'error'));
}

// Fonction pour afficher la modal d'upload
function showUploadModal() {
    window.location.href = 'upload_document.php';
}


// Fonction pour supprimer un document
function deleteDocument(documentId, cardElement) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce document ? Cette action est irréversible.')) {
        return;
    }

    // Désactiver le bouton pendant la suppression
    const deleteBtn = cardElement.querySelector('button[onclick*="deleteDocument"]');
    if (deleteBtn) {
        deleteBtn.disabled = true;
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Suppression...';
    }

    fetch('api/delete_document.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            document_id: documentId
        }),
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Erreur HTTP: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Animation de suppression
            cardElement.style.transition = 'all 0.3s ease';
            cardElement.style.opacity = '0';
            cardElement.style.transform = 'translateX(100%)';
            
            setTimeout(() => {
                cardElement.remove();
                showNotification('Document supprimé avec succès', 'success');
                
                // Vérifier s'il reste des documents
                const container = document.querySelector('[style*="grid-template-columns: repeat(auto-fill, minmax(350px, 1fr))"]');
                if (container && container.children.length === 0) {
                    location.reload(); // Recharger pour afficher le message "aucun document"
                }
            }, 300);
        } else {
            throw new Error(data.message || 'Erreur lors de la suppression');
        }
    })
    .catch(error => {
        console.error('Erreur suppression:', error);
        showNotification('Erreur: ' + error.message, 'error');
        
        // Réactiver le bouton en cas d'erreur
        if (deleteBtn) {
            deleteBtn.disabled = false;
            deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
        }
    });
}

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
