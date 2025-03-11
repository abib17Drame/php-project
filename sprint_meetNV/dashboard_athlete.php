<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Athlète - Sprint Meet</title>
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #2980b9;      /* Bleu élégant */
            --secondary-red: #e74c3c;     /* Rouge vibrant */
            --white: #fff;
            --black: #000;
            --sidebar-width: 250px;
        }

        /* Réinitialisation */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--white);
            color: var(--black);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            transition: all 0.3s ease;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--black);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
            transition: width 0.3s ease;
            overflow: hidden;
            color: var(--white);
        }
        .sidebar.collapsed {
            width: 70px;
        }
        .sidebar .logo {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
        }
        .sidebar ul {
            list-style: none;
        }
        .sidebar ul li {
            margin-bottom: 20px;
        }
        .sidebar ul li a {
            color: var(--white);
            text-decoration: none;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 5px;
            transition: background 0.3s ease, transform 0.3s ease;
        }
        .sidebar ul li a:hover {
            background: rgba(255,255,255,0.2);
            transform: translateX(5px);
        }
        .sidebar ul li a span {
            display: inline-block;
            white-space: nowrap;
            opacity: 1;
            transition: opacity 0.3s ease;
        }
        .sidebar.collapsed ul li a span {
            opacity: 0;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            width: 100%;
            transition: margin-left 0.3s ease;
        }
        .sidebar.collapsed ~ .main-content {
            margin-left: 70px;
        }

        /* Header */
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(90deg, var(--primary-blue), var(--secondary-red));
            padding: 10px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            color: var(--white);
        }
        header .toggle-btn {
            font-size: 1.5rem;
            cursor: pointer;
        }
        header h1 {
            font-size: 1.8rem;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
        }

        /* Section d'informations */
        .athlete-info {
            background: linear-gradient(90deg, var(--primary-blue), var(--secondary-red));
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
            font-size: 1rem;
            line-height: 1.5;
            color: var(--white);
            text-align: center;
        }
        .athlete-info ul {
            list-style: none;
            margin: 20px 0;
            padding: 0;
        }
        .athlete-info ul li {
            margin: 10px 0;
        }
        .athlete-info strong {
            color: var(--white);
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }
            .sidebar.collapsed {
                width: 100%;
            }
            .main-content {
                margin-left: 0;
            }
            header {
                flex-direction: column;
                text-align: center;
            }
            .athlete-info {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="logo">Sprint Meet</div>
            <ul>
                <li><a href="scripts/mescourses.php"><i class="fas fa-running"></i><span>Courses inscrites</span></a></li>
                <li><a href="scripts/choix_course.php"><i class="fas fa-flag-checkered"></i><span>S'inscrire à une course</span></a></li>
                <li><a href="resultats_courses.php"><i class="fas fa-chart-line"></i><span>Résultats</span></a></li>
                <li><a href="scripts/logout.php"><i class="fas fa-sign-out-alt"></i><span>Déconnexion</span></a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header>
                <div class="toggle-btn" id="toggleBtn"><i class="fas fa-bars"></i></div>
                <h1>Tableau de Bord Athlète</h1>
                <div class="user-profile">
                    <i class="fas fa-user-circle" style="font-size: 2rem;"></i>
                </div>
            </header>

            <!-- Section d'informations -->
            <section class="athlete-info">
                <p>Vous êtes connecté en tant qu'athlète. Depuis ce tableau de bord, vous pouvez :</p>
                <ul>
                    <li><strong>S'inscrire à une course</strong></li>
                    <li><strong>Voir les courses auxquelles vous êtes inscrit</strong> 🏃‍♂️</li>
                    <li><strong>Consulter vos résultats et vos performances</strong> 🏆</li>
                </ul>
                <p>Utilisez le menu à gauche pour naviguer entre les différentes sections.</p>
            </section>
        </div>
    </div>

    <script>
        // Toggle sidebar collapse/expand
        const toggleBtn = document.getElementById('toggleBtn');
        const sidebar = document.getElementById('sidebar');
        
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    </script>
</body>
</html>