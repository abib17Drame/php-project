<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix du rôle</title>
    <style>
        :root {
            --primary-color: #2980b9; /* Bleu élégant */
            --secondary-color: #e74c3c; /* Rouge vibrant */
        }

        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-size: 2.5rem;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 30px;
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
            transition: transform 0.3s ease, background 0.3s ease;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            color: #fff;
            font-weight: 700;
        }

        .role-btn:hover {
            transform: scale(1.05);
            background: linear-gradient(90deg, var(--secondary-color), var(--primary-color));
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