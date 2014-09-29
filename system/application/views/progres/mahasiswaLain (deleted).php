<table class="table1" style="width:96%; margin-top:20px; border:1px solid #aaa;" border="1" cellpadding="2" cellspacing="3">
    <?php
    // pagination
    if(!empty($total_page))
        echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";

    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th width=50>KBK</th>";
    echo "<th width=140>STATUS</th>";
    echo "<th>NRP</th>";
    echo "<th>NAMA</th>";
    echo "<th>JUDUL</th>";
    echo "</tr>";
    
    $i=1;
    foreach ($listTA as $row) {
        if($i%2==0)
            $class_row = 'rowA';
        else
            $class_row = 'rowB';
        echo "<tr class='$class_row'>";
        echo "<td>$row->ID_PROPOSAL</td>";
        echo "<td>".($row->NAMA_KBK == 'BELUM ADA' ? '-' : $row->NAMA_KBK)."</td>";
        echo "<td>".$this->lib_tugas_akhir->nama_status($row->STATUS)."</td>";
        echo "<td>$row->NRP</td>";
        echo "<td>$row->NAMA_LENGKAP_MAHASISWA</td>";
        echo "<td>";
            if($this->uri->segment(3)=='bimbingan')
                echo "<a href='".site_url("progres/bimbingan/$row->ID_PROPOSAL")."'>$row->JUDUL_TA</a>";
            else
                echo "<a class='thickbox' title='Detail Tugas Akhir' href='".site_url("progres/detail/$row->ID_PROPOSAL?TB_iframe=true&height=500&width=800")."'>$row->JUDUL_TA</a>";
        echo "</td>";
        echo "</tr>";
        $i++;
    }

    // pagination
    if(!empty($total_page))
        echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";
    ?>
</table>