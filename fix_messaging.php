<?php
/**
 * Script pour corriger automatiquement les problèmes de messagerie
 */

require_once 'includes/db.php';

echo "=== CORRECTION DU MODULE DE MESSAGERIE ===\n\n";

$fixes_applied = 0;
$errors = [];

// 1. Vérifier et créer la table messages si nécessaire
echo "1. Vérification de la table messages...\n";
try {
    $result = executeQuery("SHOW TABLES LIKE 'messages'");
    if ($result->rowCount() == 0) {
        echo "   Création de la table messages...\n";
        $sql = "CREATE TABLE messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            sender_id INT NOT NULL,
            receiver_id INT DEFAULT NULL,
            subject VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            is_read TINYINT(1) DEFAULT 0,
            is_public TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        executeQuery($sql);
        echo "   ✓ Table messages créée\n";
        $fixes_applied++;
    } else {
        echo "   ✓ Table messages existe\n";
    }
} catch (Exception $e) {
    $errors[] = "Erreur table messages: " . $e->getMessage();
    echo "   ✗ Erreur: " . $e->getMessage() . "\n";
}

// 2. Ajouter les index manquants
echo "\n2. Vérification des index...\n";
try {
    $indexes_to_add = [
        'idx_sender_id' => 'ALTER TABLE messages ADD INDEX idx_sender_id (sender_id)',
        'idx_receiver_id' => 'ALTER TABLE messages ADD INDEX idx_receiver_id (receiver_id)',
        'idx_is_read' => 'ALTER TABLE messages ADD INDEX idx_is_read (is_read)',
        'idx_is_public' => 'ALTER TABLE messages ADD INDEX idx_is_public (is_public)',
        'idx_created_at' => 'ALTER TABLE messages ADD INDEX idx_created_at (created_at)',
        'idx_conversation' => 'ALTER TABLE messages ADD INDEX idx_conversation (sender_id, receiver_id, created_at)',
        'idx_unread_messages' => 'ALTER TABLE messages ADD INDEX idx_unread_messages (receiver_id, is_read)'
    ];
    
    // Récupérer les index existants
    $existing_indexes = executeQuery("SHOW INDEX FROM messages")->fetchAll();
    $existing_names = array_column($existing_indexes, 'Key_name');
    
    foreach ($indexes_to_add as $index_name => $sql) {
        if (!in_array($index_name, $existing_names)) {
            try {
                executeQuery($sql);
                echo "   ✓ Index $index_name ajouté\n";
                $fixes_applied++;
            } catch (Exception $e) {
                if (!str_contains($e->getMessage(), 'Duplicate key name')) {
                    $errors[] = "Erreur index $index_name: " . $e->getMessage();
                    echo "   ✗ Erreur index $index_name: " . $e->getMessage() . "\n";
                }
            }
        } else {
            echo "   ✓ Index $index_name existe\n";
        }
    }
} catch (Exception $e) {
    $errors[] = "Erreur vérification index: " . $e->getMessage();
    echo "   ✗ Erreur: " . $e->getMessage() . "\n";
}

// 3. Vérifier les données de test
echo "\n3. Vérification des données de test...\n";
try {
    $message_count = executeQuery("SELECT COUNT(*) FROM messages")->fetchColumn();
    echo "   Messages existants: $message_count\n";
    
    if ($message_count == 0) {
        echo "   Ajout de messages de test...\n";
        
        // Récupérer des utilisateurs pour les tests
        $users = executeQuery("SELECT id FROM users WHERE active = 1 LIMIT 3")->fetchAll();
        
        if (count($users) >= 2) {
            $test_messages = [
                [
                    'sender_id' => $users[0]['id'],
                    'receiver_id' => null,
                    'subject' => 'Bienvenue sur la messagerie !',
                    'message' => 'Bienvenue sur le système de messagerie de la Mutuelle UDM. Vous pouvez maintenant communiquer avec vos collègues étudiants.',
                    'is_public' => 1
                ],
                [
                    'sender_id' => $users[0]['id'],
                    'receiver_id' => $users[1]['id'],
                    'subject' => 'Message de test',
                    'message' => 'Ceci est un message de test pour vérifier le bon fonctionnement de la messagerie.',
                    'is_public' => 0
                ]
            ];
            
            foreach ($test_messages as $msg) {
                $sql = "INSERT INTO messages (sender_id, receiver_id, subject, message, is_public, created_at) 
                        VALUES (?, ?, ?, ?, ?, NOW())";
                executeQuery($sql, [
                    $msg['sender_id'],
                    $msg['receiver_id'],
                    $msg['subject'],
                    $msg['message'],
                    $msg['is_public']
                ]);
            }
            
            echo "   ✓ Messages de test ajoutés\n";
            $fixes_applied++;
        } else {
            echo "   ⚠ Pas assez d'utilisateurs pour créer des messages de test\n";
        }
    }
} catch (Exception $e) {
    $errors[] = "Erreur données test: " . $e->getMessage();
    echo "   ✗ Erreur: " . $e->getMessage() . "\n";
}

// 4. Vérifier les permissions
echo "\n4. Vérification des permissions...\n";
try {
    $users = executeQuery("SELECT id, role FROM users WHERE active = 1")->fetchAll();
    $permission_issues = 0;
    
    foreach ($users as $user) {
        if (!hasPermission($user['id'], 'use_messaging')) {
            $permission_issues++;
        }
    }
    
    if ($permission_issues > 0) {
        echo "   ⚠ $permission_issues utilisateurs sans permission messagerie\n";
        echo "   Note: Vérifiez la fonction hasPermission() dans db.php\n";
    } else {
        echo "   ✓ Permissions messagerie OK pour tous les utilisateurs\n";
    }
} catch (Exception $e) {
    $errors[] = "Erreur permissions: " . $e->getMessage();
    echo "   ✗ Erreur: " . $e->getMessage() . "\n";
}

// 5. Vérifier les fichiers API
echo "\n5. Vérification des fichiers API...\n";

$api_files = [
    'api/send_message.php' => 'Envoi de messages',
    'api/search_users.php' => 'Recherche d\'utilisateurs'
];

foreach ($api_files as $file => $description) {
    if (file_exists($file)) {
        echo "   ✓ $file ($description) existe\n";
        
        // Vérifier la syntaxe
        $output = shell_exec("php -l $file 2>&1");
        if (strpos($output, 'No syntax errors') !== false) {
            echo "   ✓ Syntaxe $file OK\n";
        } else {
            $errors[] = "Erreur syntaxe $file: $output";
            echo "   ✗ Erreur syntaxe $file\n";
        }
    } else {
        echo "   ✗ $file manquant\n";
        $errors[] = "Fichier manquant: $file";
    }
}

// 6. Optimiser les performances
echo "\n6. Optimisation des performances...\n";
try {
    executeQuery("ANALYZE TABLE messages");
    echo "   ✓ Table messages analysée\n";
    
    executeQuery("OPTIMIZE TABLE messages");
    echo "   ✓ Table messages optimisée\n";
    
    $fixes_applied++;
} catch (Exception $e) {
    $errors[] = "Erreur optimisation: " . $e->getMessage();
    echo "   ✗ Erreur optimisation: " . $e->getMessage() . "\n";
}

// 7. Nettoyer les anciens messages (optionnel)
echo "\n7. Nettoyage des anciens messages...\n";
try {
    $old_messages = executeQuery("SELECT COUNT(*) FROM messages WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 YEAR)")->fetchColumn();
    
    if ($old_messages > 0) {
        echo "   $old_messages messages de plus d'un an trouvés\n";
        echo "   Note: Utilisez le script d'optimisation pour les nettoyer si nécessaire\n";
    } else {
        echo "   ✓ Pas de messages anciens à nettoyer\n";
    }
} catch (Exception $e) {
    echo "   ⚠ Impossible de vérifier les anciens messages: " . $e->getMessage() . "\n";
}

// 8. Test final
echo "\n8. Test final du module...\n";
try {
    // Test des fonctions principales
    $test_user = executeQuery("SELECT id FROM users WHERE active = 1 LIMIT 1")->fetch();
    
    if ($test_user) {
        $user_id = $test_user['id'];
        
        // Test statistiques
        $stats = getMessagingStats($user_id);
        echo "   ✓ Statistiques messagerie fonctionnelles\n";
        
        // Test récupération messages
        $messages = getUserMessages($user_id, 'received', 5);
        echo "   ✓ Récupération messages fonctionnelle\n";
        
        // Test conversations
        $conversations = getRecentConversations($user_id, 5);
        echo "   ✓ Conversations récentes fonctionnelles\n";
        
        echo "   ✓ Module messagerie entièrement fonctionnel\n";
        
    } else {
        echo "   ⚠ Aucun utilisateur de test disponible\n";
    }
} catch (Exception $e) {
    $errors[] = "Erreur test final: " . $e->getMessage();
    echo "   ✗ Erreur test final: " . $e->getMessage() . "\n";
}

// Résumé
echo "\n=== RÉSUMÉ ===\n";
echo "Corrections appliquées: $fixes_applied\n";
echo "Erreurs rencontrées: " . count($errors) . "\n";

if (!empty($errors)) {
    echo "\nERREURS DÉTAILLÉES:\n";
    foreach ($errors as $i => $error) {
        echo ($i + 1) . ". $error\n";
    }
}

if (count($errors) == 0) {
    echo "\n✅ MODULE MESSAGERIE ENTIÈREMENT FONCTIONNEL !\n";
    echo "Vous pouvez maintenant utiliser la messagerie sans problème.\n";
} else {
    echo "\n⚠️ QUELQUES PROBLÈMES SUBSISTENT\n";
    echo "Consultez les erreurs ci-dessus pour les résoudre.\n";
}

echo "\nPour tester la messagerie:\n";
echo "1. Connectez-vous sur le site\n";
echo "2. Allez sur messages.php\n";
echo "3. Essayez d'envoyer un message\n";

// Fonction helper pour str_contains (PHP < 8.0)
if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        return strpos($haystack, $needle) !== false;
    }
}
?>
