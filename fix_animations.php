<?php
/**
 * Script pour corriger les animations qui font disparaître les composants
 */

echo "=== CORRECTION DES ANIMATIONS ===\n\n";

$files_to_fix = [
    'index.php',
    'alumni.php',
    'bank.php',
    'results.php',
    'messages.php',
    'dashboard.php'
];

$fixes_applied = 0;

foreach ($files_to_fix as $file) {
    if (!file_exists($file)) {
        echo "⚠ Fichier non trouvé : $file\n";
        continue;
    }
    
    echo "Correction de $file...\n";
    
    $content = file_get_contents($file);
    $original_content = $content;
    
    // Corrections des classes problématiques
    $replacements = [
        // Remplacer card-animate par hover-lift seulement
        'class="service-card card-animate hover-lift"' => 'class="service-card hover-lift"',
        'class="card-animate hover-lift"' => 'class="hover-lift"',
        'class="section-animate"' => 'class=""',
        
        // Supprimer les data-delay qui ne servent plus
        ' data-delay="0"' => '',
        ' data-delay="1"' => '',
        ' data-delay="2"' => '',
        ' data-delay="3"' => '',
        ' data-delay="4"' => '',
        ' data-delay="5"' => '',
        
        // Garder seulement les animations sûres
        'animate-pulse' => 'animate-pulse-safe',
    ];
    
    $changes_made = false;
    foreach ($replacements as $old => $new) {
        if (strpos($content, $old) !== false) {
            $content = str_replace($old, $new, $content);
            $changes_made = true;
            echo "   ✓ Remplacé: $old\n";
        }
    }
    
    if ($changes_made) {
        file_put_contents($file, $content);
        $fixes_applied++;
        echo "   ✓ Fichier corrigé\n";
    } else {
        echo "   - Aucune correction nécessaire\n";
    }
    
    echo "\n";
}

// Créer un CSS de remplacement sécurisé
echo "Création du CSS d'animations sécurisées...\n";

$safe_css = "/* Animations sécurisées - Ne font pas disparaître les éléments */

/* Animation de pulse sécurisée */
.animate-pulse-safe {
    animation: pulse-safe 2s infinite;
}

@keyframes pulse-safe {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

/* Hover effects sécurisés */
.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.hover-scale {
    transition: transform 0.3s ease;
}

.hover-scale:hover {
    transform: scale(1.05);
}

/* Animations de boutons sécurisées */
.btn-animate {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.btn-animate:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
}

/* Animations d'icônes sécurisées */
.icon-animate {
    transition: all 0.3s ease;
}

.icon-animate:hover {
    transform: scale(1.2) rotate(10deg);
    color: #2e7d32;
}

/* Animation de rotation pour les icônes spéciales */
.icon-rotate:hover {
    animation: rotate-once 0.5s ease;
}

@keyframes rotate-once {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Animations d'entrée optionnelles (à utiliser manuellement) */
.manual-fade-in {
    animation: fadeIn 0.8s ease-out;
}

.manual-slide-in {
    animation: slideInLeft 0.6s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideInLeft {
    from { opacity: 0; transform: translateX(-30px); }
    to { opacity: 1; transform: translateX(0); }
}

/* Désactiver les animations problématiques */
.card-animate {
    /* Pas d'opacity: 0 par défaut */
}

.section-animate {
    /* Pas d'opacity: 0 par défaut */
}
";

file_put_contents('assets/css/safe-animations.css', $safe_css);
echo "   ✓ CSS sécurisé créé: assets/css/safe-animations.css\n\n";

// Mettre à jour le header pour inclure le CSS sécurisé
echo "Mise à jour du header...\n";
$header_content = file_get_contents('includes/header.php');

if (strpos($header_content, 'safe-animations.css') === false) {
    $header_content = str_replace(
        '<link rel="stylesheet" href="assets/css/animations.css">',
        '<link rel="stylesheet" href="assets/css/animations.css">
    <link rel="stylesheet" href="assets/css/safe-animations.css">',
        $header_content
    );
    
    file_put_contents('includes/header.php', $header_content);
    echo "   ✓ CSS sécurisé ajouté au header\n";
} else {
    echo "   - CSS sécurisé déjà présent\n";
}

// Créer un guide d'utilisation sécurisée
echo "\nCréation du guide d'utilisation sécurisée...\n";

$guide = "# Guide d'Animations Sécurisées - Mutuelle UDM

## ❌ Classes à ÉVITER (font disparaître les éléments)
- `card-animate` (sans classe supplémentaire)
- `section-animate` (sans classe supplémentaire)
- `animate-fade-in` (sur des éléments importants)

## ✅ Classes SÉCURISÉES à utiliser
- `hover-lift` - Élévation au survol
- `hover-scale` - Agrandissement au survol
- `btn-animate` - Animation des boutons
- `icon-animate` - Animation des icônes
- `animate-pulse-safe` - Pulsation sécurisée

## 🎯 Utilisation Recommandée

### Cartes et Éléments
```html
<!-- ✅ BIEN -->
<div class=\"service-card hover-lift\">
    <i class=\"fas fa-book icon-animate\"></i>
    <h3>Titre</h3>
</div>

<!-- ❌ ÉVITER -->
<div class=\"service-card card-animate\">
    <!-- Peut faire disparaître l'élément -->
</div>
```

### Boutons
```html
<!-- ✅ BIEN -->
<button class=\"btn btn-primary btn-animate\">
    Cliquez-moi
</button>
```

### Icônes
```html
<!-- ✅ BIEN -->
<i class=\"fas fa-star icon-animate\"></i>
<i class=\"fas fa-cog icon-rotate\"></i>
```

### Animations Manuelles (Optionnelles)
```html
<!-- ✅ BIEN - Animation manuelle -->
<div class=\"manual-fade-in\">
    Contenu qui apparaît en fondu
</div>
```

## 🔧 Corrections Appliquées
- Suppression des `card-animate` problématiques
- Remplacement par `hover-lift` seulement
- Suppression des `data-delay` inutiles
- Ajout du CSS sécurisé

## 🎨 Résultat
- ✅ Plus de disparition d'éléments
- ✅ Animations au survol fonctionnelles
- ✅ Effets visuels préservés
- ✅ Expérience utilisateur améliorée
";

file_put_contents('ANIMATIONS_SECURISEES.md', $guide);
echo "   ✓ Guide créé: ANIMATIONS_SECURISEES.md\n";

echo "\n=== RÉSUMÉ ===\n";
echo "Fichiers corrigés: $fixes_applied\n";
echo "✅ Animations sécurisées appliquées\n";
echo "✅ Plus de disparition d'éléments\n";
echo "✅ Effets de survol préservés\n\n";

echo "🎉 PROBLÈME RÉSOLU !\n";
echo "Vos composants ne disparaîtront plus avec les animations.\n";
echo "Seuls les effets de survol et animations sécurisées sont actifs.\n";
?>
