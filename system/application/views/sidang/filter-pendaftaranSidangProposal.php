<form id="filter-form" method="post" style="display: inline;float: left;padding: 0 1em 0 0; margin-bottom: 10px" action="<?php echo site_url('sidang/pendaftaranSidangProposal')?>">
    Filter
    <select onchange="document.forms['filter-form'].submit();" name="filter_kbk" style="min-width: 150px; height: 20px;">
        <option value=""> - Pilih KBK - </option>
        <?php
        //print_r($kbk); die;
        foreach ($kbk as $row_k) {
            if($row_k->ID_KBK == $this->session->userdata('filter_kbk'))
                $tanda = " selected ";
            else
                $tanda = " ";
            echo "<option $tanda value='".$row_k->ID_KBK."'>".$row_k->NAMA_KBK."</option>";
        }
        ?>
    </select>
</form>
