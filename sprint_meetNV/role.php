<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix du rôle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
        }
        .role-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 40px;
        }
        .role-btn {
            padding: 20px 40px;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s ease;
            background-color: #f0f0f0;
        }
        .role-btn:hover {
            transform: scale(1.05);
            background-color: #e0e0e0;
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <h1>Choisissez votre rôle d'inscription</h1>
    <div class="role-container">
        <button class="role-btn" onclick="redirectTo('arbitre')">
            Arbitre
        </button>
        
        <button class="role-btn" onclick="redirectTo('athlete')">
            Athlète
        </button>
    </div>
    <script>
        function redirectTo(role) {
            if(role === 'arbitre') {
                window.location.href = 'registerAr.html';
            } else if(role === 'athlete') {
                window.location.href = 'registerA.html';
            }
        }
    </script>
</body>
</html>