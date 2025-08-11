# Guide d'Animations Sécurisées - Mutuelle UDM

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
<div class="service-card hover-lift">
    <i class="fas fa-book icon-animate"></i>
    <h3>Titre</h3>
</div>

<!-- ❌ ÉVITER -->
<div class="service-card card-animate">
    <!-- Peut faire disparaître l'élément -->
</div>
```

### Boutons
```html
<!-- ✅ BIEN -->
<button class="btn btn-primary btn-animate">
    Cliquez-moi
</button>
```

### Icônes
```html
<!-- ✅ BIEN -->
<i class="fas fa-star icon-animate"></i>
<i class="fas fa-cog icon-rotate"></i>
```

### Animations Manuelles (Optionnelles)
```html
<!-- ✅ BIEN - Animation manuelle -->
<div class="manual-fade-in">
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
