<?php
class MY_Controller extends Controller {
    
    function MY_Controller() {
        parent::Controller();
        $this->load->library('lib_alert');
        $this->load->library('lib_tugas_akhir');
        $this->load->model('mdosen');
    }
    
    function filter($item) {
        // cegah akses dr browser
        if(strtolower($this->uri->segment(2)) == "filter")
        {
            $this->lib_alert->warning("Halaman tidak ditemukan!");
            redirect('error/index');  
        }
        
        if($this->input->post($item) != '') 
        {
            $value = $this->input->post($item);             // from POST data
            $this->session->set_userdata($item, $value);    // save in session
        } 
        elseif($this->session->userdata($item) != '') 
        {
            $value = $this->session->userdata($item);       // from session
        } 
        else 
        {
            $value = '-1';     // -1 -> semua kbk
        }
        // cek value valid/tidak
        if($item == 'kbk') {
            if($this->mdosen->cekKBK($value) == false)
                $value = '-1';
        } elseif($item == 'status') {
            if($this->lib_tugas_akhir->is_status($value) == false)
                $value = '-1'; 
        } elseif($item == 'dosen') {
            if($this->mdosen->cekDosen($value) == false)
                $value = '-1';
        }

        return $value;
    }
    
}
?>
