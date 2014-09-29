<?php
    echo "<tr>";
    echo "<th rowspan=2 width=20>TREEID</th>";
    echo "<th rowspan=2 width=100>JADWAL</th>";
    foreach ($ruangan as $rng) {
        echo "<th colspan=".sizeof($kbk).">$rng->DESKRIPSI</th>";
    }
    echo "</tr>";
    echo "<tr>";
    foreach ($ruangan as $rng2) {
        foreach ($kbk as $k) {
            echo "<th width=15><a href='".site_url("jadwalRuangKBK/setDefaultRuangKBKAssignment/$id_sidangTA/$rng2->ID_JDW_RUANG/$k->ID_KBK")."'>$k->NAMA_KBK</a></th>";
        }
    }
    echo "</tr>";

    foreach ($slot as $sl) {
        if(strlen($sl->TREEID)==4) {
            echo "<tr class='rowA'>";
            echo "<td>$sl->TREEID</td>";
            echo "<td>$sl->DESKRIPSI</td>";
            echo "<td colspan=100>&nbsp;</td>";
            echo "</tr>";
        } else {
            echo "<tr class='rowB'>";
            echo "<td>$sl->TREEID</td>";
            echo "<td>$sl->DESKRIPSI</td>";
            foreach ($ruangan as $rng3) {
                if ($ada_jadwal[$sl->TREEID][$rng3->ID_JDW_RUANG] == TRUE) {
                    if($status[$sl->TREEID][$rng3->ID_JDW_RUANG] == '0') {
                        foreach ($kbk as $k2) {
                            if($id_kbk[$sl->TREEID][$rng3->ID_JDW_RUANG] == $k2->ID_KBK)
                                $tanda = 'CHECKED';
                            else
                                $tanda = ' ';
                            
                            echo "<td class='center'>";
                            echo "<input type='radio' name='IDKBK_".$id_jdw_ruang_avail[$sl->TREEID][$rng3->ID_JDW_RUANG]."' value='$k2->ID_KBK' $tanda />";
                            echo "</td>";
                        }
                    } else {
                        echo "<td class='center' colspan=4 style='background-color:pink'> Ada Sidang </td>";
                    }
                    
                } else {
                    echo "<td class='center' colspan=4 style='background-color:#FFFF99'> Tidak Ada Jadwal </td>";
                }
            }
            echo "</tr>";
        }
        
    }


?>
