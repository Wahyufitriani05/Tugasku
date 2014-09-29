<div id="some-content" class="box box-shadow grid_13 clearfix">
    <?php if($type=="admin")$this->load->view("berita/subContent-berita");?>
    <div class="alpha omega" style="min-height: 500px;">
        <!-- judul halaman + gambar-->
        <a href="<?php echo site_url('berita/lihatBerita'); ?>"><h1>Berita</h1></a>
        <!-- judul halaman + gambar-->
        <div style="margin: 1em 0 1em 1em;font-size: 12px;min-width: 100%;">
            <?=$this->load->view("berita/search-berita");?>
        </div>
        <?=$this->load->view("berita/lihatBerita");?>
        <div align="center"><?php echo $this->pagination->create_links();?></div>
    </div>
    <br/>
</div>