<div id="some-content" class="box box-shadow clearfix">
    <div class="alpha omega">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
        <?php
        echo "<span id='sidang_TA'>";
            echo $this->load->view("sidang/jadwalSidangTA");
        echo "</span>";
        ?>
    </div>
</div>