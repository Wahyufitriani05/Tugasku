<script>
function populateElement(selector, defvalue) {
    $(selector).each(function() {
        if($.trim(this.value) == "") {
            this.value = defvalue;
        }
    });

    $(selector).focus(function() {
        if(this.value == defvalue) {
            this.value = "";
            $('#search').attr('color', black);
        }
    });

    $(selector).blur(function() {
        if($.trim(this.value) == "") {
            this.value = defvalue;
            $('#search').attr('color', grey);
        }
    });
 }

$(document).ready(function(){
    populateElement("#nama", "Masukkan Nama KBK di sini...");
    populateElement("#keterangan", "Masukkan Keterangan KBK di sini...");
})

</script>
<div style="width: 90%;padding: 1em 0 1em 0;">
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
</div>
<form action="<?php echo site_url('kbk/ubahKBK');?>" method="post" style="display: inline;float: left;padding: 0 1em 0 0;">
Nama KBK : <input type="text" name="nama" id="nama" style="height: 15px; width: 150px;"/>
Keterangan KBK : <input type="text" name="keterangan" id="keterangan" style="height: 15px; width: 210px;"/>
<input type="submit" value="Tambah KBK"  title="Tambah KBK" style="width: 100px;"/>
</form>