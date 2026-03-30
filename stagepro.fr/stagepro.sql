-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 30 mars 2026 à 08:59
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `stagepro`
--

-- --------------------------------------------------------

--
-- Structure de la table `candidatures`
--

CREATE TABLE `candidatures` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `offre_id` int(11) NOT NULL,
  `cv` varchar(255) DEFAULT NULL,
  `lettre_motivation` text DEFAULT NULL,
  `statut` varchar(20) NOT NULL DEFAULT 'en_attente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `candidatures`
--

INSERT INTO `candidatures` (`id`, `utilisateur_id`, `offre_id`, `cv`, `lettre_motivation`, `statut`, `created_at`) VALUES
(5, 3, 2, 'uploads/1774621442_Dossier_Synthese_Yassin_AKACHAR_CPI A2 Info 25-26 Aix_Semestre_4 (2).PDF', 'ihi', 'en_attente', '2026-03-27 14:24:02');

-- --------------------------------------------------------

--
-- Structure de la table `entreprises`
--

CREATE TABLE `entreprises` (
  `id` int(11) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `email_contact` varchar(150) DEFAULT NULL,
  `telephone_contact` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `entreprises`
--

INSERT INTO `entreprises` (`id`, `nom`, `description`, `email_contact`, `telephone_contact`, `created_at`) VALUES
(2, 'DataFlow', 'DataFlow est une entreprise spécialisée en data science et intelligence artificielle. Elle développe des solutions d’analyse de données avancées pour aider les entreprises à prendre des décisions stratégiques.', 'contact@dataflow.fr', '0607080910', '2026-03-24 13:45:29'),
(3, 'CreativeLab', 'CreativeLab est une agence digitale spécialisée dans le design UX/UI et la création d’expériences numériques innovantes. Elle accompagne ses clients dans la conception d’interfaces modernes, intuitives et performantes.', 'contact@creativelab.fr', '0708091011', '2026-03-24 13:45:29'),
(6, 'TechCorp', 'TechCorp est une entreprise spécialisée dans le développement de solutions web et logicielles sur mesure. Elle conçoit des plateformes digitales performantes adaptées aux besoins des entreprises.', 'contact@techcorp.fr', '0611223344', '2026-03-27 14:27:50'),
(7, 'SecureIT', 'SecureIT est une entreprise spécialisée en cybersécurité et protection des systèmes informatiques. Elle accompagne les entreprises dans la sécurisation de leurs infrastructures.', 'contact@secureit.fr', '0677889900', '2026-03-27 14:27:50'),
(8, 'CyberNova', 'CyberNova est une entreprise innovante spécialisée dans la cybersécurité et l’intelligence artificielle. Elle développe des solutions de protection avancées pour les entreprises.', 'contact@cybernova.fr', '0678451239', '2026-03-27 14:27:50');

-- --------------------------------------------------------

--
-- Structure de la table `offres`
--

CREATE TABLE `offres` (
  `id` int(11) NOT NULL,
  `entreprise_id` int(11) NOT NULL,
  `titre` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `competences` text DEFAULT NULL,
  `localite` varchar(255) DEFAULT NULL,
  `duree` varchar(100) DEFAULT NULL,
  `nb_places` int(11) DEFAULT 1,
  `remuneration` decimal(10,2) DEFAULT NULL,
  `date_offre` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `offres`
--

INSERT INTO `offres` (`id`, `entreprise_id`, `titre`, `description`, `competences`, `localite`, `duree`, `nb_places`, `remuneration`, `date_offre`, `created_at`) VALUES
(2, 2, 'Data Analyst', 'Analyse de données et reporting', NULL, NULL, NULL, 1, 900.00, '2026-03-21', '2026-03-24 13:45:29'),
(15, 3, 'UX/UI Designer Junior', 'Création de maquettes et amélioration UX.', NULL, NULL, NULL, 1, 800.00, '2026-03-27', '2026-03-27 14:31:40'),
(16, 2, 'Data Analyst', 'Analyse de données et dashboards.', NULL, NULL, NULL, 1, 900.00, '2026-03-27', '2026-03-27 14:31:40'),
(17, 6, 'Développeur Web Fullstack', 'Développement web PHP / JS.', NULL, NULL, NULL, 1, 850.00, '2026-03-27', '2026-03-27 14:31:40'),
(18, 7, 'Consultant Cybersécurité', 'Audit et sécurité des systèmes.', NULL, NULL, NULL, 1, 950.00, '2026-03-27', '2026-03-27 14:31:40'),
(19, 8, 'Ingénieur IA & Sécurité', 'Détection d’intrusions avec IA.', NULL, NULL, NULL, 1, 1000.00, '2026-03-27', '2026-03-27 14:31:40'),
(20, 6, 'Développeur Mobile', 'Applications Android/iOS.', NULL, NULL, NULL, 1, 800.00, '2026-03-27', '2026-03-27 14:31:40'),
(21, 3, 'Marketing Digital', 'SEO et réseaux sociaux.', NULL, NULL, NULL, 1, 700.00, '2026-03-27', '2026-03-27 14:31:40'),
(22, 3, 'UX/UI Designer Junior', 'Création de maquettes et amélioration UX.', NULL, NULL, NULL, 1, 800.00, '2026-03-27', '2026-03-27 14:34:11'),
(23, 2, 'Data Analyst', 'Analyse de données et dashboards.', NULL, NULL, NULL, 1, 900.00, '2026-03-27', '2026-03-27 14:34:11'),
(24, 6, 'Développeur Web Fullstack', 'Développement web PHP / JS.', NULL, NULL, NULL, 1, 850.00, '2026-03-27', '2026-03-27 14:34:11'),
(25, 7, 'Consultant Cybersécurité', 'Audit et sécurité des systèmes.', NULL, NULL, NULL, 1, 950.00, '2026-03-27', '2026-03-27 14:34:11'),
(26, 8, 'Ingénieur IA & Sécurité', 'Détection d’intrusions avec IA.', NULL, NULL, NULL, 1, 1000.00, '2026-03-27', '2026-03-27 14:34:11'),
(27, 6, 'Développeur Mobile', 'Applications Android/iOS.', NULL, NULL, NULL, 1, 800.00, '2026-03-27', '2026-03-27 14:34:11'),
(28, 3, 'Marketing Digital', 'SEO et réseaux sociaux.', NULL, NULL, NULL, 1, 700.00, '2026-03-27', '2026-03-27 14:34:11');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `nom`) VALUES
(1, 'admin'),
(3, 'etudiant'),
(2, 'pilote');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`, `role_id`, `created_at`) VALUES
(1, 'Admin', 'StagePro', 'admin@stagepro.fr', '$2y$10$CHrQlxIkBDXIGVcRTD8tUe0quwucOLIwDnckCgJA1q6mWd0vylJba', 1, '2026-03-24 13:54:36'),
(2, 'Pilote', 'Paul', 'pilote@stagepro.fr', '$2y$10$CHrQlxIkBDXIGVcRTD8tUe0quwucOLIwDnckCgJA1q6mWd0vylJba', 2, '2026-03-24 13:54:36'),
(3, 'Etudiant', 'Emma', 'etudiant@stagepro.fr', '$2y$10$CHrQlxIkBDXIGVcRTD8tUe0quwucOLIwDnckCgJA1q6mWd0vylJba', 3, '2026-03-24 13:54:36'),
(5, 'Pleindoux', 'Valentin', 'valentin.pleindoux@viacesi.fr', '$2y$10$8raFQm5W8KVGoen2JGS3se0RgLPQHWynrZL3wOyohzwpzLHd3cYqm', 2, '2026-03-25 14:07:36'),
(6, 'Pleindoux', 'Valentin', 'pleindoux.valentin13@gmail.com', '$2y$10$9ICB8d/91om3lti2Yyz9K.ni.Wo10tPiR5Nqa3GUFlr8XZmG9MizC', 3, '2026-03-25 14:39:25'),
(7, 'de', 'de', 'eded@gmail.com', '$2y$10$3NvmD7I.mWFveTIsskZSmuM70F58RTgziITt4WFruhxbR/vA02sKy', 2, '2026-03-26 16:10:58');

-- --------------------------------------------------------

--
-- Structure de la table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `offre_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `candidatures`
--
ALTER TABLE `candidatures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `offre_id` (`offre_id`);

--
-- Index pour la table `entreprises`
--
ALTER TABLE `entreprises`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `offres`
--
ALTER TABLE `offres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entreprise_id` (`entreprise_id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Index pour la table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_wishlist` (`utilisateur_id`,`offre_id`),
  ADD KEY `fk_wishlist_offre` (`offre_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `candidatures`
--
ALTER TABLE `candidatures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `entreprises`
--
ALTER TABLE `entreprises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `offres`
--
ALTER TABLE `offres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `candidatures`
--
ALTER TABLE `candidatures`
  ADD CONSTRAINT `candidatures_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `candidatures_ibfk_2` FOREIGN KEY (`offre_id`) REFERENCES `offres` (`id`);

--
-- Contraintes pour la table `offres`
--
ALTER TABLE `offres`
  ADD CONSTRAINT `offres_ibfk_1` FOREIGN KEY (`entreprise_id`) REFERENCES `entreprises` (`id`);

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Contraintes pour la table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `fk_wishlist_offre` FOREIGN KEY (`offre_id`) REFERENCES `offres` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_wishlist_user` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
