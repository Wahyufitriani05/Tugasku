<table class='table1' style='width:96%; margin-top:20px; border:1px solid #aaa;' border='1' cellpadding='2' cellspacing='3'>
    <tr>
        <th width=60>TREE ID</th>
        <th width=120>WAKTU</th>
        <th>JADWAL</th>
        <th>DOSEN</th>
    </tr>
    <?php
    foreach ($list_slot as $slot) {
        if(strlen($slot->TREEID)==4)
            $class_row = "rowA";
        else
            $class_row = "rowB";
        ?>
    <tr class="<?php echo $class_row?>">
        <td><?php echo $slot->TREEID?></td>
        <td><?php echo $slot->DESKRIPSI?></td>
        <td>
            <?php

            if(isset ($slot->JADWAL_AVAIL)) {
                
                foreach ($slot->JADWAL_AVAIL as $jadwal_avail) {
                    
                    //tambahan agar jadwal avalaible sesuai KBK
                    if($jadwal_avail->ID_KBK == $parameter['IDKBK']) {
                    ?>
            <a class='thickbox' title='PILIH PENGUJI' href='<?php echo site_url("jadwalMahasiswa/pilihPenguji/".$parameter['SIDANGTA']."/".$parameter['NIP1']."/".$parameter['NIP2']."/".$parameter['IDPROPOSAL']."/".$parameter['IDKBK']."/$slot->TREEID/$jadwal_avail->ID_JDW_RUANG_AVAIL?TB_iframe=true&height=250&width=350")?>'><?php echo "$jadwal_avail->DESKRIPSI</br>";// ($jadwal_avail->NAMA_KBK / $jadwal_avail->STATUS)"?></a>&nbsp;
                    <?php
                    }
                }
            }
            ?>
        </td>
        <td>
            <?php
            foreach ($slot->DOSEN_AVAIL as $dosen_avail) {
                if (($dosen_avail->NIP==$parameter['NIP1']) || (($dosen_avail->NIP==$parameter['NIP2']))) {
                    echo "<font color=black>[";
                }

                if ($dosen_avail->STATUS=='0') {
                    echo "<font color=red><B>" . $dosen_avail->INISIAL_DOSEN . "</B> ";
                } else {
                    echo "<font color=grey>" . $dosen_avail->INISIAL_DOSEN . " ";
                }

                if (($dosen_avail->NIP==$parameter['NIP1']) || (($dosen_avail->NIP==$parameter['NIP2']))) {
                        echo "<font color=black>] ";
                }
            }
            ?>
        </td>
    </tr>
        <?php
    }
    ?>
</table>
