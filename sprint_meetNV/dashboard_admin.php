<?php
require_once 'includes/db_connect.php';

// Récupération du nombre d'athlètes
$queryAthletes = "SELECT COUNT(*) as total FROM users WHERE role='athlete'";
$resultAthletes = mysqli_query($conn, $queryAthletes);
$rowAthletes = mysqli_fetch_assoc($resultAthletes);
$totalAthletes = $rowAthletes['total'];

// Récupération du nombre de courses
$queryCourses = "SELECT COUNT(*) as total FROM courses";
$resultCourses = mysqli_query($conn, $queryCourses);
$rowCourses = mysqli_fetch_assoc($resultCourses);
$totalCourses = $rowCourses['total'];

// Récupération du nombre d'arbitres
$queryArbitres = "SELECT COUNT(*) as total FROM users WHERE role='arbitre'";
$resultArbitres = mysqli_query($conn, $queryArbitres);
$rowArbitres = mysqli_fetch_assoc($resultArbitres);
$totalArbitres = $rowArbitres['total'];

// Récupération du nombre de résultats (inscriptions avec temps réalisé)
$queryResults = "SELECT COUNT(*) as total FROM inscriptions WHERE temps_realise IS NOT NULL";
$resultResults = mysqli_query($conn, $queryResults);
$rowResults = mysqli_fetch_assoc($resultResults);
$totalResults = $rowResults['total'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Administrateur - Sprint Meet</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Font Awesome pour les icônes -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-sOMEHASH" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-blue: #2980b9;      /* Bleu élégant */
      --secondary-red: #e74c3c;       /* Rouge vibrant */
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
    .admin-info {
      background: linear-gradient(90deg, var(--primary-blue), var(--secondary-red));
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 30px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.2);
      font-size: 1rem;
      line-height: 1.5;
      color: var(--white);
    }
    .admin-info strong {
      color: var(--white);
      text-decoration: underline;
    }
    /* Dashboard Cards */
    .dashboard-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }
    .card {
      background: var(--white);
      border: 2px solid var(--primary-blue);
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
      text-align: center;
      color: var(--black);
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card h3 {
      font-size: 1.2rem;
      margin-bottom: 10px;
      color: var(--secondary-red);
    }
    .card p {
      font-size: 2rem;
      font-weight: 700;
      margin: 0;
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
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
      <div class="logo">Sprint Meet</div>
      <ul>
        <li><a href="athletes.php"><i class="fas fa-running"></i><span>Gérer les Athlètes</span></a></li>
        <li><a href="courses.php"><i class="fas fa-flag-checkered"></i><span>Gérer les Courses</span></a></li>
        <li><a href="arbitres.php"><i class="fas fa-user-shield"></i><span>Gérer les Arbitres</span></a></li>
        <li><a href="resultats_courses.php"><i class="fas fa-chart-line"></i><span>Résultats</span></a></li>
        <li><a href="scripts/logout.php"><i class="fas fa-sign-out-alt"></i><span>Se déconnecter</span></a></li>
      </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
      <!-- Header -->
      <header>
        <div class="toggle-btn" id="toggleBtn"><i class="fas fa-bars"></i></div>
        <h1>Tableau de Bord Administrateur</h1>
        <div class="user-profile">
          <i class="fas fa-user-circle" style="font-size: 2rem;"></i>
        </div>
      </header>

      <!-- Section d'informations -->
      <section class="admin-info">
        En tant qu'Administrateur, vous avez accès aux fonctionnalités suivantes :<br>
        - <strong>Gérer les courses</strong> : Ajouter des courses.<br>
        - <strong>Gérer les athletes</strong> : Modifier, Supprimer et consulter les détails de chaque athlète.<br>
        - <strong>Gérer les arbitres</strong> : Modifier les infos, Supprimer et Assigner des courses à un arbitre.<br>
        - <strong>Consulter les résultats</strong> : Accédez aux résultats des matchs passés.<br>
        Merci pour votre travail et bonne journée !
      </section>

      <!-- Dashboard Cards -->
      <section class="dashboard-cards">
        <div class="card">
          <h3>Athlètes</h3>
          <p><?php echo $totalAthletes; ?></p>
        </div>
        <div class="card">
          <h3>Courses</h3>
          <p><?php echo $totalCourses; ?></p>
        </div>
        <div class="card">
          <h3>Arbitres</h3>
          <p><?php echo $totalArbitres; ?></p>
        </div>
        <div class="card">
          <h3>Résultats</h3>
          <p><?php echo $totalResults; ?></p>
        </div>
      </section>
      <!-- Vous pouvez ajouter d'autres sections ou widgets ici -->
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
