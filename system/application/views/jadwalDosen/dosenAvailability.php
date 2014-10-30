<?php
    echo $this->lib_js->checkall();
            
    echo "<tr>";?>
    <th class='center'>Check All</th>
    <?php echo "<th width=250>DOSEN</th>";
    foreach ($slot_waktu as $row_waktu) {
        echo "<th>$row_waktu->DESKRIPSI</th>";
    }
    echo "</tr>";
    
    foreach ($dosen as $row_dosen) {
        if($this->session->userdata['type']=='dosen' && $row_dosen->NIP == $this->session->userdata['nip'])
        {
            echo "<tr class='rowB'>";
            echo "<td><input type='checkbox' onclick=\"javascript:toggleCheckboxes(this,'$row_dosen->NIP')\"/></td>";
            echo "<td>$row_dosen->NAMA_LENGKAP_DOSEN</td>";
            foreach ($slot_waktu as $row_waktu2) {
                if (isset ($status_jadwal[$row_dosen->NIP][$row_waktu2->TREEID])) {
                    if ($status_jadwal[$row_dosen->NIP][$row_waktu2->TREEID] > 0) {
                        echo "<td class='center'><a href='".site_url("jadwalDosen/reset/".$id_jdw_avail[$row_dosen->NIP][$row_waktu2->TREEID])."'>".$id_proposal[$row_dosen->NIP][$row_waktu2->TREEID]."</a></td>";
                    } else {
                        echo "<td class='center'><input type=checkbox id='$row_dosen->NIP' name=AVAIL_" . $row_waktu2->TREEID . "_" . $row_dosen->NIP . " CHECKED ></td>";
                    }
                } else {
                    echo "<td class='center'><input type=checkbox id='$row_dosen->NIP' name=AVAIL_" . $row_waktu2->TREEID . "_" . $row_dosen->NIP . "></td>";
                }
            }
            echo "</tr>";
        }
        else if($this->session->userdata['type']!='dosen')
        {
            echo "<tr class='rowB'>";
            echo "<td><input type='checkbox' onclick=\"javascript:toggleCheckboxes(this,'$row_dosen->NIP')\"/></td>";
            echo "<td>$row_dosen->NAMA_LENGKAP_DOSEN</td>";
            foreach ($slot_waktu as $row_waktu2) {
                if (isset ($status_jadwal[$row_dosen->NIP][$row_waktu2->TREEID])) {
                    if ($status_jadwal[$row_dosen->NIP][$row_waktu2->TREEID] > 0) {
                        echo "<td class='center'><a href='".site_url("jadwalDosen/reset/".$id_jdw_avail[$row_dosen->NIP][$row_waktu2->TREEID])."'>".$id_proposal[$row_dosen->NIP][$row_waktu2->TREEID]."</a></td>";
                    } else {
                        echo "<td class='center'><input type=checkbox id='$row_dosen->NIP' name=AVAIL_" . $row_waktu2->TREEID . "_" . $row_dosen->NIP . " CHECKED ></td>";
                    }
                } else {
                    echo "<td class='center'><input type=checkbox id='$row_dosen->NIP' name=AVAIL_" . $row_waktu2->TREEID . "_" . $row_dosen->NIP . "></td>";
                }
            }
            echo "</tr>";        
        }
    }


?>
