
<?php
//TRIS INSERTION DE MANIERE DECROISSANTE .
    // $tab = [4,5,2,87,90,12,43,12,78,21];
    // for ($i=1; $i < count($tab); $i++) { 
    //     $cle_ins = $tab[$i];
    //     $j=$i; 
    //     while ($j>0 && $tab[$j-1]<$cle_ins) {
    //         $tab[$j] = $tab[$j-1];
    //         $j = $j -1;
    //     }
    //     $tab[$j] = $cle_ins;
    // } 
    // for ($i=0; $i <count($tab) ; $i++) { 
    //     echo $tab[$i]."  ";
    // }
//TRIS INSERTION DE MANIERE CROISSANTE .
    $tab = [4,5,2,87,90,12,43,12,78,21];
    for ($i=1; $i < count($tab); $i++) { 
        $cle_ins = $tab[$i];
        $j=$i; 
        while ($j>0 && $tab[$j-1]>$cle_ins) {
            $tab[$j] = $tab[$j-1];
            $j = $j -1;
        }
        $tab[$j] = $cle_ins;
    } 
    for ($i=0; $i <count($tab) ; $i++) { 
        echo $tab[$i]."  ";
    }
?>