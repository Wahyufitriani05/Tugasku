<div id="some-content" class="box box-shadow clearfix">
    <div class="alpha omega">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
        <div style="margin: 1em;">
            <?php $this->load->view("jadwalDosen/filter-dosenAvailability");
            echo "<div class='separator'></div>";
            ?>
        </div>
        <form name='dosenAvailability' action='<?php echo site_url("jadwalDosen/updateJadwalDosen/$id_sidangTA/$parent_treeid")?>' method='POST'>
        <div style="margin: 1em;">
            <?php
            $this->load->view("jadwalDosen/subContent-updateDosenAvailability");
            echo "<div class='separator'></div>";
            ?>
        </div>
        <?php
        if(!empty($slot_waktu)) {
            //echo "<div id='scrollwide'>";
            echo "<table id='slot_jadwal' class='table1' style='width:96%; margin-top:20px; border:1px solid #aaa;' border='1' cellpadding='2' cellspacing='3'>";
                echo $this->load->view("jadwalDosen/dosenAvailability");
            echo "</table>";
            //echo "</div>";
        }
        ?>
        </form>
    </div>
</div>