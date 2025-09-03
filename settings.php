<?php
require_once 'includes/auth_middleware.php';

// Vérification de l'authentification
$user = checkAuth();

// Logger l'accès aux paramètres
logAction($_SESSION['user_id'], 'access_settings', 'Accès aux paramètres du compte');

// Traitement des formulaires
$errors = array();
$success_message = '';

// Traitement des notifications
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'notifications') {
    $email_notifications = isset($_POST['email_notifications']) ? 1 : 0;
    $sms_notifications = isset($_POST['sms_notifications']) ? 1 : 0;
    $push_notifications = isset($_POST['push_notifications']) ? 1 : 0;
    
    try {
        $sql = "UPDATE users SET 
                email_notifications = ?, 
                sms_notifications = ?, 
                push_notifications = ?, 
                updated_at = NOW() 
                WHERE id = ?";
        executeQuery($sql, array($email_notifications, $sms_notifications, $push_notifications, $_SESSION['user_id']));
        
        logAction($_SESSION['user_id'], 'update_notifications', 'Mise à jour des préférences de notification');
        $success_message = 'Préférences de notification mises à jour avec succès !';
    } catch (Exception $e) {
        $errors['notifications'] = 'Erreur lors de la mise à jour des notifications.';
        error_log("Erreur notifications : " . $e->getMessage());
    }
}

// Traitement de la confidentialité
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'privacy') {
    $profile_public = isset($_POST['profile_public']) ? 1 : 0;
    $show_email = isset($_POST['show_email']) ? 1 : 0;
    $show_results = isset($_POST['show_results']) ? 1 : 0;
    
    try {
        $sql = "UPDATE users SET 
                profile_public = ?, 
                show_email = ?, 
                show_results = ?, 
                updated_at = NOW() 
                WHERE id = ?";
        executeQuery($sql, array($profile_public, $show_email, $show_results, $_SESSION['user_id']));
        
        logAction($_SESSION['user_id'], 'update_privacy', 'Mise à jour des paramètres de confidentialité');
        $success_message = 'Paramètres de confidentialité mis à jour avec succès !';
    } catch (Exception $e) {
        $errors['privacy'] = 'Erreur lors de la mise à jour de la confidentialité.';
        error_log("Erreur confidentialité : " . $e->getMessage());
    }
}

// Traitement de la suppression de compte
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_account') {
    $password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';
    $delete_confirm = isset($_POST['delete_confirm']) ? $_POST['delete_confirm'] : '';
    
    if (empty($password_confirm)) {
        $errors['delete'] = 'Mot de passe requis pour supprimer le compte.';
    } elseif (!password_verify($password_confirm, $user['password_hash'])) {
        $errors['delete'] = 'Mot de passe incorrect.';
    } elseif ($delete_confirm !== 'SUPPRIMER') {
        $errors['delete'] = 'Veuillez taper "SUPPRIMER" pour confirmer.';
    } else {
        // Utiliser la nouvelle fonction de suppression
        $result = deleteUserAccount($_SESSION['user_id']);
        
        if ($result['success']) {
            // Déconnexion et redirection
            session_destroy();
            header('Location: index.php?message=account_deleted');
            exit;
        } else {
            $errors['delete'] = $result['message'];
        }
    }
}

// Récupérer les paramètres actuels
$user_settings = getUserById($_SESSION['user_id']);

$page_title = "Paramètres du compte";
include 'includes/header.php';
?>

<main class="main-content">
    <div class="container" style="padding: 2rem 0;">
        <!-- En-tête -->
        <div style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%); color: white; padding: 2rem; border-radius: 10px; margin-bottom: 2rem;">
            <h1 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-cog"></i> Paramètres du compte
            </h1>
            <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">
                Gérez vos préférences et paramètres de confidentialité
            </p>
        </div>

        <?php if ($success_message): ?>
            <div style="background: #e8f5e8; color: #2e7d32; padding: 1rem; border-radius: 5px; margin-bottom: 2rem; border-left: 4px solid #4caf50;">
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <div style="display: grid; gap: 2rem;">
            
            <!-- Notifications -->
            <div style="background: white; border-radius: 10px; box-shadow: var(--shadow); padding: 2rem;">
                <h2 style="color: var(--primary-color); margin: 0 0 1.5rem 0;">
                    <i class="fas fa-bell"></i> Notifications
                </h2>
                
                <?php if (isset($errors['notifications'])): ?>
                    <div style="background: #ffebee; color: #d32f2f; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; border-left: 4px solid #f44336;">
                        <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($errors['notifications']); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" style="display: grid; gap: 1rem;">
                    <input type="hidden" name="action" value="notifications">
                    
                    <div style="display: flex; align-items: center; gap: 0.5rem; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
                        <input type="checkbox" id="email_notifications" name="email_notifications" 
                               <?php echo isset($user_settings['email_notifications']) && $user_settings['email_notifications'] ? 'checked' : ''; ?>>
                        <label for="email_notifications" style="margin: 0; cursor: pointer;">
                            <i class="fas fa-envelope"></i> Recevoir les notifications par email
                        </label>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 0.5rem; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
                        <input type="checkbox" id="sms_notifications" name="sms_notifications" 
                               <?php echo isset($user_settings['sms_notifications']) && $user_settings['sms_notifications'] ? 'checked' : ''; ?>>
                        <label for="sms_notifications" style="margin: 0; cursor: pointer;">
                            <i class="fas fa-sms"></i> Recevoir les notifications par SMS
                        </label>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 0.5rem; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
                        <input type="checkbox" id="push_notifications" name="push_notifications" 
                               <?php echo isset($user_settings['push_notifications']) && $user_settings['push_notifications'] ? 'checked' : ''; ?>>
                        <label for="push_notifications" style="margin: 0; cursor: pointer;">
                            <i class="fas fa-mobile-alt"></i> Recevoir les notifications push
                        </label>
                    </div>
                    
                    <div style="text-align: right; margin-top: 1rem;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer les notifications
                        </button>
                    </div>
                </form>
            </div>

            <!-- Confidentialité -->
            <div style="background: white; border-radius: 10px; box-shadow: var(--shadow); padding: 2rem;">
                <h2 style="color: var(--primary-color); margin: 0 0 1.5rem 0;">
                    <i class="fas fa-shield-alt"></i> Confidentialité
                </h2>
                
                <?php if (isset($errors['privacy'])): ?>
                    <div style="background: #ffebee; color: #d32f2f; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; border-left: 4px solid #f44336;">
                        <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($errors['privacy']); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" style="display: grid; gap: 1rem;">
                    <input type="hidden" name="action" value="privacy">
                    
                    <div style="display: flex; align-items: center; gap: 0.5rem; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
                        <input type="checkbox" id="profile_public" name="profile_public" 
                               <?php echo isset($user_settings['profile_public']) && $user_settings['profile_public'] ? 'checked' : ''; ?>>
                        <label for="profile_public" style="margin: 0; cursor: pointer;">
                            <i class="fas fa-users"></i> Profil visible par les autres étudiants
                        </label>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 0.5rem; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
                        <input type="checkbox" id="show_email" name="show_email" 
                               <?php echo isset($user_settings['show_email']) && $user_settings['show_email'] ? 'checked' : ''; ?>>
                        <label for="show_email" style="margin: 0; cursor: pointer;">
                            <i class="fas fa-envelope"></i> Afficher mon email aux autres étudiants
                        </label>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 0.5rem; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
                        <input type="checkbox" id="show_results" name="show_results" 
                               <?php echo isset($user_settings['show_results']) && $user_settings['show_results'] ? 'checked' : ''; ?>>
                        <label for="show_results" style="margin: 0; cursor: pointer;">
                            <i class="fas fa-chart-line"></i> Partager mes résultats avec la communauté
                        </label>
                    </div>
                    
                    <div style="text-align: right; margin-top: 1rem;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer la confidentialité
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sécurité -->
            <div style="background: white; border-radius: 10px; box-shadow: var(--shadow); padding: 2rem;">
                <h2 style="color: var(--primary-color); margin: 0 0 1.5rem 0;">
                    <i class="fas fa-lock"></i> Sécurité
                </h2>
                
                <div style="display: grid; gap: 1rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
                        <div>
                            <strong>Mot de passe</strong><br>
                            <span style="color: var(--text-light); font-size: 0.9rem;">Dernière modification : 
                                <?php echo isset($user_settings['password_updated_at']) ? date('d/m/Y', strtotime($user_settings['password_updated_at'])) : 'Inconnue'; ?>
                            </span>
                        </div>
                        <a href="profile.php#password" class="btn btn-secondary">
                            <i class="fas fa-key"></i> Changer
                        </a>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
                        <div>
                            <strong>Sessions actives</strong><br>
                            <span style="color: var(--text-light); font-size: 0.9rem;">Gérer vos connexions actives</span>
                        </div>
                        <button onclick="alert('Fonctionnalité à venir')" class="btn btn-secondary">
                            <i class="fas fa-desktop"></i> Voir
                        </button>
                    </div>
                </div>
            </div>

            <!-- Données et compte -->
            <div style="background: white; border-radius: 10px; box-shadow: var(--shadow); padding: 2rem;">
                <h2 style="color: var(--primary-color); margin: 0 0 1.5rem 0;">
                    <i class="fas fa-database"></i> Données et compte
                </h2>
                
                <div style="display: grid; gap: 1rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
                        <div>
                            <strong>Exporter mes données</strong><br>
                            <span style="color: var(--text-light); font-size: 0.9rem;">Télécharger toutes vos données personnelles</span>
                        </div>
                        <button onclick="alert('Fonctionnalité à venir')" class="btn btn-secondary">
                            <i class="fas fa-download"></i> Exporter
                        </button>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: #fff3e0; border-radius: 5px; border-left: 4px solid #ff9800;">
                        <div>
                            <strong style="color: #f57c00;">Supprimer mon compte</strong><br>
                            <span style="color: #ef6c00; font-size: 0.9rem;">Action irréversible - Toutes vos données seront supprimées</span>
                        </div>
                        <button onclick="showDeleteModal()" class="btn" style="background: #f44336; color: white;">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div style="background: white; border-radius: 10px; box-shadow: var(--shadow); padding: 2rem;">
                <h2 style="color: var(--primary-color); margin: 0 0 1.5rem 0;">
                    <i class="fas fa-bolt"></i> Actions rapides
                </h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <a href="profile.php" class="btn btn-outline" style="text-decoration: none;">
                        <i class="fas fa-user"></i> Modifier le profil
                    </a>
                    <a href="dashboard.php" class="btn btn-outline" style="text-decoration: none;">
                        <i class="fas fa-home"></i> Tableau de bord
                    </a>
                    <a href="results.php" class="btn btn-outline" style="text-decoration: none;">
                        <i class="fas fa-chart-line"></i> Mes résultats
                    </a>
                    <a href="messages.php" class="btn btn-outline" style="text-decoration: none;">
                        <i class="fas fa-comments"></i> Messages
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal de suppression de compte -->
<div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 2rem; border-radius: 10px; max-width: 500px; width: 90%;">
        <h3 style="color: #f44336; margin: 0 0 1rem 0;">
            <i class="fas fa-exclamation-triangle"></i> Supprimer le compte
        </h3>
        
        <?php if (isset($errors['delete'])): ?>
            <div style="background: #ffebee; color: #d32f2f; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; border-left: 4px solid #f44336;">
                <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($errors['delete']); ?>
            </div>
        <?php endif; ?>
        
        <p style="margin-bottom: 1.5rem; line-height: 1.5;">
            <strong>Attention :</strong> Cette action est irréversible. Toutes vos données seront définitivement supprimées.
        </p>
        
        <form method="POST" style="display: grid; gap: 1rem;">
            <input type="hidden" name="action" value="delete_account">
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                    Confirmez votre mot de passe :
                </label>
                <input type="password" name="password_confirm" required 
                       style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 5px;">
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                    Tapez "SUPPRIMER" pour confirmer :
                </label>
                <input type="text" name="delete_confirm" required 
                       style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 5px;">
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1rem;">
                <button type="button" onclick="hideDeleteModal()" class="btn btn-secondary">
                    Annuler
                </button>
                <button type="submit" class="btn" style="background: #f44336; color: white;">
                    <i class="fas fa-trash"></i> Supprimer définitivement
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showDeleteModal() {
    document.getElementById('deleteModal').style.display = 'flex';
}

function hideDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

// Fermer le modal en cliquant à l'extérieur
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideDeleteModal();
    }
});
</script>

<?php include 'includes/footer.php'; ?>
