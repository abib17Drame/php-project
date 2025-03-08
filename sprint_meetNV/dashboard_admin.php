<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Administrateur - Sprint Meet</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f7f6;
      margin: 0;
      padding: 0;
      color: #333;
    }
    .container {
      max-width: 1100px;
      margin: 0px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    
.logo {
    width: 250px;
    height: auto;
    margin-right: 20px;
    transition: transform 0.3s ease;
}
.logo:hover {
      transform: scale(1.1);
    }
    h1 {
      color: #2c3e50;
      font-size: 2.5rem;
      margin-bottom: 20px;
    }


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
    .bienvenu-message {
      background: #ecf0f1;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 30px;
      text-align: left;
    }

    

    .bienvenu-message p {
      font-size: 1.1rem;
      line-height: 1.6;
      color: #555;
      margin-left: 380px;
    }

  </style>
</head>
<body>  
  <div class="container">
  
  <h1>Tableau de Bord Administrateur</h1>
  <nav>
    <ul>
      <li><a href="athletes.php">Gérer les Athlètes</a></li>
      <li><a href="courses.php">Gérer les Courses</a></li>
      <li><a href="arbitres.php">Gérer les Arbitres</a></li>
      <li><a href="resultats_courses.php">Résultats</a></li>
      <li><a href="scripts/logout.php">Se déconnecter</a></li>
    </ul>
  </nav>
  </div>
  <div class="bienvenu-message">
  <p>
        En tant qu'Administrateur, vous avez accès aux fonctionnalités suivantes :<br>
        - <strong>Gérer les courses</strong> : Ajouter des courses.<br>
        - <strong>Gérer les athletes</strong> : Modifier,Supprimer et consulter les details de chaque athlète.<br>
        -<strong>Gérer les arbitres</strong> :Modifier les infos , Surpprimer et  Assigner des courses à un arbitre.<br>
        - <strong>Consulter les résultats</strong> : Accédez aux résultats des matchs passés.<br>
        Merci pour votre travail et bonne journée !

      </p>
  </div>
</body>
</html>
