<script type="text/javascript" src="<?php echo base_url(); ?>/assets/ckeditor/ckeditor.js"></script>
<script>
function GetContents()
{
	// Get the editor instance that we want to interact with.
	var oEditor = CKEDITOR.instances.editor1;

	// Get the editor contents
	alert( "abc:"+oEditor.getData()+":abc" );
}



$(document).ready(function(){
    $("#tambah_file").click(function(){
        var jumlah_file=$("#jumlah_file").attr("value");
        if(jumlah_file<5){
            jumlah_file++;
            $("#file_area_"+$("#jumlah_file").attr("value")).after("<tr id=\"file_area_"+jumlah_file+"\" style=\"display:none\"><td colspan=\"10\">"+"<input type=\"file\" name=\"file_"+jumlah_file+"\" id=\"file_"+jumlah_file+"\" size=\"100\" />\n\
                                                    &nbsp;<!--a href=\"#\" onclick=\"hapusInputFile("+jumlah_file+")\">hapus</a--></td></tr>");
            $("#file_area_"+jumlah_file).fadeIn(500);
            $("#jumlah_file").attr("value", jumlah_file);
        }
    })
})

function hapusInputFile(id_file){
    
}

function AddNewInputFile(){
    $("#jumlah_file").getAttribute("value") = $("#jumlah_file").getAttribute("value")+1;
//    $("#file_area").innerHTML = $("#file_area").innerHTML+"<input type='file' name=\"file_"+($("#jumlah_file").getAttribute("value")+1)+"\" onchange=\"AddNewInputFile()\"/>";
    $("#file_area").innerHTML = "Tes buat baru";
}
</script>
<div id="some-content" class="box box-shadow grid_13 clearfix">
    <div class="alpha omega">
        <!-- judul halaman + gambar-->
        <h1><?php echo $title;?></h1>
        <!-- judul halaman + gambar-->
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
        <?php echo form_open_multipart('topik/tambahTopik');?>
            <table align="left" style="margin: 1em;">
                <tr><td style="width: 130px;">Judul Topik</td><td style="width: 20px;">:</td><td><input type="text" name="judul" size="90" value="<?php echo set_value('judul');?>"/></td></tr>
                <?php if(form_error('judul'))echo "<tr><td colspan=\"2\"></td><td>".form_error('judul')."</td></tr>";?>
                <tr><td>Bidang Minat Topik</td><td>:</td><td><select name="minat" style="width: 100px;">
                            <?php
                            foreach($kbk as $row)
                            {
                                echo "<option value='$row->id_kbk'>$row->nama_kbk</option>";
                            }
                            ?>
                        </select></td></tr>
                <tr><td>Isi Topik</td><td>:</td><td><?php if(form_error('isi'))echo form_error('isi');?></td></tr>
                <tr><td colspan="3">
                        <textarea class="ckeditor" cols="80" id="editor1" name="isi" rows="10"><?php if(set_value ('isi'))echo set_value ('isi');else echo "&nbsp;";?></textarea>
                    </td></tr>
                <tr><td>Dosen Pembimbing 2</td><td>:</td><td><select name="pembimbing2" style="width: 300px;">
                            <?php
                            foreach($dosen as $row)
                            {
                                if($row->nip!='') echo "<option value='$row->nip'>$row->nama_lengkap_dosen</option>";
                                else echo "<option value='$row->nip2010'>$row->nama_lengkap_dosen</option>";
                            }
                            ?>
                        </select></td></tr>
                <tr><td>File Pendukung :
                        <input type="hidden" name="jumlah_file" id="jumlah_file" value="1"/>
                    </td>
                </tr>
                <tr id="file_area_1"><td colspan="10">
                        <input type='file' name="file_1" id="file_1" size="100"/></td></tr>
                <tr><td><input type="button" id="tambah_file" value="Tambah File"/></td></tr>
                <tr><td colspan="3" align="right"><input type="submit" value="Simpan" style="width: 150px"/></td>
            </table>
        </form>
    </div>
    <br/>
</div>