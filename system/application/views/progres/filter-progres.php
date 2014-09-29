<form id="filter-form" action="<?php echo site_url($url_filter)?>" method="post" style="display: inline;float: left;padding: 0 1em 0 0;">
    <strong>FILTER</strong>&nbsp;
    <select onchange="document.forms['filter-form'].submit();" name="filter_kbk" style="min-width: 150px; height: 20px;">
        <option value="-1"> - Semua KBK - </option>
        <?php
        foreach ($list_kbk as $row_k) {
            if($row_k->ID_KBK == $this->session->userdata('filter_kbk') && $this->session->userdata('filter_kbk') != '')
                $tanda = " selected ";
            else
                $tanda = " ";
            echo "<option $tanda value='".$row_k->ID_KBK."'>".$row_k->NAMA_KBK."</option>";
        }
        ?>
    </select>
    <select onchange="document.forms['filter-form'].submit();" name="filter_status" style="min-width: 150px; height: 20px;">
        <option value="-1"> - Semua Status - </option>
        <?php
        foreach ($list_status as $row_s) {
            if($row_s['id']==$this->session->userdata('filter_status') && $this->session->userdata('filter_status') != '')
                $tanda = " selected ";
            else
                $tanda = " ";
            echo "<option $tanda value='".$row_s['id']."'>".$row_s['nama']."</option>";
        }
        ?>
    </select>
    <select onchange="document.forms['filter-form'].submit();" name="filter_dosen" style="min-width: 150px; height: 20px;">
        <option value="-1"> - Semua Dosen Pembimbing - </option>
        <?php
        foreach ($list_dosen as $row_d) {
            if($row_d->NIP==$this->session->userdata('filter_dosen') && $this->session->userdata('filter_dosen') != '')
                $tanda = " selected ";
            else
                $tanda = " ";
            echo "<option $tanda value='".$row_d->NIP."'>".$row_d->NAMA_DOSEN."</option>";
        }
        ?>
    </select>
</form>

