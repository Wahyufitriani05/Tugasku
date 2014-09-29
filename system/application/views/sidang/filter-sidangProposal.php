<form id="filter-form" method="post" style="display: inline;float: left;padding: 0 1em 0 0;" action="<?php echo site_url('sidang/sidangProposal')?>">
    Filter
    <select onchange="document.forms['filter-form'].submit();" name="filter_kbk" style="min-width: 150px; height: 20px;">
        <option value=""> - Pilih KBK - </option>
        <?php
        foreach ($kbk as $row_k) {
            if($row_k->ID_KBK == $this->session->userdata('filter_kbk'))
                $tanda = " selected ";
            else
                $tanda = " ";
            echo "<option $tanda value='".$row_k->ID_KBK."'>".$row_k->NAMA_KBK."</option>";
        }
        
        if("3" == $this->session->userdata('filter_kbk'))
                $tanda = " selected ";
            else
                $tanda = " ";
        echo "<option $tanda value='3'>RPL</option>";
        ?>
    </select>

    <select onchange="document.forms['filter-form'].submit();" name="sid_prop" style="min-width: 150px; height: 20px;">
        <option value=""> - Pilih Sidang Proposal - </option>
        <?php
        if(isset ($current_sid_prop)) {
            foreach ($sid_prop as $row_sp) {
                if($row_sp->ID_SIDANG_PROP == $current_sid_prop)
                    $tanda = " selected ";
                else
                    $tanda = " ";
                echo "<option $tanda value='".$row_sp->ID_SIDANG_PROP."'>".$row_sp->WAKTU."</option>";
            }
        }
        ?>
    </select>
    <?php
    if(isset ($current_sid_prop)) {
        echo "<input type='hidden' name='current_sid_prop' value='$current_sid_prop' >";
    }
    ?>
</form>
