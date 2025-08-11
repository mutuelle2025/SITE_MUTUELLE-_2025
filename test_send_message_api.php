<?php
/**
 * Test de l'API send_message.php
 */

session_start();

// Simuler une session utilisateur pour le test
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 9; // ID de Mejest ULRICH
    $_SESSION['user_name'] = 'Mejest ULRICH';
}

echo "<h1>Test de l'API send_message.php</h1>";

// Données de test
$test_data = [
    'recipient_id' => '1',
    'subject' => 'Test API',
    'message' => 'Ceci est un test de l\'API send_message'
];

echo "<h2>Données de test :</h2>";
echo "<pre>" . print_r($test_data, true) . "</pre>";

echo "<h2>Test avec cURL :</h2>";

// Préparer les données POST
$post_data = http_build_query($test_data);

// Configuration cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/SITE_MUTUELLE-_2025/api/send_message.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, ''); // Utiliser les cookies de session

// Ajouter les cookies de session
$session_name = session_name();
$session_id = session_id();
curl_setopt($ch, CURLOPT_COOKIE, "$session_name=$session_id");

// Exécuter la requête
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);

curl_close($ch);

echo "<h3>Résultat :</h3>";
echo "Code HTTP : $http_code<br>";

if ($error) {
    echo "Erreur cURL : $error<br>";
} else {
    echo "Réponse brute : <pre>" . htmlspecialchars($response) . "</pre>";
    
    $json_response = json_decode($response, true);
    if ($json_response) {
        echo "Réponse JSON décodée :<br>";
        echo "<pre>" . print_r($json_response, true) . "</pre>";
        
        if (isset($json_response['success']) && $json_response['success']) {
            echo "<div style='color: green; font-weight: bold;'>✅ TEST RÉUSSI !</div>";
        } else {
            echo "<div style='color: red; font-weight: bold;'>❌ TEST ÉCHOUÉ</div>";
            if (isset($json_response['message'])) {
                echo "Message d'erreur : " . $json_response['message'] . "<br>";
            }
        }
    } else {
        echo "<div style='color: red;'>❌ Réponse JSON invalide</div>";
    }
}

echo "<h2>Test direct de la fonction :</h2>";

try {
    require_once 'includes/db.php';
    
    $result = sendMessage(
        $_SESSION['user_id'],
        1,
        'Test direct',
        'Test direct de la fonction sendMessage',
        false
    );
    
    if ($result) {
        echo "<div style='color: green;'>✅ Fonction sendMessage fonctionne directement</div>";
    } else {
        echo "<div style='color: red;'>❌ Fonction sendMessage échoue</div>";
    }
    
} catch (Exception $e) {
    echo "<div style='color: red;'>❌ Erreur fonction directe : " . $e->getMessage() . "</div>";
}

echo "<h2>Formulaire de test manuel :</h2>";
?>

<form method="POST" action="api/send_message.php" target="_blank">
    <p>
        <label>Destinataire ID :</label><br>
        <input type="number" name="recipient_id" value="1" required>
    </p>
    <p>
        <label>Sujet :</label><br>
        <input type="text" name="subject" value="Test manuel" required>
    </p>
    <p>
        <label>Message :</label><br>
        <textarea name="message" required>Ceci est un test manuel de l'API</textarea>
    </p>
    <p>
        <button type="submit">Envoyer le message</button>
    </p>
</form>

<h2>Instructions :</h2>
<ol>
    <li>Vérifiez que le test cURL ci-dessus fonctionne</li>
    <li>Si ça ne fonctionne pas, utilisez le formulaire manuel</li>
    <li>Vérifiez les logs d'erreur PHP pour plus de détails</li>
    <li>Allez sur messages.php pour voir si le message apparaît</li>
</ol>

<h2>Logs d'erreur récents :</h2>
<?php
// Essayer de lire les logs d'erreur récents
$error_log_paths = [
    'logs/php_errors.log',
    '/tmp/php_errors.log',
    ini_get('error_log')
];

foreach ($error_log_paths as $log_path) {
    if ($log_path && file_exists($log_path)) {
        echo "<h3>$log_path :</h3>";
        $lines = file($log_path);
        $recent_lines = array_slice($lines, -10); // 10 dernières lignes
        echo "<pre>" . htmlspecialchars(implode('', $recent_lines)) . "</pre>";
        break;
    }
}
?>
