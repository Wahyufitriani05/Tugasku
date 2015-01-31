<div id="some-content" class="box box-shadow clearfix">
    <div class="alpha omega">
        <!--<h1><?php echo (isset($title) ? $title : ""); ?></h1>-->
        <?php 
            if($tahun!=null && $tahun!="" && $tahun!="all")   
            {
                $semester = substr($tahun, 5, 1);                    
                $year = substr($tahun, 0, 4);          
            } 
        ?>
        <h1><?php if($nama!="") echo $nama;  if($tipe!="") echo " - ".$tipe;
        if($rmk!="" && $rmk!="all") echo " - ".$rmk; 
        if($tahun!="" && $tahun!="all") {
             if($semester==2)
                echo " - ".($year-1)."/".$year." (Genap)";
            else                
                echo " - ".($year)."/".($year+1)." (Ganjil)";
        }
                           
        ?>
        </h1>
        <?php
        if(! empty($listTA))
            $this->load->view("lamastudi/detailMahasiswa");
        ?>
    </div>
</div>