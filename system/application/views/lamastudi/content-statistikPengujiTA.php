<div id="some-content" class="box box-shadow clearfix">
    <div class="alpha omega">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
        
        <div style="margin:1em;">
            <?php $this->load->view("lamastudi/filter-statistikPengujiTA"); ?>
        </div>
        <?php
        if(! empty($pengujiTA))
            $this->load->view("lamastudi/statistikPengujiTA");
        else
        	echo "<div style='clear: both; padding-left: 10px'>Tidak ada statistik</div>";
        ?>
    </div>
</div>