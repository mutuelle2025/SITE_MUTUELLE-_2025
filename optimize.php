<?php
/**
 * Script d'optimisation automatique pour la Mutuelle UDM
 * Exécute diverses optimisations pour améliorer les performances
 */

// Vérification des permissions
if (php_sapi_name() !== 'cli' && (!isset($_SESSION['user_id']) || !hasPermission($_SESSION['user_id'], 'admin'))) {
    die('Accès refusé. Seuls les administrateurs peuvent exécuter ce script.');
}

echo "=== OPTIMISATION DE LA MUTUELLE UDM ===\n\n";

// Inclure les dépendances
require_once 'includes/db.php';

/**
 * 1. Optimisation de la base de données
 */
echo "1. Optimisation de la base de données...\n";

try {
    // Exécuter le script d'index
    $sql_file = 'optimizations/database_indexes.sql';
    if (file_exists($sql_file)) {
        $sql_content = file_get_contents($sql_file);
        $queries = explode(';', $sql_content);
        
        $executed = 0;
        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query) && !str_starts_with($query, '--')) {
                try {
                    executeQuery($query);
                    $executed++;
                } catch (Exception $e) {
                    // Ignorer les erreurs d'index déjà existants
                    if (!str_contains($e->getMessage(), 'Duplicate key name')) {
                        echo "   Erreur: " . $e->getMessage() . "\n";
                    }
                }
            }
        }
        echo "   ✓ $executed requêtes d'optimisation exécutées\n";
    }
    
    // Optimiser les tables
    $tables = ['users', 'documents', 'messages', 'inscriptions', 'moyennes', 'matieres', 'semestres', 'activity_logs'];
    foreach ($tables as $table) {
        try {
            executeQuery("OPTIMIZE TABLE $table");
            echo "   ✓ Table $table optimisée\n";
        } catch (Exception $e) {
            echo "   ✗ Erreur optimisation $table: " . $e->getMessage() . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "   ✗ Erreur optimisation DB: " . $e->getMessage() . "\n";
}

/**
 * 2. Nettoyage du cache
 */
echo "\n2. Nettoyage du cache...\n";

try {
    $cleaned = cache_cleanup();
    echo "   ✓ $cleaned fichiers de cache expirés supprimés\n";
    
    $stats = cache_stats();
    echo "   ℹ Statistiques cache: {$stats['valid_files']} fichiers valides, {$stats['total_size_formatted']}\n";
    
} catch (Exception $e) {
    echo "   ✗ Erreur nettoyage cache: " . $e->getMessage() . "\n";
}

/**
 * 3. Nettoyage des logs anciens
 */
echo "\n3. Nettoyage des logs anciens...\n";

try {
    // Supprimer les logs de plus de 90 jours
    $sql = "DELETE FROM activity_logs WHERE created_at < DATE_SUB(NOW(), INTERVAL 90 DAY)";
    $stmt = executeQuery($sql);
    $deleted = $stmt->rowCount();
    echo "   ✓ $deleted anciens logs supprimés (> 90 jours)\n";
    
} catch (Exception $e) {
    echo "   ✗ Erreur nettoyage logs: " . $e->getMessage() . "\n";
}

/**
 * 4. Nettoyage des sessions expirées
 */
echo "\n4. Nettoyage des sessions...\n";

try {
    // Nettoyer les fichiers de session PHP
    $session_path = session_save_path() ?: sys_get_temp_dir();
    $session_files = glob($session_path . '/sess_*');
    $cleaned_sessions = 0;
    
    foreach ($session_files as $file) {
        if (filemtime($file) < time() - 3600) { // Plus d'1 heure
            if (unlink($file)) {
                $cleaned_sessions++;
            }
        }
    }
    
    echo "   ✓ $cleaned_sessions sessions expirées supprimées\n";
    
} catch (Exception $e) {
    echo "   ✗ Erreur nettoyage sessions: " . $e->getMessage() . "\n";
}

/**
 * 5. Optimisation des images (si dossier uploads existe)
 */
echo "\n5. Vérification des uploads...\n";

$uploads_dir = 'uploads';
if (is_dir($uploads_dir)) {
    $total_size = 0;
    $file_count = 0;
    
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($uploads_dir));
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $total_size += $file->getSize();
            $file_count++;
        }
    }
    
    echo "   ℹ $file_count fichiers uploadés, " . formatBytes($total_size) . " total\n";
} else {
    echo "   ℹ Dossier uploads non trouvé\n";
}

/**
 * 6. Vérification de la configuration PHP
 */
echo "\n6. Vérification de la configuration PHP...\n";

$recommendations = [];

// Vérifier OPcache
if (!extension_loaded('opcache')) {
    $recommendations[] = "Installer OPcache pour améliorer les performances PHP";
} else {
    echo "   ✓ OPcache activé\n";
}

// Vérifier la mémoire
$memory_limit = ini_get('memory_limit');
if (intval($memory_limit) < 128) {
    $recommendations[] = "Augmenter memory_limit à au moins 128M (actuel: $memory_limit)";
} else {
    echo "   ✓ Mémoire PHP suffisante ($memory_limit)\n";
}

// Vérifier max_execution_time
$max_execution = ini_get('max_execution_time');
if ($max_execution > 0 && $max_execution < 30) {
    $recommendations[] = "Augmenter max_execution_time à au moins 30s (actuel: {$max_execution}s)";
} else {
    echo "   ✓ Temps d'exécution PHP approprié\n";
}

/**
 * 7. Statistiques finales
 */
echo "\n7. Statistiques de performance...\n";

try {
    // Statistiques de la base de données
    $db_stats = executeQuery("SHOW TABLE STATUS")->fetchAll();
    $total_db_size = 0;
    foreach ($db_stats as $table) {
        $total_db_size += $table['Data_length'] + $table['Index_length'];
    }
    echo "   ℹ Taille base de données: " . formatBytes($total_db_size) . "\n";
    
    // Statistiques des utilisateurs
    $user_stats = executeQuery("SELECT 
        COUNT(*) as total_users,
        COUNT(CASE WHEN last_login >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 END) as active_7d,
        COUNT(CASE WHEN last_login >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 END) as active_30d
        FROM users WHERE active = 1")->fetch();
    
    echo "   ℹ Utilisateurs: {$user_stats['total_users']} total, {$user_stats['active_7d']} actifs (7j), {$user_stats['active_30d']} actifs (30j)\n";
    
    // Statistiques des documents
    $doc_stats = executeQuery("SELECT 
        COUNT(*) as total_docs,
        SUM(downloads) as total_downloads,
        AVG(downloads) as avg_downloads
        FROM documents WHERE active = 1")->fetch();
    
    echo "   ℹ Documents: {$doc_stats['total_docs']} total, {$doc_stats['total_downloads']} téléchargements, " . round($doc_stats['avg_downloads'], 1) . " moy/doc\n";
    
} catch (Exception $e) {
    echo "   ✗ Erreur statistiques: " . $e->getMessage() . "\n";
}

/**
 * 8. Recommandations
 */
if (!empty($recommendations)) {
    echo "\n8. Recommandations d'optimisation:\n";
    foreach ($recommendations as $i => $rec) {
        echo "   " . ($i + 1) . ". $rec\n";
    }
} else {
    echo "\n8. ✓ Configuration optimale détectée\n";
}

/**
 * 9. Génération du rapport
 */
echo "\n9. Génération du rapport...\n";

$report = [
    'timestamp' => date('Y-m-d H:i:s'),
    'php_version' => PHP_VERSION,
    'memory_usage' => memory_get_peak_usage(true),
    'execution_time' => microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'],
    'cache_stats' => cache_stats(),
    'recommendations' => $recommendations
];

file_put_contents('optimization_report.json', json_encode($report, JSON_PRETTY_PRINT));
echo "   ✓ Rapport sauvegardé dans optimization_report.json\n";

echo "\n=== OPTIMISATION TERMINÉE ===\n";
echo "Temps d'exécution: " . round($report['execution_time'], 2) . "s\n";
echo "Mémoire utilisée: " . formatBytes($report['memory_usage']) . "\n";

/**
 * Fonction helper pour formater les tailles
 */
function formatBytes($size, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    
    for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
        $size /= 1024;
    }
    
    return round($size, $precision) . ' ' . $units[$i];
}

/**
 * Fonction helper pour str_starts_with (PHP < 8.0)
 */
if (!function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle) {
        return strpos($haystack, $needle) === 0;
    }
}

/**
 * Fonction helper pour str_contains (PHP < 8.0)
 */
if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        return strpos($haystack, $needle) !== false;
    }
}
?>
