<div id="some-content" class="box box-shadow grid_13 clearfix">    <div class="alpha omega">        <h1><?php echo (isset($title) ? $title : ""); ?></h1>        <div class='separator'></div>        <div class='separator'></div>        <div style="margin: 1em;">            <div class='success'>Pendaftaran mahasiswa tugas akhir yang berhasil</div>        </div>        <table class='table1' style='width:50%; margin-top:20px; border:1px solid #aaa;' border='1' cellpadding='2' cellspacing='3'>            <tr>                <th width=20%>NRP</th>                <th>NAMA</th>            </tr>            <?php            $k=1;            for ($i = 0; $i < count($daftar_sukses); $i++) {                if($k%2==0)                    echo "<tr class='rowB'>";                else                    echo "<tr class='rowA'>";                echo "<td>".$daftar_sukses[$i]['nrp']."</td>";                echo "<td>".$daftar_sukses[$i]['nama']."</td>";                echo "</tr>";                $k++;            }            ?>        </table>        <div class='separator'></div>        <div class='separator'></div>        <div style="margin: 1em;">            <div class='error'>Pendaftaran mahasiswa tugas akhir yang gagal, karena NRP telah terdaftar sebagai mahasiswa tugas akhir</div>        </div>        <table class='table1' style='width:50%; margin-top:20px; border:1px solid #aaa;' border='1' cellpadding='2' cellspacing='3'>            <tr>                <th width=20%>NRP</th>                <th>NAMA</th>            </tr>            <?php            $k=1;            for ($i = 0; $i < count($daftar_gagal); $i++) {                if($k%2==0)                    echo "<tr class='rowB'>";                else                    echo "<tr class='rowA'>";                echo "<td>".$daftar_gagal[$i]['nrp']."</td>";                echo "<td>".$daftar_gagal[$i]['nama']."</td>";                echo "</tr>";                $k++;            }            ?>        </table>        <br/>    </div></div>