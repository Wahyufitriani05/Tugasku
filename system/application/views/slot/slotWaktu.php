<script type="text/javascript">
function toggleCheckboxes(chkbx) {
// written by Daniel P 3/21/07
// toggle all checkboxes found on the page
    var inputlist = document.getElementsByTagName("input");
    var nilai;
    if (chkbx.checked) {
        nilai = true;
        chkbx.checked = true;
    } else {
        nilai = false;
        chkbx.checked = false;
    }
    for (i = 0; i < inputlist.length; i++) {
        if ( inputlist[i].getAttribute("type") == 'checkbox' ) {	// look only at input elements that are checkboxes
            inputlist[i].checked = nilai;
        }
    }
}
</script>
<div id="message" style="margin: 1em;">
<?php
    if($this->session->flashdata('alert'))
        echo $this->session->flashdata('alert');
    echo validation_errors();
?>
</div>
<?php
echo $this->pquery->form_remote_tag(array('url'=>site_url("slot/hapusSlotWaktu"),'type'=>'POST','dataType'=>'script','update'=>'#slot_waktu','beforeSend'=>'return confirm("Anda yakin untuk menghapus?")'));
echo "<table class='table1' style='width:96%; margin-top:20px; border:1px solid #aaa;' border='1' cellpadding='2' cellspacing='3'>";
    if(!empty($total_page))
        echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";
    echo "<tr>";
    echo "<th width=50>TREE ID</th>";
    echo "<th width=120>WAKTU</th>";
    echo "<th>DESKRIPSI</th>";
    echo "<th class='center'><input type='checkbox' onclick='javascript:toggleCheckboxes(this)'/></th>";
    echo "</tr>";

    $i=1;
    foreach ($slot_waktu as $row) {
        $arr_waktu = explode(":", $row->WAKTU, 3);
        if(count($arr_waktu) == 3) {
            echo "<script type='text/javascript'>
            $(function() {
                $( '#waktu_$i' ).timepicker({
                    hourMin: 7,
                    hourMax: 19,
                    stepMinute: 5,
                    hour: $arr_waktu[0],
                    minute: $arr_waktu[1]
                });
            });
            </script>";
        } else {
            echo "<script type='text/javascript'>
            $(function() {
                $( '#waktu_$i' ).timepicker({
                    hourMin: 7,
                    hourMax: 19,
                    stepMinute: 5
                });
            });
            </script>";
        }
        echo "<script type='text/javascript'>
            $(document).ready(function() {";
                echo $this->pquery->observe_field("#waktu_$i",array('event'=>'change','function'=>$this->pquery->remote_function(array(
                    'url'=>site_url('slot/updateSlotWaktu/'.$row->ID_SLOT.'/"+$("#waktu_'.$i.'").val()+"'),
                    'update'=>"#deskripsi_$i"
                ))));
        echo "});
        </script>";
        
        if($i%2==0)
            $class_row = 'rowA';
        else
            $class_row = 'rowB';
        echo "<tr class='$class_row'>";
        echo "<td class='center'>";
        if(isset ($id_new_slot) && $id_new_slot == $row->ID_SLOT) {
            echo "<img src='".base_url()."assets/images/new.png'>";
            unset ($id_new_slot);
        } else {
            echo $row->TREEID;
        }
        echo "</td>";
        echo "<td class='center'><input class='in_table' type='text' id='waktu_$i' value='$row->WAKTU'></td>";
        echo "<td class='center' id='deskripsi_$i'>$row->DESKRIPSI</td>";
        echo "<td class='center'>";
            echo "<input type='checkbox' id='slot_$i' name='SLOTWAKTU_".$row->SIDANGTA."_".$row->TREEID."_".$row->ID_SLOT."' />";
            //echo $this->pquery->link_to_remote("<img title='hapus' alt='hapus' src='".base_url()."assets/images/delete-icon.jpg'>",array('url'=>site_url("penjadwalan/hapusSlotWaktu/$row->SIDANGTA/$row->TREEID/$row->ID_SLOT"), 'update'=>"#slot_waktu", 'beforeSend'=>'return confirm("Anda yakin untuk menghapus?")'));
        echo "</td>";
        echo "</tr>";
        $i++;
    }
    if(!empty($total_page))
        echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";
echo "</table>";
echo "<input type='hidden' name='jre932jsdks'/>";
echo "<div style='margin: 1em;text-align:right;'>";
    echo "<input type='submit' value='delete'/>";
echo "</div>";
echo "</form>";
?>