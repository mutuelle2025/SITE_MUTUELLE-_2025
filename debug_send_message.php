<?php
/**
 * Script de débogage pour l'envoi de messages
 */

session_start();
require_once 'includes/db.php';

// Activer l'affichage des erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Débogage Envoi de Messages</h1>";

// Simuler les données du formulaire
$test_data = [
    'sender_id' => 9, // ID de l'utilisateur Mejest ULRICH
    'recipient_id' => 1, // ID d'un autre utilisateur
    'subject' => 'Test de débogage',
    'message' => 'Ceci est un test de débogage pour l\'envoi de messages',
    'is_public' => false
];

echo "<h2>1. Vérification de la connexion utilisateur</h2>";
if (isset($_SESSION['user_id'])) {
    echo "✅ Utilisateur connecté : " . $_SESSION['user_id'] . "<br>";
} else {
    echo "❌ Aucun utilisateur connecté<br>";
    echo "Simulation avec l'utilisateur ID: " . $test_data['sender_id'] . "<br>";
    $_SESSION['user_id'] = $test_data['sender_id'];
}

echo "<h2>2. Test de la fonction getUserById</h2>";
try {
    $sender = getUserById($test_data['sender_id']);
    if ($sender) {
        echo "✅ Expéditeur trouvé : " . $sender['prenom'] . " " . $sender['nom'] . "<br>";
    } else {
        echo "❌ Expéditeur non trouvé<br>";
    }
    
    $recipient = getUserById($test_data['recipient_id']);
    if ($recipient) {
        echo "✅ Destinataire trouvé : " . $recipient['prenom'] . " " . $recipient['nom'] . "<br>";
    } else {
        echo "❌ Destinataire non trouvé<br>";
    }
} catch (Exception $e) {
    echo "❌ Erreur getUserById : " . $e->getMessage() . "<br>";
}

echo "<h2>3. Test de la fonction sendMessage</h2>";
try {
    echo "Tentative d'envoi avec les paramètres :<br>";
    echo "- Expéditeur : " . $test_data['sender_id'] . "<br>";
    echo "- Destinataire : " . $test_data['recipient_id'] . "<br>";
    echo "- Sujet : " . $test_data['subject'] . "<br>";
    echo "- Message : " . $test_data['message'] . "<br>";
    echo "- Public : " . ($test_data['is_public'] ? 'Oui' : 'Non') . "<br><br>";
    
    $result = sendMessage(
        $test_data['sender_id'],
        $test_data['recipient_id'],
        $test_data['subject'],
        $test_data['message'],
        $test_data['is_public']
    );
    
    if ($result) {
        echo "✅ Message envoyé avec succès !<br>";
        
        // Récupérer le dernier message pour vérification
        $last_message = executeQuery("SELECT * FROM messages ORDER BY id DESC LIMIT 1")->fetch();
        if ($last_message) {
            echo "Dernier message créé :<br>";
            echo "- ID : " . $last_message['id'] . "<br>";
            echo "- Sujet : " . $last_message['subject'] . "<br>";
            echo "- Date : " . $last_message['created_at'] . "<br>";
        }
    } else {
        echo "❌ Échec de l'envoi du message<br>";
    }
} catch (Exception $e) {
    echo "❌ Erreur sendMessage : " . $e->getMessage() . "<br>";
    echo "Trace : <pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<h2>4. Test de la structure de la table messages</h2>";
try {
    $structure = executeQuery("DESCRIBE messages")->fetchAll();
    echo "Structure de la table messages :<br>";
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Champ</th><th>Type</th><th>Null</th><th>Clé</th><th>Défaut</th></tr>";
    foreach ($structure as $field) {
        echo "<tr>";
        echo "<td>" . $field['Field'] . "</td>";
        echo "<td>" . $field['Type'] . "</td>";
        echo "<td>" . $field['Null'] . "</td>";
        echo "<td>" . $field['Key'] . "</td>";
        echo "<td>" . $field['Default'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} catch (Exception $e) {
    echo "❌ Erreur structure table : " . $e->getMessage() . "<br>";
}

echo "<h2>5. Test de la requête SQL directe</h2>";
try {
    $sql = "INSERT INTO messages (sender_id, receiver_id, subject, message, is_public, created_at) 
            VALUES (?, ?, ?, ?, ?, NOW())";
    
    $params = [
        $test_data['sender_id'],
        $test_data['recipient_id'],
        'Test SQL Direct',
        'Test d\'insertion directe en base',
        0
    ];
    
    echo "SQL : " . $sql . "<br>";
    echo "Paramètres : " . implode(', ', $params) . "<br>";
    
    $stmt = executeQuery($sql, $params);
    echo "✅ Insertion SQL directe réussie<br>";
    echo "Lignes affectées : " . $stmt->rowCount() . "<br>";
    
} catch (Exception $e) {
    echo "❌ Erreur SQL directe : " . $e->getMessage() . "<br>";
}

echo "<h2>6. Vérification des contraintes de clés étrangères</h2>";
try {
    // Vérifier si les utilisateurs existent
    $sender_exists = executeQuery("SELECT COUNT(*) FROM users WHERE id = ?", [$test_data['sender_id']])->fetchColumn();
    $recipient_exists = executeQuery("SELECT COUNT(*) FROM users WHERE id = ?", [$test_data['recipient_id']])->fetchColumn();
    
    echo "Expéditeur existe : " . ($sender_exists ? "✅ Oui" : "❌ Non") . "<br>";
    echo "Destinataire existe : " . ($recipient_exists ? "✅ Oui" : "❌ Non") . "<br>";
    
    // Vérifier les contraintes FK
    $fk_check = executeQuery("SELECT @@foreign_key_checks")->fetchColumn();
    echo "Vérification clés étrangères : " . ($fk_check ? "Activée" : "Désactivée") . "<br>";
    
} catch (Exception $e) {
    echo "❌ Erreur vérification FK : " . $e->getMessage() . "<br>";
}

echo "<h2>7. Test avec les vraies données du formulaire</h2>";

// Simuler les données exactes du formulaire qui pose problème
$real_test = [
    'sender_id' => $_SESSION['user_id'],
    'recipient_id' => 9, // Mejest ULRICH WABA KENNE
    'subject' => 'ca dit qoui',
    'message' => 'ertyu',
    'is_public' => false
];

try {
    echo "Test avec les données réelles du formulaire :<br>";
    echo "- Sujet : '" . $real_test['subject'] . "'<br>";
    echo "- Message : '" . $real_test['message'] . "'<br>";
    
    // Vérifier que le destinataire existe
    $real_recipient = getUserById($real_test['recipient_id']);
    if (!$real_recipient) {
        echo "❌ Le destinataire ID " . $real_test['recipient_id'] . " n'existe pas<br>";
    } else {
        echo "✅ Destinataire valide : " . $real_recipient['prenom'] . " " . $real_recipient['nom'] . "<br>";
        
        // Tenter l'envoi
        $real_result = sendMessage(
            $real_test['sender_id'],
            $real_test['recipient_id'],
            $real_test['subject'],
            $real_test['message'],
            $real_test['is_public']
        );
        
        if ($real_result) {
            echo "✅ Envoi réussi avec les données réelles !<br>";
        } else {
            echo "❌ Échec avec les données réelles<br>";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Erreur test réel : " . $e->getMessage() . "<br>";
    echo "Ligne : " . $e->getLine() . "<br>";
    echo "Fichier : " . $e->getFile() . "<br>";
}

echo "<h2>8. Recommandations</h2>";
echo "<p>Si vous voyez des erreurs ci-dessus, voici les actions à prendre :</p>";
echo "<ul>";
echo "<li>❌ Erreur getUserById : Vérifier la fonction dans includes/db.php</li>";
echo "<li>❌ Erreur sendMessage : Vérifier la fonction dans includes/db.php</li>";
echo "<li>❌ Erreur SQL : Vérifier la structure de la table messages</li>";
echo "<li>❌ Contraintes FK : Vérifier que les utilisateurs existent</li>";
echo "</ul>";

echo "<h2>9. Messages existants</h2>";
try {
    $messages = executeQuery("SELECT m.*, u.prenom, u.nom FROM messages m JOIN users u ON m.sender_id = u.id ORDER BY m.created_at DESC LIMIT 5")->fetchAll();
    
    if (empty($messages)) {
        echo "Aucun message dans la base de données<br>";
    } else {
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Expéditeur</th><th>Sujet</th><th>Date</th></tr>";
        foreach ($messages as $msg) {
            echo "<tr>";
            echo "<td>" . $msg['id'] . "</td>";
            echo "<td>" . $msg['prenom'] . " " . $msg['nom'] . "</td>";
            echo "<td>" . htmlspecialchars($msg['subject']) . "</td>";
            echo "<td>" . $msg['created_at'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} catch (Exception $e) {
    echo "❌ Erreur récupération messages : " . $e->getMessage() . "<br>";
}
?>
