<?php
foreach($topik as $row)
{
echo "
<h2 style=\"margin: 1em 0 0 15px;\"> <span class=\"mw-headline\">$row->judul_topik</span></h2>
<h6 style=\"margin: 0 0 1em 15px;font-size: 12px;display:inline\">oleh $row->nama_dosen, $row->waktu_topik</h6>
<div style=\"display: inline;float: right;padding: 1em 1em 0 0; font-size: 14px;\">
    <span class=\"fr-value00\">KBK : </span><span class=\"fr-value".($row->id_kbk*20)."\">$row->nama_kbk</span>
    <span class=\"fr-value00\">Status : </span><span class=\"fr-value";if($row->status_topik=="0")echo "100\">Belum Diambil";else echo "20\">Diambil";echo"</span>
</div>
<div style=\"overflow:hidden; margin:3em .2em .2em .2em;min-height:400px;\">
    <table width=400 border=1>
    <tr>
        <td style=\"margin:0; padding:0 1em 0 1em; font-size:100%;\">
            $row->abstraksi_topik
        </td>
    </tr>";
    if($type=="dosen" || $type=="admin" || $type=="mahasiswa"){
        echo "
            <tr>
                <td style=\"margin:0; padding:2em 1em 0 1em; font-size:100%;\">
                    <table id=\"toc\" class=\"toc\" summary=\"Contents\" style=\"style=\"margin:30px 0px 0px 0px;width:500px;height: 100px;\" >
                        <tr>
                            <td>
                                <div id=\"toctitle\"><h2>File Pendukung</h2></div>
                                <ul>";
                                $jumlah_file=0;
                                foreach($file_topik as $row2)
                                {
                                    echo "<li class=\"toclevel-1\">
                                       <span class=\"toctext\">
                                            <a href=\"".base_url().'assets/files/topik/'.$row2->path_file."\"><span class=\"tocnumber\"></span> <span class=\"toctext\">$row2->nama_file</span></a>
                                       </span>
                                    </li>";
                                    $jumlah_file++;
                                }
                                if($jumlah_file==0)echo "---Tidak ada File---";
                                echo "</ul>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>";
    };
    echo "<tr>
        <td align=\"right\" style=\"margin: 0px;padding: 1em 2em 0 1em;\">";
           if($type=="dosen" || $type=="admin")
           {
//                echo "<div id='mw-revisiontag' class='flaggedrevs_short plainlinks noprint' style=\"position: relative;\">
//                    <table border='0' cellspacing='0' style='background: none;'>
//                        <tr style='white-space:nowrap;'>
//                            <td>
//                                <span title=\"Quality page\" class=\"fr-icon-delete\"></span>&nbsp;
//                                <b><a href=\"#\" title=\"Menghapus Topik\">Hapus</a></b>&nbsp;&nbsp;
//                            </td>
//                        </tr>
//                    </table>
//                </div>";
               if($topik_dosen>0){
                    echo "<div id='mw-revisiontag' class='flaggedrevs_short plainlinks noprint' style=\"position: relative\">
                        <table border='0' cellspacing='0' style='background: none;'>
                            <tr style='white-space:nowrap;'>
                                <td>
                                    <span title=\"Quality page\" class=\"fr-icon-edit\"></span>&nbsp;
                                    <b><a href=\"".site_url('topik/ubahTopik/'.$row->id_topik)."?TB_iframe=true&height=450&width=700\" class=\"thickbox\" title=\"Ubah Topik\">Ubah</a></b>&nbsp;&nbsp;
                                </td>
                            </tr>
                        </table>
                    </div>";
               }
           }
           else if($type=="mahasiswa")
           {
                echo "<div id='mw-revisiontag' style=\"position: relative\">
                    <table border='0' cellspacing='0' style='background: none;'>
                        <tr style='white-space:nowrap;'>";
                            if($row->status_topik=="0" && $jumlah_topik_yang_diajukan==0 && $belum_punya_proposal){
                                echo "<td>
                                    <form action=\"".site_url('topik/ambilTopik')."\" method=\"POST\">
                                    <!--span title=\"Quality page\" class=\"fr-icon-download\"></span-->
                                    <input type=\"hidden\" name=\"id_topik\" value=\"$row->id_topik\"/>
                                    <input type=\"hidden\" name=\"uri\" value=\"".$this->uri->uri_string()."\"/>
                                    <input type=\"submit\" value=\"Ambil\" style=\"padding:5px 5px 5px 5px;-moz-border-radius:5px 5px 5px 5px;border:1px solid #DDDDDD;line-height:1;font-size: 12px;font-weight: 700;color: #006699;background-color:#F9F9F9;background-image: none;\"/>
                                    </form>
                                </td>";
                            }
                            if($row->status_topik=="0" && $minati_topik_sekarang>0){
                                echo "<td>
                                    <form action=\"".site_url('topik/batalTopik')."\" method=\"POST\">
                                    <!--span title=\"Quality page\" class=\"fr-icon-back\"></span-->&nbsp;
                                    <input type=\"hidden\" name=\"id_topik\" value=\"$row->id_topik\"/>
                                    <input type=\"hidden\" name=\"uri\" value=\"".$this->uri->uri_string()."\"/>
                                    <input type=\"submit\" value=\"Batal\" style=\"padding:5px 5px 5px 5px;-moz-border-radius:5px 5px 5px 5px;border:1px solid #DDDDDD;line-height:1;font-size: 12px;font-weight: 700;color: #006699;background-color:#F9F9F9;background-image: none;\"/>
                                    </form>
                                </td>";
                            }
                        echo"</tr>
                    </table>
                </div>";
           }
        echo "</td>
    </tr>
    </table>
</div>
<hr>";
}
?>