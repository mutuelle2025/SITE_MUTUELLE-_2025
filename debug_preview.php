<?php
// Script de debug pour tester l'API de prévisualisation
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Debug - API Prévisualisation</h2>";

// Test direct de l'API
$document_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

echo "<h3>Test avec document ID: $document_id</h3>";

// Simuler l'appel à l'API
$api_url = "http://localhost/SITE_MUTUELLE-_2025/api/get_document_preview.php?id=$document_id";

echo "<p><strong>URL testée:</strong> <a href='$api_url' target='_blank'>$api_url</a></p>";

// Test avec cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_COOKIE, session_name() . '=' . session_id());

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "<h3>Résultat du test:</h3>";
echo "<p><strong>Code HTTP:</strong> $http_code</p>";

if ($error) {
    echo "<p><strong>Erreur cURL:</strong> $error</p>";
}

echo "<p><strong>Réponse:</strong></p>";
echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px; max-height: 400px; overflow-y: auto;'>";
echo htmlspecialchars($response);
echo "</pre>";

// Test direct des fonctions
echo "<h3>Test direct des fonctions</h3>";

try {
    require_once 'includes/db.php';
    
    // Test de connexion
    echo "<p>✅ Connexion DB réussie</p>";
    
    // Test de la requête
    $sql = "SELECT d.*, u.nom, u.prenom, u.filiere 
            FROM documents d 
            JOIN users u ON d.user_id = u.id 
            WHERE d.id = ?";
    
    $result = executeQuery($sql, [$document_id]);
    
    if (empty($result)) {
        echo "<p>❌ Aucun document trouvé avec l'ID $document_id</p>";
        
        // Lister les documents disponibles
        $sql_all = "SELECT id, title, type_document FROM documents WHERE active = 1 LIMIT 10";
        $all_docs = executeQuery($sql_all);
        $docs = $all_docs->fetchAll();
        
        echo "<p><strong>Documents disponibles:</strong></p>";
        echo "<ul>";
        foreach ($docs as $doc) {
            echo "<li>ID: {$doc['id']} - {$doc['title']} ({$doc['type_document']})</li>";
        }
        echo "</ul>";
        
    } else {
        echo "<p>✅ Document trouvé</p>";
        $document = $result[0];
        echo "<pre>";
        print_r($document);
        echo "</pre>";
    }
    
} catch (Exception $e) {
    echo "<p>❌ Erreur: " . $e->getMessage() . "</p>";
}

echo "<h3>Liens de test:</h3>";
echo "<ul>";
for ($i = 1; $i <= 5; $i++) {
    echo "<li><a href='?id=$i'>Tester avec ID $i</a></li>";
}
echo "</ul>";
?>
