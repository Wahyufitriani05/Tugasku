<div id="some-content" class="box box-shadow grid_13 clearfix">
    <?php echo $this->load->view("kbkDosen/subContent-addDosen");?>
    <a name="top" id="top"></a>
    <div class="alpha omega">
        <!-- judul halaman + gambar-->
        <h1>Daftar Dosen & RMK</h1>
        <?php
            $error="";
            $error=$this->session->userdata('error');
            if($error!=""){
                $this->load->view('kbkDosen/redNote');
            }

            $sukses="";
            $sukses=$this->session->userdata('sukses');
            if($sukses!=""){
                $this->load->view('kbkDosen/blueNote');
            }
        ?>
        <!-- judul halaman + gambar-->
        <div style="margin: 1em 0 1em 1em;font-size: 12px;min-width: 100%">
            <?php echo $this->load->view("kbkDosen/search-dosen");?>
        </div>
        <?php echo $this->load->view("kbkDosen/daftarDosen");?>
    </div>
    <br/>
</div>