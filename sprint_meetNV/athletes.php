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
      }
      .btn-view {background-color: #3498db;}
      .btn-edit {background-color: #2ecc71;}
      .btn-delete {background-color: #e74c3c;}
      .search-box {
          margin: 20px 0;
          padding: 10px;
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
          require_once 'includes/db_connect.php';

          try {
              // Récupération des athlètes
              $sql = "SELECT id, nom, prenom, email, profil, sexe, record_officiel FROM users WHERE role = 'athlete'";
              $stmt = $pdo->query($sql);
              $athletes = $stmt->fetchAll(PDO::FETCH_ASSOC);

              foreach($athletes as $athlete): ?>
              <tr>
                  <td><?= htmlspecialchars($athlete['id']) ?></td>
                  <td><?= htmlspecialchars($athlete['nom']) ?></td>
                  <td><?= htmlspecialchars($athlete['prenom']) ?></td>
                  <td><?= htmlspecialchars($athlete['email']) ?></td>
                  <td><?= htmlspecialchars($athlete['profil']) ?></td>
                  <td><?= htmlspecialchars($athlete['record_officiel']) ?></td>
                  <td class="action-buttons">
                      <button class="btn btn-view" onclick="voirDetails(<?= $athlete['id'] ?>)">Voir</button>
                      <button class="btn btn-edit" onclick="modifierAthlete(<?= $athlete['id'] ?>)">Modifier</button>
                      <button class="btn btn-delete" onclick="supprimerAthlete(<?= $athlete['id'] ?>)">Supprimer</button>
                  </td>
              </tr>
              <?php endforeach;
          } catch(PDOException $e) {
              echo "Erreur : " . $e->getMessage();
          }
          ?>
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

      function voirDetails(id) {
          window.location.href = `details_athlete.php?id=${id}`;
      }

      function modifierAthlete(id) {
          window.location.href = `modifier_athlete.php?id=${id}`;
      }

      function supprimerAthlete(id) {
          if(confirm('Êtes-vous sûr de vouloir supprimer cet athlète ?')) {
              window.location.href = `supprimer_athlete.php?id=${id}`;
          }
      }
  </script>
</body>
</html>
