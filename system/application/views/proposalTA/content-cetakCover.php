
<?php

$sudah_ada=false;
foreach($proposal->result() as $row)
{
    $sudah_ada=true;
    header("Content-type: application/vnd.ms-word");
    header("Content-Disposition: attachment;Filename=cover_proposalTA_".$row->nrp.".doc");

    /* alowwed size:
     * 1 --> 7.5 pt
     * 2 --> 10 pt
     * 3 --> 12 pt
     * 4 --> 13.5 pt
     * 5 --> 18 pt
     * 6 --> 24 pt
     * 7 --> 36 pt
     */
    
    //lembar pertama pengesahan proposal
    echo "<html>
          <meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
          <body>
          <table align='left' border='0' style='width:600px;'>
          <tr><td><img src='".base_url()."assets\Logo\Logo_ITS.gif' width='200' height='120'></img></td>
              <td align=\"right\">
                <table border='1' style='display:block;float:right;border-style: solid;border-collapse: collapse;padding:3 3 3 3'>
                <tr><td colspan='3' style='background-color: black; color: white;'>Status Proposal</td></tr>
                <tr><td align=\"center\" style=\"width:50px;\">OK</td><td align=\"center\" style=\"width:50px;\">REVISI</td><td align=\"center\" style=\"width:50px;\">DITOLAK</td></tr>
            </table>
            </td>
          </tr>
          <tr><td colspan='2'><hr style='color:#007dc5;margin:0 0 0 0;height:10px;'/></td></tr>
          <tr><td colspan='2'><font size='7'>Proposal Tugas Akhir</font></td></tr>
          <tr><td colspan='2'><font size='6'>$row->judul_ta</font></td></tr>
          <tr align='center' style='height:30px;'><td>&nbsp;</td></tr>
          <tr><td colspan='2'><font size='5'>$row->nama_lengkap_mahasiswa</font></td></tr>
          <tr><td colspan='2'><font size='4'>$row->nrp</font></td></tr>
          <tr align='center' style='height:30px;'><td>&nbsp;</td></tr>
          <tr><td colspan='2'><font size='4'>Dosen Pembimbing 1</font></td></tr>
          <tr><td colspan='2'><hr/></td></tr>
          <tr><td><font size='4'>$row->dosen1</font></td><td><font size='4'>$row->pembimbing1</font></td></tr>
          <tr align='center' style='height:30px;'><td>&nbsp;</td></tr>
          <tr><td colspan='2'><font size='4'>Dosen Pembimbing 2</font></td></tr>
          <tr><td colspan='2'><hr/></td></tr>
          <tr><td><font size='4'>$row->dosen2</font></td><td><font size='4'>$row->pembimbing2</font></td></tr>
          <tr align='center' style='height:30px;'><td>&nbsp;</td></tr>
          <tr align='center' style='height:30px;'><td>&nbsp;</td></tr>";
          if(strlen($row->judul_ta)<40)echo "<tr align='center' style='height:100px;'><td>&nbsp;</td></tr>";
          else if(strlen($row->judul_ta)<100) echo "<tr align='center' style='height:50px;'><td>&nbsp;</td></tr>";
          echo "<tr><td colspan='2'><font size='3'><b>Jurusan Teknik Informatika</b></font></td></tr>
          <tr><td colspan='2'><font size='3'><b>Fakultas Teknologi Informasi</b></font></td></tr>
          <tr><td colspan='2'><font size='3'><b>Institut Teknologi Sepuluh November</b></font></td></tr>
          <tr><td colspan='2'><font size='3'><b>Surabaya $row->tahun_proposal</b></font></td></tr>
          <tr><td>&nbsp</td></tr>
          </table>";

          //lembar kedua, lembar revisi sidang proposal
          echo "
          <table align='left' border='0' style='width:600px;'>
            <tr><td colspan='2' align='center'><font size='6'>Lembar Revisi</font></td></tr>
            <tr><td colspan='2' align='center'><font size='6'>Sidang Proposal</font></td></tr>";
            if(strlen($row->judul_ta<40))echo "<tr align='center' style='height:30px;'><td>&nbsp;</td></tr>";
            echo "<tr><td colspan='2' align='center'><font size='5'>$row->judul_ta</font></td></tr>";
            if(strlen($row->judul_ta<40))echo "<tr align='center' style='height:30px;'><td>&nbsp;</td></tr>";
            echo "<tr><td colspan='2' align='center'><font size='5'>$row->nama_lengkap_mahasiswa</font></td></tr>
            <tr><td colspan='2' align='center'><font size='4'>$row->nrp</font></td></tr>
            <tr align='center' style='height:30px;width:300;'><td>&nbsp;</td></tr>
            <tr><td colspan='2' align='center'><font size='5'>Isi Revisi :</font></td></tr>
            <tr align='center' style='height:15px;'><td>&nbsp;</td></tr>
            <tr><td colspan='2' align='center'><font size='3'><hr style=\"border-style: dashed\"/></font></td></tr>
            <tr align='center' style='height:15px;'><td>&nbsp;</td></tr>
            <tr><td colspan='2' align='center'><font size='3'><hr style=\"border-style: dashed\"/></font></td></tr>
            <tr align='center' style='height:15px;'><td>&nbsp;</td></tr>
            <tr><td colspan='2' align='center'><font size='3'><hr style=\"border-style: dashed\"/></font></td></tr>
            <tr align='center' style='height:15px;'><td>&nbsp;</td></tr>
            <tr><td colspan='2' align='center'><font size='3'><hr style=\"border-style: dashed\"/></font></td></tr>
            <tr align='center' style='height:15px;'><td>&nbsp;</td></tr>
            <tr><td colspan='2' align='center'><font size='3'><hr style=\"border-style: dashed\"/></font></td></tr>
            <tr align='center' style='height:15px;'><td>&nbsp;</td></tr>
            <tr><td colspan='2' align='center'><font size='3'><hr style=\"border-style: dashed\"/></font></td></tr>
            <tr align='center' style='height:15px;'><td>&nbsp;</td></tr>
            <tr><td colspan='2' align='center'><font size='3'><hr style=\"border-style: dashed\"/></font></td></tr>
            <tr align='center' style='height:15px;'><td>&nbsp;</td></tr>
            <tr><td colspan='2' align='center'><font size='3'><hr style=\"border-style: dashed\"/></font></td></tr>
            <tr align='center' style='height:30px;'><td>&nbsp;</td></tr>
            <tr><td colspan='2' align='center'><font size='4'>Surabaya, .......................................</font></td></tr>
            <tr><td colspan='2' align='center'><font size='4'>Revisi disetujui oleh</font></td></tr>
            <tr align='center' style='height:30px;'><td>&nbsp;</td></tr>
            <tr><td align='center'>Dosen Penguji 1</td><td align='center'>Dosen Penguji 2</td></tr>
            <tr align='center' style='height:50px;'><td>&nbsp;</td></tr>
            <tr align='center'><td>..................................................</td><td>..................................................</td></tr>
            <tr align='center'><td>NIP ........................................</td><td>NIP ........................................</td></tr>
            </table>";

          //lembar ketiga, lembar pengesahan proposal tugas akhir
          echo "<table align='left' border='0' style='width:600px;'>
          <tr align='center'><td colspan='2'><font size='6'>Lembar Pengesahan</font></td></tr>
          <tr align='center'><td colspan='2'><font size='6'>Proposal Tugas Akhir</font></td></tr>
          <tr align='center' style='height:70px;'><td>&nbsp;</td></tr>
          <tr align='center'><td colspan='2'><font size='6'>$row->judul_ta</size></td></tr>
          <tr align='center'><td colspan='2'><font size='5'>($row->id_proposal)</size></td></tr>
          <tr align='center' style='height:70px;'><td>&nbsp;</td></tr>
          <tr align='center'><td colspan='2'><font size='4'>$row->nama_lengkap_mahasiswa</font></td></tr>
          <tr align='center'><td colspan='2'><font size='3'>$row->nrp</font></td></tr>
          <tr align='center' style='height:70px;'><td>&nbsp;</td></tr>
          <tr align='center'><td colspan='2'><font size='4'>Surabaya, ........................................</font></td></tr>
          <tr align='center' style='height:70px;'><td>&nbsp;</td></tr>
          <tr align='center'><td colspan='2'><font size='4'>Menyetujui,</font></td></tr>
          <tr align='center'><td style='width:50%'><font size='3'>Dosen Pembimbing 1</font></td><td><font size='3'>Dosen Pembimbing 2</font></td></tr>
          <tr><td>&nbsp;<br/><br/><br/><br/><br/></td></tr>
          <tr align='center'><td><font size='3'>$row->dosen1</font></td><td><font size='3'>$row->dosen2</font></td></tr>
          <tr align='center'><td><font size='3'>NIP. $row->pembimbing1</font></td><td><font size='3'>NIP. $row->pembimbing2</font></td></tr>
          </table>";
          echo "
          </body>
          </html>";
}
if(!$sudah_ada)
{
    $this->session->set_userdata('error', 'Anda belum membuat proposal atau proposal Anda batal');
    $this->load->view('proposalTA/redNote');
    $this->session->unset_userdata('error');
}
?>

<hr style="width: 200;"/>