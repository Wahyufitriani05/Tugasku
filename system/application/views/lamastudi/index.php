<table class="table1" style="width:96%; margin-top:20px; border:1px solid #aaa;" border="1" cellpadding="2" cellspacing="3">
    <?php
    echo "<tr>";;
    echo "<th>NRP</th>";
    echo "<th>NAMA</th>";
    echo "<th>PERIODE WISUDA</th>";
    echo "<th>TGL SIDANG PROPOSAL</th>";
    echo "<th>TGL SIDANG TA</th>";
    echo "<th>LAMA PENGERJAAN TA (bulan)</th>";
    echo "</tr>";
    
    $i=1;
    foreach ($list_ta as $row) {
        if($i%2==0)
            $class_row = 'rowA';
        else
            $class_row = 'rowB';
        echo "<tr class='$class_row'>";
        echo "<td>$row->nrp</td>";
        echo "<td>$row->nama_mahasiswa</td>";
        echo "<td>$row->semester_sidang_ta $row->tahun_sidang_ta</td>";
        echo "<td>". date('d-m-Y',strtotime($row->tgl_sidang_ta)). "</td>";
        echo "<td>". date('d-m-Y',strtotime($row->tgl_sidang_ta_asli)). "</td>";        
        printf ("<td>%.2f</td>",$row->lama_studi);                           
        echo "</tr>";
        $i++;
    }
    ?>
</table>