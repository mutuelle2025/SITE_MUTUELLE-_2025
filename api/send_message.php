<?php
session_start();
require_once '../includes/db.php';

// Activer les logs d'erreur pour le débogage
error_reporting(E_ALL);
ini_set('log_errors', 1);

// Headers pour JSON
header('Content-Type: application/json');

// Vérification de la connexion
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
    exit;
}

// Vérification de la méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

try {
    $sender_id = $_SESSION['user_id'];
    $subject = trim(isset($_POST['subject']) ? $_POST['subject'] : '');
    $message = trim(isset($_POST['message']) ? $_POST['message'] : '');
    $is_public = isset($_POST['is_public']) && $_POST['is_public'] === '1';
    $recipient_id = $is_public ? null : (isset($_POST['recipient_id']) ? intval($_POST['recipient_id']) : 0);

    // Log des données reçues pour débogage
    error_log("send_message.php - Données reçues: sender_id=$sender_id, recipient_id=$recipient_id, subject='$subject', message='$message', is_public=" . ($is_public ? 'true' : 'false'));

    // Validation des données
    if (empty($subject)) {
        echo json_encode(['success' => false, 'message' => 'Le sujet est obligatoire']);
        exit;
    }

    if (empty($message)) {
        echo json_encode(['success' => false, 'message' => 'Le message est obligatoire']);
        exit;
    }

    if (!$is_public && $recipient_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Destinataire obligatoire pour un message privé']);
        exit;
    }

    // Vérifier que l'expéditeur existe
    $sender = getUserById($sender_id);
    if (!$sender) {
        error_log("send_message.php - Expéditeur introuvable: $sender_id");
        echo json_encode(['success' => false, 'message' => 'Expéditeur introuvable']);
        exit;
    }

    // Vérifier que le destinataire existe (pour les messages privés)
    if (!$is_public) {
        $recipient = getUserById($recipient_id);
        if (!$recipient) {
            error_log("send_message.php - Destinataire introuvable: $recipient_id");
            echo json_encode(['success' => false, 'message' => 'Destinataire introuvable']);
            exit;
        }
    }

    // Vérifier que la fonction sendMessage existe
    if (!function_exists('sendMessage')) {
        error_log("send_message.php - Fonction sendMessage non trouvée");
        echo json_encode(['success' => false, 'message' => 'Fonction d\'envoi non disponible']);
        exit;
    }

    // Envoyer le message
    error_log("send_message.php - Tentative d'envoi du message");
    $result = sendMessage($sender_id, $recipient_id, $subject, $message, $is_public);

    if ($result) {
        error_log("send_message.php - Message envoyé avec succès");
        echo json_encode([
            'success' => true,
            'message' => $is_public ? 'Annonce publiée avec succès' : 'Message envoyé avec succès'
        ]);
    } else {
        error_log("send_message.php - Échec de l'envoi du message");
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'envoi du message']);
    }

} catch (Exception $e) {
    error_log("send_message.php - Exception: " . $e->getMessage() . " dans " . $e->getFile() . " ligne " . $e->getLine());
    echo json_encode([
        'success' => false,
        'message' => 'Erreur interne du serveur',
        'debug' => $e->getMessage() // Temporaire pour le débogage
    ]);
}
?>