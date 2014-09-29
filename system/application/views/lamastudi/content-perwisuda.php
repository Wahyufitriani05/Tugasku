<div id="some-content" class="box box-shadow clearfix">
    <div class="alpha omega">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
        <div style="margin: 1em; float: right">
            <?php $this->load->view("lamastudi/filter-periode"); ?>
        </div>
        <?php
        if(! empty($list_ta))
            $this->load->view("lamastudi/perwisuda");
        ?>
    </div>
</div>