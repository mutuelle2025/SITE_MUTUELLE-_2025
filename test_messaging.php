<?php
/**
 * Script de test pour diagnostiquer les problèmes de messagerie
 */

// Démarrer la session
session_start();

// Inclure les dépendances
require_once 'includes/db.php';

echo "<h1>Test du Module de Messagerie</h1>";

// Test 1: Vérification de la connexion à la base de données
echo "<h2>1. Test de connexion à la base de données</h2>";
try {
    if (isConnected()) {
        echo "✅ Connexion à la base de données : OK<br>";
    } else {
        echo "❌ Connexion à la base de données : ÉCHEC<br>";
    }
} catch (Exception $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage() . "<br>";
}

// Test 2: Vérification de l'existence de la table messages
echo "<h2>2. Test de la table messages</h2>";
try {
    $result = executeQuery("DESCRIBE messages");
    echo "✅ Table messages : OK<br>";
    echo "<pre>";
    while ($row = $result->fetch()) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
    echo "</pre>";
} catch (Exception $e) {
    echo "❌ Erreur table messages : " . $e->getMessage() . "<br>";
}

// Test 3: Vérification des fonctions de messagerie
echo "<h2>3. Test des fonctions de messagerie</h2>";

$functions_to_test = [
    'getUserMessages',
    'getUnreadMessagesCount', 
    'sendMessage',
    'markMessageAsRead',
    'getMessageById',
    'deleteMessage',
    'searchUsers',
    'getMessagingStats',
    'getRecentConversations'
];

foreach ($functions_to_test as $function) {
    if (function_exists($function)) {
        echo "✅ Fonction $function : OK<br>";
    } else {
        echo "❌ Fonction $function : MANQUANTE<br>";
    }
}

// Test 4: Test avec un utilisateur de test
echo "<h2>4. Test avec utilisateur de test</h2>";

try {
    // Récupérer le premier utilisateur actif
    $test_user = executeQuery("SELECT * FROM users WHERE active = 1 LIMIT 1")->fetch();
    
    if ($test_user) {
        echo "✅ Utilisateur de test trouvé : " . $test_user['prenom'] . " " . $test_user['nom'] . "<br>";
        $user_id = $test_user['id'];
        
        // Test des statistiques de messagerie
        try {
            $stats = getMessagingStats($user_id);
            echo "✅ Statistiques messagerie : OK<br>";
            echo "   - Messages reçus : " . $stats['received'] . "<br>";
            echo "   - Messages envoyés : " . $stats['sent'] . "<br>";
            echo "   - Messages non lus : " . $stats['unread'] . "<br>";
            echo "   - Messages publics : " . $stats['public'] . "<br>";
        } catch (Exception $e) {
            echo "❌ Erreur statistiques : " . $e->getMessage() . "<br>";
        }
        
        // Test de récupération des messages
        try {
            $messages = getUserMessages($user_id, 'received', 5);
            echo "✅ Récupération messages : OK (" . count($messages) . " messages)<br>";
        } catch (Exception $e) {
            echo "❌ Erreur récupération messages : " . $e->getMessage() . "<br>";
        }
        
        // Test des conversations récentes
        try {
            $conversations = getRecentConversations($user_id, 5);
            echo "✅ Conversations récentes : OK (" . count($conversations) . " conversations)<br>";
        } catch (Exception $e) {
            echo "❌ Erreur conversations : " . $e->getMessage() . "<br>";
        }
        
    } else {
        echo "❌ Aucun utilisateur de test trouvé<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur test utilisateur : " . $e->getMessage() . "<br>";
}

// Test 5: Test des permissions
echo "<h2>5. Test des permissions</h2>";

if ($test_user) {
    try {
        $has_messaging = hasPermission($test_user['id'], 'use_messaging');
        if ($has_messaging) {
            echo "✅ Permission use_messaging : OK<br>";
        } else {
            echo "❌ Permission use_messaging : REFUSÉE<br>";
        }
        
        $has_role = hasRole($test_user['id'], 'etudiant');
        if ($has_role) {
            echo "✅ Rôle étudiant : OK<br>";
        } else {
            echo "❌ Rôle étudiant : REFUSÉ<br>";
        }
        
    } catch (Exception $e) {
        echo "❌ Erreur permissions : " . $e->getMessage() . "<br>";
    }
}

// Test 6: Test de l'API send_message
echo "<h2>6. Test de l'API send_message</h2>";

if (file_exists('api/send_message.php')) {
    echo "✅ Fichier api/send_message.php : OK<br>";
} else {
    echo "❌ Fichier api/send_message.php : MANQUANT<br>";
}

// Test 7: Test de la structure de la page messages.php
echo "<h2>7. Test de la page messages.php</h2>";

if (file_exists('messages.php')) {
    echo "✅ Fichier messages.php : OK<br>";
    
    // Vérifier la syntaxe PHP
    $output = shell_exec('php -l messages.php 2>&1');
    if (strpos($output, 'No syntax errors') !== false) {
        echo "✅ Syntaxe messages.php : OK<br>";
    } else {
        echo "❌ Erreur syntaxe messages.php : " . $output . "<br>";
    }
} else {
    echo "❌ Fichier messages.php : MANQUANT<br>";
}

// Test 8: Test des sessions
echo "<h2>8. Test des sessions</h2>";

if (session_status() === PHP_SESSION_ACTIVE) {
    echo "✅ Sessions PHP : OK<br>";
    
    if (isset($_SESSION['user_id'])) {
        echo "✅ Utilisateur connecté : " . $_SESSION['user_id'] . "<br>";
    } else {
        echo "⚠️ Aucun utilisateur connecté (normal pour ce test)<br>";
    }
} else {
    echo "❌ Sessions PHP : PROBLÈME<br>";
}

// Test 9: Test de la configuration PHP
echo "<h2>9. Configuration PHP</h2>";

echo "Version PHP : " . PHP_VERSION . "<br>";
echo "Extensions chargées :<br>";

$required_extensions = ['pdo', 'pdo_mysql', 'session', 'json'];
foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ $ext : OK<br>";
    } else {
        echo "❌ $ext : MANQUANT<br>";
    }
}

// Test 10: Recommandations
echo "<h2>10. Recommandations</h2>";

$recommendations = [];

// Vérifier si les index sont présents
try {
    $indexes = executeQuery("SHOW INDEX FROM messages")->fetchAll();
    $index_names = array_column($indexes, 'Key_name');
    
    $required_indexes = ['idx_sender_id', 'idx_receiver_id', 'idx_is_read'];
    foreach ($required_indexes as $idx) {
        if (!in_array($idx, $index_names)) {
            $recommendations[] = "Ajouter l'index $idx sur la table messages";
        }
    }
} catch (Exception $e) {
    $recommendations[] = "Vérifier les index de la table messages";
}

// Vérifier la configuration
if (ini_get('session.auto_start')) {
    $recommendations[] = "Désactiver session.auto_start dans php.ini";
}

if (empty($recommendations)) {
    echo "✅ Aucune recommandation - Configuration optimale<br>";
} else {
    echo "⚠️ Recommandations :<br>";
    foreach ($recommendations as $rec) {
        echo "   - $rec<br>";
    }
}

echo "<h2>Résumé</h2>";
echo "<p>Test terminé. Si vous voyez des ❌, cela indique les problèmes à corriger.</p>";
echo "<p>Pour tester la messagerie complètement, connectez-vous en tant qu'utilisateur et visitez <a href='messages.php'>messages.php</a></p>";
?>
