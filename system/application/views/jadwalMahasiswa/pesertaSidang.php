<style>
    tr th, tr td {
        font-size: 11px;
    }
</style>
<?php
    echo "<tr>";
    echo "<th>PROSES</th>";
    echo "<th>STATUS</th>";
    echo "<th>SLOT</th>";
    echo "<th>WAKTU</th>";
    echo "<th>RUANGAN</th>";
    echo "<th>KBK</th>";
    echo "<th>PEMB 1</th>";
    echo "<th>PEMB 2</th>";
    echo "<th>PENJI 1</th>";
    echo "<th>PENJI 2</th>";
    echo "<th>SW</th>";
    echo "<th>NRP</th>";
    echo "<th>MAHASISWA</th>";
//    echo "<th>STATUS SIDANG</th>";
    echo "<th>JUDUL</th>";
    //echo "<th>PROSES TIDAK MENGGUNAKAN DOSEN PEMBIMBING 1</th>";
    echo "</tr>";

    $rowClass = array(0 => 'rowB', 1 => 'rowA');
    $i = 0;
    $status[1] = 'Bermasalah';
    $status[2] = 'Tidak Ada Slot Pembimbing';
    $status[3] = 'Bermasalah';
    $status[4] = 'Hanya Ada 1 Penguji';
    $status[5] = 'Tidak Ada Slot Penguji (2)';
    $status[6] = 'OK';
    $status[7] = 'Tidak Ada Ruangan';
    foreach ($list_proposal as $prop) {
        if(isset($prop->ID_JDW_MHS)) {
        //if($ada_jadwal[$prop->ID_PROPOSAL_ASLI]==TRUE) {
            //$jdw_mhs = $jadwal_mhs[$prop->ID_PROPOSAL_ASLI];
            echo "<tr class='".$rowClass[($i%2)]."'>";
            echo "<td><input type='checkbox' name='DELETE_".$id_sidangTA."_".$prop->ID_JDW_MHS."' />HAPUS</td>";//<a href='".site_url("penjadwalan/deleteJadwalMajuSidang/$id_sidangTA/$jdw_mhs->ID_JDW_MHS")."'>DELETE</a></td>";
            echo "<td>".$status[$prop->STATUS]."</td>";
            echo "<td>$prop->ID_SLOT</td>";
            echo "<td>$prop->WAKTUHARI</td>";
//            echo "<td><a class='thickbox' title='GANTI RUANG SIDANG' href='".site_url("jadwalMahasiswa/gantiRuangSidang/$id_sidangTA/$prop->ID_JDW_MHS?TB_iframe=true&height=200&width=300")."'>$prop->DESKRIPSI</a></td>";
            echo "<td>$prop->DESKRIPSI</td>";
//            echo "<script type='text/javascript'>
//                $(document).ready(function() {";
//                    echo $this->pquery->observe_field("#kbk_$i",array('event'=>'change','function'=>$this->pquery->remote_function(array(
//                        'url'=>site_url('jadwalMahasiswa/gantiKBK/'.$id_sidangTA.'/'.$prop->ID_PROPOSAL_ASLI.'/"+$("#kbk_'.$i.'").val()+"'),
//                        'update'=>"#updatekbk_$i"
//                    ))));
//            echo "});
//            </script>";
            echo "<td>";
//            echo "<select id='kbk_$i'>";
//            foreach ($list_kbk as $lkbk) {
//                if($lkbk->ID_KBK == $prop->ID_KBK_ASLI)
//                    $tanda2 = "SELECTED";
//                else
//                    $tanda2 = "";
//                echo "<option value='$lkbk->ID_KBK' $tanda2 >$lkbk->NAMA_KBK</option>";
//            }
//            echo "</select>";
//            echo "<span id='updatekbk_$i'></span>";
            echo $prop->NAMA_KBK;
            echo "</td>";
//            echo "<td><a class='thickbox' title='GANTI PEMBIMBING 1' href='".site_url("jadwalMahasiswa/gantiPembimbing/1/$id_sidangTA/$prop->ID_PROPOSAL_ASLI?TB_iframe=true&height=300&width=600")."'>$prop->INISIAL_PEMBIMBING1</a></td>";
//            echo "<td><a class='thickbox' title='GANTI PEMBIMBING 2' href='".site_url("jadwalMahasiswa/gantiPembimbing/2/$id_sidangTA/$prop->ID_PROPOSAL_ASLI?TB_iframe=true&height=300&width=600")."'>$prop->INISIAL_PEMBIMBING2</a></td>";
//            echo "<td><a class='thickbox' title='GANTI PENGUJI 1' href='".site_url("jadwalMahasiswa/gantiPenguji/1/$id_sidangTA/$prop->ID_PROPOSAL_ASLI/$prop->ID_JDW_MHS?TB_iframe=true&height=300&width=600")."'>$prop->INISIAL_PENGUJI1<a/></td>";
//            echo "<td><a class='thickbox' title='GANTI PENGUJI 2' href='".site_url("jadwalMahasiswa/gantiPenguji/2/$id_sidangTA/$prop->ID_PROPOSAL_ASLI/$prop->ID_JDW_MHS?TB_iframe=true&height=300&width=600")."'>$prop->INISIAL_PENGUJI2<a/></td>";
            echo "<td>$prop->INISIAL_PEMBIMBING1</td>";
            echo "<td>$prop->INISIAL_PEMBIMBING2</td>";
            echo "<td>$prop->INISIAL_PENGUJI1</td>";
            echo "<td>$prop->INISIAL_PENGUJI2</td>";
            echo "<td><input type='checkbox' name='SWITCH_".$id_sidangTA."_".$prop->ID_JDW_MHS."' /></td>";//<a href='".site_url("penjadwalan/deleteJadwalMajuSidang/$id_sidangTA/$jdw_mhs->ID_JDW_MHS")."'>DELETE</a></td>";
            echo "<td>$prop->NRP</td>";
            echo "<td>$prop->NAMA_LENGKAP_MAHASISWA</td>";
//            echo "<td>$prop->STATUS</td>";
            echo "<td>$prop->JUDUL_TA</td>";
            //echo "<td>&nbsp;</td>";
            echo "</tr>";
        } else {
            echo "<tr class='".$rowClass[($i%2)]."'>";
//            echo "<td><input type='checkbox' name='CARIJADWAL_".$id_sidangTA."_".$prop->ID_PROPOSAL_ASLI."' /><a class='thickbox' title='CARI JADWAL' href='".site_url("jadwalMahasiswa/cariJadwal/$id_sidangTA/$prop->PEMBIMBING1/$prop->PEMBIMBING2/$prop->ID_PROPOSAL_ASLI/$prop->ID_KBK_ASLI?TB_iframe=true&height=450&width=800")."'>JADWAL</a></td>";
            echo "<td><a class='thickbox' title='CARI JADWAL' href='".site_url("jadwalMahasiswa/cariJadwal/$id_sidangTA/$prop->PEMBIMBING1/$prop->PEMBIMBING2/$prop->ID_PROPOSAL_ASLI/$prop->ID_KBK_ASLI?TB_iframe=true&height=450&width=800")."'>JADWAL</a></td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
//             echo "<script type='text/javascript'>
//                $(document).ready(function() {";
//                    echo $this->pquery->observe_field("#kbk_$i",array('event'=>'change','function'=>$this->pquery->remote_function(array(
//                        'url'=>site_url('jadwalMahasiswa/gantiKBK/'.$id_sidangTA.'/'.$prop->ID_PROPOSAL_ASLI.'/"+$("#kbk_'.$i.'").val()+"'),
//                        'update'=>"#updatekbk_$i"
//                    ))));
//            echo "});
//            </script>";
            echo "<td>";
//            echo "<select id='kbk_$i'>";
//            foreach ($list_kbk as $lkbk) {
//                if($lkbk->ID_KBK == $prop->ID_KBK_ASLI)
//                    $tanda2 = "SELECTED";
//                else
//                    $tanda2 = "";
//                echo "<option value='$lkbk->ID_KBK' $tanda2 >$lkbk->NAMA_KBK</option>";
//            }
//            echo "</select>";
//            echo "<span id='updatekbk_$i'></span>";
            echo $prop->NAMA_KBK;
            echo "</td>";
//            echo "<td><a class='thickbox' href='".site_url("jadwalMahasiswa/gantiPembimbing/1/$id_sidangTA/$prop->ID_PROPOSAL_ASLI?TB_iframe=true&height=300&width=600")."'>$prop->INISIAL_PEMBIMBING1</td>";
//            echo "<td><a class='thickbox' href='".site_url("jadwalMahasiswa/gantiPembimbing/2/$id_sidangTA/$prop->ID_PROPOSAL_ASLI?TB_iframe=true&height=300&width=600")."'>$prop->INISIAL_PEMBIMBING2</td>";
            echo "<td>$prop->INISIAL_PEMBIMBING1</td>";
            echo "<td>$prop->INISIAL_PEMBIMBING2</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>&nbsp;</td>";
            echo "<td>$prop->NRP</td>";
            echo "<td>$prop->NAMA_LENGKAP_MAHASISWA</td>";
//            echo "<td>$prop->STATUS</td>";
            echo "<td>$prop->JUDUL_TA</td>";
            //echo "<td><input type='checkbox' name='PEMBIMBINGX_".$prop->ID_PROPOSAL_ASLI."_".$prop->ID_KBK_ASLI."_".$prop->PEMBIMBING1."_".$prop->PEMBIMBING2."_".$prop->NRP."' /></td>";
            echo "</tr>";
        }
        $i++;
    }


?>
