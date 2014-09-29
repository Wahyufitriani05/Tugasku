<div id="some-content" class="box box-shadow grid_13 clearfix">
    <?php echo $this->load->view("topik/headerTab-topik");?>
    <div class="alpha omega">
        <!-- judul halaman + gambar-->
        <h1>Buat Topik TA</h1>
        <!-- judul halaman + gambar-->
        <?php echo $this->load->view("topik/yellowNote-topik");?>
        <form method="POST" action="#">
            <table align="left" style="margin: 1em;">
                <tr><td style="width: 100px;">Judul Topik</td><td style="width: 20px;">:</td><td><input type="text" name="judul" size="90"/></td></tr>
                <tr><td>Deskripsi Topik</td><td>:</td></tr>
                <tr><td colspan="3"><?php echo $this->load->view("topik/textEditor");?></td></tr>
                <tr><td>File Pendukung</td><td>:</td><td><input type='file' /></td></tr>
                <tr><td colspan="3" align="right"><input type="submit" value="Simpan" style="width: 150px;"/></td>
            </table>
        </form>
    </div>
    <br/>
</div>