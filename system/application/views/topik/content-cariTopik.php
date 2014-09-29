<div id="some-content" class="box box-shadow grid_13 clearfix">
    <?php echo $this->load->view("topik/headerTab-topik");?>
    <? if($type=='dosen' || $type=='admin') $this->load->view("topik/subContent-topik");?>
    <div class="alpha omega" style="min-height: 400px;">
        <!-- judul halaman + gambar-->
        <div id="clear"></div>
        <h1>Topik Tugas Akhir</h1>
        <!-- judul halaman + gambar-->
        <div style="margin: 30px 0 30px 1em;font-size: 12px;min-width: 100%">
            <div style="height: 1px;">Hasil Pencarian :</div>
            <?php echo $this->load->view("topik/search-topik");?>
        </div>
        <?php echo $this->load->view("topik/lihatTopik");?>
        <div align="center"><?php echo $this->pagination->create_links();?></div>
    </div>
    <br/>
</div>