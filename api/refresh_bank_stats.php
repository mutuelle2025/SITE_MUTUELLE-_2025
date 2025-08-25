<?php
session_start();
require_once '../includes/db.php';

// Vérifier la connexion et permission (n'importe quel utilisateur connecté peut demander un refresh léger)
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Accès non autorisé']);
    exit;
}

// Invalider le cache des stats et recalculer
try {
    cache_delete('bank_statistics');
    $stats = getBankStatistics();
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'stats' => $stats]);
    exit;
} catch (Exception $e) {
    error_log('Erreur refresh stats: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'actualisation des statistiques']);
    exit;
}

