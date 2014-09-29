<?php
echo "<script type='text/javascript'>
    $(function() {
        $( '#waktu' ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
    });
    </script>";
?>
<div style="display: none;" id="entry_sidangproposal">  
    <?php echo $this->pquery->form_remote_tag(array('url'=>site_url("sidang/entrySidangProposal"),'type'=>'POST','dataType'=>'script','update'=>'#sidang_proposal'));?>
        <div class='detail'>
            <div class='element'><b>Waktu</b></div>
            <div class='element mini'>:</div>
            <div class='element wide'><input class='input small' type='text' id='waktu' name='waktu' value="<?php echo date("Y-m-d")?>"/></div>
        </div>
        <div class='detail'>
            <div class='element'><b>Keterangan</b></div>
            <div class='element mini'>:</div>
            <div class='element wide'><input class='input' type='text' id='keterangan' name='keterangan'/></div>
        </div>
        <div class='detail'>
            <div class='element'>&nbsp;</div>
            <div class='element wide' style='margin:1em; text-align:right'>
                <input type='button' value='Batal'  style='width: 150px' onclick='self.parent.tb_remove()'/>
                <input type='submit' value='Simpan' style='width: 150px' onclick='self.parent.tb_remove()'/>
            </div>
        </div>
    </form>
</div>