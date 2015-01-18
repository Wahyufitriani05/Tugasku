<?php
require 'MY_Controller.php';

class Sidang extends MY_Controller 
{
    function Sidang() 
    {
        parent::MY_Controller();
        $this->load->library('lib_user');
        $this->load->library('lib_js');
        $this->load->library('pquery');
        $this->load->model('msidang');
        $this->load->model('mproposal');
        $this->load->model('mslot');        
    }

    function index() 
    {
        $this->sidangProposal();
    }
    
    function filterKBK() 
    {
        if(strtolower($this->uri->segment(2)) == 'filterkbk')
        {
            $this->lib_alert->warning("Halaman tidak ditemukan!");
            redirect('error/index');  
        }
        
        $id_kbk = $this->filter("filter_kbk");
        if($id_kbk == "-1") 
        {
            $id_kbk = "1";
            $this->session->set_userdata('filter_kbk', $id_kbk);
        }
        return $id_kbk;
    }
    
    function sidangProposal() 
    {
        $data['title'] = "Sidang Proposal Tugas Akhir";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['content'] = "sidang/content-sidangProposal";
        
        $arr_kbk['KBJ'] = 1;
        $arr_kbk['KCV'] = 2;
        $arr_kbk['RPL'] = 3;
        $arr_kbk['AJK'] = 4;
        $arr_kbk['MI'] = 5;
        $arr_kbk['DTK'] = 6;
        $arr_kbk['AP'] = 7;
        $arr_kbk['IGS'] = 8;

        if($this->lib_user->is_admin_kbk() == true) 
        {
            $id_kbk = $arr_kbk[$this->session->userdata('type')];
            $daftar_kbk = $this->mdosen->listKBK("", $id_kbk);
            $this->session->set_userdata('kbk', $id_kbk);
        } 
        else 
        {
            $id_kbk = $this->filterKBK();
            $daftar_kbk = $this->mdosen->listKBK();
            // array_pop($daftar_kbk); // hapus array urutan pertama
        }
        
		if($this->input->post('sid_prop')!='')
		{
			$id_sidprop = $this->input->post('sid_prop');
		}
		else
		{
			$id_sidprop = $this->uri->segment(3, $this->msidang->getIDSidPropTerbaru($id_kbk));
		}

        // jika belum pernah ada sidang proposal
        if($id_sidprop != '') 
        {
            if($this->input->post('kbk')) 
            {
                if($this->input->post('sid_prop') != $this->input->post('current_sid_prop'))
                    $id_sidprop = $this->input->post('sid_prop');
                redirect("sidang/sidangProposal/$id_sidprop");
            }
            if(! $this->msidang->cekSidangProposal($id_sidprop)) 
            {
                $this->lib_alert->warning("Data sidang proposal tidak ditemukan");
                redirect('error/index');
            }
            // list TA yang maju sidang proposal
            $tgl_sidprop = $this->msidang->fieldSidangProp("WAKTU", $id_sidprop);
            $data['listTA'] = $this->msidang->getListProposalMajuSidangProp_Darurat($id_kbk, $id_sidprop, "", "", $tgl_sidprop);
            // set id sidprop saat ini
            $data['current_sid_prop'] = $id_sidprop;
            // daftar status
            $data['status'] = $this->lib_tugas_akhir->list_status(array('1','11','12','13'));
        }

        $data['kbk'] = $daftar_kbk;
        // set daftar sidprop
        $data['sid_prop'] = $this->msidang->jadwalSidangProposal($id_kbk, 1);
        
        
        $data['id_sidprop'] = $this->input->post('sid_prop');
        $data['id_kbk'] = $id_kbk;
        
        $this->load->view('template', $data);
    }

    function pendaftaranSidangProposal() 
    {
        if($this->lib_user->is_admin() == true || $this->lib_user->is_admin_kbk() == true) 
        {}
        else
        {
            $this->lib_alert->error("Halaman ini hanya bisa dilihat oleh Administrator atau Administrator KBK");
            redirect ("error/index");
        }
        
        $data['title'] = "Pendaftaran Maju Sidang Proposal";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['content'] = "sidang/content-pendaftaranSidangProposal";
        
        $arr_kbk['KBJ'] = 1;
        $arr_kbk['KCV'] = 2;
        $arr_kbk['RPL'] = 3;
        $arr_kbk['AJK'] = 4;
        $arr_kbk['MI'] = 5;
        $arr_kbk['DTK'] = 6;
        $arr_kbk['AP'] = 7;
        $arr_kbk['IGS'] = 8;

        if($this->lib_user->is_admin_kbk() == true) 
        {
            $id_kbk = $arr_kbk[$this->session->userdata('type')];
            $daftar_kbk = $this->mdosen->listKBK("", $id_kbk);
            $this->session->set_userdata('kbk', $id_kbk);
        } 
        else 
        {
            $id_kbk = $this->filterKBK();
            $daftar_kbk = $this->mdosen->listKBK();
            //array_pop($daftar_kbk); // hapus array urutan pertama
        }
        
        // list TA yang akan maju sidang proposal
        $data['listTA'] = $this->msidang->getListProposalMajuSidangProp($id_kbk);
        $data['status'] = $this->lib_tugas_akhir->list_status(array('1','11','12','13'));
        $data['kbk'] = $daftar_kbk;
        $data['sid_prop'] = $this->msidang->jadwalSidangProposal($id_kbk, 1);
        $this->load->view('template', $data);
    }

    function daftarSidangProposal($id_proposal="", $id_sidprop='') 
    {
        if($this->lib_user->is_admin() == true || $this->lib_user->is_admin_kbk() == true)
        {
            if($this->mproposal->cek($id_proposal)) 
            {
                if($this->msidang->cekSidangProposal($id_sidprop)) 
                {
                    $data = array(
                        'STATUS' => '1',
                        'SPROP' => $id_sidprop
                    );
                    $this->mproposal->update($data, $id_proposal);
                    // tampilkan icon penanda update sukses
                    echo " &nbsp; <img src='".base_url()."assets/images/updated.png'>";
                } 
                else 
                {
                    echo " &nbsp; <img src='".base_url()."assets/images/failed.png'>";
                }
            } 
            else 
            {
                echo " &nbsp; <img src='".base_url()."assets/images/failed.png'>";
            }
        } 
        else 
        {
            echo " &nbsp; <img src='".base_url()."assets/images/failed.png'>";
        }
    }
    
    // pengubahan Status Proposal



    function ubahStatusProposal($id_proposal="", $status='') 
    {
        if($this->lib_user->is_admin() == true || $this->lib_user->is_admin_kbk() == true)
        {
            if($this->mproposal->cek($id_proposal)) 
            {
                if($this->lib_tugas_akhir->is_status($status)) 
                {
                    $data = array(
                        'STATUS' => $status,
                        'TGL_SIDANG_PROP' => date("Y-m-d")
                    );
                    $this->mproposal->update($data, $id_proposal);
                    
                    echo " &nbsp; <img src='".base_url()."assets/images/updated.png'>";
                    // tampilkan icon penanda update sukses
                    /*
                    if($status!='11')
                        echo " &nbsp; <img src='".base_url()."assets/images/updated.png'>";
                    else
                        redirect(base_url().'index.php/sidang/sidangProposal');
                     * 
                     */
                } 
                else 
                {
                    echo " &nbsp; <img src='".base_url()."assets/images/failed.png'>";
                }
            } 
            else 
            {
                echo " &nbsp; <img src='".base_url()."assets/images/failed.png'>";
            }
        } 
        else 
        {
            echo " &nbsp; <img src='".base_url()."assets/images/failed.png'>";
        }
    }

    function previewProposal($id_proposal="") 
    {
        $this->mproposal->cek($id_proposal, true);
        
        if($this->lib_user->is_admin() == true || $this->lib_user->is_admin_kbk() == true || $this->lib_user->is_dosen() == true)
                $data['proposal']=$this->mproposal->getProposalFiles($id_proposal);
        
        $data['detailTA'] = $this->mproposal->getDetail($id_proposal);
        $data['content'] = 'sidang/content-previewProposal';
        $this->load->view('tb_template', $data);
    }
	
    function jadwalSidangProposal() 
    {
        if($this->lib_user->is_admin() == true || $this->lib_user->is_admin_kbk() == true) 
        {}
        else
        {
            $this->lib_alert->error("Halaman ini hanya bisa dilihat oleh Administrator atau Administrator KBK");
            redirect ("error/index");
        }
        
        $data['title'] = "Penjadwalan Sidang Proposal Tugas Akhir";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['content'] = "sidang/content-jadwalSidangProposal";
        
        $arr_kbk['KBJ'] = 1;
        $arr_kbk['KCV'] = 2;
        $arr_kbk['RPL'] = 3;
        $arr_kbk['AJK'] = 4;
        $arr_kbk['MI'] = 5;
        $arr_kbk['DTK'] = 6;
        $arr_kbk['AP'] = 7;
        $arr_kbk['IGS'] = 8;

        if($this->lib_user->is_admin_kbk() == true) 
        {
            $id_kbk = $arr_kbk[$this->session->userdata('type')];
            $daftar_kbk = $this->mdosen->listKBK("", $id_kbk);
            $this->session->set_userdata('kbk', $id_kbk);
        } 
        else 
        {
            $id_kbk = $this->filterKBK();
            $daftar_kbk = $this->mdosen->listKBK();
            //array_pop($daftar_kbk); // hapus array urutan pertama
            $this->session->set_userdata('kbk', $id_kbk);
        }

        $data['kbk'] = $daftar_kbk;
        $data['sid_prop'] = $this->msidang->jadwalSidangProposal($id_kbk);
        $this->load->view('template', $data);
    }

    function jadwalSidangProposalAjaxRequest($id_kbk='', $id_new_sidprop="") 
    {
        if($this->lib_user->is_admin() == true || $this->lib_user->is_admin_kbk() == true) 
        {}
        else
        {
            $this->lib_alert->error("Halaman ini hanya bisa dilihat oleh Administrator atau Administrator KBK");
            redirect ("error/index/".true);
        }
        
        $this->mdosen->cekKBK($id_kbk,true);
        
        $data['id_new_sidprop'] =$id_new_sidprop;
        $data['sid_prop'] = $this->msidang->jadwalSidangProposal($id_kbk);
        $this->load->view('sidang/jadwalSidangProposal', $data);
    }

    function aktivasiSidangProposal($id_sidprop='') {
        if($this->lib_user->is_admin() == true || $this->lib_user->is_admin_kbk() == true)
        {
            if ($this->msidang->cekSidangProposal($id_sidprop)) 
            {
                $waktu_entri = date("Y-m-d")." ".date("H:i:s");
                // update AKTIF/TIDAK
                $this->msidang->updateStatusSidangProposal($id_sidprop, $waktu_entri);
                echo "<div class='success'>Sidang proposal pada tanggal ".$this->msidang->fieldSidangProp("WAKTU", $id_sidprop)." telah diaktifkan/dinonaktifkan.</div>";
            } 
            else 
            {
                echo "<div class='error'>Sidang proposal pada tanggal ".$this->msidang->fieldSidangProp("WAKTU", $id_sidprop)." gagal diaktifkan/dinonaktifkan. Data sidang proposal tidak ditemukan.</div>";
            }
        } 
        else 
        {
            echo "<div class='error'>Sidang proposal pada tanggal ".$this->msidang->fieldSidangProp("WAKTU", $id_sidprop)." gagal diaktifkan/dinonaktifkan. Waktu session login anda telah habis.</div>";
        }
    }

    function updateWaktuSidangProposal($id_sidprop='', $waktu='') 
    {
        if($this->lib_user->is_admin() == true || $this->lib_user->is_admin_kbk() == true)
        {
            if($this->msidang->cekSidangProposal($id_sidprop) && $waktu != "") 
            {
                $waktu_entri = date("Y-m-d")." ".date("H:i:s");
                $data_update_sidprop = array(
                    'WAKTU_SIDANG_PROP' => $waktu_entri,
                    'WAKTU' => $this->db->escape_like_str($waktu)
                );
                // update data ke Database
                $this->msidang->updateSidangProposal($data_update_sidprop, $id_sidprop);
                echo "<div class='success'>Waktu sidang proposal dengan ID $id_sidprop telah diganti menjadi tanggal $waktu</div>";
            } else {
                echo "<div class='error'>Waktu sidang proposal dengan ID $id_sidprop tidak bisa diganti. Data sidang proposal/waktu tidak valid/kosong.</div>";
            }
        } 
        else 
        {
            echo "<div class='error'>Waktu sidang proposal dengan ID $id_sidprop tidak bisa diganti. Waktu session login anda telah habis.</div>";
        }
    }

    function updateKeteranganSidangProposal($id_sidprop='', $keterangan='') 
    {
        if($this->lib_user->is_admin() == true || $this->lib_user->is_admin_kbk() == true)
        {
            if($this->msidang->cekSidangProposal($id_sidprop) && $keterangan != "") 
            {
                $waktu_entri = date("Y-m-d")." ".date("H:i:s");
                $data_update_sidprop = array(
                    'WAKTU_SIDANG_PROP' => $waktu_entri,
                    'KET_SIDANG_PROP' => $this->db->escape_like_str($keterangan)
                );
                // update data ke Database
                $this->msidang->updateSidangProposal($data_update_sidprop, $id_sidprop);
                echo "<div class='success'>Keterangan sidang proposal dengan ID $id_sidprop berhasil diupdate</div>";
            } 
            else 
            {
                echo "<div class='error'>Keterangan sidang proposal dengan ID $id_sidprop gagal diupdate. Data sidang proposal/keterangan tidak valid/kosong.</div>";
            }
        } 
        else 
        {
            echo "<div class='error'>Keterangan sidang proposal dengan ID $id_sidprop gagal diupdate. Waktu session login anda telah habis.</div>";
        }
    }
	
    function entryRevisiProposal($id_proposal)
    {
        $data['id_proposal'] = $id_proposal;
        $data['revisi'] = $this->mproposal->getRevisiProposal($id_proposal);
        $this->load->view('sidang/entryRevisiProposal',$data);
    }

    function updateRevisiProposal()
    {
        $revisi = $this->input->post('revisi');
        $id_proposal = $this->input->post('id_proposal');
        $this->mproposal->updateRevisiProposal($id_proposal,$revisi);
    }

    // tambah SidProp
    function entrySidangProposal() 
    {
        if($this->lib_user->is_admin() == true || $this->lib_user->is_admin_kbk() == true) 
        {}
        else
        {
            $this->lib_alert->error("Halaman ini hanya bisa dilihat oleh Administrator atau Administrator KBK");
            redirect ("error/index/".true);
        }
        
        $arr_kbk['KBJ'] = 1;
        $arr_kbk['KCV'] = 2;
        $arr_kbk['RPL'] = 3;
        $arr_kbk['AJK'] = 4;
        $arr_kbk['MI'] = 5;
        $arr_kbk['DTK'] = 6;
        $arr_kbk['AP'] = 7;
        $arr_kbk['IGS'] = 8;
        
        if($this->lib_user->is_admin_kbk() == true) 
        {
            
            $id_kbk = $arr_kbk[$this->session->userdata('type')];
            $this->session->set_userdata('kbk', $id_kbk);
        } 
        else 
        {
            $id_kbk = $this->session->userdata('kbk');
        }
        
        $this->form_validation->set_rules('waktu', 'waktu sidang proposal', 'required');
        $this->form_validation->set_error_delimiters('<div class="warning">', '</div>');
        if ($this->form_validation->run()) 
        {
            $waktu_entri = date("Y-m-d")." ".date("H:i:s");
			$bidang_minat = $this->mdosen->detailKBK($id_kbk);
            if ($this->input->post('keterangan')=="")
                $keterangan = "Sidang Proposal ".$bidang_minat->NAMA_KBK." ".$this->db->escape_like_str($this->input->post('waktu'));
            else
                $keterangan = $this->db->escape_like_str($this->input->post('keterangan'));
            $data_sidprop = array(
                'WAKTU_SIDANG_PROP' => $waktu_entri,
                'ID_KBK' => $this->db->escape_like_str($id_kbk),
                'WAKTU' => $this->db->escape_like_str($this->input->post('waktu')),
                'KET_SIDANG_PROP' => $keterangan,
                'STATUS_SIDANG_PROP' => '0'
            );
            // tambahkan data ke Database
            $this->msidang->addSidangProposal($data_sidprop);
            $this->lib_alert->success("Jadwal sidang proposal baru pada tanggal ".$this->input->post('waktu')." telah disimpan");
            redirect("sidang/jadwalSidangProposalAjaxRequest/".$id_kbk."/".$this->msidang->getLastIDSidangProp());
        } 
        else 
        {
            $data['sid_prop'] = $this->msidang->jadwalSidangProposal($this->session->userdata('kbk'));
            $this->load->view('sidang/jadwalSidangProposal', $data);
        }
    }
	
    // hapus SidProp
    function hapusSidangProposal($id_sidprop="") {
        if($this->lib_user->is_admin() == true || $this->lib_user->is_admin_kbk() == true) 
        {}
        else
        {
            $this->lib_alert->error("Halaman ini hanya bisa dilihat oleh Administrator atau Administrator KBK");
            redirect ("error/index/".true);
        }
        
        if($this->msidang->cekSidangProposal($id_sidprop) == false) 
        {
            $this->lib_alert->error("Sidang proposal tidak ditemukan!");
        } 
        else 
        {
            $id_kbk = $this->session->userdata("filter_kbk");
            $tgl = $this->msidang->fieldSidangProp("WAKTU", $id_sidprop);
            $jml_peserta_sidprop = count($this->msidang->getListProposalMajuSidangProp_Darurat($id_kbk, $id_sidprop, "", "", $tgl));
            if($jml_peserta_sidprop > 0)
            {
                $this->lib_alert->error("Jadwal sidang proposal pada tanggal ".$tgl." tidak bisa dihapus karena sudah dipakai.");
            }
            else 
            {
                $this->msidang->hapusSidangProposal($id_sidprop);
                $this->lib_alert->success("Jadwal sidang proposal pada tanggal ".$tgl." telah dihapus");
            }
        }
        redirect("sidang/jadwalSidangProposalAjaxRequest/".$id_kbk);
    }
	
    function jadwalSidangTA() 
    {
        $this->lib_user->cek_admin();
        
        $bulan = date('n');
        $tahun = date('Y');
        if($bulan >= 8 && $bulan <= 12) {
            $semester = 'Ganjil';
            $tahun_ajaran = $tahun."/".($tahun+1);
        } elseif($bulan == 1) {
            $semester = 'Ganjil';
            $tahun_ajaran = ($tahun-1)."/".$tahun;
        } else {
            $semester = 'Genap';
            $tahun_ajaran = ($tahun-1)."/".$tahun;
        }
        if(! $this->msidang->cekSidangTA(array("SEMESTER_SIDANG_TA" => $semester, "TAHUN_SIDANG_TA" => $tahun_ajaran))) 
        {
            $data['semester'] = $semester;
            $data['tahun_ajaran'] = $tahun_ajaran;
        }
        // jadwal sidTA
        $data['sid_ta'] = $this->msidang->jadwalSidangTA();
        // set page information
        $data['title'] = "Penjadwalan Jadwal Sidang TA";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['content'] = "sidang/content-jadwalSidangTA";
		
        $this->load->view('template', $data);
    }

    function jadwalSidangTAAjaxRequest($id_new_sidTA="") 
    {
        $this->lib_user->cek_admin(true);
        
        $bulan = date('n');
        $tahun = date('Y');
        if($bulan >= 8 && $bulan <= 12) {
            $semester = 'Ganjil';
            $tahun_ajaran = $tahun."/".($tahun+1);
        } elseif($bulan == 1) {
            $semester = 'Ganjil';
            $tahun_ajaran = ($tahun-1)."/".$tahun;
        } else {
            $semester = 'Genap';
            $tahun_ajaran = ($tahun-1)."/".$tahun;
        }
        if(! $this->msidang->cekSidangTA(array("SEMESTER_SIDANG_TA" => $semester, "TAHUN_SIDANG_TA" => $tahun_ajaran))) 
        {
            $data['semester'] = $semester;
            $data['tahun_ajaran'] = $tahun_ajaran;
        }

        $data['id_new_sidTA'] = $id_new_sidTA;
        // jadwal sidTA
        $data['sid_ta'] = $this->msidang->jadwalSidangTA();
        $this->load->view('sidang/jadwalSidangTA', $data);
    }

    function aktivasiSidangTA($id_sidangTA='') {
        // jika login admin
        if($this->lib_user->is_admin() == true) 
        {
            if($this->msidang->cekSidangTA($id_sidangTA)) 
            {
                $this->msidang->updateStatusSidangTA('0');
                $waktu_entri = date("Y-m-d")." ".date("H:i:s");
                $data_update_status_sidTA = array(
                    'WAKTU_SIDANG_TA' => $waktu_entri,
                    'STATUS_SIDANG_TA' => '1'
                );
                // tambahkan data ke Database
                $this->msidang->updateSidangTA($data_update_status_sidTA, $id_sidangTA);
                echo "<div class='success'>Sidang TA periode semester ".$this->msidang->periodeSidangTA($id_sidangTA)." telah diaktifkan.</div>";
            } 
            else 
            {
                echo "<div class='error'>Sidang TA periode semester ".$this->msidang->periodeSidangTA($id_sidangTA)." gagal diaktifkan. Data sidang TA tidak ditemukan.</div>";
            }
        } 
        else 
        {
            echo "<div class='error'>Sidang TA periode semester ".$this->msidang->periodeSidangTA($id_sidangTA)." gagal diaktifkan. Waktu session login anda telah habis.</div>";
        }
    }

    function updateKeteranganSidangTA($id_sidangTA='', $keterangan='') {
        // jika login admin
        if($this->lib_user->is_admin() == true) 
        {
            if($keterangan != "" && $this->msidang->cekSidangTA($id_sidangTA)) 
            {
                $waktu_entri = date("Y-m-d")." ".date("H:i:s");
                $data_update_sidprop = array(
                    'WAKTU_SIDANG_TA' => $waktu_entri,
                    'KET_SIDANG_TA' => $this->db->escape_like_str($keterangan)
                );
                // tambahkan data ke Database
                $this->msidang->updateSidangTA($data_update_sidprop, $id_sidangTA);
                echo "<div class='success'>Keterangan sidang TA periode semester ".$this->msidang->periodeSidangTA($id_sidangTA)." telah diupdate.</div>";
            }
            else 
            {
                echo "<div class='error'>Keterangan sidang TA periode semester ".$this->msidang->periodeSidangTA($id_sidangTA)." gagal diupdate. Data sidang TA/keterangan tidak valid/kosong.</div>";
            }
        } 
        else 
        {
            echo "<div class='error'>Keterangan sidang TA periode semester ".$this->msidang->periodeSidangTA($id_sidangTA)." gagal diupdate. Waktu session login anda telah habis.</div>";
        }
    }
	
    function entrySidangTA() 
    {
        $this->lib_user->cek_admin(true);
        
        $bulan = date('n');
        $tahun = date('Y');
        if($bulan >= 8 && $bulan <= 12) {
            $semester = 'Ganjil';
            $tahun_ajaran = $tahun."/".($tahun+1);
        } elseif($bulan == 1) {
            $semester = 'Ganjil';
            $tahun_ajaran = ($tahun-1)."/".$tahun;
        } else {
            $semester = 'Genap';
            $tahun_ajaran = ($tahun-1)."/".$tahun;
        }
        
        if($this->input->post('semester') == $semester && $this->input->post('tahunajaran') == $tahun_ajaran) {
            if(! $this->msidang->cekSidangTA(array("SEMESTER_SIDANG_TA" => $semester, "TAHUN_SIDANG_TA" => $tahun_ajaran))) {
                $waktu_entri = date("Y-m-d")." ".date("H:i:s");
                $data_sidTA = array(
                    'WAKTU_SIDANG_TA' => $waktu_entri,
                    'SEMESTER_SIDANG_TA' => $this->db->escape_like_str($this->input->post('semester')),
                    'TAHUN_SIDANG_TA' => $this->db->escape_like_str($this->input->post('tahunajaran')),
                    'KET_SIDANG_TA' => $this->db->escape_like_str($this->input->post('keterangan')),
                    'STATUS_SIDANG_TA' => '0'
                );
                // tambahkan data ke Database
                $this->msidang->addSidangTA($data_sidTA);
                $this->lib_alert->success("Jadwal sidang TA baru periode semester ".$this->input->post('semester')." ".$this->input->post('tahunajaran')." telah disimpan");
                redirect("sidang/jadwalSidangTAAjaxRequest/".$this->msidang->getLastIDSidangTA());
            } else {
                $this->lib_alert->error("Jadwal sidang TA baru gagal disimpan karena jadwal sidang TA semester $semester $tahun_ajaran telah terdaftar");
                redirect("sidang/jadwalSidangTAAjaxRequest");
            }
        } else {
            $this->lib_alert->warning("Ada kesalahan pada input data semester/tahun ajaran");
            redirect("sidang/jadwalSidangTAAjaxRequest");
        }
    }
	
    function hapusSidangTA($id_sidTA="") {
        $this->lib_user->cek_admin(true);
        
        if(! $this->msidang->cekSidangTA($id_sidTA)) 
        {
            $this->lib_alert->error("Sidang TA tidak ditemukan!.");
        } 
        else 
        {
            $periode = $this->msidang->periodeSidangTA($id_sidTA);
            if($this->mslot->cekSlot(array("SIDANGTA" => $id_sidTA))) {
                $this->lib_alert->error("Gagal menghapus data sidang TA periode $periode. Mungkin data sidang TA masih berisi jadwal slot hari/waktu.");
            } else {
                // hapus sidang TA
                $this->msidang->hapusSidangTA($id_sidTA);
                $this->lib_alert->success("Jadwal sidang TA periode $periode telah dihapus");
            }
        }
        redirect("sidang/jadwalSidangTAAjaxRequest");
    }
}

?>
