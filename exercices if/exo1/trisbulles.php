<?php
//TRIS BULLE PAR ORDRE CROISSANT
    $tab = [3,21,45,67,33,90,3,7,1,67,0];
    for ($i=0; $i < count($tab)-1; $i++) { 
        for ($j=0; $j < (count($tab)-1-$i); $j++) {
            if ($tab[$j]>$tab[$j+1]) {
                $temp = $tab[$j];
                $tab[$j] = $tab[$j+1];
                $tab[$j+1] = $temp;
            } 
        }
    }
    for ($i=0; $i <count($tab) ; $i++) { 
        echo $tab[$i]."  ";
    }
//TRIS BULLE PAR ORDRE DECROISSANT
    // $tab = [3,21,45,67,33,90,3,7,1,67];
    // for ($i=0; $i < count($tab)-1; $i++) { 
    //     for ($j=0; $j < (count($tab)-1-$i); $j++) {
    //         if ($tab[$j]<$tab[$j+1]) {
    //             $temp = $tab[$j];
    //             $tab[$j] = $tab[$j+1];
    //             $tab[$j+1] = $temp;
    //         } 
    //     }
    // }
    // for ($i=0; $i <count($tab) ; $i++) { 
    //     echo $tab[$i]."  ";
    // }
?>