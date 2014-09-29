<script type="text/javascript" src="<?php echo base_url(); ?>/assets/ckeditor/ckeditor.js"></script>
<div id="some-content" class="box box-shadow grid_13 clearfix">
    <!--?=$this->load->view("headerTab-addTopik");?-->
    <!--?=$this->load->view("subContent-addTopik");?-->
    <a name="top" id="top"></a>
    <div class="alpha omega" style="min-height: 450px;">
        <!-- judul halaman + gambar-->
        <h1>Formulir Pendaftaran Proposal TA</h1>
<!--        <h3 id="siteSub">tagline: From openSUSE</h3>-->
<!--        <div class="center">
            <div class="floatnone">
                <a href="/Portal:11.2" title="Portal:11.2"><img alt="openSUSE 11.2 out now!" src="<?php echo base_url()?>assets/images/3/31/OpenSUSE_11.2_728x90.png" width="728" height="90" border="0" /></a>
            </div>
        </div>-->
        <!-- judul halaman + gambar-->
        <br>
        <?php echo $this->load->view('proposalTA/redNote');
              $this->session->unset_userdata('error'); ?>
    </div>
    <br/>
</div>