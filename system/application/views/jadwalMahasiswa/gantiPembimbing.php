<h3 style="color:#4B75B3">Daftar Dosen Pembimbing Yang Tersedia</h3>
<table border="0">
<?php
echo "<a style='color:#4B75B3' href='".site_url("jadwalMahasiswa/confirmGantiPembimbing/$no/$id_sidangTA/$id_proposal/")."'><b>Hapus Pembimbing $no</b></a><br>";
$i=0;
foreach ($list_dosen as $row) {
    if($i%3==0)
        echo "<tr><td>";
    else
        echo "<td>";
    echo "<a style='color:#4B75B3' href='".site_url("jadwalMahasiswa/confirmGantiPembimbing/$no/$id_sidangTA/$id_proposal/$row->NIP")."'>$row->NAMA_DOSEN</a>";
    if($i%3==2)
        echo "</td></tr>";
    else
        echo "</td>";
    $i++;
}
?>
</table>