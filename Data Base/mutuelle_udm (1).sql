-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2025 at 12:41 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mutuelle_udm`
--

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `file_size` int(11) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `filiere` varchar(100) NOT NULL,
  `niveau` varchar(10) NOT NULL,
  `matiere` varchar(100) DEFAULT NULL,
  `type_document` enum('examen','cours','td','tp','autre') DEFAULT 'autre',
  `downloads` int(11) DEFAULT 0,
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `user_id`, `title`, `description`, `filename`, `original_filename`, `file_size`, `file_type`, `filiere`, `niveau`, `matiere`, `type_document`, `downloads`, `active`, `created_at`, `updated_at`) VALUES
(14, 6, 'Gshsh', 'Yeyeh', '6883f18fcfc6d_1753477519.pdf', 'Calendrier-des-examens-2025 (2).pdf', 4583254, 'pdf', 'gestion', 'L2', 'Majak', 'cours', 0, 1, '2025-07-25 21:05:19', '2025-07-25 21:05:19');

-- --------------------------------------------------------

--
-- Table structure for table `evaluations`
--

CREATE TABLE `evaluations` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `type` enum('controle','partiel','final','projet','tp','oral') NOT NULL,
  `coefficient` decimal(3,1) DEFAULT 1.0,
  `description` text DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `evaluations`
--

INSERT INTO `evaluations` (`id`, `nom`, `type`, `coefficient`, `description`, `active`, `created_at`) VALUES
(1, 'Contrôle Continu 1', 'controle', 0.3, 'Premier contrôle continu', 1, '2025-07-25 12:02:41'),
(2, 'Contrôle Continu 2', 'controle', 0.3, 'Deuxième contrôle continu', 1, '2025-07-25 12:02:41'),
(3, 'Examen Partiel', 'partiel', 1.0, 'Examen de mi-semestre', 1, '2025-07-25 12:02:41'),
(4, 'Examen Final', 'final', 2.0, 'Examen final de fin de semestre', 1, '2025-07-25 12:02:41'),
(5, 'Projet', 'projet', 1.5, 'Projet de fin de module', 1, '2025-07-25 12:02:42'),
(6, 'Travaux Pratiques', 'tp', 0.5, 'Évaluation des TP', 1, '2025-07-25 12:02:42'),
(7, 'Examen Oral', 'oral', 1.0, 'Présentation orale', 1, '2025-07-25 12:02:42');

-- --------------------------------------------------------

--
-- Table structure for table `inscriptions`
--

CREATE TABLE `inscriptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `semestre_id` int(11) NOT NULL,
  `matiere_id` int(11) NOT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT current_timestamp(),
  `active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `matieres`
--

CREATE TABLE `matieres` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `code` varchar(20) NOT NULL,
  `filiere` varchar(100) NOT NULL,
  `niveau` varchar(10) NOT NULL,
  `coefficient` decimal(3,1) DEFAULT 1.0,
  `credits` int(11) DEFAULT 3,
  `semestre_type` enum('S1','S2','S3','S4','S5','S6') NOT NULL,
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `matieres`
--

INSERT INTO `matieres` (`id`, `nom`, `code`, `filiere`, `niveau`, `coefficient`, `credits`, `semestre_type`, `active`, `created_at`) VALUES
(1, 'Algorithmique Avancée', 'ALG301', 'informatique', 'L3', 2.0, 6, 'S1', 1, '2025-07-25 12:03:05'),
(2, 'Base de Données', 'BDD301', 'informatique', 'L3', 2.0, 6, 'S1', 1, '2025-07-25 12:03:05'),
(3, 'Programmation Orientée Objet', 'POO301', 'informatique', 'L3', 2.0, 6, 'S1', 1, '2025-07-25 12:03:05'),
(4, 'Systèmes d\'Exploitation', 'SYS301', 'informatique', 'L3', 1.5, 4, 'S1', 1, '2025-07-25 12:03:05'),
(5, 'Mathématiques Discrètes', 'MAT301', 'informatique', 'L3', 1.5, 4, 'S1', 1, '2025-07-25 12:03:05'),
(6, 'Anglais Technique', 'ANG301', 'informatique', 'L3', 1.0, 2, 'S1', 1, '2025-07-25 12:03:05'),
(7, 'Génie Logiciel', 'GL302', 'informatique', 'L3', 2.0, 6, 'S2', 1, '2025-07-25 12:03:06'),
(8, 'Réseaux Informatiques', 'RES302', 'informatique', 'L3', 2.0, 6, 'S2', 1, '2025-07-25 12:03:06'),
(9, 'Intelligence Artificielle', 'IA302', 'informatique', 'L3', 1.5, 4, 'S2', 1, '2025-07-25 12:03:06'),
(10, 'Sécurité Informatique', 'SEC302', 'informatique', 'L3', 1.5, 4, 'S2', 1, '2025-07-25 12:03:06'),
(11, 'Projet de Fin d\'Études', 'PFE302', 'informatique', 'L3', 2.0, 8, 'S2', 1, '2025-07-25 12:03:06'),
(12, 'Communication', 'COM302', 'informatique', 'L3', 1.0, 2, 'S2', 1, '2025-07-25 12:03:06');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `is_public` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `subject`, `message`, `is_read`, `is_public`, `created_at`) VALUES
(11, 7, 6, 'test', 'test test', 0, 0, '2025-07-28 07:42:06'),
(12, 7, NULL, 'test', 'test', 0, 1, '2025-07-28 08:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `moyennes`
--

CREATE TABLE `moyennes` (
  `id` int(11) NOT NULL,
  `inscription_id` int(11) NOT NULL,
  `moyenne_matiere` decimal(4,2) DEFAULT NULL,
  `moyenne_semestre` decimal(4,2) DEFAULT NULL,
  `moyenne_generale` decimal(4,2) DEFAULT NULL,
  `credits_obtenus` int(11) DEFAULT 0,
  `credits_totaux` int(11) DEFAULT 0,
  `statut` enum('admis','ajourne','redouble','en_cours') DEFAULT 'en_cours',
  `derniere_maj` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `inscription_id` int(11) NOT NULL,
  `evaluation_id` int(11) NOT NULL,
  `note` decimal(4,2) NOT NULL,
  `note_sur` decimal(4,2) DEFAULT 20.00,
  `date_evaluation` date NOT NULL,
  `commentaire` text DEFAULT NULL,
  `validee` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Table structure for table `semestres`
--

CREATE TABLE `semestres` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `annee_universitaire` varchar(20) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `semestres`
--

INSERT INTO `semestres` (`id`, `nom`, `annee_universitaire`, `date_debut`, `date_fin`, `active`, `created_at`) VALUES
(1, 'Semestre 1', '2024-2025', '2024-09-01', '2025-01-31', 1, '2025-07-25 12:02:42'),
(2, 'Semestre 2', '2024-2025', '2025-02-01', '2025-06-30', 1, '2025-07-25 12:02:42'),
(3, 'Semestre 1', '2023-2024', '2023-09-01', '2024-01-31', 1, '2025-07-25 12:02:42'),
(4, 'Semestre 2', '2023-2024', '2024-02-01', '2024-06-30', 1, '2025-07-25 12:02:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `numero_etudiant` varchar(20) NOT NULL,
  `filiere` varchar(100) NOT NULL,
  `niveau` varchar(10) NOT NULL,
  `role` enum('etudiant','moderateur','admin','super_admin') DEFAULT 'etudiant',
  `password_hash` varchar(255) NOT NULL,
  `active` tinyint(1) DEFAULT 1,
  `email_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `numero_etudiant`, `filiere`, `niveau`, `role`, `password_hash`, `active`, `email_verified`, `created_at`, `updated_at`, `last_login`) VALUES
(6, 'NONO', 'Boris', 'boris@gmail.com', '2024000006', 'gestion', 'L3', 'admin', '$2y$10$aaFqLsU3Zr.DEgj6DxukWeyC4EzhA4PaWThgQKdDQktm6ltfDF0xe', 1, 0, '2025-07-25 13:10:29', '2025-07-28 10:21:43', '2025-07-28 10:21:43'),
(7, 'Admin', 'Super', 'admin@udm.ma', 'ADMIN001', 'administration', 'ADMIN', 'moderateur', '$2y$10$GlkRqHXbCE04QjVmdH.bn.RSlSK2pogbY2x4sGugHONYAhFoJQHK.', 1, 0, '2025-07-25 14:29:20', '2025-08-05 09:32:19', '2025-08-05 09:30:54'),
(9, 'WABA KENNE', 'Mejest ULRICH', 'ulrich@gmail.com', '202212345', 'ingenierie', 'L1', 'etudiant', '$2y$10$yG754DdC//SkopWoUeYgW.PJJlOYQoYrW4wi4v1lql4v6FSuj/hrq', 1, 0, '2025-07-25 16:03:48', '2025-07-25 16:04:11', '2025-07-25 16:04:11'),
(10, 'Mutuelle', 'Des Etudiants', 'mutuelledesetudiant.udm2025@gmail.com', '20242025', 'autre', 'Doctorat', 'super_admin', '$2y$10$847KQDY9UhP4jnEWSEt/cOkzvcmxOz0VXS9YLmv5xtelW/3d9f7Va', 1, 0, '2025-08-05 09:29:52', '2025-08-05 09:32:08', '2025-08-05 09:32:08');

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_filiere` (`filiere`),
  ADD KEY `idx_niveau` (`niveau`),
  ADD KEY `idx_matiere` (`matiere`),
  ADD KEY `idx_type` (`type_document`),
  ADD KEY `idx_active` (`active`);

--
-- Indexes for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_active` (`active`);

--
-- Indexes for table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_inscription` (`user_id`,`semestre_id`,`matiere_id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_semestre` (`semestre_id`),
  ADD KEY `idx_matiere` (`matiere_id`);

--
-- Indexes for table `matieres`
--
ALTER TABLE `matieres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idx_filiere` (`filiere`),
  ADD KEY `idx_niveau` (`niveau`),
  ADD KEY `idx_semestre` (`semestre_type`),
  ADD KEY `idx_active` (`active`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sender` (`sender_id`),
  ADD KEY `idx_receiver` (`receiver_id`),
  ADD KEY `idx_public` (`is_public`),
  ADD KEY `idx_read` (`is_read`);

--
-- Indexes for table `moyennes`
--
ALTER TABLE `moyennes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_moyenne` (`inscription_id`),
  ADD KEY `idx_statut` (`statut`),
  ADD KEY `idx_maj` (`derniere_maj`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_inscription` (`inscription_id`),
  ADD KEY `idx_evaluation` (`evaluation_id`),
  ADD KEY `idx_date` (`date_evaluation`),
  ADD KEY `idx_validee` (`validee`);

--
-- Indexes for table `semestres`
--
ALTER TABLE `semestres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_annee` (`annee_universitaire`),
  ADD KEY `idx_active` (`active`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `numero_etudiant` (`numero_etudiant`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_numero_etudiant` (`numero_etudiant`),
  ADD KEY `idx_filiere` (`filiere`),
  ADD KEY `idx_niveau` (`niveau`),
  ADD KEY `idx_role` (`role`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_token` (`token`),
  ADD KEY `idx_expires` (`expires_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inscriptions`
--
ALTER TABLE `inscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `matieres`
--
ALTER TABLE `matieres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `moyennes`
--
ALTER TABLE `moyennes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `semestres`
--
ALTER TABLE `semestres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD CONSTRAINT `inscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscriptions_ibfk_2` FOREIGN KEY (`semestre_id`) REFERENCES `semestres` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscriptions_ibfk_3` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `moyennes`
--
ALTER TABLE `moyennes`
  ADD CONSTRAINT `moyennes_ibfk_1` FOREIGN KEY (`inscription_id`) REFERENCES `inscriptions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`inscription_id`) REFERENCES `inscriptions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
