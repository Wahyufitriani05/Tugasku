<script type="text/javascript" src="<?php echo base_url(); ?>/assets/ckeditor/ckeditor.js"></script>
<div id="some-content" class="box box-shadow grid_13 clearfix">
    <!--?=$this->load->view("headerTab-addTopik");?-->
    <!--?=$this->load->view("subContent-addTopik");?-->
    <a name="top" id="top"></a>
    <div class="alpha omega">
        <!-- judul halaman + gambar-->
        <h1>Formulir Pendaftaran Proposal TA</h1>
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
        ?>
        <div style="margin: 1em 0 1em 1em;font-size: 12px;min-width: 100%">
        <?php echo form_open_multipart('proposal/buatProposal');?>
                <table width="100%">
                    <tr><td width="25%">Judul Tugas Akhir</td><td width="3%">:</td><td><input name="judul" type="text"  value="<?php echo set_value('judul');?>" style="width: 450px;"/></td></tr>
                    <?php if(form_error('judul'))echo "<tr><td colspan=\"2\"></td><td>".form_error('judul')."</td></tr>";?>
                    <tr><td>Bidang Minat</td><td>:</td><td>
                            <select name="bidang_minat" style="min-width: 200px;">
                                <option value="">Pilih Bidang Minat</option>
                                <?php
                                foreach($kbk as $row){
                                    echo "<option value=\"$row->id_kbk\" ".set_select('bidang_minat', $row->id_kbk).">$row->keterangan_kbk ($row->nama_kbk)</option>";
                                };
                                ?>
                            </select></td></tr>
                    <?php if(form_error('bidang_minat'))echo "<tr><td colspan=\"2\"></td><td>".form_error('bidang_minat')."</td></tr>";?>
                    <tr><td>Abstraksi</td><td>:</td><td><?php echo form_error('abstraksi');?></td></tr>
                    <tr><td colspan="3">
                            <textarea class="ckeditor" cols="80" id="editor1" name="abstraksi" rows="10"><?php if(set_value ('abstraksi'))echo set_value ('abstraksi');else echo "&nbsp;";?></textarea>
                        </td></tr>
                    <tr><td>Kata Kunci Proposal</td><td>:</td><td><input type="text" name="keyword" value="<?php echo set_value('keyword');?>" style="min-width: 300px;">&nbsp;<a href="#">apa itu?</a></td></tr>
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
                                    echo "<option value=\"$temp_nip\" ".set_select('pembimbing1', $temp_nip).">$row->nama_lengkap_dosen</option>";
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
                                    echo "<option value=\"$nip[$i]\" ".set_select('pembimbing2', $nip[$i]).">$dosen[$i]</option>";
                                }
                                ?>
                            </select>
                        </td></tr>
                    <?php if(form_error('pembimbing2'))echo "<tr><td colspan=\"2\"></td><td>".form_error('pembimbing2')."</td></tr>";?>
                    <tr><td colspan="3"><hr style="margin: 10px 0px 10px 0px;"><?php $this->load->view('proposalTA/yellowNote-FilePermitted');?></td></tr>
                    <tr><td>Unggah File Proposal</td><td>:</td><td><input type="file" name="file_proposal" size="45px"/></td></tr>
                    <?php if(isset($_FILES['file_proposal']) && $_FILES['file_proposal']['name']=="")echo "<tr><td colspan=\"2\"></td><td><font color=\"red\">*File proposal harus diisi</font></td></tr>";?>
                    <tr><td>Unggah File Referensi</td><td>:</td><td><input type="file" name="file_paper" size="45px"/></td></tr>
                    <!--?php if(isset($_FILES['file_paper']) && $_FILES['file_paper']['name']=="")echo "<tr><td colspan=\"2\"></td><td><font color=\"red\">*File paper harus diisi</font></td></tr>";?-->
<!--                    <tr><td colspan="3"><?php echo $this->load->view("proposalTA/summary");?></td></tr>-->
                    <tr><td colspan="3" style="padding-right: 2em;">
                        <div id='mw-revisiontag' class='flaggedrevs_short plainlinks noprint' style="position: relative">
                            <table border='0' cellspacing='0' style='background: none;'>
                                <tr style='white-space:nowrap;'>
                                    <td>
                                        <span title="Quality page" class="fr-icon-download"></span>&nbsp;
                                        <b><input type="submit" style="background: none;border: none;" value="Buat Proposal Baru"></b>&nbsp;&nbsp;
                                    </td>
                                </tr>
                            </table>
                        </div>
                        </td></tr>
                </table>
            </form>
        </div>
    </div>
    <br/>
</div>