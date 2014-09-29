<div id="some-content" class="box box-shadow grid_13 clearfix">
    <?php echo $this->load->view("topik/headerTab-topik");?>
    <? if($type=='dosen' || $type=='admin') $this->load->view("topik/subContent-topik");?>
    <div class="alpha omega" style="min-height: 400px;">
        <!-- judul halaman + gambar-->
        <div id="clear"></div>
        <h1>Topik Tugas Akhir</h1>
        <!-- judul halaman + gambar-->
        <div style="margin: 30px 0 30px 1em;font-size: 12px;min-width: 100%">
            <?php echo $this->load->view("topik/filter-topik");?>
            <?php echo $this->load->view("topik/search-topik");?>
        </div>
        <?php
        if($id_topik!=0){
            foreach($topik_approved as $row){
                echo "<table style=\"width:96.5%;align:center;background:#ffeecc;border:2px solid #FF9900; margin:1em 1em 1em 1em;\" cellpadding=\"5px\" cellspacing=\"0\">
                    <tr>
                        <td style=\"vertical-align: middle;\"><b>Topik Tugas Akhir yang Anda minati telah disetujui dosen. <br>Judul Topik : \"<i>$row->judul_topik</i>\"<br>Segera hubungi dosen yang pembimbing!!!</b>
                    </td></tr>
                </table>";
            }
        }
        ?>
        <?php echo $this->load->view("topik/lihatTopik");?>
        <div align="center"><?php echo $this->pagination->create_links();?></div>
    </div>
    <br/>
</div>