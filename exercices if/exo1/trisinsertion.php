<?php

function Tri_insertion($Tab){
    $n = count($Tab);
    for ($i=1; $i < $n; $i++) { 
        $val = $Tab[$i];
        $j = $i-1;
        while ($j >= 0 && $Tab[$j] > $val) {
            $Tab[$j+1] = $Tab[$j];
            $j = $j-1;
        }
        $Tab[$j+1] = $val;
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

$Tab = [15, 98, 200, 0, 6, -7];

echo "Tableau à trier: ";
Afficher($Tab);

echo "Tableau trié: ";
$Tab_trié = Tri_insertion($Tab);
Afficher($Tab_trié);

?>