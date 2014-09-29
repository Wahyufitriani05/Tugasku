<?php

$sudah_ada=false;
foreach($proposal->result() as $row)
{
    $sudah_ada=true;
    header("Content-type: application/vnd.ms-word");
    header("Content-Disposition: attachment;Filename=lembar_persetujuanMajuSidangTA_".$row->nrp.".doc");

    echo "<html
          xmlns:o='urn:schemas-microsoft-com:office:office'
          xmlns:w='urn:schemas-microsoft-com:office:word'
          xmlns:v='urn:schemas-microsoft-com:vml'
          xmlns='http://www.w3.org/TR/REC-html40'>
          <head><title>Cetak Cover Proposal</title>
              <meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
              <[if gte mso 9]>
                 <xml>
                     <w:WordDocument>
                     <w:View>Print</w:View>
                     <w:Zoom>100</w:Zoom>
                     <w:DoNotOptimizeForBrowser/>
                     </w:WordDocument>
                 </xml>
             <![endif]>
             <style>
                 < /* Style Definitions */
                     @page Section1
                     {size:8.27in 11.69in;
                     margin:1.18in 1.0in 1.0in 1.0in ;
                     mso-header-margin:.5in;
                     mso-footer-margin:.5in; mso-paper-source:0;}
                     div.Section1
                     {page:Section1;}
                 >
             </style>
          </head>
          <body>
          <div class=Section1>
          <table align='left' border='0' style='width:600px;'>
          <tr align='center'><td colspan='2'><font size='6'>Lembar Persetujuan</font></td></tr>
          <tr align='center'><td colspan='2'><font size='6'>Maju Sidang Tugas Akhir</font></td></tr>
          <tr align='center' style='height:70px;'><td>&nbsp;</td></tr>
          <tr align='center'><td colspan='2'><font size='6'>$row->judul_ta</size></td></tr>
          <tr align='center'><td colspan='2'><font size='5'>($row->id_proposal)</size></td></tr>
          <tr align='center' style='height:70px;'><td>&nbsp;</td></tr>
          <tr align='center'><td colspan='2'><font size='4'>$row->nama_lengkap_mahasiswa</font></td></tr>
          <tr align='center'><td colspan='2'><font size='3'>$row->nrp</font></td></tr>
          <tr align='center' style='height:70px;'><td>&nbsp;</td></tr>
          <tr align='center'><td colspan='2'><font size='4'>Surabaya, .......................................</font></td></tr>
          <tr align='center' style='height:70px;'><td>&nbsp;</td></tr>
          <tr align='center'><td colspan='2'><font size='5'>Menyetujui,</font></td></tr>
          <tr align='center'><td style='width:50%'><font size='5'>Dosen Pembimbing 1</font></td><td><font size='5'>Dosen Pembimbing 2</font></td></tr>
          <tr><td>&nbsp;<br/><br/><br/><br/><br/></td></tr>
          <tr align='center'><td><font size='4'>$row->dosen1</font></td><td><font size='4'>$row->dosen2</font></td></tr>
          <tr align='center'><td><font size='3'>NIP. $row->pembimbing1</font></td><td><font size='3'>NIP. $row->pembimbing2</font></td></tr>
          </table>
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