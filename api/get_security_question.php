<?php
/**
 * API pour récupérer la question de sécurité d'un utilisateur
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

// Récupérer les données JSON
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['email'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email requis']);
    exit;
}

$email = trim($input['email']);

// Validation de l'email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Format d\'email invalide']);
    exit;
}

try {
    // Récupérer la question de sécurité
    $question = getSecurityQuestion($email);
    
    if ($question) {
        echo json_encode([
            'success' => true,
            'question' => $question
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Aucun compte trouvé avec cet email'
        ]);
    }
    
} catch (Exception $e) {
    error_log("Erreur get_security_question: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erreur serveur'
    ]);
}
?>
