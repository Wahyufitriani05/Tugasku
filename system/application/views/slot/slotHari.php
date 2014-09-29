<div id="message" style="margin: 1em;">
<?php
    if($this->session->flashdata('alert'))
        echo $this->session->flashdata('alert');
    echo validation_errors();
?>
</div>
<?php
echo "<table class='table1' style='width:96%; margin-top:20px; border:1px solid #aaa;' border='1' cellpadding='2' cellspacing='3'>";
    if(!empty($total_page))
        echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";
    echo "<tr>";
    echo "<th width=90>TREE ID</th>";
    echo "<th width=120>TANGGAL</th>";
    echo "<th>DESKRIPSI</th>";
    echo "<th width=120>SLOT WAKTU</th>";
    echo "<th width=90>DELETE</th>";
    echo "</tr>";

    $i=1;
    foreach ($slot_hari as $row) {
        echo "<script type='text/javascript'>
        $(function() {
            $( '#tgl_$i' ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
        });
        </script>";

        echo "<script type='text/javascript'>
            $(document).ready(function() {";
                echo $this->pquery->observe_field("#tgl_$i",array('event'=>'change','function'=>$this->pquery->remote_function(array(
                    'url'=>site_url('slot/updateTanggalSlotHari/'.$row->ID_SLOT.'/"+$("#tgl_'.$i.'").val()+"'),
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
        echo "<td class='center'><input class='in_table' type='text' id='tgl_$i' value='$row->TGL'></td>";
        echo "<td id='deskripsi_$i'>$row->DESKRIPSI</td>";
        echo "<td class='center'>";
            echo "<a class='thickbox' title='<b>SLOT WAKTU - $row->STRING_TGL</b>' href='".site_url("slot/slotWaktu/$id_sidangTA/$row->TREEID?TB_iframe=true&height=400&width=800")."'>";
            echo "<img title='view slot waktu' alt='view slot waktu' src='".base_url()."assets/images/time-icon.png'>";
            echo "</a>";
        echo "</td>";
        echo "<td class='center'>";
            echo "<a onclick=\"return confirm('Anda yakin untuk menghapus?')\" href='".site_url("slot/hapusSlotHari/$row->SIDANGTA/$row->TREEID/$row->ID_SLOT")."'><img title='hapus' alt='hapus' src='".base_url()."assets/images/delete-icon.jpg'></a>";
        echo "</td>";
        echo "</tr>";
        $i++;
    }
    if(!empty($total_page))
        echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";
echo "</table>";
?>