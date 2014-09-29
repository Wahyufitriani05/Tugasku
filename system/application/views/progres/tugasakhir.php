<table class="table1" style="width:96%; margin-top:20px; border:1px solid #aaa;" border="1" cellpadding="2" cellspacing="3">
    <?php
    // pagination
    if(!empty($total_page))
        echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";

    $sort_by = $this->session->userdata('tugasakhir_sortby');
    $sort_type = ($this->session->userdata('tugasakhir_sorttype')=="" ? "-" : $this->session->userdata('tugasakhir_sorttype'));
    $list_sort_type = array(
        'asc' => 'desc',
        'desc' => 'asc',
        '-' => 'asc'
    );
    $uri = $this->uri->uri_string();
    $new_uri = str_replace("/", "%20", $uri);
    echo "<tr>";
    echo "<th class='".($sort_by=='1' ? 'sorting'.$sort_type : 'sorting')."' width=30><a href='".site_url("progres/sorting/1/$list_sort_type[$sort_type]/".$new_uri)."'>ID</a></th>";
    echo "<th class='".($sort_by=='2' ? 'sorting'.$sort_type : 'sorting')."' width=50><a href='".site_url("progres/sorting/2/$list_sort_type[$sort_type]/".$new_uri)."'>KBK</th>";
    echo "<th class='".($sort_by=='3' ? 'sorting'.$sort_type : 'sorting')."' width=140><a href='".site_url("progres/sorting/3/$list_sort_type[$sort_type]/".$new_uri)."'>STATUS</th>";
    echo "<th class='".($sort_by=='4' ? 'sorting'.$sort_type : 'sorting')."'><a href='".site_url("progres/sorting/4/$list_sort_type[$sort_type]/".$new_uri)."'>NRP</a></th>";
    echo "<th class='".($sort_by=='5' ? 'sorting'.$sort_type : 'sorting')."'><a href='".site_url("progres/sorting/5/$list_sort_type[$sort_type]/".$new_uri)."'>NAMA</a></th>";
    echo "<th class='".($sort_by=='6' ? 'sorting'.$sort_type : 'sorting')."'><a href='".site_url("progres/sorting/6/$list_sort_type[$sort_type]/".$new_uri)."'>JUDUL</a></th>";
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
            if($this->uri->segment(3)=='bimbingan' && $row->STATUS != '31')
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