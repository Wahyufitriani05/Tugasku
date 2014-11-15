<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

require_once 'lib_alert.php';

class Lib_user 
{
    var $session_ci;
    var $lib_alert;
    
    function Lib_user() 
    {
        $this->session_ci = new CI_Session();  
        $this->lib_alert = new Lib_alert();    
    }
	
    function get_javascript_menu() 
    {
        if($this->session_ci->userdata('type') == 'admin' ) 
            $js_menu = 'menuAdmin';
        elseif($this->session_ci->userdata('type') == 'NCC' || $this->session_ci->userdata('type') == 'KCV' || $this->session_ci->userdata('type') == 'SE') 
            $js_menu = 'menuKBK';
        elseif ($this->session_ci->userdata('type') == 'dosen') 
            $js_menu = 'menuDosen';
        elseif ($this->session_ci->userdata('type') == 'mahasiswa') 
            $js_menu = 'menuMahasiswa';
        else 
            $js_menu = 'menuGuest';
        return $js_menu;    // return file name of menu javascript
    }
	
    function get_header() {
        if($this->session_ci->userdata('type') == 'admin' ) 
            $header = 'headerAdmin';
        elseif($this->session_ci->userdata('type') == 'NCC' || $this->session_ci->userdata('type') == 'KCV' || $this->session_ci->userdata('type') == 'SE') 
            $header = 'headerAdmin';
        elseif ($this->session_ci->userdata('type') == 'dosen') 
            $header = 'headerDosen';
        elseif ($this->session_ci->userdata('type') == 'mahasiswa') 
            $header = 'headerMahasiswa';
        else 
            $header = 'headerGuest';
        return $header; // return file name of menu header
    }

    function cek_admin($dialog = false, $redirect_page="error/index/", $message="Halaman ini hanya bisa dilihat oleh administrator") 
    {
        if($this->session_ci->userdata('type') != 'admin' ) 
        {
            $this->lib_alert->warning($message);
            if($redirect_page == "error/index/") {
                redirect("error/index/".$dialog);
            } else {
                redirect($redirect_page);
            }
        }
    }
    
    function cek_admin_kbk($dialog = false, $redirect_page="error/index/", $message="Halaman ini hanya bisa dilihat oleh admin KBK") 
    {
        if($this->session_ci->userdata('type') == 'NCC' || $this->session_ci->userdata('type') == 'KCV' || $this->session_ci->userdata('type') == 'RPL' || $this->session_ci->userdata('type') == 'AJK' || $this->session_ci->userdata('type') == 'MI' || $this->session_ci->userdata('type') == 'DTK' || $this->session_ci->userdata('type') == 'AP' || $this->session_ci->userdata('type') == 'IGS') 
        {}
        else
        {
            $this->lib_alert->warning($message);
            if($redirect_page == "error/index/") {
                redirect("error/index/".$dialog);
            } else {
                redirect($redirect_page);
            }
        }
    }
    
    function cek_admin_dosen($dialog = false, $redirect_page="error/index/", $message="Halaman ini hanya bisa dilihat oleh dosen dan admin") 
    {
        
        if($this->session_ci->userdata('type') == 'dosen'  || $this->session_ci->userdata('type') == 'admin')
        {
            
        }
        else
        {
            $this->lib_alert->warning($message);
            if($redirect_page == "error/index/") {
                redirect("error/index/".$dialog);
            } else {
                redirect($redirect_page);
            }
        }
    }
    
    function cek_dosen($dialog = false, $redirect_page="error/index/", $message="Halaman ini hanya bisa dilihat oleh dosen") 
    {
        if($this->session_ci->userdata('type') != 'dosen') 
        {
            $this->lib_alert->warning($message);
            if($redirect_page == "error/index/") {
                redirect("error/index/".$dialog);
            } else {
                redirect($redirect_page);
            }
        }
    }

    function cek_mahasiswa($dialog = false, $redirect_page="error/index/", $message="Halaman ini hanya bisa dilihat oleh mahasiswa") 
    {
        if($this->session_ci->userdata('type') != 'mahasiswa' ) 
        {
            $this->lib_alert->warning($message);
            if($redirect_page == "error/index/") {
                redirect("error/index/".$dialog);
            } else {
                redirect($redirect_page);
            }
        }
    }

    function is_admin() 
    {
        if($this->session_ci->userdata('type') == 'admin' )
            return TRUE;
        else
            return FALSE;
    }

    function is_admin_kbk() 
    {
        if($this->session_ci->userdata('type') == 'NCC' || $this->session_ci->userdata('type') == 'KCV' || $this->session_ci->userdata('type') == 'RPL' || $this->session_ci->userdata('type') == 'AJK' || $this->session_ci->userdata('type') == 'MI' || $this->session_ci->userdata('type') == 'DTK' || $this->session_ci->userdata('type') == 'AP' || $this->session_ci->userdata('type') == 'IGS') 
            return TRUE;
        else
            return FALSE;
    }

    function is_dosen() 
    {
        if($this->session_ci->userdata('type') == 'dosen')
            return TRUE;
        else
            return FALSE;
    }
    
    function is_mahasiswa() 
    {
        if($this->session_ci->userdata('type') == 'mahasiswa')
            return TRUE;
        else
            return FALSE;
    }
}
?>