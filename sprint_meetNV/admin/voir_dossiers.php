<?php
session_start();
require_once '../includes/db_connect.php';

// Vérifier si l'ID de l'athlète est bien passé en paramètre
if (!isset($_GET['athlete_id']) || empty($_GET['athlete_id'])) {
    die("ID de l'athlète non spécifié.");
}

$athlete_id = intval($_GET['athlete_id']);

// Récupérer les informations de l'athlète
$sql = "SELECT id, nom, prenom FROM users WHERE role = 'athlete' AND id = $athlete_id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_ls($result) === 0) {
    die("Aucun athlète trouvé avec cet ID.");
}

$l = mysqli_fetch_assoc($result);
$prenom = $l['prenom'];
$nom = $l['nom'];

// Dossier où les fichiers sont stockés
$upload_dir = "../../uploads/";

// Générer les noms des fichiers attendus
$record_file = $prenom . "_" . $athlete_id . "_record";
$piece_identite_file = $prenom . "_" . $athlete_id . "_cn";
$diplome_file = $prenom . "_" . $athlete_id . "_ds";

// Fonction pour vérifier si un fichier existe
function verifier_existence($upload_dir, $base_name) {
    // Liste des extensions possibles
    $extensions = ['.pdf', '.jpg', '.png', '.jpeg', '.txt','.docx']; 
    foreach ($extensions as $ext) {
        if (file_exists($upload_dir . $base_name . $ext)) {
            return $base_name . $ext;
        }
    }
    return false;
}

// Vérifier l'existence des fichiers
$record_file_path = verifier_existence($upload_dir, $record_file);
$piece_identite_file_path = verifier_existence($upload_dir, $piece_identite_file);
$diplome_file_path = verifier_existence($upload_dir, $diplome_file);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Documents des Athlètes</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            margin: 0;
            padding: 20px;
        }

        .documents-container {
            max-width: 1000px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }

        h3 {
            color: #34495e;
            margin-bottom: 15px;
        }

        .files-section {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .file-link {
            display: inline-block;
            padding: 8px 15px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: transform 0.2s, background 0.3s;
        }

        .file-link:hover {
            transform: translateY(-2px);
            background: #2980b9;
        }

        .no-files {
            color: #e74c3c;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="documents-container">
        <h2>fICHIERS  Athlètes</h2>
        
        <div class="athlete-documents">
            <h3><?php echo htmlspecialchars($nom) . ' ' . htmlspecialchars($prenom); ?></h3>
            
            <div class="files-section">
                <?php if ($record_file_path): ?>
                    <a href="<?php echo $upload_dir . $record_file_path; ?>" 
                       class="file-link" target="_blank">Record</a>
                <?php else: ?>
                    <p class="no-files">Aucun fichier record disponible.</p>
                <?php endif; ?>
                
                <?php if ($piece_identite_file_path): ?>
                    <a href="<?php echo $upload_dir . $piece_identite_file_path; ?>" 
                       class="file-link" target="_blank">Pièce d'identité</a>
                <?php else: ?>
                    <p class="no-files">Aucune pièce d'identité disponible.</p>
                <?php endif; ?>
                
                <?php if ($diplome_file_path): ?>
                    <a href="<?php echo $upload_dir . $diplome_file_path; ?>" 
                       class="file-link" target="_blank">Diplôme</a>
                <?php else: ?>
                    <p class="no-files">Aucun diplôme disponible.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>