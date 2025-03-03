<?php
require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des Athlètes - Sprint Meet</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
      .athlete-table {
          width: 100%;
          border-collapse: collapse;
          margin: 20px 0;
      }
      .athlete-table th, .athlete-table td {
          padding: 12px;
          text-align: left;
          border: 1px solid #ddd;
      }
      .athlete-table th {
          background-color: #2c3e50;
          color: white;
      }
      .athlete-table tr:nth-child(even) {
          background-color: #f2f2f2;
      }
      .action-buttons {
          display: flex;
          gap: 10px;
      }
      .btn {
          padding: 5px 10px;
          border-radius: 4px;
          cursor: pointer;
          color: white;
          text-decoration: none;
      }
      .btn-view {background-color: #3498db;}
      .btn-edit {background-color: #2ecc71;}
      .btn-delete {background-color: #e74c3c;}
      .search-box {
          margin: 20px 0;
          padding: 10px;
      }
      .btn-voir-dossier{
        background-color:rgb(160, 174, 39);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
      }
  </style>
</head>
<body>
  <h1>Gestion des Athlètes</h1>

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
                      <a href="details_athlete.php?id=<?php echo $athlete['id']; ?>" class="btn btn-view">Details</a>
                      <a href="modifier_athlete.php?id=<?php echo $athlete['id']; ?>" class="btn btn-edit">Modifier</a>
                      <a href="supprimer_athlete.php?id=<?php echo $athlete['id']; ?>" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet athlète ?')">Supprimer</a>
                      <a href="admin/voir_dossiers.php?athlete_id=<?php echo $athlete['id']; ?>" 
                         class="btn-voir-dossier">
                          Voir dossiers
                      </a>
                    </td>
              </tr>
          <?php endforeach; ?>
      </tbody>
  </table>

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
