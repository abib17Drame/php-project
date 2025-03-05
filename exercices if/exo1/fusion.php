<?php
    function triFusion($tab, $debut, $fin, $ctab) {
        if ($debut < $fin) {
            $milieu = (int)(($debut + $fin) / 2);

            $tab = triFusion($tab, $debut, $milieu, $ctab);
            $tab = triFusion($tab, $milieu + 1, $fin, $ctab);
            $pg = $debut;
            $pd = $milieu + 1;

            for ($i = $debut; $i <= $fin; $i++) {
                if ($pg > $milieu || ($pd <= $fin && $tab[$pg] > $tab[$pd])) {
                    $ctab[$i] = $tab[$pd];
                    $pd++;
                } else {
                    $ctab[$i] = $tab[$pg];
                    $pg++;
                }
            }
            for ($i = $debut; $i <= $fin; $i++) {
                $tab[$i] = $ctab[$i];
            }
        }

        return $tab;
    }

    $tab = [38,27,43,3, 9,8,2, 10];
    $ctab = [];


    for ($i = 0; $i < count($tab); $i++) {
        $ctab[$i] = 0;
    }


    $tab = triFusion($tab, 0, count($tab) - 1, $ctab);
    for ($i = 0; $i < count($tab); $i++) {
        echo $tab[$i];
        if ($i < count($tab) - 1) {
            echo "  ";
        }
    }
?>
