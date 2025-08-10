<?php
function Tri_rapide(&$Tab, $pos_min, $pos_max) {
    if ($pos_min < $pos_max) { 
        //On récupère la position du pivot
        $pos_piv = Partition($Tab, $pos_min, $pos_max);

        //Appel récursif des de la fonction Tri_rapide() pour les éléments plus petits que pivot (à gauche)
        Tri_rapide($Tab, $pos_min, $pos_piv - 1);
        Tri_rapide($Tab, $pos_piv + 1, $pos_max);
    }
}

//Fonction qui échan
function Echange(&$a, &$b) { //Utilisation du passage par référence pour faire directement l'échange
    $temp = $a;
    $a = $b;
    $b = $temp;
}

//Fonction patition 
function Partition(&$Tab, $pos_min, $pos_max) { //&$Tab passage par référence: on modifie directement les éléments du tableau
    //Choix du pivot: Je choisit le dernier élément du tableau comme pivot
    $pivot = $Tab[$pos_max];

    //On initialise i à la position minimale - 1
    $i = $pos_min - 1;

    //Comparaison des des éléments du tableau au pivot
    for ($j = $pos_min; $j < $pos_max; $j++) { 
        if ($Tab[$j] < $pivot) { //Si l'élement à la position j est inférieur au pivot
            $i++; 
            Echange($Tab[$i], $Tab[$j]); //Puis on échange $Tab[$i] et $Tab[$j]
        } //Sinon on ignore $T[$j] et $j passe à l'itération suivante ($j++)
    }

    //A Lorsque $j va atteindre $pos_max (l'indice du pivot), on incrémente $i puis on échange le $pivot et l'élément à la position $i + 1
    Echange($Tab[$i + 1], $Tab[$pos_max]);
    return $i + 1; //Puis on retourne la position du pivot
}

//Affichage 
function Afficher($Tab){
    foreach ($Tab as $key) {
        echo $key . " ";
    }
    echo "<br/>";
}

$Tab = array(50, -6, 12, 0, -3, 150);
$n = count($Tab); //Taille du tableau

echo "Tableau à trier: ";
Afficher($Tab);

//Appel de la fonction Tri_rapide()
Tri_rapide($Tab, 0, $n - 1);
echo "Tableau trié: ";
Afficher($Tab);

?>