<style>
    tr th, tr td {
        font-size: 11px;
    }
</style>
<?php
echo $this->lib_js->thickbox();

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
            echo "<td><a class='thickbox' title='Detail Tugas Akhir' href='".site_url("jadwalMahasiswa/evaluasiTugasAkhir/$prop->ID_PROPOSAL?TB_iframe=true&height=500&width=800")."'>$prop->NAMA_PEMBIMBING1</a></td>";
            echo "<td>$prop->NAMA_PEMBIMBING2</td>";
            echo "<td>$prop->PENGUJI1</td>";
            echo "<td>$prop->PENGUJI2</td>";
            echo "<td>$prop->JUDUL_TA</td>";
            echo "</tr>";
            $i++;
        //} 
    }


?>
