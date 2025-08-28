<?php
/**
 * API pour réinitialiser le mot de passe après vérification de la question de sécurité
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

if (!$input || !isset($input['email']) || !isset($input['new_password'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email et nouveau mot de passe requis']);
    exit;
}

$email = trim($input['email']);
$newPassword = $input['new_password'];

// Validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Format d\'email invalide']);
    exit;
}

if (strlen($newPassword) < 8) {
    echo json_encode(['success' => false, 'message' => 'Le mot de passe doit contenir au moins 8 caractères']);
    exit;
}

if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', $newPassword)) {
    echo json_encode(['success' => false, 'message' => 'Le mot de passe doit contenir une minuscule, une majuscule et un chiffre']);
    exit;
}

try {
    // Réinitialiser le mot de passe
    $result = resetPasswordWithSecurity($email, $newPassword);
    
    if ($result) {
        // Logger l'action
        $user = getUserByEmail($email);
        if ($user) {
            error_log("Réinitialisation de mot de passe pour l'utilisateur ID: " . $user['id'] . " (" . $email . ")");
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Mot de passe réinitialisé avec succès'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erreur lors de la réinitialisation'
        ]);
    }
    
} catch (Exception $e) {
    error_log("Erreur reset_password: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erreur serveur'
    ]);
}
?>
