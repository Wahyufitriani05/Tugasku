<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Lib_alert 
{
    
    var $session_ci;
    
    function Lib_alert() 
    {
        $this->session_ci = new CI_Session();
    }
	
    function info($message) 
    {
        $this->session_ci->set_flashdata('alert', "<div class='info'>$message</div>");
    }

    function success($message) 
    {
        $this->session_ci->set_flashdata('alert', "<div class='success'>$message</div>");
    }

    function warning($message) 
    {
        $this->session_ci->set_flashdata('alert', "<div class='warning'>$message</div>");
    }

    function error($message) 
    {
        $this->session_ci->set_flashdata('alert', "<div class='error'>$message</div>");
    }
    
    function custom($name, $message) 
    {
        $this->session_ci->set_flashdata($name, $message);
    }
    
} 

?>