<link rel='stylesheet' href='http://localhost/tugasku/assets/themes/bento/css/style.fluid.css' type='text/css' media='screen' /><link rel='stylesheet' href='http://localhost/tugasku/assets/skins/common/shared.css?207' type='text/css' media='screen' /><link rel='stylesheet' href='http://localhost/tugasku/assets/skins/common/commonPrint.css?207' type='text/css' media='print' /><link rel='stylesheet' href='http://localhost/tugasku/assets/extensions/FlaggedRevs/flaggedrevs.css' type='text/css' /><link rel='stylesheet' href='http://localhost/tugasku/assets/skins/bento/css_local/style.css' type='text/css' media='screen' />
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
<div id="entry_sidangproposal">  
    <?php echo $this->pquery->form_remote_tag(array('url'=>site_url("sidang/updateRevisiProposal"),'type'=>'POST','dataType'=>'script','update'=>'#sidang_proposal'));?>
        <div class='detail'>
        <input type="hidden" name="id_proposal" value="<?php echo $id_proposal; ?>">
            <div class='element wide'><textarea class='input' rows='8' type='text' id='revisi' name='revisi' style="margin: 20px auto 0px; width: 90%; box-sizing: content-box; display: block;"><?php echo $revisi; ?></textarea></div>
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