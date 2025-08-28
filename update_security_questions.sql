-- Script pour ajouter les colonnes de questions de sécurité à la table users
-- À exécuter dans phpMyAdmin ou via ligne de commande MySQL

USE mutuelle_udm;

-- Ajouter les colonnes pour les questions de sécurité
ALTER TABLE users 
ADD COLUMN security_question VARCHAR(255) NULL AFTER password_hash,
ADD COLUMN security_answer_hash VARCHAR(255) NULL AFTER security_question;

-- Vérifier que les colonnes ont été ajoutées
DESCRIBE users;

-- Optionnel : Ajouter un index sur security_question pour optimiser les recherches
CREATE INDEX idx_security_question ON users(security_question);

-- Afficher un message de confirmation
SELECT 'Colonnes de sécurité ajoutées avec succès!' AS message;
