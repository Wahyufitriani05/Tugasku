<?php
$count=0;
foreach($topik as $row)
{
    echo "
    <hr>
    <h2 style=\"margin: 1em 0 0 15px;\"> <span class=\"mw-headline\"> <a href=\"".site_url('topik/detailTopik/'.$row->id_topik)."\">$row->judul_topik</a></span></h2>
    <h6 style=\"margin: 0 0 1em 15px;font-size: 12px;display:inline\">oleh $row->nama_dosen, $row->waktu_topik</h6>
    <div style=\"display: inline;float: right;padding: 1em 1em 0 0; font-size: 14px;\">
        <span class=\"fr-value00\">KBK : </span><span class=\"fr-value".($row->id_kbk*20)."\">$row->nama_kbk</span>
        <span class=\"fr-value00\">Status : </span><span class=\"fr-value";if($row->status_topik=="0")echo "100\">Belum Diambil";else echo "20\">Diambil";echo"</span>
    </div>
    <div style=\"overflow:hidden; margin:3em .2em .2em .2em;\">
        <table style=\"width:98%;\">
        <tr>
            <td style=\"margin:0; padding:0 1em 0 1em; font-size:100%;\">
                $row->isi_topik...
            </td>
        </tr>
        <tr>
            <td align=\"right\" style=\"margin: 0px;padding: 1em 2em 0 1em;\">
                <div id='mw-revisiontag' class='flaggedrevs_short plainlinks noprint' style=\"position: relative\">
                    <table border='0' cellspacing='0' style='background: none;'>
                        <tr style='white-space:nowrap;'>
                            <td>
                                <span title=\"Quality page\" class=\"fr-icon-stable\"></span>&nbsp;
                                <b><a href=\"".site_url('topik/detailTopik/'.$row->id_topik)."\" title=\"Detail Topik\">Selengkapnya...</a></b>&nbsp;&nbsp;
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        </table>
    </div>";
    $count++;
}

//tidak ada topik yang sesuai
if($count==0){
    $this->session->set_userdata('error', 'Kata Kunci yang dicari tidak ditemukan di dalam daftar Topik !!!');
    echo "<br/><br/>";
    $this->load->view('kbkDosen/redNote');
    $this->session->unset_userdata('error');
}
?>