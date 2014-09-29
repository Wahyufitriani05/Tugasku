<form id="filter-form" method="post" style="display: inline;float: left;padding: 0 1em 0 0;" action="<?php echo site_url('ruang/ruangSidang')?>">
    Semester
    <select onchange="document.forms['filter-form'].submit();" name="sidangTA" style="min-width: 150px; height: 20px;">
       <option value=""> - Pilih Sidang TA - </option>
        <?php
        if(isset ($id_sidangTA)) {
            foreach ($list_sidangTA as $row_sidTA) {
                if($row_sidTA->ID_SIDANG_TA == $id_sidangTA)
                    $tanda = " selected ";
                else
                    $tanda = " ";
                echo "<option $tanda value='".$row_sidTA->ID_SIDANG_TA."'>$row_sidTA->SEMESTER_SIDANG_TA $row_sidTA->TAHUN_SIDANG_TA </option>";
            }
        }
        ?>
    </select>
</form>
