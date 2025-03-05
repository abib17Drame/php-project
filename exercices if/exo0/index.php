<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercice 0</title>
    <style>
        body{
            margin: 130px;
            font-family: Arial , sans-serif;
        }

        table{
            width: 50%;
            margin: 0 auto;
             
        }
        th , td{
            border: 2px solid black;
            padding: 10px;
            text-align:center;
        }
        th{
            background-color: green;
            color: white;
        }
        h1{
            text-align:center;
            color: green;
        }
    </style>
</head>
<body>
    <?php
        $tab =[
            ["prenom"=> "Malick" ,"nom"=> "Wade" ,"date"=> "10/01/1990"],
            ["prenom"=> "Malick" ,"nom"=> "Wade" ,"date"=> "10/01/1990"],
            ["prenom"=> "Malick" ,"nom"=> "Wade" ,"date"=> "10/01/1990"],
            ["prenom"=>"Malick" , "nom"=>"Wade" , "date"=>"10/01/1990"],
            ["prenom"=>"Malick" , "nom"=>"Wade" , "date"=>"10/01/1990"],
            ["prenom"=>"Malick" , "nom"=>"Wade" , "date"=>"10/01/1990"],
        ];
    ?>
    <h1>Tableau cree avec php et affiche par du HTML</h1>
    <table>
        <thead>
            <tr>
                <th>Prenom</th>
                <th>Nom</th>
                <th>Date de naissance</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($tab as $key) {
                    echo "<tr>";
                    echo "<td>" .$key['prenom']."</td>";
                    echo "<td>" .$key['nom']."</td>";
                    echo "<td>" .$key['date']."</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>

    </table>
</body>
</html>