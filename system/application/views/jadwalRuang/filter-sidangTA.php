<?php echo "<form id='filter-form' method='post' style='display: inline;float: left;padding: 0 1em 0 0;' action='".site_url('jadwalRuang/'.$this->uri->segment(2))."'>";?>
    <div class='detail' style="width:500px;">
        <div class='element'>Sidang TA</div>
        <div class='element mini'>:</div>
        <div class='element'>
            <select onchange="document.forms['filter-form'].submit();" name="sidangTA" style="min-width: 150px; height: 20px;">
                <option value=""> - Pilih Sidang TA - </option>
                <?php
                foreach ($list_sidangTA as $row_sidTA) {
                    if($row_sidTA->ID_SIDANG_TA == $id_sidangTA)
                        $tanda = " selected ";
                    else
                        $tanda = " ";
                    echo "<option $tanda value='".$row_sidTA->ID_SIDANG_TA."'>".$row_sidTA->KET_SIDANG_TA."</option>";
                }
                ?>
            </select>
        </div>
    </div>
</form>