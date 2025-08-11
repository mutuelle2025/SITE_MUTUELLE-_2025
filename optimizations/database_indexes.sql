-- Optimisations de la base de données pour la Mutuelle UDM
-- Ajout d'index pour améliorer les performances des requêtes

-- Index pour la table users
ALTER TABLE users ADD INDEX idx_email (email);
ALTER TABLE users ADD INDEX idx_active (active);
ALTER TABLE users ADD INDEX idx_filiere_niveau (filiere, niveau);
ALTER TABLE users ADD INDEX idx_role (role);
ALTER TABLE users ADD INDEX idx_last_login (last_login);

-- Index pour la table documents
ALTER TABLE documents ADD INDEX idx_active (active);
ALTER TABLE documents ADD INDEX idx_filiere_niveau (filiere, niveau);
ALTER TABLE documents ADD INDEX idx_matiere (matiere);
ALTER TABLE documents ADD INDEX idx_type_document (type_document);
ALTER TABLE documents ADD INDEX idx_user_id (user_id);
ALTER TABLE documents ADD INDEX idx_created_at (created_at);
ALTER TABLE documents ADD INDEX idx_downloads (downloads);
-- Index composé pour les recherches fréquentes
ALTER TABLE documents ADD INDEX idx_search (active, filiere, niveau, matiere);
-- Index pour la recherche textuelle
ALTER TABLE documents ADD FULLTEXT INDEX idx_fulltext_search (title, description);

-- Index pour la table messages
ALTER TABLE messages ADD INDEX idx_sender_id (sender_id);
ALTER TABLE messages ADD INDEX idx_receiver_id (receiver_id);
ALTER TABLE messages ADD INDEX idx_is_read (is_read);
ALTER TABLE messages ADD INDEX idx_is_public (is_public);
ALTER TABLE messages ADD INDEX idx_created_at (created_at);
-- Index composé pour les conversations
ALTER TABLE messages ADD INDEX idx_conversation (sender_id, receiver_id, created_at);
ALTER TABLE messages ADD INDEX idx_unread_messages (receiver_id, is_read);

-- Index pour la table inscriptions
ALTER TABLE inscriptions ADD INDEX idx_user_id (user_id);
ALTER TABLE inscriptions ADD INDEX idx_semestre_id (semestre_id);
ALTER TABLE inscriptions ADD INDEX idx_matiere_id (matiere_id);
ALTER TABLE inscriptions ADD INDEX idx_active (active);
-- Index composé pour les résultats
ALTER TABLE inscriptions ADD INDEX idx_user_semestre (user_id, semestre_id);

-- Index pour la table moyennes
ALTER TABLE moyennes ADD INDEX idx_inscription_id (inscription_id);
ALTER TABLE moyennes ADD INDEX idx_moyenne_matiere (moyenne_matiere);
ALTER TABLE moyennes ADD INDEX idx_statut (statut);

-- Index pour la table matieres
ALTER TABLE matieres ADD INDEX idx_filiere_niveau (filiere, niveau);
ALTER TABLE matieres ADD INDEX idx_active (active);
ALTER TABLE matieres ADD INDEX idx_semestre_type (semestre_type);

-- Index pour la table semestres
ALTER TABLE semestres ADD INDEX idx_active (active);
ALTER TABLE semestres ADD INDEX idx_annee_universitaire (annee_universitaire);

-- Index pour la table activity_logs
ALTER TABLE activity_logs ADD INDEX idx_user_id (user_id);
ALTER TABLE activity_logs ADD INDEX idx_action (action);
ALTER TABLE activity_logs ADD INDEX idx_created_at (created_at);
-- Index composé pour les statistiques
ALTER TABLE activity_logs ADD INDEX idx_user_date (user_id, created_at);

-- Index pour la table notes (si elle existe)
-- ALTER TABLE notes ADD INDEX idx_inscription_id (inscription_id);
-- ALTER TABLE notes ADD INDEX idx_type_note (type_note);

-- Optimisation des requêtes avec ANALYZE TABLE
ANALYZE TABLE users;
ANALYZE TABLE documents;
ANALYZE TABLE messages;
ANALYZE TABLE inscriptions;
ANALYZE TABLE moyennes;
ANALYZE TABLE matieres;
ANALYZE TABLE semestres;
ANALYZE TABLE activity_logs;
