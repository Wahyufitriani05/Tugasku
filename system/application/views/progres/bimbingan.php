<?php 
echo "<div id='message' style='margin: 1em;'>";
    echo validation_errors();
    if($this->session->flashdata('alert'))
        echo $this->session->flashdata('alert');
echo "</div>";

if(isset($bimbingan) && !empty($bimbingan)) {
    echo "<table class='table1' style='width:96%; margin-top:20px; border:1px solid #aaa;' border='1' cellpadding='2' cellspacing='3'>";
        echo "<tr>";
            echo "<th width='20'>No</th>";
            echo "<th width='120'>Waktu</th>";
            echo "<th>Topik</th>";            
            echo "<th width=250>Pembimbing</th>";
            echo "<th>Komentar</th>";
            if(@$print) { }
            else {
            echo "<th width='80'>Edit / Hapus</th>";
            }
        echo "</tr>";
        $index_bimbingan=1;
        foreach ($bimbingan as $row) {
            if($index_bimbingan%2==0)
                echo "<tr class='rowA'>";
            else
                echo "<tr class='rowB'>";
            echo "<td>$index_bimbingan.</td>";
            echo "<td class='center'>";
            if(isset ($id_new_progres) && $id_new_progres == $row->ID_PROGRESS) {
                echo "<img src='".base_url()."assets/images/new.png'>";
                unset ($id_new_progres);
            } elseif(isset ($id_updated_progres) && $id_updated_progres == $row->ID_PROGRESS) {
                echo "<img src='".base_url()."assets/images/updated.png'>";
                unset ($id_updated_progres);
            }else {
                echo $row->TGL_PROGRESS;
            }
            echo "</td>";
            echo "<td><p>$row->ISI_PROGRESS</p></td>";
            echo "<td>$row->PEMBIMBING</td>";
            if($row->ISI_KOMENTAR==NULL)
                echo "<td>--</td>";
            else
                echo "<td>$row->ISI_KOMENTAR</td>";
            
            if(@$print) { }
            else {
            echo "<td class='center'>";
                if($this->session->userdata('nip') == $row->NIP || $row->NIP == '000000000') {
                    echo "<a class='thickbox' title='Update Bimbingan' href='".site_url("progres/updateBimbingan/$row->ID_PROPOSAL/$row->ID_PROGRESS?TB_iframe=true&height=300&width=640")."'><img title='edit' alt='edit' src='".base_url()."assets/images/edit-icon.jpg'></a>";
                    echo "&nbsp;&nbsp;&nbsp;";
                    echo "<a onclick=\"return confirm('Anda yakin untuk menghapus?')\" href='".site_url("progres/hapusBimbingan/$row->ID_PROPOSAL/$row->ID_PROGRESS")."'><img title='hapus' alt='hapus' src='".base_url()."assets/images/delete-icon.jpg'></a>";
                }
            echo "</td>";
            }
            echo "</tr>";
            $index_bimbingan++;
        }
    echo "</table>";
}
?>
