</br>
<div id="some-content" class="box box-shadow clearfix">
    <div class="alpha omega">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
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
        <?php if ($this->lib_tugas_akhir->nama_status($detailTA->status) == "Revisi") { ?>
        <div class='detail'>
            <div class='element'>DETAIL REVISI</div>
            <div class='element mini'>:</div>
            <div class='element wide'><?php echo $detailTA->revisi_proposal?></div>
        </div>
        <?php } ?>
        <div class='detail'>
            <div class='element'>TGL SIDANG PROPOSAL</div>
            <div class='element mini'>:</div>
            <div class='element wide'><?php echo substr($detailTA->tgl_sidang_ta,0,10); ?></div>
        </div>
        <div class='detail'>
            <div class='element'>TGL SIDANG TA</div>
            <div class='element mini'>:</div>
            <div class='element wide'>
            <?php
            if($detailTA->tgl_sidang_ta_asli=='0000-00-00')
                echo $detailTA->tanggal_yudisium;
            else
                echo $detailTA->tgl_sidang_ta_asli;
            ?></div>
        </div>
        <div class='detail'>
            <div class='element'>LAMA PENGERJAAN TA</div>
            <div class='element mini'>:</div>
            <div class='element wide'>
            <?php 
            if($detailTA->tgl_sidang_ta_asli=='0000-00-00')
            {
                $lamastudi = explode(".",$detailTA->lama_yudisium);
            }
            else
            {
                $lamastudi = explode(".",$detailTA->lama_sidang);
            }
            if(is_null($detailTA->tanggal_yudisium))
            {
                echo "";
            }
            else
            {
                echo $lamastudi[0].".".substr($lamastudi[1],0,2)." bulan";
            }
            ?></div>
        </div>
        <?php
        if(isset($proposal)) 
        {
        ?>
        <div class='detail'>
            <div class='element'><b>FILE</b></div>
            <div class='element mini'>:</div>
            <div class='element wide'>&nbsp;</div>
        </div>
        <span style='clear:both;'></span>
        <?php 
            $i=1;
            foreach($proposal as $row)
            {
                echo "<a style='padding-left:200px;' href='".base_url()."assets/files/proposal/".$row->path_file."'>".$i++.". $row->nama_file</a></br>";
            }
        }
        ?>
    </div>
</div>
