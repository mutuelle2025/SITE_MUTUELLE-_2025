<?php
session_start();
require_once '../includes/db.php';

// Vérification de la connexion
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    die('Accès non autorisé');
}

// Support GET et POST pour compatibilité avec les liens directs
$document_id = 0;
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $document_id = intval($_GET['id']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['document_id'])) {
    $document_id = intval($_POST['document_id']);
}

if ($document_id <= 0) {
    http_response_code(400);
    die('ID de document invalide');
}

try {
    // Récupération des informations du document
    $document = getDocumentById($document_id);
    
    if (!$document) {
        http_response_code(404);
        die('Document non trouvé');
    }
    
    // Chemin vers le fichier
    $file_path = '../uploads/' . $document['filename'];
    
    // Vérification de l'existence du fichier
    if (!file_exists($file_path)) {
        // Pour les documents d'exemple, créer un fichier PDF temporaire
        if ($document['type_document'] === 'information') {
            createSamplePDF($file_path, $document['title'], $document['description']);
        } else {
            http_response_code(404);
            die('Fichier non trouvé sur le serveur');
        }
    }
    
    // Incrémenter le compteur de téléchargements
    incrementDownloadCount($document_id);
    
    // Enregistrer l'activité de téléchargement (optionnel)
    // logDownloadActivity($_SESSION['user_id'], $document_id);
    
    // Préparation du téléchargement
    $file_size = filesize($file_path);
    $file_name = $document['original_filename'];
    
    // Headers pour le téléchargement
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $file_name . '"');
    header('Content-Length: ' . $file_size);
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    // Nettoyage du buffer de sortie
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    // Lecture et envoi du fichier par chunks pour éviter les problèmes de mémoire
    $chunk_size = 8192; // 8KB chunks
    $handle = fopen($file_path, 'rb');
    
    if ($handle === false) {
        http_response_code(500);
        die('Erreur lors de la lecture du fichier');
    }
    
    while (!feof($handle)) {
        $chunk = fread($handle, $chunk_size);
        echo $chunk;
        flush();
    }
    
    fclose($handle);
    exit;
    
} catch (Exception $e) {
    error_log("Erreur téléchargement document ID $document_id : " . $e->getMessage());
    http_response_code(500);
    die('Erreur interne du serveur');
}

/**
 * Fonction pour créer un PDF d'exemple pour les documents d'information
 */
function createSamplePDF($file_path, $title, $description) {
    // Contenu HTML simple pour le PDF
    $html_content = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <title>" . htmlspecialchars($title) . "</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
            h1 { color: #1976d2; border-bottom: 2px solid #1976d2; padding-bottom: 10px; }
            .header { text-align: center; margin-bottom: 30px; }
            .content { margin: 20px 0; }
            .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #666; }
        </style>
    </head>
    <body>
        <div class='header'>
            <h1>" . htmlspecialchars($title) . "</h1>
            <p><strong>Université des Montagnes (UDM)</strong></p>
            <p>Document d'information - Filières et Admissions</p>
        </div>
        
        <div class='content'>
            <h2>Description</h2>
            <p>" . nl2br(htmlspecialchars($description)) . "</p>
            
            <h2>Informations générales</h2>
            <p>Ce document contient des informations importantes concernant les filières et les procédures d'admission à l'Université des Montagnes.</p>
            
            <h2>Contact</h2>
            <p>Pour plus d'informations, contactez le service des admissions de l'UDM.</p>
            <ul>
                <li>Email: admissions@udm.edu.cm</li>
                <li>Téléphone: +237 XXX XXX XXX</li>
                <li>Site web: www.udm.edu.cm</li>
            </ul>
        </div>
        
        <div class='footer'>
            <p>Document généré automatiquement - " . date('d/m/Y H:i') . "</p>
            <p>© " . date('Y') . " Université des Montagnes - Tous droits réservés</p>
        </div>
    </body>
    </html>";
    
    // Créer le fichier HTML temporaire
    $temp_html = sys_get_temp_dir() . '/temp_' . uniqid() . '.html';
    file_put_contents($temp_html, $html_content);
    
    // Créer un PDF simple (fallback si wkhtmltopdf n'est pas disponible)
    $pdf_content = "%PDF-1.4
1 0 obj
<<
/Type /Catalog
/Pages 2 0 R
>>
endobj

2 0 obj
<<
/Type /Pages
/Kids [3 0 R]
/Count 1
>>
endobj

3 0 obj
<<
/Type /Page
/Parent 2 0 R
/MediaBox [0 0 612 792]
/Contents 4 0 R
/Resources <<
/Font <<
/F1 5 0 R
>>
>>
>>
endobj

4 0 obj
<<
/Length 200
>>
stream
BT
/F1 12 Tf
50 750 Td
(" . substr($title, 0, 50) . ") Tj
0 -20 Td
(Document d'information UDM) Tj
0 -40 Td
(" . substr($description, 0, 100) . "...) Tj
0 -20 Td
(Genere le " . date('d/m/Y') . ") Tj
ET
endstream
endobj

5 0 obj
<<
/Type /Font
/Subtype /Type1
/BaseFont /Helvetica
>>
endobj

xref
0 6
0000000000 65535 f 
0000000009 00000 n 
0000000058 00000 n 
0000000115 00000 n 
0000000274 00000 n 
0000000526 00000 n 
trailer
<<
/Size 6
/Root 1 0 R
>>
startxref
623
%%EOF";
    
    // Créer le répertoire si nécessaire
    $dir = dirname($file_path);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    
    // Écrire le PDF
    file_put_contents($file_path, $pdf_content);
    
    // Nettoyer le fichier temporaire
    if (file_exists($temp_html)) {
        unlink($temp_html);
    }
}

/**
 * Fonction pour enregistrer l'activité de téléchargement (optionnelle)
 */
function logDownloadActivity($user_id, $document_id) {
    try {
        $sql = "INSERT INTO download_logs (user_id, document_id, downloaded_at) VALUES (?, ?, NOW())";
        executeQuery($sql, [$user_id, $document_id]);
    } catch (Exception $e) {
        // Log silencieux, ne pas interrompre le téléchargement
        error_log("Erreur log téléchargement : " . $e->getMessage());
    }
}
?>
