<div id="header">
    <div id="header-content" class="container_12">
        <!--<a id="header-logo" href="http://www.opensuse.org"><img src="<?=base_url()?>assets/skins/bento/header-logo.png" width="46" height="26" alt="Header Logo" /></a>-->
        <a id="header-logo" href="<?php echo base_url();?>"><img src="<?=base_url()?>assets/images/images_book logo2.gif" width="86" height="30" alt="Header Logo" /></a>
        <ul id="global-navigation">
            <li id="item-topikTA"><a href="#">Topik TA</a></li>
            <li><a href="<?php echo site_url('progres/tugasakhir')?>">Pencarian TA</a></li>
            <li id="item-sidang"><a href="#">Sidang</a></li>
            <?php if($this->session->userdata['type']=="admin")echo "<li id=\"item-kbkDosen\"><a href=\"#\">RMK Dosen</a></li>";?>
            <li id="item-berita"><a href="#">Berita</a></li>
            <li id="item-penjadwalan"><a href="#">Penjadwalan</a></li>
            <?php if($this->session->userdata['type']=="admin")echo "<li id=\"item-mahasiswa\"><a href=\"#\">Mahasiswa</a></li>";?>
            <li id="item-lamastudi"><a href="#">Lama Pengerjaan TA</a></li>
            <?php if($this->session->userdata['type']=="admin")echo "<li id=\"item-statistik\"><a href=\"#\">Statistik</a></li>";?>
        </ul>
    </div>
</div>