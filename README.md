# Sprint Meet 

Projet de gestion de compétitions d'athlétisme (sprint) réalisé dans le cadre de la deuxième année de DUT Informatique à l'École Supérieure Polytechnique de Dakar.

## Description

Cette application web permet de gérer l'organisation de compétitions de sprint. Elle offre des interfaces distinctes pour les administrateurs, les arbitres et les athlètes, chacun disposant de fonctionnalités adaptées à son rôle.

## Fonctionnalités

*   **Administrateur :**
    *   Gestion des utilisateurs (arbitres, athlètes)
    *   Création et gestion des compétitions et des courses
    *   Validation des résultats
*   **Arbitre :**
    *   Consultation des courses assignées
    *   Saisie des temps et des classements pour chaque course
*   **Athlète :**
    *   Inscription aux compétitions
    *   Consultation de ses courses et de ses résultats
*   **Visiteur :**
    *   Consultation des courses publiques et des résultats finaux.

## Installation

Suivez ces étapes pour installer et lancer le projet en local.

**Prérequis :**

*   Un serveur web local (Apache, Nginx)
*   PHP (préciser la version, ex: 7.4 ou supérieure)
*   Un système de gestion de base de données (MySQL / MariaDB)

**Étapes :**

1.  **Clonez le projet :**
    ```bash
    git clone https://github.com/abib17Drame/php-project.git
    cd php-project/sprint_meetNV
    ```

2.  **Base de données :**
    *   Ouvrez votre outil de gestion de base de données (phpMyAdmin, par exemple).
    *   Créez une nouvelle base de données nommée `sprint_meet`.
    *   Importez le fichier `sprint_meetNV/sql/sprint_meet.sql` dans la base de données que vous venez de créer.

3.  **Configuration :**
    *   Ouvrez le fichier `sprint_meetNV/includes/db_connect.php`.
    *   Modifiez les informations de connexion à la base de données si nécessaire (serveur, nom d'utilisateur, mot de passe).

4.  **Lancement :**
    *   Placez le dossier du projet dans le répertoire racine de votre serveur web (ex: `htdocs` pour XAMPP, `www` for WAMP).
    *   Ouvrez votre navigateur et accédez à `http://localhost/php-project/sprint_meetNV/`.



## Auteurs

*   Boubacar Ly
*   Serigne Amsatou LO SEYE
*   Sory Ibrahima SOUMARE
*   Mouhamadou Abib DRAME

---