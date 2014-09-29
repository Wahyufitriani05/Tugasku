<div id="some-content" class="box box-shadow clearfix">
    <div class="alpha omega">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
        <div style="margin: 1em;">
            <?php $this->load->view("jadwalRuang/filter-sidangTA");
            echo "<div class='separator'></div>";
            ?>
        </div>
        <form name='roomAvailability' action='<?php echo site_url("jadwalRuang/updateJadwalRuangan/$id_sidangTA")?>' method='POST'>
        <div style="margin: 1em;">
            <?php
            $this->load->view("jadwalRuang/subContent-updateRuangAvailability");
            echo "<div class='separator'></div>";
            ?>
        </div>
        <?php
        if(!empty($ruangan)) {
            echo "<table id='jadwal_ruangan' class='table1' style='width:96%; margin-top:20px; border:1px solid #aaa;' border='1' cellpadding='2' cellspacing='3'>";
                echo $this->load->view("jadwalRuang/ruangAvailability");
            echo "</table>";
        }
        ?>
        </form>
    </div>
</div>