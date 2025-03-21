<?php
require_once '../includes/db_connect.php'; // Inclut le fichier de connexion à la base de données
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des Athlètes - Sprint Meet</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-blue: #2980b9; /* Bleu élégant */
      --secondary-red: #e74c3c; /* Rouge vibrant */
      --white: #fff;
      --black: #000;
    }

    /* Styles généraux */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Montserrat', sans-serif;
      background: var(--white);
      color: var(--black);
      text-align: center;
      min-height: 100vh;
      overflow-x: hidden;
      padding: 20px;
    }

    /* Header */
    header {
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(90deg, var(--primary-blue), var(--secondary-red));
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 20px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.3);
      color: var(--white);
    }
    h1 {
      font-size: 2rem;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
    }

    /* Search and Filter */
    .search-box {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin: 20px 0;
    }
    .search-box input, .search-box select {
      padding: 10px;
      border: 1px solid var(--primary-blue);
      border-radius: 5px;
      font-size: 1rem;
    }

    /* Athlete Table */
    .athlete-table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .athlete-table th, .athlete-table td {
      padding: 12px;
      text-align: left;
      border: 1px solid #ddd;
    }
    .athlete-table th {
      background-color: var(--primary-blue);
      color: var(--white);
    }
    .athlete-table tr:nth-child(even) {
      background-color: #f2f2f2;
    }
    .athlete-table tr:hover {
      background-color: #e0e7ff;
    }

    /* Action Buttons */
    .action-buttons {
      display: flex;
      gap: 10px;
    }
    .btn {
      padding: 8px 15px;
      min-width: 120px;
      border-radius: 4px;
      cursor: pointer;
      color: var(--white);
      text-decoration: none;
      transition: background-color 0.3s ease, transform 0.3s ease;
      text-align: center;
    }
    .btn i {
      margin-right: 5px;
    }
    .btn-view {
      background-color: var(--primary-blue); /* #2980b9 */
    }
    .btn-view:hover {
      background-color: #1f618d; /* Plus foncé */
    }
    .btn-edit {
      background-color: #3498db; /* Nuance plus claire de bleu */
    }
    .btn-edit:hover {
      background-color: #2980b9; /* Plus foncé */
    }
    .btn-delete {
      background-color: var(--secondary-red); /* #e74c3c */
    }
    .btn-delete:hover {
      background-color: #c0392b; /* Plus foncé */
    }
    .btn-voir-dossier {
      background-color: #1f618d; /* Nuance plus foncée de bleu */
    }
    .btn-voir-dossier:hover {
      background-color: #154360; /* Encore plus foncé */
    }
    .btn:hover {
      transform: translateY(-3px);
    }

    /* Return Link */
    .retour {
      display: inline-block;
      padding: 12px 25px;
      background: var(--primary-blue);
      color: var(--white);
      text-decoration: none;
      border-radius: 8px;
      margin-top: 20px;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }
    .retour:hover {
      background: var(--secondary-red);
      transform: translateY(-3px);
    }
  </style>
</head>
<body>
  <header>
    <h1>Gestion des Athlètes</h1>
  </header>

  <div class="search-box">
    <input type="text" id="searchAthlete" placeholder="Rechercher un athlète...">
    <select id="filterProfile">
      <option value="">Tous les profils</option>
      <option value="individuel">Individuel</option>
      <option value="equipe">Équipe</option>
    </select>
  </div>

  <table class="athlete-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Profil</th>
        <th>Record</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Récupération des athlètes
      $sql = "SELECT id, nom, prenom, email, profil, sexe, record_officiel FROM users WHERE role = 'athlete'";
      $result = mysqli_query($conn, $sql);
      $athletes = mysqli_fetch_all($result, MYSQLI_ASSOC);

      foreach ($athletes as $athlete): ?>
        <tr>
          <td><?php echo htmlspecialchars($athlete['id']); ?></td>
          <td><?php echo htmlspecialchars($athlete['nom']); ?></td>
          <td><?php echo htmlspecialchars($athlete['prenom']); ?></td>
          <td><?php echo htmlspecialchars($athlete['email']); ?></td>
          <td><?php echo htmlspecialchars($athlete['profil']); ?></td>
          <td><?php echo htmlspecialchars($athlete['record_officiel']); ?></td>
          <td class="action-buttons">
            <a href="details_athlete.php?id=<?php echo $athlete['id']; ?>" class="btn btn-view"><i class="fas fa-search"></i> Details</a>
            <a href="modifier_athlete.php?id=<?php echo $athlete['id']; ?>" class="btn btn-edit"><i class="fas fa-edit"></i> Modifier</a>
            <a href="supprimer_athlete.php?id=<?php echo $athlete['id']; ?>" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet athlète ?')"><i class="fas fa-trash"></i> Supprimer</a>
            <a href="voir_dossiers.php?athlete_id=<?php echo $athlete['id']; ?>" class="btn btn-voir-dossier"><i class="fas fa-folder"></i> Voir dossiers</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <a href="dashboard_admin.php" class="retour">Retour au tableau de bord</a>

  <script>
    // Recherche dynamique
    document.getElementById('searchAthlete').addEventListener('keyup', function() {
      let search = this.value.toLowerCase();
      let rows = document.querySelectorAll('.athlete-table tbody tr');
      rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(search) ? '' : 'none';
      });
    });

    // Filtrage par profil
    document.getElementById('filterProfile').addEventListener('change', function() {
      let filter = this.value.toLowerCase();
      let rows = document.querySelectorAll('.athlete-table tbody tr');
      rows.forEach(row => {
        let profile = row.children[4].textContent.toLowerCase();
        row.style.display = !filter || profile === filter ? '' : 'none';
      });
    });
  </script>
</body>
</html>