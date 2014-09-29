<?php foreach($berita as $row){
    echo "
        <h2 style=\"margin: 1em 0 0 15px;\"> <span class=\"mw-headline\"><a href=\"".site_url('berita/detailBerita/'.$this->uri->segment(3))."\" title=\"Detail Berita ".$this->uri->segment(3)."\">";
        if($row->judul_berita!="")echo $row->judul_berita;
        else echo "Tidak Ada Judul";
    echo "</a></span></h2>
        <h6 style=margin: 0 0 1em 15px;font-size: 12px;display:inline>
        oleh $row->nama_dosen,
        $row->waktu_berita</h6>
        <div style=\"overflow:hidden; margin:1em .2em .2em .2em;\">
            <table style=\"width:100%;\">
            <tr>
                <td style=\"margin:0; padding:0 1em 0 1em; font-size:100%;\">
                    $row->isi_berita
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
                echo "
                </td>
            </tr>
            </table>
        </div>
";
echo $this->load->view("berita/file_pendukung");
}
?>