<?php
// Script de test pour diagnostiquer les problèmes de results.php
require_once 'includes/db.php';

echo "<h2>Test de diagnostic - Page Results</h2>";

// Test 1: Vérifier la connexion à la base de données
echo "<h3>1. Test de connexion à la base de données</h3>";
try {
    $pdo = getConnection();
    echo "✅ Connexion réussie<br>";
} catch (Exception $e) {
    echo "❌ Erreur de connexion: " . $e->getMessage() . "<br>";
    exit;
}

// Test 2: Vérifier l'existence de la table documents
echo "<h3>2. Test de la table documents</h3>";
try {
    $sql = "SHOW TABLES LIKE 'documents'";
    $result = executeQuery($sql);
    if ($result->rowCount() > 0) {
        echo "✅ Table documents existe<br>";
    } else {
        echo "❌ Table documents n'existe pas<br>";
    }
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "<br>";
}

// Test 3: Vérifier les colonnes de la table documents
echo "<h3>3. Test des colonnes de la table documents</h3>";
try {
    $sql = "DESCRIBE documents";
    $result = executeQuery($sql);
    $columns = $result->fetchAll();
    
    $required_columns = ['id', 'title', 'type_document', 'filiere', 'user_id'];
    foreach ($required_columns as $col) {
        $found = false;
        foreach ($columns as $column) {
            if ($column['Field'] === $col) {
                $found = true;
                break;
            }
        }
        echo ($found ? "✅" : "❌") . " Colonne '$col'<br>";
    }
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "<br>";
}

// Test 4: Vérifier les documents de type 'information'
echo "<h3>4. Test des documents de type 'information'</h3>";
try {
    $sql = "SELECT COUNT(*) as count FROM documents WHERE type_document = 'information' AND active = 1";
    $result = executeQuery($sql);
    $count = $result->fetch()['count'];
    echo "📊 Nombre de documents 'information': $count<br>";
    
    if ($count == 0) {
        echo "⚠️ Aucun document de type 'information' trouvé. Exécutez le script update_document_types.sql<br>";
    }
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "<br>";
}

// Test 5: Tester la fonction getDocuments avec filtres
echo "<h3>5. Test de la fonction getDocuments</h3>";
try {
    $filters = ['type_document' => 'information'];
    $documents = getDocuments($filters, 1, 5);
    echo "✅ Fonction getDocuments fonctionne<br>";
    echo "📊 Documents récupérés: " . count($documents) . "<br>";
    
    if (count($documents) > 0) {
        echo "<strong>Premier document:</strong><br>";
        $doc = $documents[0];
        echo "- ID: " . $doc['id'] . "<br>";
        echo "- Titre: " . htmlspecialchars($doc['title']) . "<br>";
        echo "- Type: " . $doc['type_document'] . "<br>";
        echo "- Filière: " . $doc['filiere'] . "<br>";
    }
} catch (Exception $e) {
    echo "❌ Erreur getDocuments: " . $e->getMessage() . "<br>";
}

// Test 6: Tester la fonction getAvailableFilieres
echo "<h3>6. Test de la fonction getAvailableFilieres</h3>";
try {
    $filieres = getAvailableFilieres();
    echo "✅ Fonction getAvailableFilieres fonctionne<br>";
    echo "📊 Filières disponibles: " . count($filieres) . "<br>";
    if (count($filieres) > 0) {
        echo "- Filières: " . implode(', ', $filieres) . "<br>";
    }
} catch (Exception $e) {
    echo "❌ Erreur getAvailableFilieres: " . $e->getMessage() . "<br>";
}

// Test 7: Tester les filtres
echo "<h3>7. Test des filtres</h3>";
try {
    // Test filtre par filière
    $filters = ['type_document' => 'information', 'filiere' => 'informatique'];
    $docs_informatique = getDocuments($filters, 1, 10);
    echo "📊 Documents filière 'informatique': " . count($docs_informatique) . "<br>";
    
    // Test filtre par recherche
    $filters = ['type_document' => 'information', 'search' => 'admission'];
    $docs_search = getDocuments($filters, 1, 10);
    echo "📊 Documents contenant 'admission': " . count($docs_search) . "<br>";
} catch (Exception $e) {
    echo "❌ Erreur filtres: " . $e->getMessage() . "<br>";
}

// Test 8: Vérifier les utilisateurs
echo "<h3>8. Test des utilisateurs</h3>";
try {
    $sql = "SELECT COUNT(*) as count FROM users";
    $result = executeQuery($sql);
    $count = $result->fetch()['count'];
    echo "📊 Nombre d'utilisateurs: $count<br>";
    
    if ($count > 0) {
        $sql = "SELECT id, nom, prenom FROM users LIMIT 3";
        $result = executeQuery($sql);
        $users = $result->fetchAll();
        echo "👥 Premiers utilisateurs:<br>";
        foreach ($users as $user) {
            echo "- ID: {$user['id']}, Nom: {$user['prenom']} {$user['nom']}<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ Erreur utilisateurs: " . $e->getMessage() . "<br>";
}

echo "<h3>🔧 Actions recommandées</h3>";
echo "1. Si aucun document 'information' n'existe, exécutez update_document_types.sql<br>";
echo "2. Vérifiez que la session est active pour tester results.php<br>";
echo "3. Consultez les logs d'erreur PHP si des problèmes persistent<br>";
?>
