CREATE DATABASE IF NOT EXISTS sprint_meet;
USE sprint_meet;

DROP TABLE IF EXISTS performances;
DROP TABLE IF EXISTS inscriptions;
DROP TABLE IF EXISTS courses;
DROP TABLE IF EXISTS users;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  prenom VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE, 
  mot_de_passe VARCHAR(255) NOT NULL,
  role ENUM('admin','arbitre','athlete') NOT NULL DEFAULT 'athlete',
  
  -- Pour gérer le type de compte (individuel ou équipe)
  profil ENUM('individuel','equipe') DEFAULT 'individuel',
  
  -- Informations communes pour les athlètes et arbitres
  sexe ENUM('homme','femme') DEFAULT 'homme',
  pays VARCHAR(100) DEFAULT NULL,
  age INT DEFAULT NULL,
  club VARCHAR(100) DEFAULT NULL,
  
  -- Informations spécifiques pour les athlètes
  discipline VARCHAR(50) DEFAULT NULL,            -- pour un compte individuel
  discipline_equipe VARCHAR(50) DEFAULT NULL,       -- pour un compte équipe
  record_officiel VARCHAR(20) DEFAULT '00:00:00',
  fichier_record VARCHAR(255) DEFAULT NULL,         -- chemin vers le fichier record
  diplome VARCHAR(255) DEFAULT NULL,                -- pour diplômes (individuel)
  piece_identite VARCHAR(255) DEFAULT NULL,         -- pour la pièce d'identité (individuel)
  
  -- Informations spécifiques pour les arbitres
  identifiant VARCHAR(100) DEFAULT NULL,
  fichier_certif VARCHAR(255) DEFAULT NULL,         -- chemin vers le certificat d'arbitrage
  
  date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  course_type ENUM('Sprint100m','Sprint120m','Haies100m','Relais4x100m','Relais4x400m','Autre') NOT NULL,
  round_type ENUM('Series','DemiFinale','Finale') NOT NULL,
  date_course DATE NOT NULL,
  statut_inscription ENUM('ouvert','ferme') DEFAULT 'ouvert'
);

CREATE TABLE IF NOT EXISTS inscriptions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  course_id INT NOT NULL,
  date_inscription DATE NOT NULL DEFAULT CURRENT_DATE,
  position INT DEFAULT NULL,
  temps_realise VARCHAR(10) DEFAULT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (course_id) REFERENCES courses(id)
);

CREATE TABLE IF NOT EXISTS performances (
  id INT AUTO_INCREMENT PRIMARY KEY,
  inscription_id INT NOT NULL,
  temps FLOAT DEFAULT NULL,
  statut ENUM('OK','DNS','DNF','DSQ') DEFAULT 'OK',
  est_qualifie BOOLEAN DEFAULT FALSE,
  FOREIGN KEY (inscription_id) REFERENCES inscriptions(id)
);

CREATE TABLE arbitrage (
    id INT PRIMARY KEY AUTO_INCREMENT,
    arbitre_id INT,
    course_id INT,
    date_assignation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (arbitre_id) REFERENCES users(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
);
