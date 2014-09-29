<?php
echo "<script type='text/javascript'>
    $(function() {
        $( '#waktu' ).timepicker({
            hourMin: 7,
            hourMax: 19,
            stepMinute: 5
        });
    });
</script>";
?>
<div style="display: none;" id="entry_slotWaktu">  
    <?php echo $this->pquery->form_remote_tag(array('url'=>site_url("slot/entrySlotWaktu/$id_sidangTA/$parent_treeid"),'type'=>'POST','dataType'=>'script','update'=>'#slot_waktu'));?>
        <div class='detail'>
            <div class='element'><b>Waktu</b></div>
            <div class='element mini'>:</div>
            <div class='element wide'><input class='input small' type='text' id='waktu' name='waktu'/></div>
        </div>
        <div class='detail'>
            <div class='element'>&nbsp;</div>
            <div class='element wide' style='margin:1em; text-align:right'>
                <input type='hidden' name='adsdgfg45354'/>
                <?php echo $this->pquery->link_to_function("<input type='button' value='Batal'  style='width: 150px'/>",$this->pquery->visual_effect("slideToggle","#entry_slotWaktu"));?>
                <input type='submit' value='Simpan' style='width: 150px'/>
            </div>
        </div>
    </form>
</div>