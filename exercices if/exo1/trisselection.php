<?php
// TRIS PAR SELECTION PAR ORDRE CROISSANT
    // $tab = [2,4,6,7,1,12,3,45,76,21,8];
    // for ($i=0; $i < count($tab)-1; $i++) { 
    //     $min = $i;
    //     for ($j=$i+1; $j < count($tab); $j++) { 
    //         if($tab[$j]<$tab[$min]){
    //             $min = $j;
    //         }
    //         $temp = $tab[$min];
    //         $tab[$min] = $tab[$i];
    //         $tab[$i] = $temp;
    //     }
    // }
    // for ($i=0; $i < count($tab); $i++) { 
    //     echo $tab[$i]."  ";
    // }
//TRIS PAR SELECTION PAR ORDRE DECROISSANT
    $tab = [2,4,6,7,1,12,3,45,76,21,8];
    for ($i=0; $i < count($tab)-1; $i++) { 
        $min = $i;
        for ($j=$i+1; $j < count($tab); $j++) { 
            if($tab[$j]>$tab[$min]){
                $min = $j;
            }
            $temp = $tab[$min];
            $tab[$min] = $tab[$i];
            $tab[$i] = $temp;
        }
    }
    for ($i=0; $i < count($tab); $i++) { 
        echo $tab[$i]."  ";
    }
?>