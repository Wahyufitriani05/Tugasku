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
echo "<th width=50>ID</th>";
echo "<th width=50>AKTIF</th>";
echo "<th width=90>BIDANG MINAT</th>";
echo "<th width=90>WAKTU</th>";
echo "<th>KETERANGAN</th>";
echo "<th width=50>DELETE</th>";
echo "</tr>";

unset($st);
$st[1]='CHECKED';
$st[0]='';
$i=1;
foreach ($sid_prop as $row) {
    echo "<script type='text/javascript'>
    $(function() {
        $( '#waktu_$i' ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
    });
    </script>";

    echo "<script type='text/javascript'>
        $(document).ready(function() {";
            echo $this->pquery->observe_field("#aktif_$i",array('event'=>'click','function'=>$this->pquery->remote_function(array(
                'url'=>site_url('sidang/aktivasiSidangProposal/"+$("#aktif_'.$i.'").val()+"'),
                'update'=>"#message"
            ))));
    echo "});
    </script>";

    echo "<script type='text/javascript'>
        $(document).ready(function() {";
            echo $this->pquery->observe_field("#waktu_$i",array('event'=>'change','function'=>$this->pquery->remote_function(array(
                'url'=>site_url('sidang/updateWaktuSidangProposal/'.$row->ID_SIDANG_PROP.'/"+$("#waktu_'.$i.'").val()+"'),
                'update'=>"#message"
            ))));
    echo "});
    </script>";

    echo "<script type='text/javascript'>
        $(document).ready(function() {";
            echo $this->pquery->observe_field("#keterangan_$i",array('event'=>'change','function'=>$this->pquery->remote_function(array(
                'url'=>site_url('sidang/updateKeteranganSidangProposal/'.$row->ID_SIDANG_PROP.'/"+$("#keterangan_'.$i.'").val()+"'),
                'update'=>"#message"
            ))));
    echo "});
    </script>";

    if($i%2==0)
        $class_row = 'rowA';
    else
        $class_row = 'rowB';
    echo "<tr class='$class_row'>";
    echo "<td class='center'>";
        if(isset ($id_new_sidprop) && $id_new_sidprop == $row->ID_SIDANG_PROP) {
            echo "<img src='".base_url()."assets/images/new.png'>";
            unset ($id_new_sidprop);
        } else { 
            echo $row->ID_SIDANG_PROP;
        }
    echo "</td>";
    echo "<td class='center'><input type='checkbox' id='aktif_$i' name='aktif' value='$row->ID_SIDANG_PROP' ".$st[$row->STATUS_SIDANG_PROP]." /></td>";
    echo "<td class='center'>$row->NAMA_KBK</td>";
    echo "<td class='center'><input class='in_table' type='text' id='waktu_$i' value='$row->WAKTU'></td>";
    echo "<td class='center'><input class='in_table' type='text' id='keterangan_$i' value='$row->KET_SIDANG_PROP'/></td>";
    echo "<td class='center'>";
        echo $this->pquery->link_to_remote("<img title='hapus' alt='hapus' src='".base_url()."assets/images/delete-icon.jpg'>",array('url'=>site_url("sidang/hapusSidangProposal/$row->ID_SIDANG_PROP"), 'update'=>"#sidang_proposal", 'beforeSend'=>'return confirm("Anda yakin untuk menghapus?")'));
    echo "</td>";
    echo "</tr>";
    $i++;
}
if(!empty($total_page)) 
    echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";
echo "</table>";
?>
