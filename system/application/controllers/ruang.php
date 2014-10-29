<?php
class Ruang extends Controller 
{
    
    function Ruang() 
    {
        parent::Controller();
        $this->load->library('lib_alert');
        $this->load->library('lib_user');
        $this->load->library('lib_js');
        $this->load->library('pquery');
        $this->load->model('msidang');
        $this->load->model('mdosen');
        $this->load->model('mruang');
        $this->load->model('mslot');
        $this->load->model('mjadwalruangavail');
    }

    function index() 
    {
        $this->ruangSidang();
    }

    function filterSidangTA($id_sidangTA="") 
    {
        if(strtolower($this->uri->segment(2)) == 'filtersidangta')
        {
            $this->lib_alert->warning("Halaman tidak ditemukan!");
            redirect('error/index'); 
        }
        
        // get ID Sidang TA from POST method 
        if($this->input->post('sidangTA') != '') 
        {
            $id_sidangTA = $this->input->post('sidangTA');
            redirect("ruang/ruangSidang/$id_sidangTA");
        }
        // cek valid/tidak
        if($this->msidang->cekSidangTA($id_sidangTA) == false)
            $id_sidangTA = $this->msidang->getIDSidangTAAktif();
        return $id_sidangTA;
    }

    function ruangSidang($id_sidangTA="") 
    {
        $this->lib_user->cek_admin();
        
        $id_sidangTA = $this->filterSidangTA($id_sidangTA);
        
        $data['title'] = "Ruang Sidang TA";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['leftSide'] = 'leftSide';
        $data['content'] = "ruang/content-ruangSidang";
        $data['list_sidangTA'] = $this->msidang->jadwalSidangTA();
        $data['ruang_sidang'] = $this->mruang->getList($id_sidangTA);
        $data['id_sidangTA'] = $id_sidangTA;
        $this->load->view('template', $data);
    }

    function ruangSidangAjaxRequest($id_sidangTA="", $id_ruang_baru="") 
    {
        $this->lib_user->cek_admin(true);
        
        $this->msidang->cekSidangTA($id_sidangTA, true);
        $this->mruang->cek($id_ruang_baru, true);

        $data['id_ruang_baru'] = $id_ruang_baru;
        $data['ruang_sidang'] = $this->mruang->getList($id_sidangTA);
        $data['id_sidangTA'] = $id_sidangTA;
        $this->load->view('ruang/ruangSidang', $data);
    }

    function entryRuangSidang($id_sidangTA="") 
    {
        $this->lib_user->cek_admin(true);
        $this->msidang->cekSidangTA($id_sidangTA, true);

        $this->form_validation->set_rules('ruang_sidang', 'nama ruang sidang TA', 'trim|required|max_length[200]|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="warning">', '</div>');
        if ($this->form_validation->run()) 
        {
            $id_jdw_ruang = 1;
            $cek = $id_sidangTA;
            while ($id_jdw_ruang==1)
            {
                $id_jdw_ruang = $this->mruang->getNewID($cek);
                $cek--;
            }
            
            $data_entry_ruangsidang = array(
                'ID_JDW_RUANG' => $id_jdw_ruang,
                'DESKRIPSI' => $this->db->escape_like_str($this->input->post('ruang_sidang')),
                'SIDANGTA' => $this->db->escape_like_str($id_sidangTA)
            );
            $this->mruang->add($data_entry_ruangsidang);
            $this->setSemuaSlotAvailable($id_sidangTA, $id_jdw_ruang);
            $this->setDefaultRuangKBKAssignment($id_sidangTA, $id_jdw_ruang, "0");
            $this->lib_alert->success("Penambahan ruangan berhasil");
            redirect("ruang/ruangSidangAjaxRequest/$id_sidangTA/".$id_jdw_ruang);
        } 
        else 
        {
            // view ruang sidang
            $data['ruang_sidang'] = $this->mruang->getList($id_sidangTA);
            $data['id_sidangTA'] = $id_sidangTA;
            $this->load->view('ruang/ruangSidang', $data);
        }
    }
    
    function updateRuangSidang($id_sidangTA='', $id_jdw_ruang='', $nama_ruang='') 
    {
        if($this->lib_user->is_admin() == true || $this->lib_user->is_admin_kbk() == true)
        {
            if($this->mruang->cek($id_jdw_ruang) && $nama_ruang != "") 
            {
                $data_ruang = array(
                    'DESKRIPSI' => $this->db->escape_like_str($nama_ruang)
                );
                // update data ke Database
                $this->mruang->update($data_ruang, $id_jdw_ruang);
                $this->setSemuaSlotAvailable($id_sidangTA, $id_jdw_ruang);
                $this->setDefaultRuangKBKAssignment($id_sidangTA, $id_jdw_ruang, "0");
                echo "<div class='success'>Update ruang sidang <strong>'$nama_ruang'</strong> berhasil</div>";
            } 
            else 
            {
                echo "<div class='warning'>Nama ruang sidang tidak boleh kosong.</div>";
            }
        } 
        else 
        {
            echo "<div class='error'>Waktu session login anda telah habis.</div>";
        }
    }
    
    function updateRuangDanSlot($id_sidangTA='', $id_jdw_ruang='') 
    {
        if($this->lib_user->is_admin() == true || $this->lib_user->is_admin_kbk() == true)
        {
            if($this->mruang->cek($id_jdw_ruang)) 
            {
                $this->setSemuaSlotAvailable($id_sidangTA, $id_jdw_ruang);
                $this->setDefaultRuangKBKAssignment($id_sidangTA, $id_jdw_ruang, "0");
                $nama_ruang = $this->mruang->field("DESKRIPSI");
                echo "<div class='success'>Update ruang dan slot <strong>'$nama_ruang'</strong> berhasil</div>";
            } 
            else 
            {
                echo "<div class='warning'>Ruang sidang tidak ditemukan</div>";
            }
        } 
        else 
        {
            echo "<div class='error'>Waktu session login anda telah habis.</div>";
        }
    }
    
    function hapusRuangSidang($id_sidangTA="", $id_jdw_ruang="") {
        $this->lib_user->cek_admin(true);
        
        // cek id sidang TA, ruang
        $this->msidang->cekSidangTA($id_sidangTA, true);
        $this->mruang->cek($id_jdw_ruang, true);

        // cek apakah slot sudah dipakai oleh ruangan
        if($this->mjadwalruangavail->cek(array("SIDANGTA"=>$id_sidangTA, "ID_JDW_RUANG"=>$id_jdw_ruang, "STATUS"=>2)))
        {
            $this->lib_alert->error('Gagal menghapus ruang sidang karena ruang telah digunakan.');
            redirect("ruang/ruangSidangAjaxRequest/$id_sidangTA");
        }

        $this->mjadwalruangavail->hapusJadwalRuangAvail(array("SIDANGTA"=>$id_sidangTA, "ID_JDW_RUANG"=>$id_jdw_ruang, "STATUS"=>'0'));
        // hapus ruang dr database
        $this->mruang->hapus($id_jdw_ruang);

        $this->lib_alert->success("Ruang sidang berhasil dihapus.");
        redirect("ruang/ruangSidangAjaxRequest/$id_sidangTA");
    }
    
    function setSemuaSlotAvailable($id_sidangTA="", $id_jdw_ruang="")
    {
        $this->lib_user->cek_admin();
        
        $this->msidang->cekSidangTA($id_sidangTA, false);
        $this->mruang->cek($id_jdw_ruang, false);

        $slot = $this->mslot->getListSlot($id_sidangTA);

        foreach ($slot as $row) {
            if(strlen($row->TREEID)==6) {
                $data_jadwal_baru = array(
                    'ID_JDW_RUANG' => $id_jdw_ruang,
                    'ID_SLOT' => $row->TREEID,
                    'SIDANGTA' => $id_sidangTA // default STATUS 0
                );
                if($this->mjadwalruangavail->cek($data_jadwal_baru) == false)
                    $this->mjadwalruangavail->addJadwalRuangAvail($data_jadwal_baru);
            }
        }
    }
    
    function setDefaultRuangKBKAssignment($id_sidangTA="", $id_jdw_ruang="", $id_kbk="0") {
        $this->lib_user->cek_admin();
        
        $this->msidang->cekSidangTA($id_sidangTA, false);
        $this->mdosen->cekKBK($id_kbk, false);
        $this->mruang->cek($id_jdw_ruang, false);
        
        $data_update_jadwal = array(
            'ID_KBK' => $id_kbk
        );
        
        $this->mjadwalruangavail->updateJadwalRuangAvailBySidangDanRuang($data_update_jadwal, $id_sidangTA, $id_jdw_ruang);
    }
}
?>