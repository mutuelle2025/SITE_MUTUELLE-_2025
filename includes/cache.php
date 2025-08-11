<?php
/**
 * Système de cache simple pour améliorer les performances
 * Compatible PHP 5.4+
 */

class SimpleCache {
    private $cache_dir;
    private $default_ttl;
    
    public function __construct($cache_dir = 'cache', $default_ttl = 3600) {
        $this->cache_dir = rtrim($cache_dir, '/');
        $this->default_ttl = $default_ttl;
        
        // Créer le dossier cache s'il n'existe pas
        if (!is_dir($this->cache_dir)) {
            mkdir($this->cache_dir, 0755, true);
        }
        
        // Créer le fichier .htaccess pour sécuriser le cache
        $htaccess_file = $this->cache_dir . '/.htaccess';
        if (!file_exists($htaccess_file)) {
            file_put_contents($htaccess_file, "Deny from all\n");
        }
    }
    
    /**
     * Générer une clé de cache sécurisée
     */
    private function generateKey($key) {
        return md5($key);
    }
    
    /**
     * Obtenir le chemin du fichier cache
     */
    private function getCacheFile($key) {
        $safe_key = $this->generateKey($key);
        return $this->cache_dir . '/' . $safe_key . '.cache';
    }
    
    /**
     * Mettre en cache une valeur
     */
    public function set($key, $value, $ttl = null) {
        if ($ttl === null) {
            $ttl = $this->default_ttl;
        }
        
        $cache_file = $this->getCacheFile($key);
        $cache_data = array(
            'expires' => time() + $ttl,
            'data' => $value
        );
        
        return file_put_contents($cache_file, serialize($cache_data)) !== false;
    }
    
    /**
     * Récupérer une valeur du cache
     */
    public function get($key, $default = null) {
        $cache_file = $this->getCacheFile($key);
        
        if (!file_exists($cache_file)) {
            return $default;
        }
        
        $cache_content = file_get_contents($cache_file);
        if ($cache_content === false) {
            return $default;
        }
        
        $cache_data = unserialize($cache_content);
        if ($cache_data === false) {
            // Fichier corrompu, le supprimer
            unlink($cache_file);
            return $default;
        }
        
        // Vérifier l'expiration
        if (time() > $cache_data['expires']) {
            unlink($cache_file);
            return $default;
        }
        
        return $cache_data['data'];
    }
    
    /**
     * Vérifier si une clé existe et est valide
     */
    public function has($key) {
        return $this->get($key, '__NOT_FOUND__') !== '__NOT_FOUND__';
    }
    
    /**
     * Supprimer une entrée du cache
     */
    public function delete($key) {
        $cache_file = $this->getCacheFile($key);
        if (file_exists($cache_file)) {
            return unlink($cache_file);
        }
        return true;
    }
    
    /**
     * Vider tout le cache
     */
    public function clear() {
        $files = glob($this->cache_dir . '/*.cache');
        $deleted = 0;
        
        foreach ($files as $file) {
            if (unlink($file)) {
                $deleted++;
            }
        }
        
        return $deleted;
    }
    
    /**
     * Nettoyer les fichiers expirés
     */
    public function cleanup() {
        $files = glob($this->cache_dir . '/*.cache');
        $cleaned = 0;
        
        foreach ($files as $file) {
            $cache_content = file_get_contents($file);
            if ($cache_content !== false) {
                $cache_data = unserialize($cache_content);
                if ($cache_data !== false && time() > $cache_data['expires']) {
                    if (unlink($file)) {
                        $cleaned++;
                    }
                }
            }
        }
        
        return $cleaned;
    }
    
    /**
     * Obtenir des statistiques du cache
     */
    public function getStats() {
        $files = glob($this->cache_dir . '/*.cache');
        $total_files = count($files);
        $total_size = 0;
        $expired = 0;
        
        foreach ($files as $file) {
            $total_size += filesize($file);
            
            $cache_content = file_get_contents($file);
            if ($cache_content !== false) {
                $cache_data = unserialize($cache_content);
                if ($cache_data !== false && time() > $cache_data['expires']) {
                    $expired++;
                }
            }
        }
        
        return array(
            'total_files' => $total_files,
            'total_size' => $total_size,
            'total_size_formatted' => $this->formatBytes($total_size),
            'expired_files' => $expired,
            'valid_files' => $total_files - $expired
        );
    }
    
    /**
     * Formater la taille en octets
     */
    private function formatBytes($size, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }
    
    /**
     * Méthode helper pour cache avec callback
     */
    public function remember($key, $callback, $ttl = null) {
        $value = $this->get($key);
        
        if ($value === null) {
            $value = call_user_func($callback);
            $this->set($key, $value, $ttl);
        }
        
        return $value;
    }
}

// Instance globale du cache
$cache = new SimpleCache('cache', 3600); // 1 heure par défaut

/**
 * Fonctions helper pour le cache
 */
function cache_set($key, $value, $ttl = null) {
    global $cache;
    return $cache->set($key, $value, $ttl);
}

function cache_get($key, $default = null) {
    global $cache;
    return $cache->get($key, $default);
}

function cache_has($key) {
    global $cache;
    return $cache->has($key);
}

function cache_delete($key) {
    global $cache;
    return $cache->delete($key);
}

function cache_clear() {
    global $cache;
    return $cache->clear();
}

function cache_remember($key, $callback, $ttl = null) {
    global $cache;
    return $cache->remember($key, $callback, $ttl);
}

function cache_cleanup() {
    global $cache;
    return $cache->cleanup();
}

function cache_stats() {
    global $cache;
    return $cache->getStats();
}

// Nettoyage automatique du cache (1% de chance à chaque chargement)
if (rand(1, 100) === 1) {
    cache_cleanup();
}
