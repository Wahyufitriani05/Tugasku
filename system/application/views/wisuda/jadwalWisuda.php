<?php
echo "<table class='table1' style='width:96%; margin-top:20px; border:1px solid #aaa;' border='1' cellpadding='2' cellspacing='3'>";
    if(!empty($total_page))
        echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th width=50>AKTIF</th>";
    echo "<th width=150>WAKTU ENTRI</th>";
    echo "<th>KETERANGAN</th>";
    echo "<th width=50>DELETE</th>";
    echo "</tr>";

    unset($st);
    $st[1]='CHECKED';
    $st[0]='';
    $i=1;
    foreach ($wisuda as $row) {
            echo "<script type='text/javascript'>
                    $(document).ready(function() {";
                            echo $this->pquery->observe_field("#aktif_$i",array('event'=>'click','function'=>$this->pquery->remote_function(array(
                                    'url'=>site_url('wisuda/updateWisuda'),
                                    'update'=>"#waktu_entri_$i",
                                    'with'=>'waktu_entri='.$row->WAKTU_PERIODE_WISUDA.'&aktif="+$("#aktif_'.$i.'").val()+"'
                            ))));
            echo "});
            </script>";

            echo "<script type='text/javascript'>
                    $(document).ready(function() {";
                            echo $this->pquery->observe_field("#keterangan_$i",array('event'=>'change','function'=>$this->pquery->remote_function(array(
                                    'url'=>site_url('wisuda/updateWisuda'),
                                    'update'=>"#waktu_entri_$i",
                                    'with'=>'id_wisuda='.$row->ID_PERIODE_WISUDA.'&waktu_entri='.$row->WAKTU_PERIODE_WISUDA.'&keterangan="+$("#keterangan_'.$i.'").val()+"'
                            ))));
            echo "});
            </script>";

            if($i%2==0)
                $class_row = 'rowA';
            else
                $class_row = 'rowB';
            echo "<tr class='$class_row'>";
            echo "<td class='center'>$row->ID_PERIODE_WISUDA</td>";
            echo "<td class='center'><input type='radio' id='aktif_$i' name='aktif' value='$row->ID_PERIODE_WISUDA' ".$st[$row->AKTIF]." /></td>";
            echo "<td class='center' id='waktu_entri_$i'>$row->WAKTU_PERIODE_WISUDA</td>";
            echo "<td class='center'><input class='in_table' type='text' id='keterangan_$i' value='$row->KET_PERIODE_WISUDA'/></td>";
            echo "<td class='center'>";
                    echo $this->pquery->link_to_remote("<img title='hapus' alt='hapus' src='".base_url()."assets/images/delete-icon.jpg'>",array('url'=>site_url("wisuda/hapusWisuda/$row->ID_PERIODE_WISUDA"), 'update'=>"#wisuda", 'beforeSend'=>'return confirm("Anda yakin untuk menghapus?")'));
            echo "</td>";
            echo "</tr>";
            $i++;
    }
    if(!empty($total_page))
        echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";
echo "</table>";
?>