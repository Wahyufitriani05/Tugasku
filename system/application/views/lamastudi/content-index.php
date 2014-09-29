<div id="some-content" class="box box-shadow clearfix">
    <div class="alpha omega">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
        <?php
        if(! empty($list_ta))
            $this->load->view("lamastudi/index");
        ?>
    </div>
</div>