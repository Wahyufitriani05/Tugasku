<script type="text/javascript" src="<?php echo base_url(); ?>/assets/ckeditor/ckeditor.js"></script>

<?php

        echo "<link rel='stylesheet' href='".base_url()."assets/themes/bento/css/style.fluid.css' type='text/css' media='screen' />";

        // Extension Style (User Interface)

        echo "<link rel='stylesheet' href='".base_url()."assets/skins/common/shared.css?207' type='text/css' media='screen' />";

        echo "<link rel='stylesheet' href='".base_url()."assets/skins/common/commonPrint.css?207' type='text/css' media='print' />";

        // style for pop up window

        echo "<link rel='stylesheet' href='".base_url()."assets/extensions/FlaggedRevs/flaggedrevs.css' type='text/css' />";

        echo "<link rel='stylesheet' href='".base_url()."assets/skins/bento/css_local/style.css' type='text/css' media='screen' />";

?>

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

<!-- judul halaman + gambar-->

<h1><?php echo $title;?></h1>

<!-- judul halaman + gambar-->

<?php
	$ada_topik=false;
    foreach($topik as $row_topik){
		$ada_topik=true;
        $judul_topik=$row_topik->judul_topik;

        $id_kbk=$row_topik->id_kbk;

        $isi_topik=$row_topik->abstraksi_topik;

        $nip2=$row_topik->nip2;

        $nip20102=$row_topik->nip20102;

    }
    $error="";
	if(!$ada_topik)$this->session->set_userdata('error', "Topik yang diubah tidak ditemukan!!");
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

<?php 
if($ada_topik)
{
echo form_open_multipart('topik/ubahTopik/'.$id_topik)
    ."<table align=\"left\" style=\"margin: 1em;\">
        <tr><td style=\"width: 130px;\">Judul Topik</td><td style=\"width: 20px;\">:</td><td><input type=\"text\" name=\"judul\" size=\"90\" value=\""; if(set_value('judul'))echo set_value('judul'); else echo $judul_topik; echo "\"/></td></tr>";
        if(form_error('judul'))echo "<tr><td colspan=\"2\"></td><td>".form_error('judul')."</td></tr>";
        echo "<tr><td>Bidang Minat Topik</td><td>:</td><td><select name=\"minat\" style=\"width: 100px;\">";
                    foreach($kbk as $row)
                    {
                        echo "<option value='$row->id_kbk'";
						if(set_select('minat', '$row->id_kbk')=="selected") set_select('minat', '$row->id_kbk');
                        else if($row->id_kbk==$id_kbk)echo " selected ";

                        echo ">$row->nama_kbk</option>";

                    }
         	echo "</select></td></tr>
        <tr><td>Isi Topik</td><td>:</td><td>"; if(form_error('isi'))echo form_error('isi'); echo "</td></tr>
        <tr><td colspan=\"3\">
                <textarea class=\"ckeditor\" cols=\"80\" id=\"editor1\" name=\"isi\" rows=\"10\">"; if(set_value ('isi'))echo set_value ('isi');else echo "&nbsp;".$isi_topik; echo "</textarea>
            </td></tr>
        <tr><td>Dosen Pembimbing 2</td><td>:</td><td><select name=\"pembimbing2\" style=\"width: 300px;\">";
                    foreach($dosen as $row)
                    {
                        if($row->nip!='') {

                            echo "<option value='$row->nip'";

                            if($row->nip==$nip2) echo " selected ";

                            echo ">$row->nama_lengkap_dosen</option>";

                        }
                        else {
                            echo "<option value='$row->nip2010'";

                            if($row->nip2010==$nip20102) echo " selected ";

                            echo ">$row->nama_lengkap_dosen</option>";

                        }
                    }
                echo "</select></td></tr>
        <tr><td colspan=\"3\" align=\"right\"><input type=\"submit\" value=\"Simpan\" style=\"width: 150px\"/></td>
    </table>
</form>";
}?>