<?php
    echo "<tr style='border: 1px solid #aaa;'>";
    echo "<th style='border: 1px solid #aaa;' rowspan=2 width=20><center>TREEID</center></th>";
    echo "<th style='border: 1px solid #aaa;' rowspan=2 width=100><center>JADWAL</center></th>";
    foreach ($ruangan as $rng) {
        echo "<th style='border: 1px solid #aaa;' colspan=".sizeof($kbk)."><center>$rng->DESKRIPSI</center></th>";
    }
    echo "</tr>";
    echo "<tr style='border: 1px solid #aaa;'>";
    foreach ($ruangan as $rng2) {
        foreach ($kbk as $k) {
            echo "<th style='border: 1px solid #aaa;' width=15><center><a href='".site_url("jadwalRuangKBK/setDefaultRuangKBKAssignment/$id_sidangTA/$rng2->ID_JDW_RUANG/$k->ID_KBK")."'>$k->NAMA_KBK</center></a></th>";
        }
    }
    echo "</tr>";

    foreach ($slot as $sl) {
        if(strlen($sl->TREEID)==4) {
            echo "<tr style='border: 1px solid #aaa;' class='rowA'>";
            echo "<td style='border: 1px solid #aaa;'>$sl->TREEID</td>";
            echo "<td style='border: 1px solid #aaa;'>$sl->DESKRIPSI</td>";
            echo "<td style='border: 1px solid #aaa;' colspan=100>&nbsp;</td>";
            echo "</tr>";
        } else {
            echo "<tr style='border: 1px solid #aaa;' class='rowB'>";
            echo "<td style='border: 1px solid #aaa;'>$sl->TREEID</td>";
            echo "<td style='border: 1px solid #aaa;'>$sl->DESKRIPSI</td>";
            foreach ($ruangan as $rng3) {
                if ($ada_jadwal[$sl->TREEID][$rng3->ID_JDW_RUANG] == TRUE) {
                    if($status[$sl->TREEID][$rng3->ID_JDW_RUANG] == '0') {
                        foreach ($kbk as $k2) {
                            if($id_kbk[$sl->TREEID][$rng3->ID_JDW_RUANG] == $k2->ID_KBK)
                                $tanda = 'CHECKED';
                            else
                                $tanda = ' ';
                            
                            echo "<td style='border: 1px solid #aaa;' class='center'>";
                            echo "<input type='radio' name='IDKBK_".$id_jdw_ruang_avail[$sl->TREEID][$rng3->ID_JDW_RUANG]."' value='$k2->ID_KBK' $tanda />";
                            echo "</td>";
                        }
                    } else {
                        //penggantian lebar colspan
                        echo "<td class='center' colspan=".count($kbk)." style='background-color:pink; border: 1px solid #aaa;'> Ada Sidang </td>";
                    }
                    
                } else {
                    echo "<td class='center' colspan=".count($kbk)." style='background-color:#FFFF99; border: 1px solid #aaa;'> Tidak Ada Jadwal </td>";
                }
            }
            echo "</tr>";
        }
        
    }


?>
