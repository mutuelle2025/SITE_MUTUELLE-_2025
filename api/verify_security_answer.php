<?php
/**
 * API pour vérifier la réponse à la question de sécurité
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

if (!$input || !isset($input['email']) || !isset($input['answer'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email et réponse requis']);
    exit;
}

$email = trim($input['email']);
$answer = trim($input['answer']);

// Validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Format d\'email invalide']);
    exit;
}

if (empty($answer)) {
    echo json_encode(['success' => false, 'message' => 'Réponse requise']);
    exit;
}

try {
    // Vérifier la réponse
    $isValid = verifySecurityAnswer($email, $answer);
    
    if ($isValid) {
        echo json_encode([
            'success' => true,
            'message' => 'Réponse correcte'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Réponse incorrecte'
        ]);
    }
    
} catch (Exception $e) {
    error_log("Erreur verify_security_answer: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erreur serveur'
    ]);
}
?>
