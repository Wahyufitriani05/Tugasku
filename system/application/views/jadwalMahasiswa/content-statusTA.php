<div id="some-content" class="box box-shadow clearfix">
    <div class="alpha omega">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
        <div style="margin: 1em;">
            <?php $this->load->view("jadwalMahasiswa/filter-statusTA");?>
        </div>
        <form name='majuSidang' action='<?php echo site_url("jadwalMahasiswa/updateStatusTA")?>' method='POST'>
        <div style="margin: 1em;">
            <?php
            $this->load->view("jadwalMahasiswa/subContent-updateStatusTA");
            echo "<div class='separator'></div>";
            ?>
        </div>
        <style>
        #scrollwide {
        height: 400px;
        overflow: auto;
        width: 1150px;
        white-space: nowrap;
        }
        </style>
        <?php
        if(!empty($list_proposal)) {
            echo "<div id='scrollwide'>";
            echo "<table id='majuSidang' class='table1' style='width:96%; margin-top:20px; border:1px solid #aaa;' border='1' cellpadding='2' cellspacing='3'>";
                echo $this->load->view("jadwalMahasiswa/statusTA");
            echo "</table>";
            echo "</div>";
        }
        ?>
        </form>
    </div>
</div>