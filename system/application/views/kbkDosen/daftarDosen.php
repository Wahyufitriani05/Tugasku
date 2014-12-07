<?php 
// Thickbox
//echo $this->lib_js->thickbox(); 

?>
<table class="table1" style="width:90%; margin-top:20px; border:1px solid #aaa;" border="1" cellpadding="2" cellspacing="3">
    <tr><td colspan="10" align="center"><?php echo $this->pagination->create_links();?></td></tr>
    <tr>
        <th width="15">NIP</th>
		<th>Nama</th>
        <th>Status</th>
                <?php
                    $count_kbk=0;
                    $nama_kbk= array();
                    $id_kbk=array();
                    foreach($kbk as $row){
                        $id_kbk[$count_kbk]=$row->id_kbk;
                        $nama_kbk[$count_kbk++]=$row->nama_kbk;
                        echo "<th>$row->nama_kbk</th>";
                    }
                ?>
		<th>Edit</th>
	</tr>
        <?php
        
            if(isset($search) && $search!=null)
            {
                $uri = $search;
                $link = 1;
            }
            else
            {
                $uri = $this->uri->segment(3, 0);
                $link = 2;
            }
            $nama="";
            $state=$nama_kbk[0];
            $nip="";
            $baris=0;
            foreach($dosen as $row){
                //baris record dosen baru
                if($nama!=$row->nama_lengkap_dosen){
                    //bukan record pertama
                    if($nama!=""){
                        for($i=1; $i<$count_kbk; $i++){
                            if($state==$nama_kbk[$i]){
                                echo "<td align=\"center\"><a href=\"".site_url('kbk/ubahKBKDosen/'.$id_kbk[$i].'/'.$nip.'/1/'.$uri.'/'.$link)."\">-</a></td>";
                                $state=$nama_kbk[($i+1)%$count_kbk];
                            }
                        }
                        echo "<td align=\"center\"><a href=\"".site_url('kbk/ubahDosen/'.$nip)."?TB_iframe=true&height=450&width=700\" class=\"thickbox\" title=\"Ubah Dosen\">Edit</a></td></tr>";
                    }
                    //baris record baru
                    //set nip/nip2010
                    if($row->nip!="")$nip=$row->nip;
                    else $nip=$row->nip2010;
                    
                    //set nama lengkap dosen
                    $nama=$row->nama_lengkap_dosen;
                    
                    if(($baris+1)%2==0)echo "<tr class=\"rowA\">";
                    else echo "<tr class=\"rowB\">";
                    $baris++;

                    echo "<td align=\"right\">";
                    if($row->nip!="") echo $row->nip;
                    else echo $row->nip2010;
                    echo "</td>
                        <td>$row->nama_lengkap_dosen</td>";
                    
                        if($row->status_dosen == 0)                        
                        echo "<td align=\"center\"><a href=\"".site_url('kbk/ubahStatusDosen/'.$nip.'/2/'.$uri.'/'.$link)."\">-</a></td>";
                        else
                        echo 
                        "<td align=\"center\"><a href=\"".site_url('kbk/ubahStatusDosen/'.$nip.'/0/'.$uri.'/'.$link)."\">Aktif</a></td>";
                            
                }

                //state kbk tiap dosen
                $bool_kbk=false;
                for($i=0; $i<$count_kbk;$i++){
                    if($state==$nama_kbk[$i] && !$bool_kbk){
                        if($state==$row->nama_kbk){
                            echo "<td align=\"center\"><a href=\"".site_url('kbk/ubahKBKDosen/'.$id_kbk[$i].'/'.$nip.'/2/'.$uri.'/'.$link)."\">Ya</a></td>";
                            $bool_kbk=true;
                        }
                        else{
                            echo "<td align=\"center\"><a href=\"".site_url('kbk/ubahKBKDosen/'.$id_kbk[$i].'/'.$nip.'/1/'.$uri.'/'.$link)."\">-</a></td>";
                        }
                        $state=$nama_kbk[($i+1)%$count_kbk];
                    }
                }
            }

            if($nama!=""){
                //tambahan penutup state dan edit untuk record terakhir
                for($i=1; $i<$count_kbk; $i++){
                    if($state==$nama_kbk[$i]){
                        echo "<td align=\"center\">-</td>";
                        $state=$nama_kbk[($i+1)%$count_kbk];
                    }
                }
                echo "<td align=\"center\"><a href=\"".site_url('kbk/ubahDosen/'.$nip)."?TB_iframe=true&height=450&width=700\" class=\"thickbox\" title=\"Ubah Dosen\">Edit</a></td></tr>";
            }
            else {
                echo "<tr><td colspan='50'>Tidak Ada Data yang sesuai</td></tr>";
            }
        ?>
    <tr><td colspan="10" align="center"><?php echo $this->pagination->create_links();?></td></tr>
</table>