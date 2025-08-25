<?php
session_start();
require_once '../includes/db.php';

// Vérifier la connexion
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Accès non autorisé']);
    exit;
}

// Récupérer l'ID du document
$document_id = intval(isset($_GET['document_id']) ? $_GET['document_id'] : 0);
if ($document_id <= 0) {
    http_response_code(400);
    echo 'ID de document invalide';
    exit;
}

try {
    $document = getDocumentById($document_id);
    if (!$document) {
        http_response_code(404);
        echo 'Document non trouvé';
        exit;
    }

    $file_path = '../uploads/' . $document['filename'];
    if (!file_exists($file_path)) {
        http_response_code(404);
        echo 'Fichier introuvable';
        exit;
    }

    // Déterminer le type MIME en fonction de l'extension enregistrée
    $ext = strtolower($document['file_type']);
    $mime = 'application/octet-stream';
    switch ($ext) {
        case 'pdf':
            $mime = 'application/pdf';
            break;
        case 'jpg':
        case 'jpeg':
            $mime = 'image/jpeg';
            break;
        case 'png':
            $mime = 'image/png';
            break;
        case 'gif':
            $mime = 'image/gif';
            break;
        case 'webp':
            $mime = 'image/webp';
            break;
        default:
            // Aperçu non pris en charge
            http_response_code(415);
            echo 'Aperçu non disponible pour ce type de fichier';
            exit;
    }

    $file_size = filesize($file_path);
    $file_name = $document['original_filename'];

    // Headers pour affichage inline (aperçu)
    header('Content-Type: ' . $mime);
    header('Content-Disposition: inline; filename="' . $file_name . '"');
    header('Content-Length: ' . $file_size);
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');

    if (ob_get_level()) {
        ob_end_clean();
    }

    $chunk_size = 8192;
    $handle = fopen($file_path, 'rb');
    if ($handle === false) {
        http_response_code(500);
        echo 'Erreur lors de la lecture du fichier';
        exit;
    }

    while (!feof($handle)) {
        $chunk = fread($handle, $chunk_size);
        echo $chunk;
        flush();
    }

    fclose($handle);
    exit;

} catch (Exception $e) {
    error_log('Erreur aperçu document ID ' . $document_id . ' : ' . $e->getMessage());
    http_response_code(500);
    echo 'Erreur interne du serveur';
    exit;
}

