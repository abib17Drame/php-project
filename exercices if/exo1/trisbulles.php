<?php 
//Tri à bulles 

function Tri_bulles($Tab){
    $n = count($Tab);
    for ($i=0; $i < $n ; $i++) { 
        for ($j=0; $j < ($n - $i -1) ; $j++) { 
            if ($Tab[$j] > $Tab[$j+1]) {
                $temp = $Tab[$j];
                $Tab[$j] = $Tab[$j+1];
                $Tab[$j+1] = $temp;
            }
        }
    }
    return $Tab;
}

//Affichage 
function Afficher($Tab){
    foreach ($Tab as $key) {
        echo $key . " ";
    }
    echo "<br/>";
}

$Tab = [0, -98, 200, 1, -13, 30];

echo "Tableau à trier: ";
Afficher($Tab);

echo "Tableau trié: ";
$Tab_trié = Tri_bulles($Tab);
Afficher($Tab_trié);

?>