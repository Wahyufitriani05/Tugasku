<style>
    tr th, tr td {
        font-size: 11px;
    }
</style>
<?php
    echo "<tr>";
	if($this->session->userdata('type')=="admin")echo "<th>BERITA ACARA</th>";
    echo "<th width=150>WAKTU</th>";
    echo "<th>KBK</th>";
    echo "<th>RUANGAN</th>";
    echo "<th>NRP</th>";
    echo "<th width=150>MAHASISWA</th>";
    echo "<th width=170>PEMBIMBING 1</th>";
    echo "<th width=170>PEMBIMBING 2</th>";
    echo "<th width=170>PENGUJI 1</th>";
    echo "<th width=170>PENGUJI 2</th>";
    if( ($item->userdata('type')=="dosen") || $item->userdata('type')=='admin' || ($item->userdata('type') == 'KBJ' || $item->userdata('type') == 'KCV' || $item->userdata('type') == 'RPL' || $item->userdata('type') == 'AJK' || $item->userdata('type') == 'MI' || $item->userdata('type') == 'DTK' || $item->userdata('type') == 'AP' || $item->userdata('type') == 'IGS')  )
    echo "<th width=170>Revisi Penguji 1</th>";
    if( ($item->userdata('type')=="dosen") || $item->userdata('type')=='admin' || ($item->userdata('type') == 'KBJ' || $item->userdata('type') == 'KCV' || $item->userdata('type') == 'RPL' || $item->userdata('type') == 'AJK' || $item->userdata('type') == 'MI' || $item->userdata('type') == 'DTK' || $item->userdata('type') == 'AP' || $item->userdata('type') == 'IGS')  ) 
    echo "<th width=170>Revisi Penguji 2</th>";
    echo "<th>JUDUL</th>";
    echo "</tr>";

    $rowClass = array(0 => 'rowB', 1 => 'rowA');
    $i = 0;
    foreach ($list_proposal as $prop) {
        //if($ada_jadwal[$prop->ID_PROPOSAL]==TRUE) {
            //$jdw_mhs = $jadwal_mhs[$prop->ID_PROPOSAL];
            echo "<tr class='".$rowClass[($i%2)]."'>";
			if($this->session->userdata('type')=="admin")echo "<td align=\"center\"><a href=".site_url('jadwalMahasiswa/unduhBeritaAcara/'.$prop->ID_PROPOSAL).">Unduh</a></td>";
            echo "<td>$prop->WAKTUHARI</td>";
            echo "<td>$prop->NAMA_KBK</td>";
            echo "<td>$prop->DESKRIPSI</td>";
            echo "<td>$prop->NRP</td>";
            echo "<td>$prop->NAMA_LENGKAP_MAHASISWA</td>";
            echo "<td>";
                if( ($item->userdata('type')=="dosen" && $item->userdata('nip')==$prop->NIP1) || $item->userdata('type')=='admin' || $item->userdata('type') == $prop->NAMA_KBK)
                    echo "<a class='thickbox' title='Detail Tugas Akhir' href='".site_url("jadwalMahasiswa/evaluasiTugasAkhir/$prop->ID_PROPOSAL/$prop->NIP1/pembimbing?TB_iframe=true&height=500&width=800")."'>$prop->NAMA_PEMBIMBING1</a>";
                else
                    echo $prop->NAMA_PEMBIMBING1;
            echo "</td>";
            echo "<td>";
                if( ($item->userdata('type')=="dosen" && $item->userdata('nip')==$prop->NIP2) || $item->userdata('type')=='admin' || $item->userdata('type') == $prop->NAMA_KBK)
                    echo "<a class='thickbox' title='Detail Tugas Akhir' href='".site_url("jadwalMahasiswa/evaluasiTugasAkhir/$prop->ID_PROPOSAL/$prop->NIP2/pembimbing?TB_iframe=true&height=500&width=800")."'>$prop->NAMA_PEMBIMBING2</a>";
                else
                    echo $prop->NAMA_PEMBIMBING2;
            echo "</td>";
            echo "<td>";
                if( ($item->userdata('type')=="dosen" && $item->userdata('nip')==$prop->NIP3) || $item->userdata('type')=='admin' || $item->userdata('type') == $prop->NAMA_KBK)
                    echo "<a class='thickbox' title='Detail Tugas Akhir' href='".site_url("jadwalMahasiswa/evaluasiTugasAkhir/$prop->ID_PROPOSAL/$prop->NIP3/penguji?TB_iframe=true&height=500&width=800")."'>$prop->PENGUJI1</a>";
                else
                    echo $prop->PENGUJI1;
            echo "</td>";           
            echo "<td>";
                if( ($item->userdata('type')=="dosen" && $item->userdata('nip')==$prop->NIP4) || $item->userdata('type')=='admin' || $item->userdata('type') == $prop->NAMA_KBK)
                    echo "<a class='thickbox' title='Detail Tugas Akhir' href='".site_url("jadwalMahasiswa/evaluasiTugasAkhir/$prop->ID_PROPOSAL/$prop->NIP4/penguji?TB_iframe=true&height=500&width=800")."'>$prop->PENGUJI2</a>";
                else
                    echo $prop->PENGUJI2;
            echo "</td>";
            if( ($item->userdata('type')=="dosen") || $item->userdata('type')=='admin' || ($item->userdata('type') == 'KBJ' || $item->userdata('type') == 'KCV' || $item->userdata('type') == 'RPL' || $item->userdata('type') == 'AJK' || $item->userdata('type') == 'MI' || $item->userdata('type') == 'DTK' || $item->userdata('type') == 'AP' || $item->userdata('type') == 'IGS')  ):
            
            echo "<td>";
                    if( ($item->userdata('type')=="dosen" && $item->userdata('nip')==$prop->NIP3) || $item->userdata('type')=='admin' || $item->userdata('type') == $prop->NAMA_KBK) :
                    echo "<a class='thickbox' title='Revisi Tugas Akhir' href='".site_url("jadwalMahasiswa/revisiTugasAkhir/$prop->ID_PROPOSAL/$prop->NIP3?TB_iframe=true&height=215&width=640")."'>";
                    echo "Edit Revisi";
                    echo "</a>";                
                    else:
                        echo "-";
                    endif;
                    
            echo "</td>";
            endif; 
            if( ($item->userdata('type')=="dosen") || $item->userdata('type')=='admin' || ($item->userdata('type') == 'KBJ' || $item->userdata('type') == 'KCV' || $item->userdata('type') == 'RPL' || $item->userdata('type') == 'AJK' || $item->userdata('type') == 'MI' || $item->userdata('type') == 'DTK' || $item->userdata('type') == 'AP' || $item->userdata('type') == 'IGS')  ):
            
            echo "<td>";
                    if( ($item->userdata('type')=="dosen" && $item->userdata('nip')==$prop->NIP4) || $item->userdata('type')=='admin' || $item->userdata('type') == $prop->NAMA_KBK) :
                    echo "<a class='thickbox' title='Revisi Tugas Akhir' href='".site_url("jadwalMahasiswa/revisiTugasAkhir/$prop->ID_PROPOSAL/$prop->NIP4?TB_iframe=true&height=215&width=640")."'>";
                    echo "Edit Revisi";
                    echo "</a>";    
                    else:
                        echo "-";
                    endif;
            echo "</td>";
            endif; 
            echo "<td>$prop->JUDUL_TA</td>";
            echo "</tr>";
            $i++;
        //} 
    }


?>
