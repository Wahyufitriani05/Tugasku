<div id="some_other_content" class="box box-shadow alpha clear-both navigation">
    <?php
        $this->load->model('mberita');
        $data=$this->mberita->getThreeTopBerita();
    ?>
    <h2 class="box-header">Berita Terbaru</h2>
    <ul class="navigation" style="font-size: 12px;">
        <?php
        foreach($data as $row){
            echo "<li style=\"padding-bottom: 0.5em;\"><a href=\"".site_url('berita/detailBerita/'.$row->id_berita)."\">";
            if($row->judul_berita)echo $row->judul_berita;
            else echo "Tidak ada judul";
            echo "</a></li>";
        }
        ?>
    </ul>
</div>
<div id="some_other_content" class="box box-shadow alpha clear-both navigation">
    <h2 class="box-header">Teknik Informatika</h2>
    <ul class="navigation" style="font-size: 12px;">
        <li style="padding-bottom: 0.5em;"><a href="<?php echo site_url('berita/visimisi'); ?>">Visi & Misi</a></li>
    </ul>
</div>
<div id="some_other_content" class="box box-shadow alpha clear-both navigation">
    <h2 class="box-header">Link Lain</h2>
    <ul class="navigation" style="font-size: 12px;">
        <li style="padding-bottom: 0.5em;"><a href="http://www.if.its.ac.id/v2/">Teknik Informatika</a></li>
        <li style="padding-bottom: 0.5em;"><a href="http://www.baak.its.ac.id/KalenderAkademik.php">Kalender Akademik ITS</a></li>
    </ul>
</div>