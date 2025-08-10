-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mer. 26 mars 2025 à 09:31
-- Version du serveur : 8.0.35
-- Version de PHP : 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : sprint_meet
--
CREATE DATABASE sprint_meet;
USE sprint_meet;
-- --------------------------------------------------------

--
-- Structure de la table arbitrage
--

CREATE TABLE arbitrage (
  id int NOT NULL,
  arbitre_id int DEFAULT NULL,
  course_id int DEFAULT NULL,
  date_assignation datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table arbitrage
--

INSERT INTO arbitrage (id, arbitre_id, course_id, date_assignation) VALUES
(8, 6, 9, '2025-03-21 23:19:24');

-- --------------------------------------------------------

--
-- Structure de la table courses
--

CREATE TABLE courses (
  id int NOT NULL,
  nom varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  course_type enum('Sprint100m','Sprint200m','Sprint400m','Haies100m','Haies110m','Haies400m','Relais4x100m','Relais4x400m','Autre') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  round_type enum('Series','DemiFinale','Finale') COLLATE utf8mb4_general_ci NOT NULL,
  date_course date NOT NULL,
  statut_inscription enum('ouvert','ferme') COLLATE utf8mb4_general_ci DEFAULT 'ouvert'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table courses
--

INSERT INTO courses (id, nom, course_type, round_type, date_course, statut_inscription) VALUES
(9, 'Sprint100m Homme', 'Sprint100m', 'DemiFinale', '2025-08-17', 'ferme');

-- --------------------------------------------------------

--
-- Structure de la table inscriptions
--

CREATE TABLE inscriptions (
  id int NOT NULL,
  user_id int NOT NULL,
  course_id int NOT NULL,
  date_inscription timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  position int DEFAULT NULL,
  temps_realise varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  couloir int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table inscriptions
--

INSERT INTO inscriptions (id, user_id, course_id, date_inscription, position, temps_realise, couloir) VALUES
(20, 22, 9, '2025-03-09 01:31:10', NULL, '00:01:00', 2),
(22, 18, 9, '2025-03-09 01:33:23', NULL, '00:08:00', 3),
(23, 13, 9, '2025-03-21 23:17:50', NULL, '00:08:06', 5);

-- --------------------------------------------------------

--
-- Structure de la table performances
--

CREATE TABLE performances (
  id int NOT NULL,
  inscription_id int NOT NULL,
  temps float DEFAULT NULL,
  statut enum('OK','DNS','DNF','DSQ') COLLATE utf8mb4_general_ci DEFAULT 'OK',
  est_qualifie tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table users
--

CREATE TABLE users (
  id int NOT NULL,
  nom varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  prenom varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  email varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  mot_de_passe varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  role enum('admin','arbitre','athlete') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'athlete',
  profil enum('individuel','equipe') COLLATE utf8mb4_general_ci DEFAULT 'individuel',
  sexe enum('homme','femme') COLLATE utf8mb4_general_ci DEFAULT 'homme',
  pays varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  age int DEFAULT NULL,
  club varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  discipline varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  discipline_equipe varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  record_officiel varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  fichier_record varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  diplome varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  piece_identite varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  identifiant varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  fichier_certif varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  date_creation timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table users
--

INSERT INTO users (id, nom, prenom, email, mot_de_passe, role, profil, sexe, pays, age, club, discipline, discipline_equipe, record_officiel, fichier_record, diplome, piece_identite, identifiant, fichier_certif, date_creation) VALUES
(6, 'ad', 'Ad', 'ad@gmail.com', '$2y$10$BGA4i4xydYaSbnhonGFhDe62OR6oIvMZFiR7SR1UsPCAR.gEmQ08C', 'arbitre', 'individuel', 'homme', '', 0, NULL, '', '', '00:00:00', NULL, NULL, NULL, 'ad', NULL, '2025-03-06 14:00:45'),
(8, 'Admin', 'Super', 'admin@sprintmeet.com', 'admin', 'admin', 'individuel', 'homme', NULL, NULL, NULL, NULL, NULL, '00:00:00', NULL, NULL, NULL, NULL, NULL, '2025-03-06 14:07:49'),
(10, 'Fall', 'Alou', 'Alou@gmail.com', '$2y$10$AUpRfWYn0uiRG3MdCpKqq.QnnR0urkG10b1pBllN988q.JZavz2zG', 'athlete', 'individuel', 'homme', 'Senegal', 32, NULL, '', '', '00:00:00', NULL, NULL, NULL, '', NULL, '2025-03-06 14:40:17'),
(12, 'Bah', 'Baba', 'baba@gmail.com', '$2y$10$bHHkcjjjjpoW3IiKm7dkTucRLDlC/U/eL61FydMbsp9HxnM3VxSEu', 'athlete', 'individuel', 'homme', 'Senegal', 25, NULL, '', '', '00:00:00', NULL, NULL, NULL, '', NULL, '2025-03-06 14:45:15'),
(13, 'Lah', 'Abdou', 'abdou@gmail.com', '$2y$10$/8C1x.NBFoBwHqeGdhA9Z.cIwMP4ctw5b324D8CfRglnKRkkA4iGu', 'athlete', 'individuel', 'homme', 'Mali', 21, NULL, '', '', '00:00:00', NULL, NULL, NULL, '', NULL, '2025-03-06 14:50:41'),
(14, 'Diakite', 'Momo', 'momo@gmail.com', '$2y$10$4GEODYvUvr4LtFfmN/brFujNp0TR1SYejdO5jhtH0ngzcdiDjHZFG', 'athlete', 'individuel', 'homme', 'Senegal', 28, NULL, '', '', '00:00:00', NULL, NULL, NULL, '', NULL, '2025-03-06 15:00:29'),
(15, 'Bagayogo', 'Amar', 'amar@gmail.com', '$2y$10$yOc/1lVfys9OyRSTmwVYmOcb1E2AJPByO04vy2GTKYuy6PSXXA8z.', 'athlete', 'individuel', 'homme', 'Mali', 25, NULL, '', '', '00:00:00', NULL, NULL, NULL, '', NULL, '2025-03-06 15:04:01'),
(16, 'Drame', 'Habib', 'abib@gmail.com', '$2y$10$cCySmPT.yUOXXd7of1ZfqexQkrZZOv3NrWq9anwKd.rX1ox91tp1W', 'athlete', 'individuel', 'homme', 'Senegal', 27, NULL, '', '', '00:00:00', NULL, NULL, NULL, '', NULL, '2025-03-06 15:21:03'),
(18, 'Wade', 'Malick', 'malick@gmail.com', '$2y$10$uznwl8bQPwt/0lrWtg8TmupzzvW8HZwwODO2VJdTvSdBXTLxF2gte', 'athlete', 'individuel', 'homme', 'Senegal', 18, NULL, '', '', '00:00:00', NULL, NULL, NULL, '', NULL, '2025-03-06 15:34:25'),
(19, 'TT', 'Albert', 'Albert@gmail.com', '$2y$10$/Rcb2FafxAjYLGcjE0nRw.KzDGS/Kth4/OCoM8nWiQt5q.VEyL.0y', 'athlete', 'equipe', 'homme', '', 0, NULL, '', '', '00:00:00', NULL, NULL, NULL, '', NULL, '2025-03-06 20:50:40'),
(20, 'Diakite', 'Mamadou ', 'Mamadou@gmail.com', '$2y$10$xK7R.4d1fcJ6wKi.DVyUU.wTxBQ9euhdHSDurA02vUdHdD5ssXXSq', 'athlete', 'individuel', 'homme', 'Mali', 19, NULL, '', '', '00:00:24', NULL, NULL, NULL, '', NULL, '2025-03-06 22:47:07'),
(22, 'Soumaré', 'Sory ibrahim', 'sory@gmail.com', '$2y$10$EJiAUtEC.mXQ/4puaT03.e6IC9nlyFO/.sgmZ1/upjHbUGnmXE35q', 'athlete', 'individuel', 'homme', 'Mali', 19, NULL, '', '', '00:09:00', NULL, NULL, NULL, '', NULL, '2025-03-09 01:30:49');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table arbitrage
--
ALTER TABLE arbitrage
  ADD PRIMARY KEY (id),
  ADD KEY arbitre_id (arbitre_id),
  ADD KEY course_id (course_id);

--
-- Index pour la table courses
--
ALTER TABLE courses
  ADD PRIMARY KEY (id);

--
-- Index pour la table inscriptions
--
ALTER TABLE inscriptions
  ADD PRIMARY KEY (id),
  ADD KEY user_id (user_id),
  ADD KEY course_id (course_id);

--
-- Index pour la table performances
--
ALTER TABLE performances
  ADD PRIMARY KEY (id),
  ADD KEY inscription_id (inscription_id);

--
-- Index pour la table users
--
ALTER TABLE users
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY email (email);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table arbitrage
--
ALTER TABLE arbitrage
  MODIFY id int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table courses
--
ALTER TABLE courses
  MODIFY id int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table inscriptions
--
ALTER TABLE inscriptions
  MODIFY id int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table performances
--
ALTER TABLE performances
  MODIFY id int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table users
--
ALTER TABLE users
  MODIFY id int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table arbitrage
--
ALTER TABLE arbitrage
  ADD CONSTRAINT arbitrage_ibfk_1 FOREIGN KEY (arbitre_id) REFERENCES users (id),
  ADD CONSTRAINT arbitrage_ibfk_2 FOREIGN KEY (course_id) REFERENCES courses (id);

--
-- Contraintes pour la table inscriptions
--
ALTER TABLE inscriptions
  ADD CONSTRAINT inscriptions_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id),
  ADD CONSTRAINT inscriptions_ibfk_2 FOREIGN KEY (course_id) REFERENCES courses (id);

--
-- Contraintes pour la table performances
--
ALTER TABLE performances
  ADD CONSTRAINT performances_ibfk_1 FOREIGN KEY (inscription_id) REFERENCES inscriptions (id);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;