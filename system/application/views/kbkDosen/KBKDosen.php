<table class="table1" style="width:90%; margin-top:20px; border:1px solid #aaa;" border="1" cellpadding="2" cellspacing="3">
    <tr>
        <th width="15">No</th>
        <th width="70">Nama KBK</th>
        <th>Keterangan KBK</th>
        <th width="100">Status KBK</th>
	</tr>
        <?php
            $count=1;
            foreach($kbk as $row){
                echo "<tr><td>".$count++."</td><td>$row->nama_kbk</td><td>$row->keterangan_kbk</td><td align=\"center\">";
                echo "<a href=\"".site_url('kbk/ubahStatus/'.$row->id_kbk."/");
                if($row->status_kbk=="DIPAKAI")echo "/0";
                else echo "/1";
                echo "\">$row->status_kbk</a>";
                echo "</td></tr>";
            }
        ?>
</table>