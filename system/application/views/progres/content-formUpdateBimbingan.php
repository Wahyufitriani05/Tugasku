<?php
$waktu_bimbingan = $detail_bimbingan->TGL_PROGRESS;
$tgl_bimbingan = explode(" ", $waktu_bimbingan);
$jam_bimbingan = explode(":", $tgl_bimbingan[1]);
echo "<script type='text/javascript'>
    $(function() {
        $( '#tgl_updateProgres' ).datetimepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
    });
</script>";
?>
<div>
    <div id="message" style="margin: 1em;">
        <?php echo validation_errors();?>
    </div>
    <form method="post" action="<?php echo site_url("progres/updateBimbingan/$detail_bimbingan->ID_PROPOSAL/$detail_bimbingan->ID_PROGRESS")?>">
        <div class='detail'>
            <div class='element'><b>Tanggal Bimbingan</b></div>
            <div class='element mini'>:</div>
            <div class='element wide'><input class='input small' type='text' id='tgl_updateProgres' name='tgl_updateProgres' value='<?php echo $tgl_bimbingan[0].' '.$jam_bimbingan[0].':'.$jam_bimbingan[1]; ?>'/></div>
        </div>
        <?php if($this->lib_user->is_dosen() == true && isset($nama_dosen)) { ?>
            <div class='detail'>
                <div class='element'><b>Dosen Pembimbing</b></div>
                <div class='element mini'>:</div>
                <div class='element wide'><?php echo $this->session->userdata('nip')." - ".$nama_dosen;?></div>
            </div>
        <?php } ?>        
        <div class='detail'>
            <div class='element'><b>Topik Bimbingan</b></div>
            <div class='element mini'>:</div>
            <div class='element wide'><textarea class='textarea medium' name='editor1' id='editor1' cols='50'><?php echo $detail_bimbingan->ISI_PROGRESS?></textarea> </div>
        </div>
        
        <?php if($this->lib_user->is_dosen() == true && isset($nama_dosen)) { ?>
        <div class='detail'>
            <div class='element' style="margin-top:10px;"><b>Komentar</b></div>
            <div class='element mini' style="margin-top:10px;">:</div>
            <div class='element wide' style="margin-top:10px;"><textarea class='textarea medium' name='komentar1' id='komentar1' cols='50' ><?php echo $detail_bimbingan->ISI_KOMENTAR?></textarea> </div>
        </div>
        <?php }?>

        <div class='detail'>
            <div class='element'>&nbsp;</div>
            <div class='element wide' style='margin:1em; text-align:right'>
            <input type='hidden' name='isa2i2ew8id'/>
            <input type="button" value="Batal" style='width: 150px' onclick="self.parent.tb_remove()"/>
            <?php if($this->lib_user->is_mahasiswa()) { ?>
                <input type='submit' value='Simpan' style='width: 150px'/>
            <?php } else { ?>
                <input type='submit' value='Approve' style='width: 150px'/>
            <?php } ?>
            </div>
        </div>
    </form>
</div>
        