<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Arbitre - Sprint Meet</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* Style général */
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f7f6;
      margin: 0;
      padding: 0;
      color: #333;
    }

    .container {
      max-width: 1100px;
      margin: 30px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    h1 {
      color: #2c3e50;
      font-size: 2.5rem;
      margin-bottom: 20px;
    }

    /* Navigation */
    nav ul {
      list-style: none;
      display: flex;
      justify-content: center;
      padding: 0;
      background: #2c3e50;
      border-radius: 8px;
      margin-bottom: 30px;
    }

    nav ul li {
      margin: 0 15px;
    }

    nav ul li a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      padding: 15px 20px;
      display: block;
      transition: background 0.3s, transform 0.3s;
    }

    nav ul li a:hover {
      background: #34495e;
      transform: translateY(-3px);
    }

    /* Contenu principal */
    .bienvenu-message {
      background: #ecf0f1;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 30px;
      text-align: left;
    }

    .bienvenu-message h2 {
      color: #2c3e50;
      margin-top: 0;
      font-size: 1.8rem;
    }

    .bienvenu-message p {
      font-size: 1.1rem;
      line-height: 1.6;
      color: #555;
    }

    /* Tableau */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    th, td {
      padding: 15px;
      border: 1px solid #ddd;
      text-align: center;
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

    /* Boutons */
    .btn {
      padding: 10px 20px;
      background-color: #3498db;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      transition: background 0.3s, transform 0.3s;
      display: inline-block;
      margin: 5px;
    }

    .btn:hover {
      background-color: #2980b9;
      transform: translateY(-2px);
    }

    .btn-noter {
      background-color: #27ae60;
    }

    .btn-noter:hover {
      background-color: #219653;
    }

    .btn-consulter {
      background-color: #9b59b6;
    }

    .btn-consulter:hover {
      background-color: #8e44ad;
    }

    /* Animation */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .container {
      animation: fadeIn 0.8s ease-out;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Tableau de Bord Arbitre</h1>
    <nav>
      <ul>
        <li><a href="dashboard_arbitre.php">Accueil</a></li>
        <li><a href="historique_arbitrage.php">Courses Assignées</a></li>
        <li><a href="scripts/logout.php">Se Déconnecter</a></li>
      </ul>
    </nav>

    <!-- Message de bienvenue -->
    <div class="bienvenu-message">
      <h2>Bienvenue !</h2>
      <p>
        En tant qu'arbitre, vous avez accès aux fonctionnalités suivantes :<br>
        - <strong>Gérer les course</strong> : Consultez et gérez les matchs qui vous sont assignés.<br>
        - <strong>Consulter les résultats</strong> : Accédez aux résultats des matchs passés.<br>
        - <strong>Mon profil</strong> : Modifiez vos informations personnelles ou consultez votre profil.<br><br>
        Utilisez le menu ci-dessus pour naviguer et accéder aux différentes sections. Si vous avez des questions ou besoin d'aide, n'hésitez pas à contacter l'administrateur.<br><br>
        Merci pour votre travail et bonne journée !
      </p>
    </div>
  </div>

</body>
</html>