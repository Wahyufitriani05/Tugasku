<div>
    <div class='detail'>
        <div class='element'><b>NRP / Nama Mahasiswa</b></div>
        <div class='element mini'>:</div>
        <div class='element wide'><?php echo $detailTA->nrp." / ".$detailTA->nama_lengkap_mahasiswa;?></div>
    </div>
    <div class='detail'>
        <div class='element'><b>ID Proposal</b></div>
        <div class='element mini'>:</div>
        <div class='element wide'><?php echo $detailTA->id_proposal;?></div>
    </div>
    <div class='detail'>
        <div class='element'><b>Judul Tugas Akhir</b></div>
        <div class='element mini'>:</div>
        <div class='element wide'><?php echo $detailTA->judul_ta;?></div>
    </div>
    <div class='detail'>
        <div class='element'><b>Pembimbing 1</b></div>
        <div class='element mini'>:</div>
        <div class='element wide'><?php echo $detailTA->pembimbing1;?></div>
    </div>
    <div class='detail'>
        <div class='element'><b>Pembimbing 2</b></div>
        <div class='element mini'>:</div>
        <div class='element wide'><?php echo $detailTA->pembimbing2;?></div>
    </div>
    <div class='detail'>
        <div class='element'><b>Status</b></div>
        <div class='element mini'>:</div>
        <div class='element wide'><?php echo $this->lib_tugas_akhir->nama_status($detailTA->status);?></div>
    </div>
    <div class='detail'>
        <div class='element'><b>Abstraksi</b></div>
        <div class='element mini'>:</div>
        <div class='element wide'><?php echo $detailTA->abstraksi;?></div>
    </div>
    <?php
    if(isset($proposal) && ($this->lib_user->is_dosen() == TRUE || $this->lib_user->is_admin() == TRUE || $this->lib_user->is_admin_kbk() == TRUE)) 
    {
    ?>
    <div class='detail'>
        <div class='element'><b>Berkas proposal</b></div>
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
    <br><br><br>
    <?php 
    if($this->session->userdata('type')=='admin' || $this->lib_user->is_admin_kbk() == TRUE) 
    { 
    ?>
    <a href='<?php echo site_url("proposal/ubahProposal/$detailTA->id_proposal/$detailTA->nrp")?>'><input type='button' value='Edit Proposal'  style='width: 150px'/></a>
    <?php 
    } 
    ?>
</div>