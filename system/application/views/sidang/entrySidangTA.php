<div style="display: none;" id="entry_sidangTA">  
    <?php echo $this->pquery->form_remote_tag(array('url'=>site_url("sidang/entrySidangTA"),'type'=>'POST','dataType'=>'script','update'=>'#sidang_TA'));?>
        <div class='detail'>
            <div class='element'><b>Semester</b></div>
            <div class='element mini'>:</div>
            <div class='element wide'>
                <!--
                <select name='semester' class='input'>
                    <option value="">- pilih semester - </option>
                    <option value="Ganjil">Ganjil </option>
                    <option value="Genap">Genap </option>
                </select>
                -->
                <?php echo $semester;?>
                <input type="hidden" name="semester" value="<?php echo $semester?>" />
            </div>
        </div>
        <div class='detail'>
            <div class='element'><b>Tahun Ajaran</b></div>
            <div class='element mini'>:</div>
            <div class='element wide'>
                <?php echo $tahun_ajaran;?>
                <input type="hidden" name="tahunajaran" value="<?php echo $tahun_ajaran?>" />
            </div>
        </div>
        <div class='detail'>
            <div class='element'><b>Keterangan</b></div>
            <div class='element mini'>:</div>
            <div class='element wide'><input class='input' type='text' id='keterangan' name='keterangan'/></div>
        </div>
        <div class='detail'>
            <div class='element'>&nbsp;</div>
            <div class='element wide' style='margin:1em; text-align:right'>
                <input type='hidden' name='as76131jah'/>
                <input type='submit' value='Simpan' style='width: 150px' onclick='self.parent.tb_remove()'/>
                <input type='button' value='Batal'  style='width: 150px' onclick='self.parent.tb_remove()'/>
            </div>
        </div>
    </form>
</div>