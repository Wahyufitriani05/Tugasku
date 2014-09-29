<?php
    echo "<tr>";
    echo "<th>TREEID</th>";
    echo "<th width=250>JADWAL</th>";
    foreach ($ruangan as $row) {
        echo "<th>$row->DESKRIPSI</th>";
    }
    echo "</tr>";

    foreach ($slot as $row2) {
        if(strlen($row2->TREEID)==4) {
            echo "<tr class='rowA'>";
            echo "<td>$row2->TREEID</td>";
            echo "<td>$row2->DESKRIPSI</td>";
            echo "<td colspan=100>&nbsp;</td>";
            echo "</tr>";
        } else {
            echo "<tr class='rowB'>";
            echo "<td>$row2->TREEID</td>";
            echo "<td>$row2->DESKRIPSI</td>";
            foreach ($ruangan as $row3) {
                if (isset ($status[$row2->TREEID][$row3->ID_JDW_RUANG])) {
                    if ($status[$row2->TREEID][$row3->ID_JDW_RUANG] > 0) {
                        echo "<td class='center' style='background-color:pink'><a href='".site_url("jadwalRuang/resetJadwalRuangan/$id_sidangTA/$row3->ID_JDW_RUANG/$row2->TREEID")."'>Reset</a></td>";
                    } else {
                        echo "<td class='center'><input type=checkbox name=AVAIL_" . $row2->TREEID . "_" . $row3->ID_JDW_RUANG . " CHECKED ></td>";
                    }
                } else {
                    echo "<td class='center'><input type=checkbox name=AVAIL_" . $row2->TREEID . "_" . $row3->ID_JDW_RUANG . "></td>";
                }
            }
            echo "</tr>";
        }
        
    }


?>
