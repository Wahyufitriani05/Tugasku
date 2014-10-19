<script>
	function printContent(el){
		var restorepage = document.body.innerHTML;
		var printcontent = document.getElementById(el).innerHTML;
		document.body.innerHTML = printcontent;
		window.print();
		document.body.innerHTML = restorepage;
	}
	</script> 

<div id="some-content" class="box box-shadow clearfix">
    <div class="alpha omega">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
        <div style="margin: 1em;">
            <?php 
            // jika belum pernah bimbingan
            if(isset($bimbingan) && empty($bimbingan))
                echo "<div class='warning'><h3>BELUM PERNAH BIMBINGAN</h3>$detailTA->nama_lengkap_mahasiswa ($detailTA->nrp) belum pernah melakukan bimbingan tugas akhir</div>";
            ?>
        </div>
        <div class='detail'>
            <div class='element'>NRP</div>
            <div class='element mini'>:</div>
            <div class='element'><?php echo $detailTA->nrp?></div>
        </div>
        <div class='detail'>
            <div class='element'>NAMA</div>
            <div class='element mini'>:</div>
            <div class='element wide'><?php echo $detailTA->nama_lengkap_mahasiswa?></div>
        </div>
        <div class='detail'>
            <div class='element'>JUDUL TA</div>
            <div class='element mini'>:</div>
            <div class='element wide'><?php echo $detailTA->judul_ta?></div>
        </div>
        <div class='detail'>
            <div class='element'>PEMBIMBING 1</div>
            <div class='element mini'>:</div>
            <div class='element wide'><?php echo $detailTA->pembimbing1?></div>
        </div>
        <div class='detail'>
            <div class='element'>PEMBIMBING 2</div>
            <div class='element mini'>:</div>
            <div class='element wide'><?php echo $detailTA->pembimbing2?></div>
        </div>
        <div class='detail'>
            <div class='element'>KBK</div>
            <div class='element mini'>:</div>
            <div class='element wide'><?php echo $detailTA->nama_kbk?></div>
        </div>
        <div class='detail'>
            <div class='element'>STATUS</div>
            <div class='element mini'>:</div>
            <div class='element wide'><?php echo $this->lib_tugas_akhir->nama_status($detailTA->status); ?></div>
        </div>
        <?php
        if(isset($proposal)) 
        {
        ?>
        <div class='detail'>
            <div class='element'>FILE</div>
            <div class='element mini'>:</div>
            <div class='element wide'>
        <?php 
            $i=1;
            foreach($proposal as $row)
            {
                echo "<a href='".base_url()."assets/files/proposal/".$row->path_file."'>".$i++.". $row->nama_file</a></br>";
            }
        }
        ?>
            </div>
        </div>
        <div class='separator'></div>
        <div class='detail'>
            <div class='element'><h2>Progres Bimbingan</h2></div>
            
            <div class='element wide' >
        <?php
        echo "<div class='separator'></div>";
        $this->load->view("progres/subContent-progresBaru");
        echo "<div class='separator'></div>";
        $this->load->view("progres/bimbinganBaru");
        echo "<div class='separator'></div>";
        echo "<span id='bimbingan'>";
            $this->load->view("progres/bimbingan");
        echo "</span>";
        
        ?>
		
		
		
            </div>
        </div>
        
        
    </div>
</div>
