<div id="message" style="margin: 1em;">
<?php
    if($this->session->flashdata('alert'))
        echo $this->session->flashdata('alert');
    echo validation_errors();
?>
</div>
<?php
echo "<table class='table1' style='width:46%; margin-top:20px; border:1px solid #aaa;' border='1' cellpadding='2' cellspacing='3'>";
    if(!empty($total_page))
        echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";
    
    echo "<tr>";
    echo "<th width=50>NO</th>";
    echo "<th>NAMA RUANGAN</th>";
    echo "<th width=150>UPDATE RUANG & SLOT</th>";
    echo "<th width=50>DELETE</th>";
    echo "</tr>";

    $i=1;
    foreach ($ruang_sidang as $row) {
        echo "<script type='text/javascript'>
            $(document).ready(function() {";
                echo $this->pquery->observe_field("#ruang_$i",array('event'=>'change','function'=>$this->pquery->remote_function(array(
                    'url'=>site_url('ruang/updateRuangSidang/'.$id_sidangTA.'/'.$row->ID_JDW_RUANG.'/"+$("#ruang_'.$i.'").val()+"'),
                    'update'=>"#message"
                ))));
        echo "});
        </script>";
    
        if($i%2==0)
            $class_row = 'rowA';
        else
            $class_row = 'rowB';
        echo "<tr class='$class_row'>";
            echo "<td>";
                echo $i;//$row->ID_JDW_RUANG;
            echo "</td>";
            echo "<td>";
            if(isset ($id_ruang_baru) && $id_ruang_baru == $row->ID_JDW_RUANG) 
            {
                echo "$row->DESKRIPSI &nbsp; <img src='".base_url()."assets/images/new.png'>";
                unset ($id_ruang_baru);
            }
            else
                echo "<input class='in_table' type='text' id='ruang_$i' value='$row->DESKRIPSI'/>";
            echo "</td>";
            echo "<td class='center'>";
                echo $this->pquery->link_to_remote("update",array('url'=>site_url("ruang/updateRuangDanSlot/$id_sidangTA/$row->ID_JDW_RUANG"), 'update'=>"#message", 'beforeSend'=>'return confirm("Anda yakin untuk mengupdate ruang dan slot?")'));
            echo "</td>";
            echo "<td class='center'>";
                echo $this->pquery->link_to_remote("<img title='hapus' alt='hapus' src='".base_url()."assets/images/delete-icon.jpg'>",array('url'=>site_url("ruang/hapusRuangSidang/$id_sidangTA/$row->ID_JDW_RUANG"), 'update'=>"#ruang_sidang", 'beforeSend'=>'return confirm("Anda yakin untuk menghapus?")'));
            echo "</td>";
        echo "</tr>";
        $i++;
    }
    
    if(!empty($total_page))
        echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";
echo "</table>";
?>