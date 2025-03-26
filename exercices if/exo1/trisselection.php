<?php
//Tri par selection 

function Tri_selection($Tab){
    $n = count($Tab);
    for ($i=0 ; $i < $n ; $i++) { 
        $pos_min = $i;
        for ($j=$i+1; $j < $n ; $j++) { 
            if ($Tab[$j] < $Tab[$pos_min]) {
                $pos_min = $j;
            }
        }
        $temp = $Tab[$i];
        $Tab[$i] = $Tab[$pos_min];
        $Tab[$pos_min] = $temp;
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

$Tab = [15, 98, -7, 0, 6, 200];

echo "Tableau à trier: ";
Afficher($Tab);

echo "Tableau trié: ";
$Tab_trié = Tri_selection($Tab);
Afficher($Tab_trié);

?>