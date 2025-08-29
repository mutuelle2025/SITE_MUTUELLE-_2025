-- Script pour ajouter le type de document 'information' à la table documents
-- À exécuter dans phpMyAdmin ou via ligne de commande MySQL

-- Modifier l'ENUM pour inclure le type 'information'
ALTER TABLE documents 
MODIFY COLUMN type_document ENUM('examen', 'cours', 'td', 'tp', 'information', 'autre') DEFAULT 'autre';

-- Vérifier et obtenir un user_id valide
SET @valid_user_id = (SELECT id FROM users LIMIT 1);

-- Ajouter quelques documents d'exemple pour les filières et admissions (seulement si un utilisateur existe)
INSERT INTO documents (user_id, title, description, filename, original_filename, file_size, file_type, filiere, niveau, matiere, type_document, created_at) 
SELECT 
    @valid_user_id,
    title,
    description,
    filename,
    original_filename,
    file_size,
    file_type,
    filiere,
    niveau,
    matiere,
    type_document,
    created_at
FROM (
    SELECT 'Guide d\'admission en Informatique' as title, 'Document détaillant les procédures d\'admission, les prérequis et les débouchés de la filière Informatique à l\'UDM.' as description, 'guide_admission_informatique.pdf' as filename, 'Guide Admission Informatique.pdf' as original_filename, 2048576 as file_size, 'application/pdf' as file_type, 'informatique' as filiere, 'L1' as niveau, NULL as matiere, 'information' as type_document, NOW() as created_at
    UNION ALL
    SELECT 'Présentation de la filière Médecine', 'Brochure complète sur la formation médicale, les spécialisations disponibles et les conditions d\'accès.', 'presentation_medecine.pdf', 'Présentation Médecine UDM.pdf', 3145728, 'application/pdf', 'medecine', 'L1', NULL, 'information', NOW()
    UNION ALL
    SELECT 'Calendrier académique 2024-2025', 'Calendrier officiel des cours, examens et vacances pour l\'année académique en cours.', 'calendrier_2024_2025.pdf', 'Calendrier Académique 2024-2025.pdf', 1048576, 'application/pdf', 'generale', 'L1', NULL, 'information', NOW()
    UNION ALL
    SELECT 'Procédures d\'inscription Droit', 'Guide complet des démarches d\'inscription en première année de Droit, documents requis et délais.', 'inscription_droit.pdf', 'Procédures Inscription Droit.pdf', 1572864, 'application/pdf', 'droit', 'L1', NULL, 'information', NOW()
    UNION ALL
    SELECT 'Bourses et aides financières', 'Information sur les différentes bourses disponibles, critères d\'éligibilité et procédures de demande.', 'bourses_aides.pdf', 'Bourses et Aides Financières.pdf', 2097152, 'application/pdf', 'generale', 'L1', NULL, 'information', NOW()
) AS temp_data
WHERE @valid_user_id IS NOT NULL;

-- Mettre à jour les statistiques
UPDATE documents SET downloads = FLOOR(RAND() * 100) + 10 WHERE type_document = 'information';

-- Vérification des données insérées
SELECT id, title, type_document, filiere, downloads FROM documents WHERE type_document = 'information';
