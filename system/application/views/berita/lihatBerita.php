<?php
$count=0;
foreach($berita as $row){
    echo "
        <h2 style=\"margin: 1em 0 0 15px;\"> <span class=\"mw-headline\"><a href=\"".site_url('berita/detailBerita/'.$row->id_berita)."\" title=\"Detail Berita $row->id_berita\">";
        if($row->judul_berita!="")echo $row->judul_berita;
        else echo "Tidak Ada Judul";
    echo "</a></span></h2>";
    echo "<h6 style=margin: 0 0 1em 15px;font-size: 12px;display:inline>
        oleh $row->nama_dosen,
        $row->waktu_berita</h6>
        <div style=\"overflow:hidden; margin:1em .2em .2em .2em;\">
            <table style=\"width:100%;\">
            <tr>
                <td style=\"margin:0; padding:0 1em 0 1em; font-size:100%;\">
                    $row->isi_berita...
                </td>
            </tr>
            <tr>
                <td align=\"right\" style=\"margin: 0px;padding: 1em 2em 0 1em;\">";
//                //tombol hapus berita
//                echo "
//                    <div id='mw-revisiontag' class='flaggedrevs_short plainlinks noprint' style=\"position: relative;\">
//                        <table border='0' cellspacing='0' style='background: none;'>
//                            <tr style='white-space:nowrap;'>
//                                <td>
//                                    <span title=\"Quality page\" class=\"fr-icon-delete\"></span>&nbsp;
//                                    <b><a href=\"#\" title=\"Menghapus Topik\">Hapus</a></b>&nbsp;&nbsp;
//                                </td>
//                            </tr>
//                        </table>
//                    </div>";
//                //tombol ubah berita
//                echo "
//                    <div id='mw-revisiontag' class='flaggedrevs_short plainlinks noprint' style=\"position: relative\">
//                        <table border='0' cellspacing='0' style='background: none;'>
//                            <tr style='white-space:nowrap;'>
//                                <td>
//                                    <span title=\"Quality page\" class=\"fr-icon-edit\"></span>&nbsp;
//                                    <b><a href=\"#\" title=\"Mengubah Topik\">Ubah</a></b>&nbsp;&nbsp;
//                                </td>
//                            </tr>
//                        </table>
//                    </div>";
                //tombol lihat detail berita
                echo "
                     <div id='mw-revisiontag' class='flaggedrevs_short plainlinks noprint' style=\"position: relative\">
                        <table border='0' cellspacing='0' style='background: none;'>
                            <tr style='white-space:nowrap;'>
                                <td>
                                    <span title=\"Quality \" class=\"fr-icon-stable\"></span>&nbsp;
                                    <b><a href=\"".site_url('berita/detailBerita/'.$row->id_berita)."\" title=\"Detail Berita $row->id_berita\">Selengkapnya...</a></b>&nbsp;&nbsp;
                                </td>
                            </tr>
                        </table>
                    </div>";
				$tipe_user=$this->session->userdata('type');
				if($tipe_user=="admin" || $tipe_user=="KBJ" || $tipe_user=="KCV" || $tipe_user=="RPL" || $tipe_user=="AJK" || $tipe_user=="MI" || $tipe_user=="DTK" || $tipe_user=="AP" || $tipe_user=="AP" || $tipe_user=="IGS")
				{
					//tombol ubah Berita
					echo "
						 <div id='mw-revisiontag' class='flaggedrevs_short plainlinks noprint' style=\"position: relative\">
							<table border='0' cellspacing='0' style='background: none;'>
								<tr style='white-space:nowrap;'>
									<td>
										<span title=\"Quality \" class=\"fr-icon-stable\"></span>&nbsp;
										<b><a href=\"".site_url('berita/ubahBerita/'.$row->id_berita)."?TB_iframe=true&height=450&width=700\" class=\"thickbox\" title=\"Ubah Berita\">Ubah Berita</a></b>&nbsp;&nbsp;
									</td>
								</tr>
							</table>
						</div>";
					//tombol hapus Berita
					echo "
						 <div id='mw-revisiontag' class='flaggedrevs_short plainlinks noprint' style=\"position: relative\">
							<table border='0' cellspacing='0' style='background: none;'>
								<tr style='white-space:nowrap;'>
									<td>
										<span title=\"Quality \" class=\"fr-icon-stable\"></span>&nbsp;
										<b><a href=\"".site_url('berita/hapusBerita/'.$row->id_berita)."\" title=\"Hapus Berita\">hapus Berita</a></b>&nbsp;&nbsp;
									</td>
								</tr>
							</table>
						</div>";
				}
                echo "
                </td>
            </tr>
            </table>
        </div>
        <hr/>
";
$count++;
}

//tidak ada berita yang sesuai
if($count==0){
    $this->session->set_userdata('error', 'Kata Kunci yang dicari tidak ditemukan di dalam daftar Berita !!!');
    echo "<br/><br/>";
    $this->load->view('kbkDosen/redNote');
    $this->session->unset_userdata('error');
}
?>