<?php echo "<form id='filter-form' method='post' style='display: inline;float: left;padding: 0 1em 0 0;' action='".site_url('jadwalMahasiswa/'.$this->uri->segment(2))."'>";?>
    <div class='detail' style="width:120px; float: left">
        <div class='element'>
            <select onchange="document.forms['filter-form'].submit();" name="kbk" style="min-width: 150px; height: 20px;">
                <option value="-1"> - Semua KBK - </option>
                <?php
                foreach ($kbk as $row_k) {
                    if($row_k->ID_KBK == $this->session->userdata('kbk') && $this->session->userdata('kbk') != '')
                        $tanda = " selected ";
                    else
                        $tanda = " ";
                    echo "<option $tanda value='".$row_k->ID_KBK."'>".$row_k->NAMA_KBK."</option>";
                }
                ?>
            </select>
        </div>
    </div>
</form>
