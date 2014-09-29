<div style="display: none;" id="entry_Wisuda">  
    <?php echo $this->pquery->form_remote_tag(array('url'=>site_url("wisuda/entryWisuda"),'type'=>'POST','dataType'=>'script','update'=>'#wisuda'));?>
        <div class='detail'>
            <div class='element'><b>Keterangan</b></div>
            <div class='element mini'>:</div>
            <div class='element wide'><input class='input' type='text' id='keterangan' name='keterangan'/></div>
        </div>
        <div class='detail'>
            <div class='element'>&nbsp;</div>
            <div class='element wide' style='margin:1em; text-align:right'>
                <input type='hidden' name='shasa7s67as'/>
                <input type='submit' value='Simpan' style='width: 150px' onclick='self.parent.tb_remove()'/>
                <input type='button' value='Batal'  style='width: 150px' onclick='self.parent.tb_remove()'/>
            </div>
        </div>
    </form>
</div>