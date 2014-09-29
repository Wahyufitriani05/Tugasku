<script type="text/javascript" src="<?php echo base_url(); ?>/assets/ckeditor/ckeditor.js"></script>
<div id="some-content" class="box box-shadow grid_13 clearfix">
    <!--?=$this->load->view("headerTab-addTopik");?-->
    <!--?=$this->load->view("subContent-addTopik");?-->
    <a name="top" id="top"></a>
    <div class="alpha omega">
        <!-- judul halaman + gambar-->
        <h1>Add Index.php</h1>
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
        <?php echo form_open_multipart('RestrictAccess');?>
                <table width="100%">
                    <tr><td>Unggah File restrict</td><td>:</td><td><input type="file" name="file_proposal" size="45px"/></td></tr>
                    <?php if(isset($_FILES['file_proposal']) && $_FILES['file_proposal']['name']=="")echo "<tr><td colspan=\"2\"></td><td><font color=\"red\">*File proposal harus diisi</font></td></tr>";?>
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