<?php echo count($listTA); ?>
<table class="table1" style="width:96%; margin-top:20px; border:1px solid #aaa;" border="1" cellpadding="2" cellspacing="3">
    <?php
    echo "<tr>";;
    echo "<th>NO</th>";
    echo "<th>NRP</th>";
    echo "<th>NAMA</th>";
    echo "<th>DOSEN PEMBIMBING 1</th>";
    echo "<th>DOSEN PEMBIMBING 2</th>";
    if($tipe == 'penguji')
    {
        echo "<th>DOSEN PENGUJI 1</th>";
        echo "<th>DOSEN PENGUJI 2</th>";
    }
    echo "</tr>";
    
    $i=1;
    foreach ($listTA as $row) {
        if($i%2==0)
            $class_row = 'rowA';
        else
            $class_row = 'rowB';
        echo "<tr class='$class_row'>";
        echo "<td>$i</td>";
        echo "<td>$row->NRP</td>";
        echo "<td>$row->NAMA_LENGKAP_MAHASISWA</td>";
        echo "<td>$row->PEMBIMBING1</td>";
        echo "<td>$row->PEMBIMBING2</td>";
        if($tipe=='penguji')
        {
            echo "<td>$row->PENGUJI1</td>";
            echo "<td>$row->PENGUJI2</td>";
        }
        $i++;
    }
    ?>
</table>