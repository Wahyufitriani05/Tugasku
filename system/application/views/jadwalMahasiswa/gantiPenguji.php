<h3 style="color:#4B75B3">Daftar Dosen KBK yang belum Diassign</h3>
<table border="0">
<?php
$i=0;
foreach ($list_dosen_blm_diassign as $row) {
    if($i%3==0)
        echo "<tr><td>";
    else
        echo "<td>";
    echo "<a style='color:#4B75B3' href='".site_url("jadwalMahasiswa/confirmGantiPenguji/$no/$id_sidangTA/$id_proposal/$row->NIP/$id_jdw_mhs")."'>$row->NAMA_DOSEN</a>";
    if($i%3==2)
        echo "</td></tr>";
    else
        echo "</td>";
    $i++;
}
?>
</table>

<h3 style="color:#4B75B3">Daftar Dosen yang Tersedia pada Saat Tersebut</h3>
<table border="0">
<?php
$i=0;
foreach ($list_dosen_avail as $row2) {
    if($i%3==0)
        echo "<tr><td>";
    else
        echo "<td>";
    echo "<a style='color:#4B75B3' href='".site_url("jadwalMahasiswa/confirmGantiPenguji/$no/$id_sidangTA/$id_proposal/$row2->NIP/$id_jdw_mhs/$row2->ID_JDW_AVAIL")."'>$row2->NAMA_DOSEN</a>";
    if($i%3==2)
        echo "</td></tr>";
    else
        echo "</td>";
    $i++;
}
?>
</table>