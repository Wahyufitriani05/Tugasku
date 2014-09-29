<?php echo $this->lib_js->thickbox();?>
<hr>
<?php
$count=0;
echo "<table class=\"table1\" style=\"width:90%; margin-top:20px; border:1px solid #aaa;\" border=\"1\" cellpadding=\"2\" cellspacing=\"3\">
<tr><th>ID Topik</th><th>Judul Topik</th><th>Tanggal Publish</th><th>Jumlah Peminat</th><th>Status Topik</th><th>Detail Peminat</th><th>Ubah</th></tr>";
foreach($topik as $row)
{
    echo "<tr align=\"left\"";
    if($count%2==1)echo " class=\"rowA\"";
    else echo " class=\"rowB\"";
    echo "><td>$row->id_topik</td><td>$row->judul_topik</td><td>$row->waktu_topik</td><td>$row->jumlah_approve</td><td>";
    if($row->status_topik==0)echo "Menunggu";
    else echo "Sudah Diambil";
    echo "</td><td><a href=\"".site_url('topik/statusTopik/'.$row->id_topik)."?TB_iframe=true&height=450&width=700\" class=\"thickbox\" title=\"Status Topik\" >Lihat Peminat</a></td><td><a href=\"".site_url('topik/ubahTopik/'.$row->id_topik)."?TB_iframe=true&height=450&width=700\" class=\"thickbox\" title=\"Ubah Topik\">Ubah</a></td></tr>";
    $count++;
}
echo "</table>";

//tidak ada topik yang sesuai
if($count==0){
    $this->session->set_userdata('error', 'Kata Kunci yang dicari tidak ditemukan di dalam daftar Topik !!!');
    echo "<br/><br/>";
    $this->load->view('kbkDosen/redNote');
    $this->session->unset_userdata('error');
}
?>