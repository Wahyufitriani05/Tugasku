<?php
        echo "<link rel='stylesheet' href='".base_url()."assets/themes/bento/css/style.fluid.css' type='text/css' media='screen' />";
        // Extension Style (User Interface)
        echo "<link rel='stylesheet' href='".base_url()."assets/skins/common/shared.css?207' type='text/css' media='screen' />";
        echo "<link rel='stylesheet' href='".base_url()."assets/skins/common/commonPrint.css?207' type='text/css' media='print' />";
        // style for pop up window
        echo "<link rel='stylesheet' href='".base_url()."assets/extensions/FlaggedRevs/flaggedrevs.css' type='text/css' />";
        echo "<link rel='stylesheet' href='".base_url()."assets/skins/bento/css_local/style.css' type='text/css' media='screen' />";
?>
<!-- judul halaman + gambar-->
<h1><?php echo $title;?></h1>
<!-- judul halaman + gambar-->
<h4>Judul Topik : <?php foreach($judul_topik as $row){echo $row->judul_topik;}?></h4>
<?php
    $error="";
    $error=$this->session->userdata('error');
    if($error!=""){
        $this->load->view('kbkDosen/redNote');
        $this->session->unset_userdata('error');
    }

    $sukses="";
    $sukses=$this->session->userdata('sukses');
    if($sukses!=""){
        $this->load->view('kbkDosen/blueNote');
        $this->session->unset_userdata('sukses');
    }
?>
<?php echo form_open_multipart('topik/statusTopik/'.$id_topik);?>
    <table class="table1" style="width:90%; margin-top:20px; border:1px solid #aaa;" border="1" cellpadding="2" cellspacing="3">
        <tr><th>No</th><th>NRP</th><th>Nama Mahasiswa</th><th>Jenis Kelamin</th><th>Tanggal Minati</th><th>Approve</th></tr>
        <?php
        $count=1;
        foreach($mahasiswa as $row){
            echo "<tr";
            if($count%2==1)echo " class=\"rowA\" ";
            else echo " class=\"rowB\" ";
            echo "><td>$count</td><td>$row->nrp</td><td>$row->nama_lengkap_mahasiswa</td><td>$row->sex_mahasiswa</td><td>$row->tanggal_minati</td>";
            if($row->approve_dosen=="0")echo "<td><a href=\"".site_url('topik/statusTopik/'.$id_topik."/".$row->nrp."/1")."\">Tidak</a></td></tr>";
            else if($row->approve_dosen=="1")echo "<td><a href=\"".site_url('topik/statusTopik/'.$id_topik."/".$row->nrp."/0")."\">Ya</a></td></tr>";
            $count++;
        }
        if($count==1)echo "<tr><td colspan=\"6\">Belum ada mahasiswa yang berminat</td></tr>";
        ?>
    </table>
</form>