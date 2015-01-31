<?php
    echo '<table class="table1" style="width:96%; margin-top:20px; border:1px solid #aaa;" border="1" cellpadding="2" cellspacing="3">';
    if(!empty($total_page))
        echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";
    echo "<tr>";
    echo "<th width=10>ID</th>";
    echo "<th width=50>NRP</th>";
    echo "<th width=170>NAMA</th>";
    echo "<th width=170>PEMBIMBING 1</th>";
    echo "<th width=170>PEMBIMBING 2</th>";
    echo "<th width=120>STATUS</th>";
    echo "</tr>";
    $i=1;
    
    foreach ($listTA as $row) {
        if($row->STA=="")
        {
            echo "<script type='text/javascript'>
                $(document).ready(function() {";
                    echo $this->pquery->observe_field("#sidta_$row->ID_PROPOSAL",array('event'=>'change','function'=>$this->pquery->remote_function(array(
                        'url'=>site_url('sidang/daftarSidangTA/'.$row->ID_PROPOSAL.'/"+$("#sidta_'.$row->ID_PROPOSAL.'").val()+"'),
                        'update'=>"#flag_$row->ID_PROPOSAL"
                    ))));
            echo "});
            </script>";

            if($i%2==0)
                $class_row = 'rowA';
            else
                $class_row = 'rowB';
            echo "<tr class='$class_row'>";
            echo "<td>$row->ID_PROPOSAL</td>";
            echo "<td>$row->NRP</td>";
            echo "<td>$row->NAMA_LENGKAP_MAHASISWA</td>";
            echo "<td>$row->NAMA_PEMBIMBING1</td>";
            echo "<td>$row->NAMA_PEMBIMBING2</td>";
            echo "<td>";
            echo "<select name='sidta' id='sidta_$row->ID_PROPOSAL' > ";
            echo "<option value=''>Pilih Sidang TA </option>";
            foreach ($list_sidangTA as $sidangTA) {
                if($sidangTA->ID_SIDANG_TA==$row->STA) {
                    $tanda2 = "selected";
                } else {
                    $tanda2 = "";
                }
                echo "<option value='".$sidangTA->ID_SIDANG_TA."' $tanda2>".$sidangTA->KET_SIDANG_TA."</option>";
            }
            echo "</select>";
            echo "<span id='flag_$row->ID_PROPOSAL'></span></td>";
            echo "</tr>";
            $i++;
        }
    }
    if(!empty($total_page))
        echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";
    ?>
</table>