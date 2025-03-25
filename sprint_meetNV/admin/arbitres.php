<?php
require_once '../includes/db_connect.php';

// Récupération des arbitres
$sql = "SELECT * FROM users WHERE role = 'arbitre' ORDER BY nom, prenom";
$result = mysqli_query($conn, $sql);
$arbitres = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Arbitres - Sprint Meet</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #2980b9;
            --secondary-red: #e74c3c;
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

        /* Table des arbitres */
        .table-container {
            overflow-x: auto;
            margin: 20px 0;
        }
        .arbitre-table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .arbitre-table th, .arbitre-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .arbitre-table th {
            background-color: var(--primary-blue);
            color: var(--white);
        }
        .arbitre-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .arbitre-table tr:hover {
            background-color: #e0e7ff;
        }
        .actions-column {
            min-width: 350px;
            white-space: nowrap;
        }

        /* Boutons d’action */
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
            background-color: #1f618d; /* Bleu foncé pour voir */
        }
        .btn-view:hover {
            background-color: #154360; /* Plus foncé */
        }
        .btn-manage {
            background-color: var(--primary-blue); /* Bleu principal */
        }
        .btn-manage:hover {
            background-color: #1f6690; /* Bleu légèrement plus foncé */
        }
        .btn-edit {
            background-color: #3498db; /* Bleu clair pour modifier */
        }
        .btn-edit:hover {
            background-color: #2980b9; /* Bleu principal */
        }
        .btn-delete {
            background-color: var(--secondary-red); /* Rouge pour supprimer */
        }
        .btn-delete:hover {
            background-color: #c0392b; /* Rouge foncé */
        }
        .btn:hover {
            transform: translateY(-3px);
        }

        /* Lien Retour */
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
        <h1>Gestion des Arbitres</h1>
    </header>

    <div class="table-container">
        <table class="arbitre-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Identifiant</th>
                    <th>Certification</th>
                    <th class="actions-column">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($arbitres as $arbitre): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($arbitre['nom']); ?></td>
                        <td><?php echo htmlspecialchars($arbitre['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($arbitre['email']); ?></td>
                        <td><?php echo htmlspecialchars($arbitre['identifiant']); ?></td>
                        <td><?php echo $arbitre['fichier_certif'] ? 'Oui' : 'Non'; ?></td>
                        <td class="action-buttons">
                            <a href="details_arbitre.php?id=<?php echo $arbitre['id']; ?>" class="btn btn-view"><i class="fas fa-search"></i> Détails</a>
                            <a href="gerer_assignations.php?id=<?php echo $arbitre['id']; ?>" class="btn btn-manage"><i class="fas fa-tasks"></i> Gérer Assignation</a>
                            <a href="modifier_arbitre.php?id=<?php echo $arbitre['id']; ?>" class="btn btn-edit"><i class="fas fa-edit"></i> Modifier</a>
                            <a href="supprimer_arbitre.php?id=<?php echo $arbitre['id']; ?>" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet arbitre ?')"><i class="fas fa-trash"></i> Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <a href="dashboard_admin.php" class="retour">Retour au tableau de bord</a>
</body>
</html>