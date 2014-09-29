<div id="some-content" class="box box-shadow clearfix">
    <div class="alpha omega">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
        <div style="margin: 1em;">
            <?php
            $this->load->view("wisuda/subContent-entryWisuda");
            echo "<div class='separator'></div>";
            $this->load->view("wisuda/entryWisuda");
            echo "<div class='separator'></div>";
            ?>
        </div>
        <?php
        if(!empty($wisuda)) {
            echo "<span id='wisuda'>";
            echo $this->load->view("wisuda/jadwalWisuda");
            echo "</span>";
        }
        ?>
    </div>
</div>