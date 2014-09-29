<div id="some-content" class="box box-shadow clearfix">
    <div class="alpha omega">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
        <div style="margin: 1em;">
            <?php $this->load->view("jadwalRuangKBK/filter-sidangTA");
            echo "<div class='separator'></div>";
            ?>
        </div>
        <form name='ruangKBK_assignment' action='<?php echo site_url("jadwalRuangKBK/updateRuangKBKAssignment/$id_sidangTA")?>' method='POST'>
        <div style="margin: 1em;">
            <?php
            $this->load->view("jadwalRuangKBK/subContent-updateRuangKBKAssignment");
            echo "<div class='separator'></div>";
            ?>
        </div>
        <?php
        if(!empty($ruangan)) {
            echo "<table id='ruangKBK_assignment' class='table1' style='width:96%; margin-top:20px; border:1px solid #aaa;' border='1' cellpadding='2' cellspacing='3'>";
                echo $this->load->view("jadwalRuangKBK/ruangKBKAssignment");
            echo "</table>";
        }
        ?>
        </form>
    </div>
</div>