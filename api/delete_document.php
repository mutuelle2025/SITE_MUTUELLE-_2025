<?php
/**
 * API pour supprimer un document
 * Accessible uniquement aux utilisateurs avec rôle différent d'étudiant
 */

// Configuration des erreurs
ini_set('display_errors', 0);
error_reporting(0);

// Démarrer la session
session_start();

// Headers CORS et JSON
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Content-Type: application/json; charset=utf-8');

// Répondre aux requêtes OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Inclure les dépendances
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth_middleware.php';

/**
 * Fonction pour envoyer une réponse JSON
 */
function sendResponse($success, $message, $data = null, $httpCode = 200) {
    http_response_code($httpCode);
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit();
}

try {
    // Vérifier que l'utilisateur est connecté
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
        sendResponse(false, 'Non autorisé - Vous devez être connecté', null, 401);
    }

    // Vérifier que l'utilisateur n'est pas un étudiant
    if ($_SESSION['user_role'] === 'etudiant') {
        logAction($_SESSION['user_id'], 'delete_document_denied', 'Tentative de suppression par un étudiant');
        sendResponse(false, 'Accès refusé - Seuls les modérateurs et administrateurs peuvent supprimer des documents', null, 403);
    }

    // Vérifier la méthode HTTP
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendResponse(false, 'Méthode non autorisée - Utilisez POST', null, 405);
    }

    // Récupérer les données de la requête
    $input = [];
    $contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

    if (strpos($contentType, 'application/json') !== false) {
        $content = file_get_contents('php://input');
        $input = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            sendResponse(false, 'Données JSON invalides', null, 400);
        }
    } else {
        $input = $_POST;
    }

    // Vérifier que l'ID du document est fourni
    if (!isset($input['document_id']) || !is_numeric($input['document_id'])) {
        sendResponse(false, 'ID de document manquant ou invalide', null, 400);
    }

    $documentId = (int)$input['document_id'];

    // Récupérer les informations du document
    $document = getDocumentById($documentId);
    if (!$document) {
        sendResponse(false, 'Document non trouvé', null, 404);
    }

    // Vérifier les permissions supplémentaires
    $userId = $_SESSION['user_id'];
    $userRole = $_SESSION['user_role'];
    
    // Un modérateur ne peut supprimer que ses propres documents
    if ($userRole === 'moderateur' && $document['user_id'] != $userId) {
        logAction($userId, 'delete_document_denied', "Tentative de suppression du document {$documentId} d'un autre utilisateur");
        sendResponse(false, 'Vous ne pouvez supprimer que vos propres documents', null, 403);
    }

    // Construire le chemin du fichier
    $filePath = __DIR__ . '/../uploads/' . $document['filename'];
    
    // Supprimer le fichier physique s'il existe
    if (file_exists($filePath)) {
        if (!unlink($filePath)) {
            error_log("Erreur lors de la suppression du fichier: {$filePath}");
            sendResponse(false, 'Erreur lors de la suppression du fichier physique', null, 500);
        }
    }

    // Supprimer l'entrée en base de données
    $sql = "DELETE FROM documents WHERE id = ?";
    $stmt = executeQuery($sql, [$documentId]);
    
    if ($stmt->rowCount() === 0) {
        sendResponse(false, 'Erreur lors de la suppression en base de données', null, 500);
    }

    // Logger l'action
    logAction($userId, 'delete_document', "Document supprimé: ID {$documentId}, Titre: {$document['title']}, Fichier: {$document['filename']}");

    // Invalider le cache des statistiques
    $cacheFile = __DIR__ . '/../cache/bank_statistics.cache';
    if (file_exists($cacheFile)) {
        unlink($cacheFile);
    }

    sendResponse(true, 'Document supprimé avec succès', [
        'document_id' => $documentId,
        'title' => $document['title']
    ]);

} catch (Exception $e) {
    error_log("Erreur dans delete_document.php: " . $e->getMessage());
    sendResponse(false, 'Erreur interne du serveur', null, 500);
}
?>
