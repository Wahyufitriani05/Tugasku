<div class="box-header header-tabs">
    <ul>
        <li><a href="<?php echo site_url('topik/lihatTopik')?>" <?php if(strtolower($this->uri->segment(2))=="lihattopik")echo "class=\"selected\"";?> title="Daftar Semua Topik TA">Semua</a></li>
        <?php
        if($type=="dosen" || $type=="admin"){
            echo "<li><a href=\"".site_url('topik/topikSaya')."\"";
            if(strtolower($this->uri->segment(2))=="topiksaya")echo " class=\"selected\" ";
            echo "title=\"Daftar Topik Saya\" accesskey=\"t\">Topik Saya</a></li>";
        }
        ?>
        <!--li><a href="<?php echo site_url('topik/daftarTopikDosen')?>" <?php if(strtolower($this->uri->segment(2))=="daftarTopikDosen")echo "class=\"selected\"";?> title="Daftar Dosen Yang Memiliki Topik TA">Topik Dosen</a></li-->
    </ul>
</div>