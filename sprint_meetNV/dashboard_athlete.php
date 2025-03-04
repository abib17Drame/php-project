<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Athlète</title>
    <style>
        /* Style général */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        /* Navigation */
        nav {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            padding: 15px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 20px;
            transition: background-color 0.3s, transform 0.3s;
            border-radius: 25px;
        }

        nav ul li a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
        }

        /* Section du tableau de bord */
        #dashboard-message {
            padding: 30px;
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            background-image: url('https://via.placeholder.com/800x400?text=Tableau+de+Bord+Athlète');
            background-size: cover;
            background-position: center;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        #dashboard-message::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        #dashboard-message h1,
        #dashboard-message p,
        #dashboard-message ul {
            position: relative;
            z-index: 2;
        }

        #dashboard-message h1 {
            color: #fff;
            font-size: 32px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        #dashboard-message p {
            font-size: 18px;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(86, 107, 156, 0.5);
        }

        #dashboard-message ul {
            list-style-type: none;
            padding: 0;
        }

        #dashboard-message ul li {
            margin-bottom: 15px;
            padding-left: 25px;
            position: relative;
            font-size: 16px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        #dashboard-message ul li::before {
            content: "•";
            color: #ff6f61;
            font-size: 24px;
            position: absolute;
            left: 0;
            top: -2px;
        }

        /* Responsive */
        @media (max-width: 600px) {
            nav ul {
                flex-direction: column;
                align-items: center;
            }

            nav ul li {
                margin: 10px 0;
            }

            #dashboard-message {
                padding: 20px;
                margin: 20px;
            }

            #dashboard-message h1 {
                font-size: 28px;
            }

            #dashboard-message p {
                font-size: 16px;
            }

            #dashboard-message ul li {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <nav>
        <ul>
            <li><a href="scripts/mescourses.php">Courses inscrit</a></li>
            <li><a href="stats_athlete.php">Statistiques</a></li>
            <li><a href="scripts/choix_course.php">S'inscrire à une course</a></li>
            <li><a href="resultats_courses.php">Résultats</a></li>
            <li><a href="scripts/logout.php">Déconnexion</a></li>
        </ul>
    </nav>

    <section id="dashboard-message">
        <h1>Bienvenue sur votre Tableau de Bord</h1>
        <p>Vous êtes connecté en tant qu'athlète. Depuis ce tableau de bord, vous pouvez :</p>
        <ul>
            <li>📌 **Consulter vos informations personnelles**.</li>
            <li>🏃‍♂️ **Voir les courses auxquelles vous êtes inscrit**.</li>
            <li>🏆 **Consulter vos résultats et vos performances**.</li>
            <li>📊 **Comparer vos performances avec celles des autres athlètes**.</li>
        </ul>
        <p>Utilisez le menu ci-dessus pour naviguer entre les différentes sections.</p>
    </section>

</body>
</html>