<div id="some-content" class="box box-shadow grid_13 clearfix">
    <a name="top" id="top"></a>
    <div class="alpha omega">
        <!-- judul halaman + gambar-->
        <h1>Dosen Baru</h1>
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
        <form method="POST" action="<?php echo site_url('kbk/tambahDosen');?>">
            <table align="left" style="margin: 1em;">
                <tr><td>NIP Dosen</td><td>:</td><td><input type="text" name="nip" size="20" value="<?php echo set_value('nip'); ?>"/></td><td><?php echo form_error('nip'); ?></td></tr>
                <tr><td>Nama Dosen</td><td>:</td><td><input type="text" name="nama" size="70" value="<?php echo set_value('nama'); ?>"/></td><td><?php echo form_error('nama'); ?></td></tr>
                <tr><td>Nama Lengkap Dosen</td><td>:</td><td><input type="text" name="nama_lengkap" size="70" value="<?php echo set_value('nama_lengkap'); ?>"/></td><td><?php echo form_error('nama_lengkap'); ?></td></tr>
                <tr><td>Email Dosen</td><td>:</td><td><input type="text" name="email" size="70" value="<?php echo set_value('email'); ?>"/></td><td><?php echo form_error('email'); ?></td></tr>
                <tr><td>Telepon Dosen</td><td>:</td><td><input type="text" name="telepon" size="70" value="<?php echo set_value('telepon'); ?>"/></td><td><?php echo form_error('telepon'); ?></td></tr>
                <tr><td>Insial Dosen</td><td>:</td><td><input type="text" name="inisial" size="70" value="<?php echo set_value('inisial'); ?>"/></td><td><?php echo form_error('inisial'); ?></td></tr>
                <tr><td>Password Dosen</td><td>:</td><td><input type="password" name="password" size="70" value="<?php echo set_value('password'); ?>"/></td><td><?php echo form_error('password'); ?></td></tr>
                <tr><td>Ulangi Password Dosen</td><td>:</td><td><input type="password" name="password2" size="70" value="<?php echo set_value('password2'); ?>"/></td><td><?php echo form_error('password2'); ?></td></tr>
                <tr><td>Jenis Kelamin</td><td>:</td><td><input type="radio" name="jenis_kelamin" value="laki-laki" <?php echo set_radio('jenis_kelamin', 'laki-laki'); ?>/>&nbsp;Laki-laki&nbsp;<input type="radio" name="jenis_kelamin" value="perempuan" <?php echo set_radio('jenis_kelamin', 'perempuan'); ?>/>&nbsp;Perempuan</td><td><?php echo form_error('jenis_kelamin'); ?></td></tr>
                <tr><td>Status Dosen</td><td>:</td><td>
                        <select name="status" style="width: 100px;">
                             <option value="">Pilih Status</option>
                            <option value="2" <?php echo set_select('status', '2'); ?>>Admin</option>
                            <option value="1" <?php echo set_select('status', '1'); ?>>Dosen Pembimbing</option>
                        </select>
                    </td><td><?php echo form_error('status'); ?></td></tr>
                <tr><td>Bidang Minat</td><td>:</td><td></td><td><?php echo form_error('minat[]'); ?></td></tr>
                <?php
                    foreach($kbk as $row){
                        echo "<tr><td colspan=\"2\"></td><td><input type=\"checkbox\" name=\"minat[]\" value=\"$row->id_kbk\" size=\"90\" ".set_checkbox('minat[]', $row->nama_kbk)."/> &nbsp; $row->keterangan_kbk ($row->nama_kbk)</td></tr>";
                    }
                ?>
                <tr><td colspan="3" align="right"><input type="submit" value="Simpan" style="width: 150px"/></td>
            </table>
        </form>
    </div>
    <br/>
</div>