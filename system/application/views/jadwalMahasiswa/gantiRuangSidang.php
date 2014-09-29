<h3 style="color:#4B75B3">Daftar Ruang Sidang Yang Tersedia</h3>
<ul>
<?php
foreach ($list_ruang_avail as $row) {
    echo "<li style='color:#4B75B3;'><a style='color:#4B75B3' href='".site_url("jadwalMahasiswa/confirmGantiRuangSidang/$id_sidangTA/$id_jdw_mhs/$row->ID_JDW_RUANG_AVAIL")."'>$row->DESKRIPSI</a></li>";
}
?>
</ul>