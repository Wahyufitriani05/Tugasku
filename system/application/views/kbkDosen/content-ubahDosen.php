<?php
        echo "<link rel='stylesheet' href='".base_url()."assets/themes/bento/css/style.fluid.css' type='text/css' media='screen' />";
        // Extension Style (User Interface)
        echo "<link rel='stylesheet' href='".base_url()."assets/skins/common/shared.css?207' type='text/css' media='screen' />";
        echo "<link rel='stylesheet' href='".base_url()."assets/skins/common/commonPrint.css?207' type='text/css' media='print' />";
        // style for pop up window
        echo "<link rel='stylesheet' href='".base_url()."assets/extensions/FlaggedRevs/flaggedrevs.css' type='text/css' />";
        echo "<link rel='stylesheet' href='".base_url()."assets/skins/bento/css_local/style.css' type='text/css' media='screen' />";
?>
<!--<div id="some-content" class="box box-shadow grid_13 clearfix">
    <a name="top" id="top"></a>
    <div class="alpha omega">-->
        <!-- judul halaman + gambar-->
        <?php $this->load->view('kbkDosen/jquery-kbk');?>
        <h1>Ubah Dosen</h1>
        <?php
            $error="";
            $error=$this->session->userdata('error');
            if($error!=""){
                $this->load->view('kbkDosen/redNote');
            }

            $sukses="";
            $sukses=$this->session->userdata('sukses');
            if($sukses!=""){
                $this->load->view('kbkDosen/blueNote');
            }
        ?>
        <!-- judul halaman + gambar-->
        <?php
        if(isset($dosen)){
            $nip="";
            $nama;
            $nama_lengkap;
            $email;
            $telepon;
            $inisial;
            $password;
            $password2;
            $jenis_kelamin;
            $status;
            $minat[] = array();
            foreach($dosen as $row){
                if($row->nip!="")$nip=$row->nip;
                else $nip=$row->nip2010;
                $nama=$row->nama_dosen;
                $nama_lengkap=$row->nama_lengkap_dosen;
                $email=$row->email_dosen;
                $telepon=$row->telp_dosen;
                $inisial=$row->inisial_dosen;
                $jenis_kelamin=$row->jenis_kelamin;
                $status=$row->status_dosen;
            }
            $this->session->set_userdata('nip_lama', $nip);
        }
        ?>
        <form method="POST" action="<?php echo site_url('kbk/ubahDosen');?>">
            <table align="left" style="margin: 1em;">
                <tr><td>NIP Dosen</td><td>:</td><td><input type="text" name="nip" size="20" value="<?php if(isset($nama))echo $nip; else echo set_value('nip'); ?>"/></td><td><?php echo form_error('nip'); ?></td></tr>
                <tr><td>Nama Dosen</td><td>:</td><td><input type="text" name="nama" size="70" value="<?php if(isset($nama))echo $nama; else echo set_value('nama'); ?>"/></td><td><?php echo form_error('nama'); ?></td></tr>
                <tr><td>Nama Lengkap Dosen</td><td>:</td><td><input type="text" name="nama_lengkap" size="70" value="<?php if(isset($nama))echo $nama_lengkap;else echo set_value('nama_lengkap'); ?>"/></td><td><?php echo form_error('nama_lengkap'); ?></td></tr>
                <tr><td>Email Dosen</td><td>:</td><td><input type="text" name="email" size="70" value="<?php if(isset($nama))echo $email;else echo set_value('email'); ?>"/></td><td><?php echo form_error('email'); ?></td></tr>
                <tr><td>Telepon Dosen</td><td>:</td><td><input type="text" name="telepon" size="70" value="<?php if(isset($nama))echo $telepon;else echo set_value('telepon'); ?>"/></td><td><?php echo form_error('telepon'); ?></td></tr>
                <tr><td>Insial Dosen</td><td>:</td><td><input type="text" name="inisial" size="70" value="<?php if(isset($nama))echo $inisial;else echo set_value('inisial'); ?>"/></td><td><?php echo form_error('inisial'); ?></td></tr>
                <tr><td>Password Dosen</td><td>:</td><td><input type="password" name="password" size="70" value="<?php echo set_value('password'); ?>"/></td><td><?php echo form_error('password'); ?></td></tr>
                <tr><td>Ulangi Password Dosen</td><td>:</td><td><input type="password" name="password2" size="70" value="<?php echo set_value('password2'); ?>"/></td><td><?php echo form_error('password2'); ?></td></tr>
                <tr><td>Jenis Kelamin</td><td>:</td><td><input type="radio" name="jenis_kelamin" value="laki-laki" <?php if(isset($nama) && $jenis_kelamin=="laki-laki")echo "checked";else echo set_radio('jenis_kelamin', 'laki-laki'); ?>/>&nbsp;Laki-laki&nbsp;<input type="radio" name="jenis_kelamin" value="perempuan" <?php if(isset($nama) && $jenis_kelamin=="perempuan")echo "checked";else echo set_radio('jenis_kelamin', 'perempuan'); ?>/>&nbsp;Perempuan</td><td><?php echo form_error('jenis_kelamin'); ?></td></tr>
                <tr><td>Status Dosen</td><td>:</td><td>
                        <select name="status" style="width: 100px;">
                             <option value="">Pilih Status</option>
                            <option value="2" <?php if(isset($nama) && $status=="2")echo "selected";else echo set_select('status', '2'); ?>>Admin</option>
                            <option value="1" <?php if(isset($nama) && $status=="1")echo "selected";else echo set_select('status', '1'); ?>>Dosen Pembimbing</option>
                        </select>
                    </td><td><?php echo form_error('status'); ?></td></tr>
                <tr><td colspan="3" align="right"><input type="submit" value="Ubah" id="ubah" style="width: 150px"/><input type="button" value="Kembali" onclick="self.parent.tb_remove()"/></td>
            </table>
        </form>
<!--    </div>
    <br/>
</div>-->