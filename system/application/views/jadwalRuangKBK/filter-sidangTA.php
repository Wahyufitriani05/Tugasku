<?php echo "<form id='filter-form' method='post' style='display: inline;float: left;padding: 0 1em 0 0;' action='".site_url(''.$this->uri->uri_string())."'>";?>
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
<?php echo "<form id='filter-form2b' method='post' style='display: inline;float: left;padding: 0 1em 0 0;' action='".site_url(''.$this->uri->uri_string())."'>";?>
    <div class='detail' style="width:500px;">
        <div class='element'>Ruangan</div>
        <div class='element mini'>:</div>
        <div class='element'>
            <select onchange="document.forms['filter-form2b'].submit();" name="ruangSidangTA" style="min-width: 150px; height: 20px;">
                <option value=""> - Pilih Sidang TA - </option>
                <?php
                foreach ($listRuangan as $row_ruangan) {
                    if($row_ruangan->ID_JDW_RUANG == $filterRuangan)
                        $tanda = " selected ";
                    else
                        $tanda = " ";
                    echo "<option $tanda value='".$row_ruangan->ID_JDW_RUANG."'>".$row_ruangan->DESKRIPSI."</option>";
                }
                ?>
            </select>
        </div>
    </div>
</form>