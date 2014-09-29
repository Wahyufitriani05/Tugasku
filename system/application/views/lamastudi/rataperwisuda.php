<table class="table1" style="width:46%; margin-top:20px; border:1px solid #aaa;" border="1" cellpadding="2" cellspacing="3">
    <?php
    echo "<tr>";
    echo "<th>PERIODE WISUDA</th>";
    echo "<th>RATA-RATA LAMA PENGERJAAN TA (bulan)</th>";
    echo "</tr>";

    $i=1;
    foreach ($list_ta as $row) {
        if($i%2==0)
            $class_row = 'rowA';
        else
            $class_row = 'rowB';
        echo "<tr class='$class_row'>";
        echo "<td><a href='".site_url("lamastudi/perwisuda/$row->id_periode_lulus")."'>$row->nama_periode</a></td>";;
        printf ("<td>%.2f</td>",$row->lama_total);
        echo "</tr>";
        $i++;
    }
    ?>
</table>