<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0); // Désactiver l'affichage des erreurs pour l'API JSON

require_once '../includes/db.php';

// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

try {
    // Vérification simple de l'authentification
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('Utilisateur non connecté');
    }
    
    // Vérification du paramètre ID
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        throw new Exception('ID du document manquant ou invalide');
    }
    
    $document_id = intval($_GET['id']);
    
    // Récupération des informations du document
    $sql = "SELECT d.*, u.nom, u.prenom, u.filiere 
            FROM documents d 
            JOIN users u ON d.user_id = u.id 
            WHERE d.id = ?";
    
    $result = executeQuery($sql, [$document_id]);
    
    if (empty($result)) {
        throw new Exception('Document non trouvé');
    }
    
    $document = $result[0];
    
    // Génération du HTML de prévisualisation
    $html = '
    <div style="padding: 1rem;">
        <!-- En-tête du document -->
        <div style="border-bottom: 2px solid var(--border-color); padding-bottom: 1rem; margin-bottom: 1.5rem;">
            <h4 style="color: var(--primary-color); margin-bottom: 0.5rem;">' . htmlspecialchars($document['title']) . '</h4>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap; font-size: 0.9rem; color: var(--text-light);">
                <span><i class="fas fa-user"></i> ' . htmlspecialchars($document['prenom'] . ' ' . $document['nom']) . '</span>
                <span><i class="fas fa-graduation-cap"></i> ' . htmlspecialchars(ucfirst($document['filiere'])) . '</span>
                <span><i class="fas fa-calendar"></i> ' . date('d/m/Y', strtotime($document['created_at'])) . '</span>
                <span><i class="fas fa-download"></i> ' . number_format($document['downloads']) . ' téléchargements</span>
            </div>
        </div>
        
        <!-- Description -->
        <div style="margin-bottom: 1.5rem;">
            <h5 style="color: var(--text-dark); margin-bottom: 0.75rem;">Description</h5>
            <p style="line-height: 1.6; color: var(--text-light);">' . nl2br(htmlspecialchars($document['description'])) . '</p>
        </div>
        
        <!-- Informations techniques -->
        <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            <h5 style="color: var(--text-dark); margin-bottom: 0.75rem;">Informations techniques</h5>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
                <div>
                    <strong>Taille :</strong><br>
                    <span style="color: var(--text-light);">' . number_format($document['file_size'] / 1024 / 1024, 2) . ' MB</span>
                </div>
                <div>
                    <strong>Format :</strong><br>
                    <span style="color: var(--text-light);">' . strtoupper(pathinfo($document['file_path'], PATHINFO_EXTENSION)) . '</span>
                </div>
                <div>
                    <strong>Ajouté le :</strong><br>
                    <span style="color: var(--text-light);">' . date('d/m/Y à H:i', strtotime($document['created_at'])) . '</span>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="api/download_document.php?id=' . $document['id'] . '" 
               class="btn btn-primary" style="text-decoration: none;">
                <i class="fas fa-download"></i> Télécharger le document
            </a>
            <button onclick="document.getElementById(\'previewModal\').style.display=\'none\'" 
                    class="btn btn-secondary">
                <i class="fas fa-times"></i> Fermer
            </button>
        </div>
    </div>';
    
    // Logger l'action de prévisualisation
    logAction($_SESSION['user_id'], 'preview_document', "Prévisualisation du document: {$document['title']}");
    
    echo json_encode([
        'success' => true,
        'html' => $html,
        'document' => [
            'id' => $document['id'],
            'title' => $document['title'],
            'author' => $document['prenom'] . ' ' . $document['nom'],
            'filiere' => $document['filiere']
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
