<?php
// Thickbox
echo $this->lib_js->thickbox(); 

?>
<div id="some-content" class="box box-shadow clearfix">
    <div class="alpha omega">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
        <div style="margin:1em;">
            <?php $this->load->view("sidang/filter-pendaftaranSidangTA"); ?>
        </div>
        <?php
        if(isset ($listTA)) {
            $this->load->view("sidang/pendaftaranSidangTA");
        }
        ?>
        
    </div>
</div>