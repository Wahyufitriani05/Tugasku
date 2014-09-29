<div id="some-content" class="box box-shadow grid_13 clearfix" style="min-height: 450px;">
    <a name="top" id="top"></a>
    <div class="alpha omega">
        <!-- judul halaman + gambar-->
        <h1><?php echo $title;?></h1>
        <!-- judul halaman + gambar-->
        <div style="margin: 1em 0 1em 1em;font-size: 12px;min-width: 100%">
            <?php echo $this->load->view("kbkDosen/tambah-KBK");?>
        </div>
        <?php echo $this->load->view("kbkDosen/KBKDosen");?>
    </div>
    <br/>
</div>