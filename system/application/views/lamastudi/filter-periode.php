<form id="filter-form" action="<?php echo site_url("lamastudi/".$this->uri->segment(2))?>" method="post" style="display: inline;float: left;padding: 0 1em 0 0;">
    Filter
    <select onchange="document.forms['filter-form'].submit();" name="periodewisuda" style="min-width: 150px; height: 20px;">
        <option value="-1"> - Semua Periode - </option>
        <?php
        foreach ($periode as $row) {
            if($row->ID_PERIODE_LULUS == $this->session->userdata('periode') && $this->session->userdata('periode') != '')
                $tanda = " selected ";
            else
                $tanda = " ";
            echo "<option $tanda value='".$row->ID_PERIODE_LULUS."'>".$row->NAMA_PERIODE."</option>";
        }
        ?>
    </select>
</form>

