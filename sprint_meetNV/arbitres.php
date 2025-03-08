<?php
require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

// Récupération des arbitres
$sql = "SELECT * FROM users WHERE role = 'arbitre' ORDER BY nom, prenom";
$result = mysqli_query($conn, $sql);
$arbitres = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Arbitres</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .arbitre-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            overflow-x: auto;
        }

        .arbitre-table th, .arbitre-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .arbitre-table th {
            background: #2c3e50;
            color: white;
        }

        .actions-column {
            min-width: 350px;
            white-space: nowrap;
        }

        .btn {
            display: inline-block;
            padding: 6px 10px;
            margin: 2px;
            font-size: 13px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-view { background: #3498db; }
        .btn-manage { background: #9b59b6; }
        .btn-edit { background: #2ecc71; }
        .btn-delete { background: #e74c3c; }

        .arbitre-table td {
            vertical-align: middle;
            padding: 8px;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .table-container {
            overflow-x: auto;
        }
       
        .retour {
            display: inline-block;
            padding: 12px 25px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        .retour:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <h1>Gestion des Arbitres</h1>

    <div class="table-container">
        <table class="arbitre-table">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Identifiant</th>
                <th>Certification</th>
                <th class="actions-column">Actions</th>
            </tr>
            <?php foreach ($arbitres as $arbitre): ?>
                <tr>
                    <td><?php echo htmlspecialchars($arbitre['nom']); ?></td>
                    <td><?php echo htmlspecialchars($arbitre['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($arbitre['email']); ?></td>
                    <td><?php echo htmlspecialchars($arbitre['identifiant']); ?></td>
                    <td><?php echo $arbitre['fichier_certif'] ? 'Oui' : 'Non'; ?></td>
                    <td class="actions-column">
                        <a href="details_arbitre.php?id=<?php echo $arbitre['id']; ?>" class="btn btn-view">Détails</a>
                        <a href="gerer_assignations.php?id=<?php echo $arbitre['id']; ?>" class="btn btn-manage">Gérer Assignation</a>
                        <a href="modifier_arbitre.php?id=<?php echo $arbitre['id']; ?>" class="btn btn-edit">Modifier</a>
                        <a href="supprimer_arbitre.php?id=<?php echo $arbitre['id']; ?>" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet arbitre ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <a href="dashboard_admin.php" class="retour">Retour au tableau de bord</a>
</body>
</html>