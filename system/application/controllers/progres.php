<?php 
require 'MY_Controller.php';

class Progres extends MY_Controller 
{    
    function Progres() 
    {
        parent::MY_Controller();
        // load model, library, helper etc.
        $this->load->library('lib_user');
        $this->load->library('lib_js');
        $this->load->library('pquery');
        $this->load->model('mprogres');
        $this->load->model('mproposal');
    }

    function index() 
    {
        // go to mahasiswaLain
        $this->tugasakhir();
    }
    
    function sorting($sort_by="", $sort_type="", $uri="") 
    {
        $this->session->set_userdata('tugasakhir_sortby', $sort_by);
        $this->session->set_userdata('tugasakhir_sorttype', $sort_type);
        $new_uri = str_replace(" ", "/", $uri);
        redirect($new_uri);
        
    }
    
    function tugasakhir($jenis="", $kriteria="", $keyword="") 
    {
        // cek parameter
        $param_jenis = array('bimbingan', 'cari');
        if(! in_array($jenis, $param_jenis))
            $jenis = "";
        // set menu, view
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['content'] = "progres/content-tugasakhir";
        // filter KBK dan status
        $id_kbk = $this->filter("filter_kbk");
        $status = $this->filter("filter_status"); 
        // sorting
        $sort_by = $this->session->userdata('tugasakhir_sortby');
        $sort_type = $this->session->userdata('tugasakhir_sorttype');
        // pagination
        $per_page = 20;
        $config['per_page'] = $per_page;                  
        $config['num_links'] = 10; 
        $config['first_link'] = 'Awal';
        $config['last_link'] = 'Akhir';
        $config['next_link'] = 'Selanjutnya';
        $config['prev_link'] = 'Sebelumnya';
        if($jenis == "bimbingan")
        {
            $this->lib_user->cek_dosen("", "progres/tugasakhir/", "Halaman <strong>'Daftar Bimbingan Tugas Akhir'</strong> hanya bisa dilihat oleh dosen pembimbing yang bersangkutan");
            $data['title'] = "Daftar Bimbingan Tugas Akhir";        // set title
            $nip_dosen = $nip = $this->session->userdata('nip');    // set nip dosen
            $this->session->set_userdata("filter_dosen", $nip_dosen);
            // pagination
            $config['base_url'] = site_url("progres/tugasakhir/$jenis");  
            $config['total_rows'] = count($this->mproposal->getListTA($id_kbk, $status, "", "", $nip_dosen)); 
            $config['uri_segment'] = 4;
            // get current pagination page
            $page = $this->uri->segment(4);
            $offset = ($page == false || is_numeric($page) == false ? 0 : $page);
            $data['url_filter'] = $this->uri->segment(1)."/".$this->uri->segment(2)."/".$jenis;
            $data['listTA'] = $this->mproposal->getListTA($id_kbk, $status, $offset, $per_page, $nip_dosen, $sort_by, $sort_type);
        } 
        else 
        {
            $nip_dosen = $this->filter("filter_dosen");             // filter dosen
            if($jenis == "cari")
            {
                $data['title'] = "Hasil Pencarian Tugas Akhir";     // set title
                // get keyword from POST data
                if($this->input->post('search')) 
                {
                    $kriteria = $this->input->post('kriteria_search');
                    $keyword = $this->input->post('search');
                    // clear filter
                    $this->session->unset_userdata('filter_kbk');
                    $this->session->unset_userdata('filter_status');
                    $this->session->unset_userdata('filter_dosen');
                    redirect("progres/tugasakhir/cari/$kriteria/$keyword");
                }
                // cek parameter
                $param_kriteria = array('judul', 'nama_mhs', 'nrp_mhs');
                if(! in_array($kriteria, $param_kriteria))
                    $kriteria = "";
                // pagination
                $config['base_url'] = site_url("progres/tugasakhir/$jenis/$keyword");  
                $config['total_rows'] = count($this->mproposal->cariTA($kriteria, $keyword, $id_kbk, $status, $nip_dosen)); 
                $config['uri_segment'] = 6;
                // get current pagination page
                $page = $this->uri->segment(6);
                $offset = ($page == false || is_numeric($page) == false ? 0 : $page);
                $data['url_filter'] = $this->uri->segment(1)."/".$this->uri->segment(2)."/".$jenis."/".$kriteria."/".$keyword;
                $data['listTA'] = $this->mproposal->cariTA($kriteria, $keyword, $id_kbk, $status, $nip_dosen, $offset, $per_page);
                $data['kriteria'] = $kriteria;
                $data['keyword'] = $keyword;
            }
            else
            {
                $data['title'] = "Tugas Akhir";                     // set title
                // pagination
                $config['base_url'] = site_url('progres/tugasakhir');
                $config['total_rows'] = count($this->mproposal->getListTA($id_kbk, $status, "", "", $nip_dosen)); 
                $config['uri_segment'] = 3;    
                // get current pagination page
                $page = $this->uri->segment(3);
                $offset = ($page == false || is_numeric($page) == false ? 0 : $page);
                $data['url_filter'] = $this->uri->segment(1)."/".$this->uri->segment(2);
                $data['listTA'] = $this->mproposal->getListTA($id_kbk, $status, $offset, $per_page, $nip_dosen, $sort_by, $sort_type);
            }
        }
        $this->pagination->initialize($config);
        // generate pagination links
        $data['total_page'] = $this->pagination->create_links();  
        $data['list_kbk'] = $this->mdosen->listKBK();
        $data['list_status'] = $this->lib_tugas_akhir->list_status();
        $data['list_dosen'] = $this->mdosen->listDosen();
        $this->load->view('template', $data);
    }

    function detail($id_proposal="") 
    {
        // cek input valid/tidak
        $this->mproposal->cek($id_proposal,false);
        // set title, menu, view
        $data['title'] = "Detail Tugas Akhir Mahasiswa";
        $data['js_menu'] = $this->lib_user->get_javascript_menu(); 		
        $data['header'] = $this->lib_user->get_header(); 		
        $data['content'] = "progres/content-detail";	        
        // detail TA
        $data['detailTA'] = $this->mproposal->getDetail($id_proposal);
        if($this->lib_user->is_admin() || $this->lib_user->is_admin_kbk() || $this->lib_user->is_dosen())
            $data['proposal'] = $this->mproposal->getProposalFiles($id_proposal);
        $this->load->view('tb_template', $data);
    }
    
    function bimbingan($id_proposal="") 
    {
        // cek jika bukan dosen pembimbing dan bukan mahasiswa pemilik proposal yang mengakses akan langsung diarahkan ke halaman detail TA 
        $get_akses = true;
        if($this->lib_user->is_admin()) {}
        elseif($this->lib_user->is_dosen() && $this->mproposal->fieldTA("STATUS", $id_proposal) != "31" ) {
            if($this->mproposal->cekPembimbingTA($id_proposal, $this->session->userdata('nip'))) {}
            else $get_akses = false;
        }
        elseif($this->lib_user->is_mahasiswa() && $this->mproposal->fieldTA("STATUS", $id_proposal) != "31" ) {
            if($this->mproposal->cek(array('ID_PROPOSAL' => $id_proposal, 'NRP' => $this->session->userdata('id')))) {}
            else $get_akses = false;
        }
        else $get_akses = false;
        
        if(! $get_akses)
        {
            $this->lib_alert->warning("Halaman <strong>bimbingan</strong> hanya bisa diakses pada TA yang masih dalam tahap pengerjaan (belum lulus). Yang bisa mengakses bimbingan hanya mahasiswa atau dosen yang bersangkutan.");
            redirect("progres/tugasakhir");
        }
        // cek input valid/tidak
        $this->mproposal->cek($id_proposal,false);
        // set title, menu, view
        $data['title'] = "Progres Tugas Akhir Mahasiswa"; 	
        $data['js_menu'] = $this->lib_user->get_javascript_menu(); 					
        $data['header'] = $this->lib_user->get_header(); 					
        $data['content'] = "progres/content-bimbingan";	
        // detail TA
        $data['detailTA'] = $this->mproposal->getDetail($id_proposal);
        if($this->lib_user->is_admin() == true || $this->lib_user->is_admin_kbk() == true || $this->lib_user->is_dosen() == true)
            $data['proposal']=$this->mproposal->getProposalFiles($id_proposal);
        // list bimbingan/progres
        $data['bimbingan'] = $this->mprogres->getList($id_proposal);
        $data['id_new_progres'] = $this->session->flashdata("id_new_progres");
        $data['id_updated_progres'] = $this->session->flashdata("id_updated_progres");
        // nama dosen yang akan mengisi bimbingan
        $data['nama_dosen'] = $this->mdosen->fieldDosen("NAMA_LENGKAP_DOSEN", $this->session->userdata('nip'));		
        $this->load->view('template', $data);
    }
    
    function progresSaya($id_new_progres="") 
    {
        // autentikasi
        $this->lib_user->cek_mahasiswa("", "progres/tugasakhir/", "Halaman <strong>'Progres TA Mahasiswa'</strong> hanya bisa dilihat oleh mahasiswa yang bersangkutan");
        // set title, menu, view
        $data['title'] = "Progres Tugas Akhir Mahasiswa"; 	
        $data['js_menu'] = $this->lib_user->get_javascript_menu(); 					
        $data['header'] = $this->lib_user->get_header(); 					
        $data['content'] = "progres/content-bimbingan";	
        // get ID proposal sesuai NRP mahasiswa
        $id_proposal = $this->mproposal->getProposalSaya($this->session->userdata('id'))->row()->id_proposal;
        // detail TA
        $data['detailTA'] = $this->mproposal->getDetail($id_proposal);
        $data['proposal']=$this->mproposal->getProposalFiles($id_proposal);
        // list bimbingan/progres
        $data['bimbingan'] = $this->mprogres->getList($id_proposal);
        $data['id_new_progres'] = $this->session->flashdata("id_new_progres");
        $data['id_updated_progres'] = $this->session->flashdata("id_updated_progres");
        $this->load->view('template', $data);
    }
	
    function bimbinganBaru($id_proposal="") 
    {
        // cek jika bukan dosen pembimbing dan bukan mahasiswa pemilik proposal yang mengakses akan langsung diarahkan ke halaman detail TA 
        $get_akses = true;
        if($this->lib_user->is_admin()) {}
        elseif($this->lib_user->is_dosen() && $this->mproposal->fieldTA("STATUS", $id_proposal) != "31" ) {
            if($this->mproposal->cekPembimbingTA($id_proposal, $this->session->userdata('nip'))) {}
            else $get_akses = false;
        }
        elseif($this->lib_user->is_mahasiswa() && $this->mproposal->fieldTA("STATUS", $id_proposal) != "31" ) {
            if($this->mproposal->cek(array('ID_PROPOSAL' => $id_proposal, 'NRP' => $this->session->userdata('id')))) {}
            else $get_akses = false;
        }
        else $get_akses = false;
        
        if(! $get_akses)
        {
            $this->lib_alert->warning("<strong>Bimbingan</strong> hanya bisa dibuat oleh mahasiswa atau dosen yang bersangkutan");
            redirect("progres/tugasakhir");
        }
        // cek input valid/tidak
        $this->mproposal->cek($id_proposal, true);        
        $this->form_validation->set_rules('tgl_progres', 'tanggal progres', 'required');
        $this->form_validation->set_rules('editor1', 'topik progres', 'required');
        $this->form_validation->set_error_delimiters('<div class="warning">', '</div>');
        // jika validasi form berhasil
        if ($this->form_validation->run() == true) 
        {
            if($this->lib_user->is_dosen() == true) 
                $nip = $this->session->userdata('nip');
            elseif($this->lib_user->is_mahasiswa() == true) 
                $nip = '000000000';
            $data_bimbingan_baru = array(
                'id_proposal' => $this->db->escape_like_str($id_proposal),
                'nip' => $this->db->escape_like_str($nip),
                'tgl_progress' => $this->db->escape_like_str($this->input->post('tgl_progres')),
                'isi_progress' => $this->db->escape_like_str($this->input->post('editor1'))
            );
            // insert ke database
            $this->mprogres->add($data_bimbingan_baru);
            // pesan berhasil
            // $this->lib_alert->success("Data bimbingan baru telah disimpan pada tanggal ".$this->input->post('tgl_progres'));
            $this->session->set_flashdata("id_new_progres", $this->mprogres->getLastID($id_proposal));
            // redirect, utk meload ulang isi tabel bimbingan yang baru
            if($this->lib_user->is_mahasiswa())
                redirect("progres/progresSaya/");
            else
                redirect("progres/bimbingan/$id_proposal/");
        } 
        else 
        {
            $this->lib_alert->warning("Topik bimbingan harus diisi!");
            if($this->lib_user->is_mahasiswa())
                redirect("progres/progresSaya");
            else
                redirect("progres/bimbingan/$id_proposal");
        }
    }

    function updateBimbingan($id_proposal="", $id_progress="" ) 
    {
       // cek jika bukan dosen pembimbing dan bukan mahasiswa pemilik proposal yang mengakses akan langsung diarahkan ke halaman detail TA 
        $get_akses = true;
        if($this->lib_user->is_admin()) {}
        elseif($this->lib_user->is_dosen() && $this->mproposal->fieldTA("STATUS", $id_proposal) != "31" ) {
            if($this->mproposal->cekPembimbingTA($id_proposal, $this->session->userdata('nip'))) {}
            else $get_akses = false;
        }
        elseif($this->lib_user->is_mahasiswa() && $this->mproposal->fieldTA("STATUS", $id_proposal) != "31" ) {
            if($this->mproposal->cek(array('ID_PROPOSAL' => $id_proposal, 'NRP' => $this->session->userdata('id')))) {}
            else $get_akses = false;
        }
        else $get_akses = false;    
        
        if(! $get_akses)
        {
            $this->lib_alert->warning("<strong>Bimbingan</strong> hanya bisa diubah oleh mahasiswa atau dosen yang bersangkutan");
            redirect("error/index/".true);
        }
        // cek input valid/tidak
        $this->mproposal->cek($id_proposal, true);
        $this->mprogres->cekProgresTA($id_proposal, $id_progress, true);
        // form validation
        $this->form_validation->set_rules('tgl_updateProgres', 'tanggal progres', 'required');
        $this->form_validation->set_rules('editor1', 'topik progres', 'required');
        $this->form_validation->set_error_delimiters('<div class="warning">', '</div>');
        // jika validasi form berhasil
        if ($this->form_validation->run() == true) 
        {
            if($this->lib_user->is_dosen() == true) 
                $nip = $this->session->userdata('nip');
            elseif($this->lib_user->is_mahasiswa() == true) 
                $nip = '000000000';
            $data_update_bimbingan = array(
                'nip' => $this->db->escape_like_str($nip),
                'tgl_progress' => $this->db->escape_like_str($this->input->post('tgl_updateProgres')),
                'isi_progress' => $this->db->escape_like_str($this->input->post('editor1'))
            );
            // update database
            $this->mprogres->update($data_update_bimbingan, $id_progress);
            // pesan berhasil
            //$this->lib_alert->success("Data bimbingan TA (".$id_progress.") telah di-update pada tanggal ".$this->input->post('tgl_updateProgres'));
            $this->session->set_flashdata("id_updated_progres", $id_progress);
            // reload/refresh halaman
            echo "<body onload='self.parent.tb_refresh(true)'></body>";
        } 
        else 
        {
            // nama dosen yang akan mengupdate bimbingan
            $data['nama_dosen'] = $this->mdosen->fieldDosen("NAMA_LENGKAP_DOSEN", $this->session->userdata('nip'));
            // detail bimbingan
            $data['detail_bimbingan'] = $this->mprogres->getDetail($id_progress);
            // view
            $data['content'] = 'progres/content-formUpdateBimbingan';
            $this->load->view('tb_template', $data);
        }
    }

    function hapusBimbingan($id_proposal="", $id_progress="") 
    {
        // cek jika bukan dosen pembimbing dan bukan mahasiswa pemilik proposal yang mengakses akan langsung diarahkan ke halaman detail TA 
        $get_akses = true;
        if($this->lib_user->is_admin()) {}
        elseif($this->lib_user->is_dosen() && $this->mproposal->fieldTA("STATUS", $id_proposal) != "31" ) {
            if($this->mproposal->cekPembimbingTA($id_proposal, $this->session->userdata('nip'))) {}
            else $get_akses = false;
        }
        elseif($this->lib_user->is_mahasiswa() && $this->mproposal->fieldTA("STATUS", $id_proposal) != "31" ) {
            if($this->mproposal->cek(array('ID_PROPOSAL' => $id_proposal, 'NRP' => $this->session->userdata('id')))) {}
            else $get_akses = false;
        }
        else $get_akses = false;    
        
        if(! $get_akses)
        {
            $this->lib_alert->warning("Bimbingan hanya bisa dihapus oleh mahasiswa atau dosen yang bersangkutan");
            redirect("progres/tugasakhir");
        }
        // cek input valid/tidak
        if($this->lib_user->is_mahasiswa())
            $this->mprogres->cekProgresTA($id_proposal, $id_progress, true, "progres/progresSaya");
        else
            $this->mprogres->cekProgresTA($id_proposal, $id_progress, true, "progres/bimbingan/$id_proposal");
        
        // tgl progres yg akan dihapus
        $tgl = $this->mprogres->field("TGL_PROGRESS", $id_progress);
        $this->mprogres->hapus($id_progress);
        // pesan berhasil
        $this->lib_alert->success("Data bimbingan TA pada tanggal ".$tgl." telah dihapus");
        // reload tabel bimbingan yg baru
        if($this->lib_user->is_mahasiswa())
            redirect("progres/progresSaya");
        else
            redirect("progres/bimbingan/$id_proposal");
    }

    
}

/* End of file progres.php */
/* Location: ./system/application/controllers/progres.php */
