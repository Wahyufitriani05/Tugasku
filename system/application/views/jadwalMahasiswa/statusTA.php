<style>
    tr th, tr td {
        font-size: 11px;
    }
</style>
<?php
echo $this->lib_js->thickbox();

    echo "<tr>";
    echo "<th>NO</th>";
    echo "<th>KBK</th>";
    echo "<th>NRP</th>";
    echo "<th>NAMA MHS</th>";
    echo "<th>LAMA</th>";
    echo "<th>SIDANG</th>";
    echo "<th>STATUS</th>";
    echo "<th>MAJU TA</th>";
    echo "<th>JUDUL</th>";
    echo "</tr>";

    $rowClass = array(0 => 'rowA', 1 => 'rowB');
    $i = 1;
    foreach ($list_proposal as $prop) {
        echo "<tr class='".$rowClass[($i%2)]."'>";
        echo "<td>$i</td>";
        echo "<td>$prop->NAMA_KBK</td>";
        echo "<td>$prop->NRP</td>";
        echo "<td>$prop->NAMA_LENGKAP_MAHASISWA</td>";
        echo "<td>$prop->lama</td>";
        echo "<td>$prop->TGL_SIDANG_TA</td>";
        echo "<td>";
        echo "<select name='status[$prop->ID_PROPOSAL]'>";
        echo "<option value=''>Pilih Status </option>";
        foreach ($list_status as $status) {
            if($status['id']==$prop->STATUS) {
                $tanda = "selected";
            } else {
                $tanda = "";
            }
            echo "<option value='".$status['id']."' $tanda>".$status['nama']."</option>";
        }
        echo "</select>";
        echo "</td>";
        echo "<td>";
        echo "<select name='sidangTA[$prop->ID_PROPOSAL]'>";
        echo "<option value=''>Pilih Sidang TA </option>";
        foreach ($list_sidangTA as $sidangTA) {
            if($sidangTA->ID_SIDANG_TA==$prop->STA) {
                $tanda2 = "selected";
            } else {
                $tanda2 = "";
            }
            echo "<option value='".$sidangTA->ID_SIDANG_TA."' $tanda2>".$sidangTA->KET_SIDANG_TA."</option>";
        }
        echo "</select>";
        echo "</td>";
        echo "<td>$prop->JUDUL_TA</td>";
        echo "</tr>";
        $i++;
    }


?>
