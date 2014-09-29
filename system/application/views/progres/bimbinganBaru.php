<?php
$tgl_skrg = date("Y-m-d");
$waktu_skrg = date("H:i:s");
$arr_waktu = explode(":", $waktu_skrg);
echo "<script type='text/javascript'>
    $(function() {
        $( '#tgl_progres' ).datetimepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            hour: $arr_waktu[0],
            minute: $arr_waktu[1]
        });
    });
</script>";
?>
<div style="display: none;" id="bimbingan_baru">
    <form action='<?php echo site_url("progres/bimbinganBaru/$detailTA->id_proposal");?>' method='POST'>
        <div class='detail'>
            <div class='element'><b>Tanggal Bimbingan</b></div>
            <div class='element mini'>:</div>
            <div class='element wide'><input class='input small' type='text' id='tgl_progres' name='tgl_progres' value='<?php echo $tgl_skrg.' '.$arr_waktu[0].':'.$arr_waktu[1]?>'/></div>
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
            <div class='element wide'><textarea class='textarea medium' name='editor1' id='editor1' cols='50'></textarea> </div>
        </div>
        <div class='detail'>
            <div class='element'>&nbsp;</div>
            <div class='element wide' style='margin:1em; text-align:right'>
            <input type='hidden' name='isa2i2ew8id'/>
            <input type='button' value='Batal'  style='width: 150px' onclick='self.parent.tb_remove()'/>
            <input type='submit' value='Simpan' style='width: 150px' onclick='self.parent.tb_remove()'/>
            </div>
        </div>
    </form>
</div>