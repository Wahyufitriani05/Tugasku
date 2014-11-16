<table class="table1" style="width:96%; margin-top:20px; border:1px solid #aaa;" border="1" cellpadding="2" cellspacing="3">
    <?php
    if(!empty($total_page))
        echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";
    echo "<tr>";
    echo "<th width=10>ID</th>";
    //echo "<th width=300>JUDUL</th>";
    echo "<th width=50>NRP</th>";
    echo "<th width=150>NAMA</th>";
    echo "<th width=150>PEMBIMBING 1</th>";
    echo "<th width=150>PEMBIMBING 2</th>";
    echo "<th width=120>STATUS</th>";
    if($this->lib_user->is_admin() or $this->lib_user->is_admin_kbk())
    {
        echo "<th>Keterangan Revisi</th>";
    }
    echo "</tr>";
    $i=1;
    foreach ($listTA as $row) {
        echo "<script type='text/javascript'>
            $(document).ready(function() {";
                echo $this->pquery->observe_field("#status_$row->ID_PROPOSAL",array('event'=>'change',
                    'function'=> $this->pquery->remote_function(array(
                    'url'=>site_url('sidang/ubahStatusProposal/'.$row->ID_PROPOSAL.'/"+$("#status_'.$row->ID_PROPOSAL.'").val()+"/'),
                    'update'=>"#flag_$row->ID_PROPOSAL"
                    ))));
        echo "
        });

        </script>";
       
        if($i%2==0)
            $class_row = 'rowA';
        else
            $class_row = 'rowB';
        echo "<tr class='$class_row'>";
        echo "<td><a class='thickbox' title='<b>PROPOSAL TUGAS AKHIR</b>' href='".site_url("sidang/previewProposal/$row->ID_PROPOSAL?TB_iframe=true&height=500&width=900")."'>$row->ID_PROPOSAL</a></td>";
        //echo "<td><a class='thickbox' title='<b>PROPOSAL TUGAS AKHIR</b>' href='".site_url("sidang/previewProposal/$row->ID_PROPOSAL?TB_iframe=true&height=500&width=900")."'>$row->JUDUL_TA</a></td>";
        echo "<td><a class='thickbox' title='<b>PROPOSAL TUGAS AKHIR</b>' href='".site_url("sidang/previewProposal/$row->ID_PROPOSAL?TB_iframe=true&height=500&width=900")."'>$row->NRP</a></td>";
        echo "<td><a class='thickbox' title='<b>PROPOSAL TUGAS AKHIR</b>' href='".site_url("sidang/previewProposal/$row->ID_PROPOSAL?TB_iframe=true&height=500&width=900")."'>$row->NAMA_LENGKAP_MAHASISWA</a></td>";
        echo "<td>$row->PEMBIMBING1</td>";
        echo "<td>$row->PEMBIMBING2</td>";
        echo "<td>";
            if($this->lib_user->is_admin() || $this->session->userdata('type')=='KBJ' || $this->session->userdata('type')=='KCV' || $this->session->userdata('type')=='RPL' || $this->session->userdata('type')=='AJK' || $this->session->userdata('type')=='MI' || $this->session->userdata('type')=='DTK' || $this->session->userdata('type')=='AP' || $this->session->userdata('type')=='IGS') {
                echo "<select id='status_$row->ID_PROPOSAL' name='status' style='min-width: 150px; height: 20px;'>";
                        foreach ($status as $row_s) {
                            if($row_s['id']==$row->STATUS)
                                echo "<option selected='' value='".$row_s['id']."'>".$row_s['nama']."</option>";
                            else
                                echo "<option value='".$row_s['id']."'>".$row_s['nama']."</option>";
                        }
                echo "</select>";

            } else {
                echo $this->lib_tugas_akhir->nama_status($row->STATUS);
            }
        
        if($this->lib_user->is_admin() or $this->lib_user->is_admin_kbk())
        {
            if($row->STATUS == 11)
                echo "<td>$row->REVISI_PROPOSAL</td>";
            else
                echo "<td>-</td>";
        }
        echo "<span id='flag_$row->ID_PROPOSAL'></span></td>";
        echo "</tr>";
        $i++;
    }
    if(!empty($total_page))
        echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";
    ?>
</table>