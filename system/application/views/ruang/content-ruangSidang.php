<div id="some-content" class="box box-shadow grid_13 clearfix">
    <div class="alpha omega">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
        <div style="margin: 1em;font-size: 12px;min-width: 80%">
            <?php
            $this->load->view("ruang/filter-sidangTA");
            $this->load->view("ruang/subContent-entryRuangSidang");
            echo "<div class='separator'></div>";
            $this->load->view("ruang/entryRuangSidang");
            echo "<div class='separator'></div>";
            ?>
        </div>
        <?php
        if(!empty($ruang_sidang)) 
        {
            echo "<span id='ruang_sidang'>";
            echo $this->load->view("ruang/ruangSidang");
            echo "</span>";
        }
        ?>
    </div>
</div>