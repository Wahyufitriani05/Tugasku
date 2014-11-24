<div id="some-content" class="box box-shadow clearfix">
    <div class="alpha omega">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
        <?php
        if(! empty($mahasiswaTA))
            $this->load->view("lamastudi/statistikTA");
        ?>
    </div>
</div>