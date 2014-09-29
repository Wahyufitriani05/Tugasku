<?php

class Wisuda extends Controller {

    
    
    
	
    function Wisuda() {
        parent::Controller();
        // load library tambahan
        $this->load->library('lib_tugas_akhir'); 
        $this->load->library('lib_alert');
        $this->load->library('lib_user');
        $this->load->library('lib_js');
        $this->load->library('pquery');
        // load model
        $this->load->model('mwisuda');
        // set javascript menu dan header
        
        
        
        // cek aksesbilitas dan privileges
        $function = $this->uri->segment(2,'');
        if( strcasecmp($function, 'jadwalWisuda') == 0 ) {
            $this->lib_user->cek_admin();
        }
        elseif( strcasecmp($function, 'entryWisuda') == 0 ||
                strcasecmp($function, 'hapusWisuda') == 0
                ){
            $this->lib_user->cek_admin('redirect_frame');
        }
    }
	
    function jadwalWisuda() {
        // jadwal wisuda
        $data['wisuda'] = $this->mwisuda->getListWisuda();
        // page information
        $data['title'] = "Jadwal Wisuda";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['content'] = "wisuda/content-jadwalWisuda";

        $this->load->view('template', $data);
    }
	
    function updateWisuda() {
        // jika login admin
        if($this->lib_user->is_admin()) {
            $waktu_entri = $this->input->get('waktu_entri');
            // -------- CEK INPUT ------------
            if($this->input->get('id_wisuda') != "" && $this->input->get('keterangan') != "" && $this->mwisuda->cekWisuda($this->input->get('id_wisuda'))) {
                // update KETERANGAN
                $waktu_entri = date("Y-m-d")." ".date("H:i:s");
                $data_update_wisuda = array(
                    'WAKTU_PERIODE_WISUDA' => $waktu_entri,
                    'KET_PERIODE_WISUDA' => $this->input->get('keterangan')
                );
                // tambahkan data ke Database
                $this->mwisuda->updateWisuda($data_update_wisuda, $this->input->get('id_wisuda'));
            }
            // -------- CEK INPUT ------------
            if($this->input->get('aktif') != "" && $this->mwisuda->cekWisuda($this->input->get('aktif'))) {
                // update AKTIF/TIDAK
                $this->mwisuda->updateStatusWisuda('0');
                $waktu_entri = date("Y-m-d")." ".date("H:i:s");
                $data_update_status_wisuda = array(
                    'WAKTU_PERIODE_WISUDA' => $waktu_entri,
                    'AKTIF' => '1'
                );
                // tambahkan data ke Database
                $this->mwisuda->updateWisuda($data_update_status_wisuda, $this->input->get('aktif'));
            }
            echo $waktu_entri;
        } else {
            echo "<span style='color:red'>Akses ditolak</span>";
        }
        
    }
	
    function entryWisuda() {
        // cek input
        if($this->input->post('keterangan') != "") {
            $waktu_entri = date("Y-m-d")." ".date("H:i:s");
            $data_wisuda = array(
                    'ID_PERIODE_WISUDA' => $this->mwisuda->newIDWisuda(),
                    'WAKTU_PERIODE_WISUDA' => $waktu_entri,
                    'KET_PERIODE_WISUDA' => $this->db->escape_like_str($this->input->post('keterangan')),
                    'AKTIF' => '0'
            );
            // tambahkan data ke Database
            $this->mwisuda->addWisuda($data_wisuda);
        }
		
        // set data jadwal wisuda
        $data['wisuda'] = $this->mwisuda->getListWisuda();

        $this->load->view('wisuda/jadwalWisuda', $data);
    }
	
    function hapusWisuda($id_wisuda="") {
        // cek id wisuda
        if($this->mwisuda->cekWisuda($id_wisuda) == FALSE) {
             redirect('error/index/'.true);
        }

        // hapus jadwal wisuda
        $this->mwisuda->hapusWisuda($id_wisuda);

        // set data jadwal wisuda yg baru
        $data['wisuda'] = $this->mwisuda->getListWisuda();

        $this->load->view('wisuda/jadwalWisuda', $data);
    }
	
}

?>
