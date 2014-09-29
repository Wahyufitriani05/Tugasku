<?php
if(isset ($semester) && isset ($tahun_ajaran)) {
    echo "<div style='margin: 1em;'>";
        $this->load->view("sidang/subContent-entrySidangTA");
        echo "<div class='separator'></div>";
        $this->load->view("sidang/entrySidangTA");
        echo "<div class='separator'></div>";
    echo "</div>";
}
if(!empty($sid_ta)) {
    echo "<div id='message' style='margin: 1em;'>";
        if($this->session->flashdata('alert'))
            echo $this->session->flashdata('alert');
        echo validation_errors();
    echo "</div>";
}
?>
<?php
echo "<table class='table1' style='width:96%; margin-top:20px; border:1px solid #aaa;' border='1' cellpadding='2' cellspacing='3'>";
    if(!empty($total_page))
        echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";
    echo "<tr>";
    echo "<th width=20>ID</th>";
    echo "<th width=50>AKTIF</th>";
    echo "<th width=70>SEMESTER</th>";
    echo "<th width=100>TAHUN AJARAN</th>";
    echo "<th>KETERANGAN</th>";
    echo "<th width=70>SLOT HARI</th>";
    echo "<th width=50>DELETE</th>";
    echo "</tr>";

    unset($st);
    $st[1]='CHECKED';
    $st[0]='';
    $i=1;
    foreach ($sid_ta as $row) {
        echo "<script type='text/javascript'>
            $(document).ready(function() {";
                echo $this->pquery->observe_field("#aktif_$i",array('event'=>'click','function'=>$this->pquery->remote_function(array(
                    'url'=>site_url('sidang/aktivasiSidangTA/"+$("#aktif_'.$i.'").val()+"'),
                    'update'=>"#message"
                ))));
        echo "});
        </script>";

        echo "<script type='text/javascript'>
            $(document).ready(function() {";
                echo $this->pquery->observe_field("#keterangan_$i",array('event'=>'change','function'=>$this->pquery->remote_function(array(
                    'url'=>site_url('sidang/updateKeteranganSidangTA/'.$row->ID_SIDANG_TA.'/"+$("#keterangan_'.$i.'").val()+"'),
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
        if(isset ($id_new_sidTA) && $id_new_sidTA == $row->ID_SIDANG_TA) {
            echo "<img src='".base_url()."assets/images/new.png'>";
            unset ($id_new_sidTA);
        } else {
            echo $row->ID_SIDANG_TA;
        }
        echo "</td>";
        echo "<td class='center'><input type='radio' id='aktif_$i' name='aktif' value='$row->ID_SIDANG_TA' ".$st[$row->STATUS_SIDANG_TA]." /></td>";
        echo "<td class='center'>$row->SEMESTER_SIDANG_TA</td>";
        echo "<td class='center'>$row->TAHUN_SIDANG_TA</td>";
        echo "<td class='center'><input class='in_table' type='text' id='keterangan_$i' value='$row->KET_SIDANG_TA'/></td>";
        echo "<td class='center'>";
            echo "<a href='".site_url("slot/slotHari/$row->ID_SIDANG_TA")."'><img title='slot hari' alt='slot hari' src='".base_url()."assets/images/schedule-icon.png'></a>";
        echo "</td>";
        echo "<td class='center'>";
            echo $this->pquery->link_to_remote("<img title='hapus' alt='hapus' src='".base_url()."assets/images/delete-icon.jpg'>",array('url'=>site_url("sidang/hapusSidangTA/$row->ID_SIDANG_TA"), 'update'=>"#sidang_TA", 'beforeSend'=>'return confirm("Anda yakin untuk menghapus?")'));
        echo "</td>";
        echo "</tr>";
        $i++;
    }
    if(!empty($total_page))
        echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";
echo "</table>";
?>