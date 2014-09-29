<?php

class Error extends Controller 
{
    
    function Error() 
    {
        parent::Controller();
        $this->load->library('lib_user');
        $this->load->library('lib_js');
    }
    
    function index($dialog = false)
    {
        $data['header'] = $this->lib_user->get_header();
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['content'] = 'error/index';
        if($dialog == true)
            $this->load->view('tb_template', $data);
        else
            $this->load->view('template', $data);
    }
}

?>
