<?php
require_once 'includes/auth_middleware.php';

// Vérification de l'authentification et des permissions
$user = checkAuth('view_bank', 'etudiant');

// Logger l'accès à la banque d'épreuves
logAction($_SESSION['user_id'], 'access_bank', 'Accès à la banque d\'épreuves');

// Récupération des filtres
$filters = array(
    'search' => trim(isset($_GET['search']) ? $_GET['search'] : ''),
    'filiere' => isset($_GET['filiere']) ? $_GET['filiere'] : '',
    'niveau' => isset($_GET['niveau']) ? $_GET['niveau'] : '',
    'matiere' => isset($_GET['matiere']) ? $_GET['matiere'] : '',
    'type_document' => isset($_GET['type_document']) ? $_GET['type_document'] : '',
    'sort' => isset($_GET['sort']) ? $_GET['sort'] : 'recent'
);

// Pagination
$page = max(1, intval(isset($_GET['page']) ? $_GET['page'] : 1));
$limit = 12;

// Récupération des données
$documents = getDocuments($filters, $page, $limit);
$total_documents = countDocuments($filters);
$total_pages = ceil($total_documents / $limit);

// Récupération des options pour les filtres
$filieres = getAvailableFilieres();
$niveaux = getAvailableNiveaux();
$matieres = getAvailableMatieres();
$stats = getBankStatistics();

$page_title = "Banque d'Épreuves";
include 'includes/header.php';
?>

<main class="main-content">
    <!-- En-tête de la banque d'épreuves -->
    <section style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%); color: white; padding: 3rem 0;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">
                    <i class="fas fa-book"></i> Banque d'Épreuves UDM
                </h1>
                <p style="font-size: 1.2rem; opacity: 0.9;">
                    Accédez à plus de <?php echo number_format($stats['total_documents']); ?> documents partagés par la communauté
                </p>
                <div>
                    <button type="button" class="btn btn-secondary" onclick="refreshStats()" style="background: rgba(255,255,255,0.2); color:white; border:1px solid rgba(255,255,255,0.4); margin-top:0.5rem;">
                        <i class="fas fa-sync"></i> Rafraîchir les statistiques
                    </button>
                </div>
            </div>

            <!-- Statistiques rapides -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div style="background: rgba(255,255,255,0.2); padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <div id="stat-total-docs" style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">
                        <?php echo number_format($stats['total_documents']); ?>
                    </div>
                    <div style="opacity: 0.9;">Documents disponibles</div>
                </div>
                <div style="background: rgba(255,255,255,0.2); padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <div id="stat-total-dl" style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">
                        <?php echo number_format($stats['total_downloads']); ?>
                    </div>
                    <div style="opacity: 0.9;">Téléchargements</div>
                </div>
                <div style="background: rgba(255,255,255,0.2); padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">
                        <?php echo count($filieres); ?>
                    </div>
                    <div style="opacity: 0.9;">Filières couvertes</div>
                </div>
                <div style="background: rgba(255,255,255,0.2); padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">
                        <?php echo count($matieres); ?>
                    </div>
                    <div style="opacity: 0.9;">Matières disponibles</div>
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
                                value="<?php echo htmlspecialchars($filters['search']); ?>"
                                placeholder="Rechercher par titre, description ou matière..."
                                style="width: 100%; padding: 0.75rem 3rem 0.75rem 1rem; border: 2px solid var(--border-color); border-radius: 25px; font-size: 1rem;"
                            >
                            <button type="submit" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: var(--primary-color); color: white; border: none; padding: 0.5rem 1rem; border-radius: 20px; cursor: pointer;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Filtres -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-dark);">Filière</label>
                            <select name="filiere" class="form-select">
                                <option value="">Toutes les filières</option>
                                <?php foreach ($filieres as $filiere): ?>
                                    <option value="<?php echo htmlspecialchars($filiere); ?>"
                                            <?php echo $filters['filiere'] === $filiere ? 'selected' : ''; ?>>
                                        <?php echo ucfirst(htmlspecialchars($filiere)); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-dark);">Niveau</label>
                            <select name="niveau" class="form-select">
                                <option value="">Tous les niveaux</option>
                                <?php foreach ($niveaux as $niveau): ?>
                                    <option value="<?php echo htmlspecialchars($niveau); ?>"
                                            <?php echo $filters['niveau'] === $niveau ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($niveau); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-dark);">Matière</label>
                            <select name="matiere" class="form-select">
                                <option value="">Toutes les matières</option>
                                <?php foreach ($matieres as $matiere): ?>
                                    <option value="<?php echo htmlspecialchars($matiere); ?>"
                                            <?php echo $filters['matiere'] === $matiere ? 'selected' : ''; ?>>
                                        <?php echo ucfirst(htmlspecialchars($matiere)); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-dark);">Type</label>
                            <select name="type_document" class="form-select">
                                <option value="">Tous les types</option>
                                <option value="examen" <?php echo $filters['type_document'] === 'examen' ? 'selected' : ''; ?>>Examens</option>
                                <option value="cours" <?php echo $filters['type_document'] === 'cours' ? 'selected' : ''; ?>>Cours</option>
                                <option value="td" <?php echo $filters['type_document'] === 'td' ? 'selected' : ''; ?>>TD</option>
                                <option value="tp" <?php echo $filters['type_document'] === 'tp' ? 'selected' : ''; ?>>TP</option>
                                <option value="autre" <?php echo $filters['type_document'] === 'autre' ? 'selected' : ''; ?>>Autre</option>
                            </select>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div style="margin-top: 1.5rem; display: flex; gap: 1rem; justify-content: space-between; align-items: center;">
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Rechercher
                            </button>
                            <a href="bank.php" class="btn btn-secondary" style="margin-left: 0.5rem;">
                                <i class="fas fa-times"></i> Effacer
                            </a>
                        </div>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <button type="button" class="btn btn-primary" onclick="showUploadModal()" style="background-color: #ff9800;">
                                <i class="fas fa-plus"></i> Ajouter un document
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Résultats -->
    <section style="padding: 2rem 0;">
        <div class="container">
            <?php if (isset($_GET['uploaded']) && $_GET['uploaded'] == '1'): ?>
                <div class="alert alert-success" style="margin-bottom: 2rem;">
                    <i class="fas fa-check-circle"></i>
                    <strong>Document partagé avec succès !</strong> Merci pour votre contribution à la communauté UDM.
                </div>
            <?php endif; ?>
            <!-- En-tête des résultats -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div>
                    <h2 style="color: var(--primary-color); margin: 0;">
                        Documents trouvés
                    </h2>
                    <p style="color: var(--text-light); margin: 0.5rem 0 0 0;">
                        <?php echo number_format($total_documents); ?> document(s)
                        <?php
                        $has_filters = false;
                        $filter_keys = array('search', 'filiere', 'niveau', 'matiere', 'type_document');
                        foreach ($filter_keys as $key) {
                            if (!empty($filters[$key])) {
                                $has_filters = true;
                                break;
                            }
                        }
                        if ($has_filters): ?>
                            correspondant à vos critères
                        <?php else: ?>
                            disponible(s)
                        <?php endif; ?>
                    </p>
                </div>

                <!-- Tri -->
                <div>
                    <select onchange="changeSorting(this.value)" style="padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px;">
                        <option value="recent" <?php echo ($filters['sort'] === 'recent') ? 'selected' : ''; ?>>Plus récents</option>
                        <option value="popular" <?php echo ($filters['sort'] === 'popular') ? 'selected' : ''; ?>>Plus téléchargés</option>
                        <option value="title" <?php echo ($filters['sort'] === 'title') ? 'selected' : ''; ?>>Par titre</option>
                    </select>
                </div>
            </div>

            <?php if (empty($documents)): ?>
                <!-- Aucun document trouvé -->
                <div style="text-align: center; padding: 3rem; background: white; border-radius: 10px; box-shadow: var(--shadow);">
                    <div style="font-size: 4rem; color: var(--text-light); margin-bottom: 1rem;">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 style="color: var(--text-dark); margin-bottom: 1rem;">Aucun document trouvé</h3>
                    <p style="color: var(--text-light); margin-bottom: 2rem;">
                        Essayez de modifier vos critères de recherche ou
                        <?php if (isset($_SESSION['user_id'])): ?>
                            soyez le premier à partager un document dans cette catégorie !
                        <?php else: ?>
                            <a href="login.php">connectez-vous</a> pour accéder à plus de contenu.
                        <?php endif; ?>
                    </p>
                    <a href="bank.php" class="btn btn-primary">Voir tous les documents</a>
                </div>
            <?php else: ?>
                <!-- Grille des documents -->
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;">
                    <?php foreach ($documents as $doc): ?>
                        <div class="document-card" style="background: white; border-radius: 10px; box-shadow: var(--shadow); overflow: hidden; transition: var(--transition);">
                            <!-- En-tête du document -->
                            <div style="background: linear-gradient(135deg,
                                <?php
                                switch($doc['type_document']) {
                                    case 'examen': echo 'var(--primary-color), var(--accent-color)'; break;
                                    case 'cours': echo '#2196f3, #64b5f6'; break;
                                    case 'td': echo '#ff9800, #ffb74d'; break;
                                    case 'tp': echo '#9c27b0, #ba68c8'; break;
                                    default: echo '#607d8b, #90a4ae'; break;
                                }
                                ?>); color: white; padding: 1.5rem; position: relative;">

                                <!-- Badge du type -->
                                <div style="position: absolute; top: 1rem; right: 1rem; background: rgba(255,255,255,0.2); padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; font-weight: bold;">
                                    <?php
                                    $types = array(
                                        'examen' => 'EXAMEN',
                                        'cours' => 'COURS',
                                        'td' => 'TD',
                                        'tp' => 'TP',
                                        'autre' => 'AUTRE'
                                    );
                                    echo isset($types[$doc['type_document']]) ? $types[$doc['type_document']] : 'DOCUMENT';
                                    ?>
                                </div>

                                <!-- Icône du type -->
                                <div style="font-size: 2.5rem; margin-bottom: 1rem;">
                                    <?php
                                    switch($doc['type_document']) {
                                        case 'examen': echo '<i class="fas fa-file-alt"></i>'; break;
                                        case 'cours': echo '<i class="fas fa-book-open"></i>'; break;
                                        case 'td': echo '<i class="fas fa-tasks"></i>'; break;
                                        case 'tp': echo '<i class="fas fa-flask"></i>'; break;
                                        default: echo '<i class="fas fa-file"></i>'; break;
                                    }
                                    ?>
                                </div>

                                <!-- Titre -->
                                <h3 style="margin: 0; font-size: 1.2rem; line-height: 1.3;">
                                    <?php echo htmlspecialchars($doc['title']); ?>
                                </h3>
                            </div>

                            <!-- Contenu du document -->
                            <div style="padding: 1.5rem;">
                                <!-- Informations académiques -->
                                <div style="display: flex; gap: 1rem; margin-bottom: 1rem; font-size: 0.9rem;">
                                    <span style="background: #e3f2fd; color: #1565c0; padding: 0.25rem 0.75rem; border-radius: 15px;">
                                        <i class="fas fa-graduation-cap"></i> <?php echo htmlspecialchars($doc['filiere']); ?>
                                    </span>
                                    <span style="background: #e8f5e8; color: #2e7d32; padding: 0.25rem 0.75rem; border-radius: 15px;">
                                        <i class="fas fa-layer-group"></i> <?php echo htmlspecialchars($doc['niveau']); ?>
                                    </span>
                                </div>

                                <?php if (!empty($doc['matiere'])): ?>
                                    <div style="margin-bottom: 1rem;">
                                        <span style="background: #fff3e0; color: #f57c00; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.9rem;">
                                            <i class="fas fa-book"></i> <?php echo htmlspecialchars($doc['matiere']); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <!-- Description -->
                                <?php if (!empty($doc['description'])): ?>
                                    <p style="color: var(--text-light); margin-bottom: 1rem; line-height: 1.5;">
                                        <?php echo htmlspecialchars(substr($doc['description'], 0, 120)) . (strlen($doc['description']) > 120 ? '...' : ''); ?>
                                    </p>
                                <?php endif; ?>

                                <!-- Métadonnées -->
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.9rem; color: var(--text-light);">
                                    <div>
                                        <i class="fas fa-user"></i> <?php echo htmlspecialchars($doc['prenom'] . ' ' . substr($doc['nom'], 0, 1) . '.'); ?>
                                    </div>
                                    <div>
                                        <i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($doc['created_at'])); ?>
                                    </div>
                                </div>

                                <!-- Statistiques et actions -->
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div style="display: flex; gap: 1rem; font-size: 0.9rem; color: var(--text-light);">
                                        <span><i class="fas fa-download"></i> <?php echo number_format($doc['downloads']); ?></span>
                                        <span><i class="fas fa-file"></i> <?php echo strtoupper($doc['file_type']); ?></span>
                                        <span><i class="fas fa-weight"></i> <?php echo formatFileSize($doc['file_size']); ?></span>
                                    </div>

                                    <div style="display:flex; gap:0.5rem;">
                                        <button onclick="previewDocument(<?php echo $doc['id']; ?>)" class="btn btn-secondary" style="padding: 0.5rem 1rem;">
                                            <i class="fas fa-eye"></i> Prévisualiser
                                        </button>
                                        <?php if (isset($_SESSION['user_id'])): ?>
                                            <button onclick="downloadDocument(<?php echo $doc['id']; ?>)" class="btn btn-primary" style="padding: 0.5rem 1rem;">
                                                <i class="fas fa-download"></i> Télécharger
                                            </button>
                                        <?php else: ?>
                                            <a href="login.php" class="btn btn-secondary" style="padding: 0.5rem 1rem;">
                                                <i class="fas fa-lock"></i> Se connecter
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <div style="margin-top: 3rem; text-align: center;">
                        <div style="display: inline-flex; gap: 0.5rem; background: white; padding: 1rem; border-radius: 10px; box-shadow: var(--shadow);">
                            <?php if ($page > 1): ?>
                                <a href="?<?php echo http_build_query(array_merge($filters, array('page' => $page - 1))); ?>"
                                   class="btn btn-secondary" style="padding: 0.5rem 1rem;">
                                    <i class="fas fa-chevron-left"></i> Précédent
                                </a>
                            <?php endif; ?>

                            <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                                <a href="?<?php echo http_build_query(array_merge($filters, array('page' => $i))); ?>"
                                   class="btn <?php echo $i === $page ? 'btn-primary' : 'btn-secondary'; ?>"
                                   style="padding: 0.5rem 1rem;">
                                    <?php echo $i; ?>
                                </a>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <a href="?<?php echo http_build_query(array_merge($filters, array('page' => $page + 1))); ?>"
                                   class="btn btn-secondary" style="padding: 0.5rem 1rem;">
                                    Suivant <i class="fas fa-chevron-right"></i>
                                </a>
                            <?php endif; ?>
                        </div>

                        <p style="margin-top: 1rem; color: var(--text-light);">
                            Page <?php echo $page; ?> sur <?php echo $total_pages; ?>
                            (<?php echo number_format($total_documents); ?> document(s) au total)
                        </p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>
</main>

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
// Fonction pour télécharger un document
function downloadDocument(documentId) {
    // Vérifier si l'utilisateur est connecté
    <?php if (!isset($_SESSION['user_id'])): ?>
        window.location.href = 'login.php';
        return;
    <?php endif; ?>

    // Créer un formulaire pour le téléchargement
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'api/download_document.php';

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'document_id';
    input.value = documentId;

    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);

    showNotification('Téléchargement en cours...', 'info');
}

// Fonction pour changer le tri
function changeSorting(sortBy) {
    const url = new URL(window.location);
    url.searchParams.set('sort', sortBy);
    url.searchParams.delete('page'); // Reset pagination
    window.location.href = url.toString();
}

// Fonction pour afficher la modal d'upload
function showUploadModal() {
    window.location.href = 'upload_document.php';
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
    const cards = document.querySelectorAll('.document-card');
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
});

// Aperçu
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