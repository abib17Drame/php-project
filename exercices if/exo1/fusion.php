<?php
// Tri par fusion en passant le tableau par référence
function Tri_fusion(&$Tab) {
    $n = count($Tab);
    if ($n <= 1) {
        return; // Si le tableau a 0 ou 1 élément, il est déjà trié
    }

    // Détermination du point de séparation
    $mil = floor($n / 2);
    
    // On divise le tableau en deux parties
    // Vous pouvez utiliser array_slice pour plus de simplicité
    $Tab_gauche = array_slice($Tab, 0, $mil);
    $Tab_droit  = array_slice($Tab, $mil);

    // Tri récursif des deux sous-tableaux
    Tri_fusion($Tab_gauche);
    Tri_fusion($Tab_droit);

    // Fusion des tableaux triés dans le tableau original (passé par référence)
    Fusion($Tab_gauche, $Tab_droit, $Tab);
}

// Fusionne deux tableaux triés dans le tableau passé par référence
function Fusion($Tab_gauche, $Tab_droit, &$Tab) {
    $i = 0; // Indice du tableau final
    $g = 0; // Indice pour le tableau gauche
    $d = 0; // Indice pour le tableau droit

    $l_Tab_gauche = count($Tab_gauche);
    $l_Tab_droit  = count($Tab_droit);

    // Comparaison des éléments des deux sous-tableaux
    while ($g < $l_Tab_gauche && $d < $l_Tab_droit) {
        if ($Tab_gauche[$g] < $Tab_droit[$d]) {
            $Tab[$i++] = $Tab_gauche[$g++];
        } else {
            $Tab[$i++] = $Tab_droit[$d++];
        }
    }

    // Ajout des éléments restants du tableau gauche
    while ($g < $l_Tab_gauche) {
        $Tab[$i++] = $Tab_gauche[$g++];
    }
    
    // Ajout des éléments restants du tableau droit
    while ($d < $l_Tab_droit) {
        $Tab[$i++] = $Tab_droit[$d++];
    }
}

// Fonction d'affichage du tableau
function Afficher($Tab) {
    foreach ($Tab as $valeur) {
        echo $valeur . " ";
    }
    echo "<br/>";
}

$Tab = [15, 98, 200, 0, 6, -7];

echo "Tableau à trier: ";
Afficher($Tab);

Tri_fusion($Tab);

echo "Tableau trié: ";
Afficher($Tab);
?>
