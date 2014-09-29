<table id="toc" class="toc" summary="Contents" style="margin:30px 0px 0px 0px;width:500px;height: 100px;">
    <tr>
        <td>
            <div id="toctitle"><h2>File Pendukung :</h2></div>
            <ul>
                <?php
                $count=0;
                foreach($file_berita as $row){
                    echo "<li class=\"toclevel-1\">
                        <a href=\"".base_url().'assets/files/berita/'.$row->path_file."\"><span class=\"tocnumber\"></span> <span class=\"toctext\">$row->nama_file</span></a>
                    </li>";
                    $count++;
                }
                if($count==0){
                    echo "Tidak ada file yang disertakan";
                }
                ?>
            </ul>
        </td>
    </tr>
</table>