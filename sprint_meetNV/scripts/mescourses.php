<?php
session_start();
require_once '../includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'athlete') {
    header("Location: ../login.html");
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT i.course_id, c.nom, c.date_course, c.course_type, c.round_type
        FROM inscriptions i 
        JOIN courses c ON i.course_id = c.id
        WHERE i.user_id = :user_id
        ORDER BY c.date_course ASC
    ");
    $stmt->execute([':user_id' => $_SESSION['user_id']]);
    $registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Courses</title>
    <link rel="stylesheet" href="../css/style.css">
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

        /* Section des courses */
        #mes-courses {
            padding: 30px;
            max-width: 1000px;
            margin: 40px auto;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        #mes-courses h1 {
            color: #2c3e50;
            font-size: 32px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #2c3e50;
            color: #fff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .statut {
            font-weight: bold;
        }

        .statut.terminee {
            color: #d9534f; /* Rouge */
        }

        .statut.a-venir {
            color: #5cb85c; /* Vert */
        }

        .details-btn {
            background-color: #2c3e50;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .details-btn:hover {
            background-color: #34495e;
        }

        /* Modal pour les détails */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .modal-content h2 {
            margin-top: 0;
            color: #2c3e50;
        }

        .modal-content p {
            margin: 10px 0;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #d9534f;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
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

            #mes-courses {
                padding: 20px;
                margin: 20px;
            }

            table, thead, tbody, th, td, tr {
                display: block;
            }

            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                margin-bottom: 10px;
                border: 1px solid #ddd;
            }

            td {
                border: none;
                position: relative;
                padding-left: 50%;
            }

            td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: bold;
            }
        }
    </style>
</head>
<body>

<nav>
    <ul>
        <li><a href="../dashboard_athlete.html">Tableau de bord</a></li>
        <li><a href="mes_informations.php">Mes informations</a></li>
        <li><a href="../results.php">Résultats</a></li>
        <li><a href="mes_stats.html">Statistiques</a></li>
        <li><a href="choix_course.php">S'inscrire à une course</a></li>
        <li><a href="logout.php">Déconnexion</a></li>
    </ul>
</nav>  

<section id="mes-courses">
    <h1>Mes Courses</h1>
    <table>
        <thead>
            <tr>
                <th>Nom de la course</th>
                <th>Type course</th>
                <th>Date & Heure</th>
                <th>Statut</th>
                <th>Position de départ</th>
                <th>Détails</th>
                <th>Annuler</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($registrations)): ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Vous n'êtes inscrit à aucune course pour le moment.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($registrations as $reg): 
                    $statut = (strtotime($reg['date_course']) < time()) ? 'Terminée' : 'À venir';
                    $statutClass = (strtotime($reg['date_course']) < time()) ? 'statut terminee' : 'statut a-venir';
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($reg['nom']); ?></td>
                    <td><?php echo htmlspecialchars($reg['course_type']); ?></td>
                    <td><?php echo htmlspecialchars($reg['date_course']); ?></td>
                    <td class="<?php echo $statutClass; ?>"><?php echo $statut; ?></td>
                    <td><?php echo htmlspecialchars($reg['position_depart'] ?? 'N/A'); ?></td>
                    <td>
                        <button class="details-btn" onclick="ouvrirModal(
                            '<?php echo htmlspecialchars($reg['nom']); ?>', 
                            '<?php echo htmlspecialchars($reg['date_course']); ?>', 
                            '<?php echo $statut; ?>', 
                            '<?php echo htmlspecialchars($reg['position_depart'] ?? 'N/A'); ?>'
                        )">Détails</button>
                    </td>
                    <td><a href="ann_ins.php"></a></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<div id="detailsModal" class="modal">
    <div class="modal-content">
        <h2 id="modalTitre">Détails de la course</h2>
        <p><strong>Date & Heure :</strong> <span id="modalDate">Aucune donnée</span></p>
        <p><strong>Statut :</strong> <span id="modalStatut">Aucune donnée</span></p>
        <p><strong>Position de départ :</strong> <span id="modalPosition">Aucune donnée</span></p>
        <button class="close-btn" onclick="fermerModal()">Fermer</button>
    </div>
</div>

<script>
    function ouvrirModal(nom, date, statut, position) {
        document.getElementById('modalTitre').innerText = nom;
        document.getElementById('modalDate').innerText = date;
        document.getElementById('modalStatut').innerText = statut;
        document.getElementById('modalPosition').innerText = position;
        document.getElementById('detailsModal').style.display = "flex";
    }

    function fermerModal() {
        document.getElementById('detailsModal').style.display = "none";
    }
</script>

</body>
</html>
