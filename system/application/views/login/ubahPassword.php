
<?php
echo $this->lib_js->thickbox(); 

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
<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
echo "
    <link rel='stylesheet' href='".base_url()."assets/themes/bento/css/style.fluid.css' type='text/css' media='screen' />
    <link rel='stylesheet' href='".base_url()."assets/skins/common/shared.css?207' type='text/css' media='screen' />
    <link rel='stylesheet' href='".base_url()."assets/skins/common/commonPrint.css?207' type='text/css' media='print' />
    <link rel='stylesheet' href='".base_url()."assets/extensions/FlaggedRevs/flaggedrevs.css' type='text/css' />
    <link rel='stylesheet' href='".base_url()."assets/skins/bento/css_local/style.css' type='text/css' media='screen' />"
    .form_open_multipart('login/ubahPassword').
    "<table class=\"table1\" style=\"width:90%; margin-top:20px; border:1px solid #aaa;\" border=\"1\" cellpadding=\"2\" cellspacing=\"3\">
    <tr><th colspan='3'>Ubah Password</th></tr>
    <tr><td>Password Lama</td><td>:</td><td><input type='password' name='password_lama'/></td></tr>";
    if(form_error('password_lama'))echo "<tr><td colspan=\"3\">".form_error('password_lama')."</td></tr>";
echo "<tr><td>Password Baru</td><td>:</td><td><input type='password' name='password_baru'/></td></tr>";
    if(form_error('password_baru'))echo "<tr><td colspan=\"3\">".form_error('password_baru')."</td></tr>";
echo "<tr><td>Ulangi Password baru</td><td>:</td><td><input type='password' name='re_password_baru'/></td></tr>";
    if(form_error('re_password_baru'))echo "<tr><td colspan=\"3\">".form_error('re_password_baru')."</td></tr>";
echo "<tr><td colspan='3' align='right'><input type='submit' value='Ubah Password'/></td></tr>
    </table>
    </form>";
?>
