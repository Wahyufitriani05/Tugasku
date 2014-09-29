<div id="some-content" class="box box-shadow grid_13 clearfix">
    <div class="alpha omega">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
        <div style="margin: 1em;">
            <p>Upload file spreadsheets (*.xls) yang berisi daftar nama mahasiswa tugas akhir. Contoh isi file seperti pada gambar di bawah ini!</p>
            <img src="<?php echo base_url()."assets/images/contoh_registrasi_mahasiswa.png"?>">
        </div>
        <?php echo form_open_multipart('mahasiswa/pendaftaranMahasiswa');?>
            <table class='table1' style='width:96%; margin-top:20px; border:0px solid #aaa;' border='0' cellpadding='0' cellspacing='0'>
                <tr>
                    <td>Upload File (*.xls)</td>
                    <td><input type="file" name="userfile" size="50"/></td>
                    <td align="right"><input type="submit" value="Daftar"/></td>
                    <td><?php echo $upload_error?></td>     
                </tr>
            </table>
        <?php echo form_close();?>
    <br/>
    </div>
</div>