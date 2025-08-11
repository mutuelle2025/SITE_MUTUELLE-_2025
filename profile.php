<?php
require_once 'includes/auth_middleware.php';

// Vérification de l'authentification
$user = checkAuth();

// Logger l'accès au profil
logAction($_SESSION['user_id'], 'access_profile', 'Accès au profil utilisateur');

// Traitement du formulaire de mise à jour
$errors = array();
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim(isset($_POST['nom']) ? $_POST['nom'] : '');
    $prenom = trim(isset($_POST['prenom']) ? $_POST['prenom'] : '');
    $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
    $filiere = trim(isset($_POST['filiere']) ? $_POST['filiere'] : '');
    $niveau = trim(isset($_POST['niveau']) ? $_POST['niveau'] : '');
    $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    // Validation des champs obligatoires
    if (empty($nom)) {
        $errors['nom'] = 'Le nom est requis';
    }
    
    if (empty($prenom)) {
        $errors['prenom'] = 'Le prénom est requis';
    }
    
    if (empty($email)) {
        $errors['email'] = 'L\'email est requis';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Format d\'email invalide';
    }
    
    if (empty($filiere)) {
        $errors['filiere'] = 'La filière est requise';
    }
    
    if (empty($niveau)) {
        $errors['niveau'] = 'Le niveau est requis';
    }

    // Vérification du changement de mot de passe
    if (!empty($new_password)) {
        if (empty($current_password)) {
            $errors['current_password'] = 'Mot de passe actuel requis pour le changement';
        } elseif (!password_verify($current_password, $user['password_hash'])) {
            $errors['current_password'] = 'Mot de passe actuel incorrect';
        }
        
        if (strlen($new_password) < 6) {
            $errors['new_password'] = 'Le nouveau mot de passe doit contenir au moins 6 caractères';
        }
        
        if ($new_password !== $confirm_password) {
            $errors['confirm_password'] = 'La confirmation ne correspond pas au nouveau mot de passe';
        }
    }

    // Vérification de l'unicité de l'email (si changé)
    if ($email !== $user['email']) {
        $existing_user = getUserByEmail($email);
        if ($existing_user && $existing_user['id'] !== $_SESSION['user_id']) {
            $errors['email'] = 'Cet email est déjà utilisé par un autre utilisateur';
        }
    }

    // Si pas d'erreurs, mise à jour
    if (empty($errors)) {
        try {
            $update_data = array(
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'filiere' => $filiere,
                'niveau' => $niveau
            );

            // Ajouter le nouveau mot de passe si fourni
            if (!empty($new_password)) {
                $update_data['password_hash'] = password_hash($new_password, PASSWORD_DEFAULT);
            }

            // Mise à jour en base
            $sql = "UPDATE users SET nom = ?, prenom = ?, email = ?, filiere = ?, niveau = ?";
            $params = array($nom, $prenom, $email, $filiere, $niveau);
            
            if (!empty($new_password)) {
                $sql .= ", password_hash = ?";
                $params[] = $update_data['password_hash'];
            }
            
            $sql .= ", updated_at = NOW() WHERE id = ?";
            $params[] = $_SESSION['user_id'];

            executeQuery($sql, $params);

            // Mise à jour des variables de session
            $_SESSION['user_name'] = $prenom . ' ' . $nom;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_filiere'] = $filiere;
            $_SESSION['user_niveau'] = $niveau;

            // Logger l'action
            logAction($_SESSION['user_id'], 'update_profile', 'Mise à jour du profil utilisateur');

            $success_message = 'Profil mis à jour avec succès !';
            
            // Recharger les données utilisateur
            $user = getUserById($_SESSION['user_id']);

        } catch (Exception $e) {
            $errors['database'] = 'Erreur lors de la mise à jour. Veuillez réessayer.';
            error_log("Erreur mise à jour profil : " . $e->getMessage());
        }
    }
}

$page_title = "Mon Profil";
include 'includes/header.php';
?>

<main class="main-content">
    <div class="container" style="padding: 2rem 0;">
        <!-- En-tête du profil -->
        <div style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%); color: white; padding: 2rem; border-radius: 10px; margin-bottom: 2rem;">
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <h1 style="margin: 0 0 0.5rem 0; font-size: 1.8rem;">
                        <?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?>
                    </h1>
                    <p style="margin: 0; opacity: 0.9; font-size: 1.1rem;">
                        <i class="fas fa-graduation-cap"></i> 
                        <?php echo htmlspecialchars($user['filiere'] . ' - ' . $user['niveau']); ?>
                    </p>
                    <p style="margin: 0.5rem 0 0 0; opacity: 0.8;">
                        <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($user['email']); ?>
                    </p>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem; align-items: start;">
            <!-- Formulaire de modification -->
            <div style="background: white; border-radius: 10px; box-shadow: var(--shadow); padding: 2rem;">
                <h2 style="color: var(--primary-color); margin: 0 0 1.5rem 0;">
                    <i class="fas fa-edit"></i> Modifier mon profil
                </h2>

                <?php if ($success_message): ?>
                    <div style="background: #e8f5e8; color: #2e7d32; padding: 1rem; border-radius: 5px; margin-bottom: 1.5rem; border-left: 4px solid #4caf50;">
                        <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success_message); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($errors)): ?>
                    <div style="background: #ffebee; color: #d32f2f; padding: 1rem; border-radius: 5px; margin-bottom: 1.5rem; border-left: 4px solid #f44336;">
                        <strong><i class="fas fa-exclamation-triangle"></i> Erreurs détectées :</strong>
                        <ul style="margin: 0.5rem 0 0 1rem; padding: 0;">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" style="display: grid; gap: 1.5rem;">
                    <!-- Informations personnelles -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-dark);">
                                <i class="fas fa-user"></i> Nom *
                            </label>
                            <input type="text" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" 
                                   required style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 5px; font-size: 1rem;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-dark);">
                                <i class="fas fa-user"></i> Prénom *
                            </label>
                            <input type="text" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" 
                                   required style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 5px; font-size: 1rem;">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-dark);">
                            <i class="fas fa-envelope"></i> Email *
                        </label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" 
                               required style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 5px; font-size: 1rem;">
                    </div>

                    <!-- Informations académiques -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-dark);">
                                <i class="fas fa-graduation-cap"></i> Filière *
                            </label>
                            <select name="filiere" required style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 5px; font-size: 1rem;">
                                <option value="">Choisir une filière</option>
                                <option value="informatique" <?php echo $user['filiere'] === 'informatique' ? 'selected' : ''; ?>>Informatique</option>
                                <option value="gestion" <?php echo $user['filiere'] === 'gestion' ? 'selected' : ''; ?>>Gestion</option>
                                <option value="droit" <?php echo $user['filiere'] === 'droit' ? 'selected' : ''; ?>>Droit</option>
                                <option value="sciences" <?php echo $user['filiere'] === 'sciences' ? 'selected' : ''; ?>>Sciences</option>
                                <option value="ingenierie" <?php echo $user['filiere'] === 'ingenierie' ? 'selected' : ''; ?>>Ingénierie</option>
                                <option value="medecine" <?php echo $user['filiere'] === 'medecine' ? 'selected' : ''; ?>>Médecine</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-dark);">
                                <i class="fas fa-layer-group"></i> Niveau *
                            </label>
                            <select name="niveau" required style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 5px; font-size: 1rem;">
                                <option value="">Choisir un niveau</option>
                                <option value="L1" <?php echo $user['niveau'] === 'L1' ? 'selected' : ''; ?>>L1</option>
                                <option value="L2" <?php echo $user['niveau'] === 'L2' ? 'selected' : ''; ?>>L2</option>
                                <option value="L3" <?php echo $user['niveau'] === 'L3' ? 'selected' : ''; ?>>L3</option>
                                <option value="M1" <?php echo $user['niveau'] === 'M1' ? 'selected' : ''; ?>>M1</option>
                                <option value="M2" <?php echo $user['niveau'] === 'M2' ? 'selected' : ''; ?>>M2</option>
                            </select>
                        </div>
                    </div>

                    <!-- Changement de mot de passe -->
                    <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                        <h3 style="color: var(--text-dark); margin: 0 0 1rem 0;">
                            <i class="fas fa-lock"></i> Changer le mot de passe (optionnel)
                        </h3>
                        
                        <div style="display: grid; gap: 1rem;">
                            <div>
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-dark);">
                                    Mot de passe actuel
                                </label>
                                <input type="password" name="current_password" 
                                       style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 5px; font-size: 1rem;">
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-dark);">
                                        Nouveau mot de passe
                                    </label>
                                    <input type="password" name="new_password" 
                                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 5px; font-size: 1rem;">
                                </div>
                                <div>
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-dark);">
                                        Confirmer le nouveau mot de passe
                                    </label>
                                    <input type="password" name="confirm_password" 
                                           style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 5px; font-size: 1rem;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 1rem;">
                        <a href="dashboard.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>

            <!-- Informations du compte -->
            <div style="background: white; border-radius: 10px; box-shadow: var(--shadow); padding: 1.5rem;">
                <h3 style="color: var(--primary-color); margin: 0 0 1rem 0;">
                    <i class="fas fa-info-circle"></i> Informations du compte
                </h3>
                
                <div style="display: grid; gap: 1rem; font-size: 0.9rem;">
                    <div>
                        <strong>Numéro étudiant :</strong><br>
                        <span style="color: var(--text-light);"><?php echo htmlspecialchars($user['numero_etudiant']); ?></span>
                    </div>
                    <div>
                        <strong>Rôle :</strong><br>
                        <span style="color: var(--text-light); text-transform: capitalize;"><?php echo htmlspecialchars($user['role']); ?></span>
                    </div>
                    <div>
                        <strong>Membre depuis :</strong><br>
                        <span style="color: var(--text-light);"><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></span>
                    </div>
                    <div>
                        <strong>Dernière connexion :</strong><br>
                        <span style="color: var(--text-light);">
                            <?php echo $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'Jamais'; ?>
                        </span>
                    </div>
                </div>

                <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                    <h4 style="margin: 0 0 0.5rem 0; color: var(--text-dark);">Actions rapides</h4>
                    <div style="display: grid; gap: 0.5rem;">
                        <a href="results.php" style="color: var(--primary-color); text-decoration: none; font-size: 0.9rem;">
                            <i class="fas fa-chart-line"></i> Voir mes résultats
                        </a>
                        <a href="messages.php" style="color: var(--primary-color); text-decoration: none; font-size: 0.9rem;">
                            <i class="fas fa-comments"></i> Mes messages
                        </a>
                        <a href="bank.php" style="color: var(--primary-color); text-decoration: none; font-size: 0.9rem;">
                            <i class="fas fa-book"></i> Banque d'épreuves
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
