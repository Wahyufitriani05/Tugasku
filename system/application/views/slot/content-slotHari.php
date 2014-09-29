<script type='text/javascript' src='<?php echo base_url()?>assets/jquery/ui/jquery.ui.datepicker.js'></script>
<script type='text/javascript' src='<?php echo base_url()?>assets/jquery/ui/jquery-ui-timepicker-addon.js'></script>

<div id="some-content" class="box box-shadow clearfix">
    <div class="alpha omega">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
        <div style="margin: 1em;">
            <?php
            $this->load->view("slot/filter-sidangTA");
            $this->load->view("slot/subContent-entrySlotHari");
            echo "<div class='separator'></div>";
            $this->load->view("slot/entrySlotHari");
            echo "<div class='separator'></div>";
            ?>
        </div>
        <?php
        echo "<span id='slot_hari'>";
        if(!empty($slot_hari)) {
            echo $this->load->view("slot/slotHari");
        }
        echo "</span>";
        ?>
    </div>
</div>