<?php
session_start();
require_once '../includes/db_connect.php';

// Vérifie si l'utilisateur est connecté et est un athlète
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'athlete') {
    header("Location: ../login.html");
    exit;
}

// Récupère les inscriptions de l'utilisateur avec le couloir attribué
$user_id = $_SESSION['user_id'];
$sql = "SELECT i.course_id, i.couloir, c.nom, c.date_course, c.course_type, c.round_type
        FROM inscriptions i
        JOIN courses c ON i.course_id = c.id
        WHERE i.user_id = '$user_id'
        ORDER BY c.date_course ASC";
$result = mysqli_query($conn, $sql);
$registrations = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Courses - Sprint Meet</title>
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

        /* Section des courses */
        .courses-section {
            background: var(--white);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 1000px;
            margin: 0 auto;
        }
        .courses-section h1 {
            font-size: 2rem;
            color: var(--primary-blue);
            margin-bottom: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: var(--primary-blue);
            color: var(--white);
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e0e7ff;
        }
        .details-btn {
            background-color: var(--primary-blue);
            color: var(--white);
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .details-btn:hover {
            background-color: #1f6690;
        }
        .cancel-link {
            color: var(--secondary-red);
            text-decoration: none;
            font-weight: bold;
        }
        .cancel-link:hover {
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
            .courses-section {
                padding: 15px;
            }
            table th, table td {
                padding: 8px;
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
                <li><a href="dashboard_athlete.php"><i class="fas fa-tachometer-alt"></i><span>Tableau de bord</span></a></li>
                <li><a href="mes_informations.php"><i class="fas fa-user"></i><span>Mes informations</span></a></li>
                <li><a href="choix_course.php"><i class="fas fa-flag-checkered"></i><span>S'inscrire à une course</span></a></li>
                <li><a href="../resultats_courses.php"><i class="fas fa-chart-line"></i><span>Résultats</span></a></li>
                <li><a href="../scripts/logout.php"><i class="fas fa-sign-out-alt"></i><span>Déconnexion</span></a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header>
                <div class="toggle-btn" id="toggleBtn"><i class="fas fa-bars"></i></div>
                <h1>Mes Courses</h1>
                <div class="user-profile">
                    <i class="fas fa-user-circle" style="font-size: 2rem;"></i>
                </div>
            </header>

            <!-- Section des courses -->
            <section class="courses-section">
                <h1>Mes Courses</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Nom de la course</th>
                            <th>Type course</th>
                            <th>Date & Heure</th>
                            <th>Couloir</th>
                            <th>Détails</th>
                            <th>Annuler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($registrations)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center;">Vous n'êtes inscrit à aucune course pour le moment.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($registrations as $reg): 
                                $statut = (strtotime($reg['date_course']) > time()) ? 'À venir' : 'Terminée';
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($reg['nom']); ?></td>
                                <td><?php echo htmlspecialchars($reg['course_type']); ?></td>
                                <td><?php echo htmlspecialchars($reg['date_course']); ?></td>
                                <td><?php echo htmlspecialchars($reg['couloir'] ?? 'Non attribué'); ?></td>
                                <td><button class="details-btn" onclick="alert('Nom: <?php echo htmlspecialchars($reg['nom']); ?>\nDate: <?php echo htmlspecialchars($reg['date_course']); ?>\nStatut: <?php echo $statut; ?>')">Détails</button></td>
                                <td><a href="ann_ins.php?course_id=<?php echo $reg['course_id']; ?>" class="cancel-link">Annuler</a></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
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