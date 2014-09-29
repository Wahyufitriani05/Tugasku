<script type='text/javascript' src='<?php echo base_url()?>assets/jquery/ui/jquery.ui.datepicker.js'></script>
<script type='text/javascript' src='<?php echo base_url()?>assets/jquery/ui/jquery-ui-timepicker-addon.js'></script>

<?php
echo "<div style='margin: 1em;'>";
    $this->load->view("slot/subContent-entrySlotWaktu");
    echo "<div class='separator'></div>";
    $this->load->view("slot/entrySlotWaktu");
    echo "<div class='separator'></div>";
    echo "<div class='separator'></div>";
echo "</div>";
echo "<span id='slot_waktu'>";
if(!empty($slot_waktu)) {
    echo $this->load->view("slot/slotWaktu");
}
echo "</span>";
?>
