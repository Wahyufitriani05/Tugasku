<?php
echo "<link rel='stylesheet' href='".base_url()."assets/themes/bento/css/style.fluid.css' type='text/css' media='screen' />";
// Extension Style (User Interface)
echo "<link rel='stylesheet' href='".base_url()."assets/skins/common/shared.css?207' type='text/css' media='screen' />";
echo "<link rel='stylesheet' href='".base_url()."assets/skins/common/commonPrint.css?207' type='text/css' media='print' />";
// style for pop up window
echo "<link rel='stylesheet' href='".base_url()."assets/extensions/FlaggedRevs/flaggedrevs.css' type='text/css' />";
echo "<link rel='stylesheet' href='".base_url()."assets/skins/bento/css_local/style.css' type='text/css' media='screen' />";
?>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/ckeditor/ckeditor.js"></script>
<!-- judul halaman + gambar-->
<h1>Ubah Proposal TA</h1>
<!--        <h3 id="siteSub">tagline: From openSUSE</h3>-->
<!--        <div class="center">
<div class="floatnone">
    <a href="/Portal:11.2" title="Portal:11.2"><img alt="openSUSE 11.2 out now!" src="<?php echo base_url()?>assets/images/3/31/OpenSUSE_11.2_728x90.png" width="728" height="90" border="0" /></a>
</div>
</div>-->
<!-- judul halaman + gambar-->
<?php
$error="";
$error=$this->session->userdata('error');
if($error!=""){
    $this->load->view('kbkDosen/redNote');
    $this->session->unset_userdata('error');
}

$sukses="";
$sukses=$this->session->userdata('sukses');
if($sukses!=""){
    $this->load->view('kbkDosen/blueNote');
    $this->session->unset_userdata('sukses');
}
$judul_ta;
$abstraksi_ta;
$bidang_minat;
$keyword;
$pembimbing1;
$pembimbing2;
foreach($proposal as $row){
    $judul_ta=$row->judul_ta;
    $abstraksi_ta=$row->abstraksi;
    $bidang_minat=$row->nama_kbk;
    $keyword=$row->keyword;
    $pembimbing1=$row->nip_pembimbing1;
    $pembimbing2=$row->nip_pembimbing2;
}
?>
<?php 
$location="proposal/ubahProposal/";
if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="KBJ" || $this->session->userdata('type')=="KCV" || $this->session->userdata('type')=="RPL" || $this->session->userdata('type')=="AJK" || $this->session->userdata('type')=="MI" || $this->session->userdata('type')=="DTK" || $this->session->userdata('type')=="AP" || $this->session->userdata('type')=="IGS")$location.=$this->uri->segment(3, 0)."/".$this->uri->segment(4, 0);
else if($this->session->userdata('type')=="mahasiswa")$location.=$this->uri->segment(3, 0);
echo form_open_multipart($location);?>
    <table width="100%">
        <tr><td width="25%">Judul Tugas Akhir</td><td width="3%">:</td><td><input name="judul" type="text"  value="<?php if(isset($judul_ta))echo $judul_ta; else echo set_value('judul');?>" style="width: 450px;"/></td></tr>
        <?php if(form_error('judul'))echo "<tr><td colspan=\"2\"></td><td>".form_error('judul')."</td></tr>";?>
        <tr><td>Bidang Minat</td><td>:</td><td>
                <select name="bidang_minat" style="min-width: 200px;">
                    <option value="">Pilih Bidang Minat</option>
                    <?php
                    foreach($kbk as $row){
                        echo "<option value=\"$row->id_kbk\"";
                        if($row->nama_kbk==$bidang_minat) echo " selected";
                        echo ">$row->keterangan_kbk ($row->nama_kbk)</option>";
                    };
                    ?>
                </select></td></tr>
        <?php if(form_error('bidang_minat'))echo "<tr><td colspan=\"2\"></td><td>".form_error('bidang_minat')."</td></tr>";?>
        <tr><td>Abstraksi</td><td>:</td><td><?php echo form_error('abstraksi');?></td></tr>
        <tr><td colspan="3">
                <textarea class="ckeditor" cols="80" id="editor1" name="abstraksi" rows="10"><?php if(isset($abstraksi_ta))echo $abstraksi_ta;else echo "&nbsp;";?></textarea>
            </td></tr>
        <tr><td>Kata Kunci Proposal</td><td>:</td><td><input type="text" name="keyword" value="<?php if(isset($keyword))echo $keyword;else echo set_value('keyword');?>" style="min-width: 300px;">&nbsp;<a href="#">apa itu?</a></td></tr>
        <?php if(form_error('keyword'))echo "<tr><td colspan=\"2\"></td><td>".form_error('keyword')."</td></tr>";?>
        <tr><td>Dosen Pembimbing 1</td><td>:</td><td>
                <select name="pembimbing1" style="min-width: 200px;">
                    <option value="">pilih pembimbing</option>
                    <?php
                    $dosen = array();
                    $nip=array();
                    $indeks_dosen=0;
                    foreach($dosen_pembimbing as $row){
                        //$temp_nip=$row->nip2010;
                        //if($temp_nip=="")$temp_nip=$row->nip;
						$temp_nip=$row->nip;
						if($temp_nip=="")$temp_nip=$row->nip2010;
                        $nip[$indeks_dosen]=$temp_nip;
                        $dosen[$indeks_dosen++]=$row->nama_lengkap_dosen;
                        echo "<option value=\"$temp_nip\"";
                        if($temp_nip==$pembimbing1)echo " selected";
                        echo ">$row->nama_lengkap_dosen</option>";
                    };
                    ?>
                </select>
            </td></tr>
        <?php if(form_error('pembimbing1'))echo "<tr><td colspan=\"2\"></td><td>".form_error('pembimbing1')."</td></tr>";?>
        <tr><td>Dosen Pembimbing 2</td><td>:</td><td>
                <select name="pembimbing2" style="min-width: 200px;">
                    <option value="">pilih pembimbing</option>
                    <?php
                    for($i=0; $i<$indeks_dosen; $i++){
                        echo "<option value=\"$nip[$i]\"";
                        if($nip[$i]==$pembimbing2)echo " selected";
                        echo ">$dosen[$i]</option>";
                    }
                    ?>
                </select>
            </td></tr>
		<tr>
			<td colspan="3"><hr style="margin: 10px 0px 10px 0px;"><b>File yang diupload</b></td>
		</tr>
		<?php
		foreach($file_proposal as $file_sekarang){
			echo "	<tr>
						<td colspan=\"3\">- ".$file_sekarang->nama_file."</td>
					</tr>";
		}
		?>
        <tr><td colspan="3"><hr style="margin: 10px 0px 10px 0px;"><b>Upload Baru</b><br><?php $this->load->view('proposalTA/yellowNote-FilePermitted');?></td></tr>
            <tr><td>Unggah File Proposal</td><td>:</td><td><input type="file" name="file_proposal" size="45px"/></td></tr>
            <?php if(isset($_FILES['file_proposal']) && $_FILES['file_proposal']['name']=="")echo "<tr><td colspan=\"2\"></td><td><font color=\"red\">*File proposal harus diisi</font></td></tr>";?>
            <tr><td>Unggah File Referensi</td><td>:</td><td><input type="file" name="file_paper" size="45px"/></td></tr>
            <tr><td colspan="3" style="padding-right: 2em;">
                <div id='mw-revisiontag' class='flaggedrevs_short plainlinks noprint' style="position: relative">
                    <table border='0' cellspacing='0' style='background: none;'>
                        <tr style='white-space:nowrap;'>
                            <td>
                                <span title="Quality page" class="fr-icon-download"></span>&nbsp;
                                <b><input type="submit" style="background: none;border: none;" value="Ubah Proposal"></b>&nbsp;&nbsp;
                            </td>
                        </tr>
                    </table>
                </div>
                </td></tr>
    </table>
</form>