<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Athlète</title>
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
      margin: 0px auto;
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

        
        



        

           
    </style>
</head>
<body>

    <nav>
        <ul>
            <li><a href="scripts/mescourses.php">Courses inscrit</a></li>
          
            <li><a href="scripts/choix_course.php">S'inscrire à une course</a></li>
            <li><a href="resultats_courses.php">Résultats</a></li>
            <li><a href="scripts/logout.php">Déconnexion</a></li>
        </ul>
    </nav>
<div class="container">
    <section id="dashboard-message">
        <h1>Bienvenue sur votre Tableau de Bord</h1>
        <p>Vous êtes connecté en tant qu'athlète. Depuis ce tableau de bord, vous pouvez :</p>
        <ul>
            <li>**Vous inscrire à une course**</li>
            <li>🏃‍♂️ **Voir les courses auxquelles vous êtes inscrit**.</li>
            <li>🏆 **Consulter vos résultats et vos performances**.</li>
            
        </ul>
        <p>Utilisez le menu ci-dessus pour naviguer entre les différentes sections.</p>
    </section>
    </div>
</body>
</html>