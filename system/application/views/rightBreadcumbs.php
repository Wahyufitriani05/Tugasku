<?php
echo $this->lib_js->thickbox();
$type = $this->session->userdata('type');
if($type=="NCC" || $type=="KCV" || $type=="RPL" || $type=="AJK" || $type=="MI" || $type=="DTK" || $type=="AP" || $type=="IGS" || $type=="admin" || $type=="dosen" || $type=="mahasiswa")
    echo "<a href='#'>".$this->session->userdata('nama')."</a> | <a class='thickbox' title='Ubah Password' href='".site_url('login/ubahPassword')."?TB_iframe=true&height=400&width=800'>Ubah Password</a> | <a href='".site_url('login/keluar')."'>Log Out</a>";
else
    echo "<a id=\"login-trigger\" href=\"#login\">Login</a>";
//<a class='thickbox' href='".site_url('example/signup?height=400&width=800')."' title='Preview'>
?>