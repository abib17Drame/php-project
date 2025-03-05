<?php
//TRIS RAPIDEE ORDRE CROISSANT .
    function triRapide($tab) {
        if (count($tab) <= 1) {
            return $tab;
        }

        $pivot = $tab[count($tab) - 1];
        $gauche = [];
        $droite = []; 

        for ($i = 0; $i < count($tab) - 1; $i++) {
            if ($tab[$i] <= $pivot) {
                $gauche[] = $tab[$i];
            } else {
                $droite[] = $tab[$i];
            }
        }
        return fusionnerTableaux(triRapide($gauche), $pivot, triRapide($droite));
    }
    function fusionnerTableaux($gauche, $pivot, $droite){
        $resultat = [];
        foreach ($gauche as $valeur) {
            $resultat[] = $valeur;
        }        
        $resultat[] = $pivot;
    
        foreach ($droite as $valeur) {
            $resultat[] = $valeur;
        }
        return $resultat;
    }
    $tab = [38, 27, 43, 3, 9, 82, 10];
    $tabTrie = triRapide($tab);
    foreach ($tabTrie as $valeur) {
        echo $valeur . "  ";
    }
?>
