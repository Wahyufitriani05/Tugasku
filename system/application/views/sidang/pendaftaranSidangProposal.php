<table class="table1" style="width:96%; margin-top:20px; border:1px solid #aaa;" border="1" cellpadding="2" cellspacing="3">
    <?php
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
        echo "<script type='text/javascript'>
            $(document).ready(function() {";
                echo $this->pquery->observe_field("#sidprop_$row->ID_PROPOSAL",array('event'=>'change','function'=>$this->pquery->remote_function(array(
                    'url'=>site_url('sidang/daftarSidangProposal/'.$row->ID_PROPOSAL.'/"+$("#sidprop_'.$row->ID_PROPOSAL.'").val()+"'),
                    'update'=>"#flag_$row->ID_PROPOSAL"
                ))));
        echo "});
        </script>";
       
        if($i%2==0)
            $class_row = 'rowA';
        else
            $class_row = 'rowB';
        echo "<tr class='$class_row'>";
        echo "<td><a class='thickbox' title='<b>PROPOSAL TUGAS AKHIR</b>' href='".site_url("sidang/previewProposal/$row->ID_PROPOSAL?TB_iframe=true&height=500&width=900")."'>$row->ID_PROPOSAL</a></td>";
        echo "<td><a class='thickbox' title='<b>PROPOSAL TUGAS AKHIR</b>' href='".site_url("sidang/previewProposal/$row->ID_PROPOSAL?TB_iframe=true&height=500&width=900")."'>$row->NRP</a></td>";
        echo "<td><a class='thickbox' title='<b>PROPOSAL TUGAS AKHIR</b>' href='".site_url("sidang/previewProposal/$row->ID_PROPOSAL?TB_iframe=true&height=500&width=900")."'>$row->NAMA_LENGKAP_MAHASISWA</a></td>";
        echo "<td>$row->PEMBIMBING1</td>";
        echo "<td>$row->PEMBIMBING2</td>";
        echo "<td>$row->SPROP";
            ?>
            <select name="sidprop" id="sidprop_<?php echo $row->ID_PROPOSAL?>" style="min-width: 150px; height: 20px;">
            <option value=""> - Pilih Sidang Proposal - </option>
            <?php
            foreach ($sid_prop as $row_sp) {
                echo "<option value='".$row_sp->ID_SIDANG_PROP."'>".$row_sp->WAKTU."</option>";
            }
            ?>
             </select>
            <?php
        echo "<span id='flag_$row->ID_PROPOSAL'></span></td>";
        echo "</tr>";
        $i++;
    }
    if(!empty($total_page))
        echo "<tr><td colspan='10' align='center'>$total_page</td></tr>";
    ?>
</table>