<?php echo "<form id='filter-form' method='post' style='display: inline;float: left;padding: 0 1em 0 0;' action='".site_url('jadwalMahasiswa/'.$this->uri->segment(2))."'>";?>
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
    <?php $ci =&get_instance();
    $ci->load->library('lib_user');
   
    if($ci->lib_user->is_admin()) : ?>
    <div class='detail' style="width:500px; margin-bottom: 15px;">
        <div class='element'>RMK</div>
        <div class='element mini'>:</div>
        <div class='element'>
            <select onchange="document.forms['filter-form'].submit();" name="RMK" style="min-width: 150px; height: 20px;">
                <option value=""> - Semua RMK - </option>
                <?php
                foreach ($list_kbk as $row) {
                    if($row->ID_KBK == $id_kbk)
                        $tanda = " selected ";
                    else
                        $tanda = " ";
                    echo "<option $tanda value='".$row->ID_KBK."'>".$row->NAMA_KBK."</option>";
                }
                ?>
            </select>
        </div>
    </div>
    
    <?php endif; ?>
</form>