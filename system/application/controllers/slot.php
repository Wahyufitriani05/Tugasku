<?php
class Slot extends Controller 
{
    
    function Slot() 
    {
        parent::Controller();
        $this->load->library('lib_tugas_akhir');
        $this->load->library('lib_alert');
        $this->load->library('lib_js');
        $this->load->library('lib_user');
        $this->load->library('pquery');
        $this->load->model('mslot');
        $this->load->model('msidang');      
        $this->load->model('mruang');   
        $this->load->model('mdosen');
        $this->load->model('mjadwalruangavail');   
        $this->load->model('mjadwaldosenavail');
    }

    function index() 
    {
        $this->slotHari();
    }

    function filterSidangTA($id_sidangTA="") 
    {
        if(strtolower($this->uri->segment(2)) == 'filtersidangta')
        {
            $this->lib_alert->warning("Halaman tidak ditemukan!");
            redirect('error/index');  
        }
        
        if($this->input->post('sidangTA') != '') 
        {
            $id_sidangTA = $this->input->post('sidangTA');
            redirect("slot/slotHari/$id_sidangTA");
        }
        if(! $this->msidang->cekSidangTA($id_sidangTA)) 
        {
            $id_sidangTA = $this->msidang->getIDSidangTAAktif();
        }
        return $id_sidangTA;
    }

    function slotHari($id_sidangTA="", $id_new_slot="") 
    {
        $this->lib_user->cek_admin(); 
        
        $id_sidangTA = $this->filterSidangTA($id_sidangTA);
        
        $data['title'] = "Penjadwalan Slot Hari Sidang TA";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['content'] = "slot/content-slotHari";
        $data['list_sidangTA'] = $this->msidang->jadwalSidangTA();
        $data['slot_hari'] = $this->mslot->getListSlotHari($id_sidangTA);
        $data['parent_treeid'] = '00';
        $data['id_sidangTA'] = $id_sidangTA;
        $data['id_new_slot'] = $id_new_slot;
        $this->load->view('template', $data);
    }

    function entrySlotHari($id_sidangTA="", $parent_treeid="") {
        $this->lib_user->cek_admin(true);
        
        $this->msidang->cekSidangTA($id_sidangTA, true);
        $this->mslot->cekTreeID($parent_treeid, true);

        $this->form_validation->set_rules('tgl', 'tanggal sidang TA', 'required');
        $this->form_validation->set_error_delimiters('<div class="warning">', '</div>');
        if ($this->form_validation->run()) 
        {
            $arr_tgl = explode("-", $this->input->post('tgl'), 3);
            $tgl_deskripsi = date('j F Y', mktime(0,0,0,$arr_tgl[1],$arr_tgl[2],$arr_tgl[0]));
            $new_treeid = $this->mslot->newTreeID($id_sidangTA, $parent_treeid);
            $data_entry_slothari = array(
                'ID_SLOT' => $this->mslot->newIDSlot(),
                'TREEID' => $new_treeid,
                'DESKRIPSI' => $tgl_deskripsi,
                'SIDANGTA' => $this->db->escape_like_str($id_sidangTA),
                'ID_KBK' => '0',
                'TGL' => $this->db->escape_like_str($this->input->post('tgl'))
            );
            // tambahkan data ke Database
            $this->mslot->add($data_entry_slothari);
            $this->lib_alert->success("Penambahan slot hari pada tanggal ".$this->db->escape_like_str($this->input->post('tgl'))." berhasil");
            redirect("slot/slotHari/$id_sidangTA/".$this->mslot->getLastIDSlot($id_sidangTA, $new_treeid));
        } 
        else 
        {
            $data['title'] = "Penjadwalan Slot Hari Sidang TA";
            $data['js_menu'] = $this->lib_user->get_javascript_menu();
            $data['header'] = $this->lib_user->get_header();
            $data['content'] = "slot/content-slotHari";
            $data['list_sidangTA'] = $this->msidang->jadwalSidangTA();
            $data['slot_hari'] = $this->mslot->getListSlotHari($id_sidangTA);
            $data['parent_treeid'] = '00';
            $data['id_sidangTA'] = $id_sidangTA;
            $this->load->view('template', $data);
        }
    }

    function updateTanggalSlotHari($id_slot="", $tgl="") {
        // jika login admin
        if($this->lib_user->is_admin()) {
            // -------- CEK INPUT ------------
            if($id_slot != "" && $tgl != "" && $this->mslot->cekSlot($id_slot)) {
                // set data untuk update
                $arr_tgl = explode("-", $tgl, 3);
                $tgl_deskripsi = date('j F Y', mktime(0,0,0,$arr_tgl[1],$arr_tgl[2],$arr_tgl[0]));
                $data_update_slothari = array(
                    'TGL' => $tgl,
                    'DESKRIPSI' => $tgl_deskripsi
                );
                // update data ke Database
                $this->mslot->update($data_update_slothari, $id_slot);
                echo "$tgl_deskripsi &nbsp; <img src='".base_url()."assets/images/updated.png'>";
            } else {
                echo "<span style='color:red'>Data slot hari/tanggal tidak valid/kosong.</span> &nbsp; <img src='".base_url()."assets/images/failed.png'>";
            }
        } else {
            echo "<span style='color:red'>Waktu session login anda telah habis.</span> &nbsp; <img src='".base_url()."assets/images/failed.png'>";
        }
    }

    function hapusSlotHari($id_sidangTA, $treeid, $id_slot) 
    {
        $this->lib_user->cek_admin(true);
        
        $this->msidang->cekSidangTA($id_sidangTA, true);
        
        if(! $this->mslot->cekTreeID($treeid) || ! $this->mslot->cekSlot($id_slot)) 
        {
            $this->lib_alert->error("Gagal menghapus slot hari. Slot tidak ditemukan, mungkin slot sudah dihapus.");
            redirect("slot/slotHari/$id_sidangTA");
        }
        $tgl = $this->mslot->field("TGL", $id_slot);
        // cek apakah slot masih punya child
        if($this->mslot->cekChild($id_sidangTA, $treeid)) 
        {
            $this->lib_alert->error("Gagal menghapus slot hari pada tanggal ".$tgl.". Mungkin slot hari tersebut masih memiliki slot waktu");
            redirect("slot/slotHari/$id_sidangTA");
        }

        // hapus slot dr database
        $this->mslot->hapus($id_slot);
        $this->lib_alert->success("Jadwal slot hari pada tanggal $tgl telah dihapus");
        redirect("slot/slotHari/$id_sidangTA");
    }

    function slotWaktu($id_sidangTA="", $parent_treeid="") 
    {
        $this->lib_user->cek_admin(true);
        
        $this->msidang->cekSidangTA($id_sidangTA, true);
        $this->mslot->cekTreeID($parent_treeid, true);

        // sbg parameter utk entry slot waktu
        $data['parent_treeid'] = $parent_treeid;
        $data['id_sidangTA'] = $id_sidangTA;
        // get slot waktu yg tersedia
        $data['slot_waktu'] = $this->mslot->getListSlotWaktu($id_sidangTA, $parent_treeid);
        $data['content'] = 'slot/content-slotWaktu';
        $this->load->view('tb_template', $data);
    }

    function slotWaktuAjaxRequest($id_sidangTA="", $parent_treeid="", $id_new_slot="") {
        $this->lib_user->cek_admin(true);
        
        $this->msidang->cekSidangTA($id_sidangTA, true);
        $this->mslot->cekTreeID($parent_treeid, true);

        $data['id_new_slot'] = $id_new_slot;
        // get slot hari yg tersedia
        $data['slot_waktu'] = $this->mslot->getListSlotWaktu($id_sidangTA, $parent_treeid);
        $data['parent_treeid'] = $parent_treeid;
        $data['id_sidangTA'] = $id_sidangTA;
        $this->load->view('slot/slotWaktu', $data);
    }

    function entrySlotWaktu($id_sidangTA="", $parent_treeid="") {
        $this->lib_user->cek_admin(true);
        
        $this->msidang->cekSidangTA($id_sidangTA, true);
        $this->mslot->cekTreeID($parent_treeid, true);

        $this->form_validation->set_rules('waktu', 'waktu slot', 'required');
        $this->form_validation->set_error_delimiters('<div class="warning">', '</div>');
        if ($this->form_validation->run()) {
            $arr_waktu = explode(":", $this->input->post('waktu'), 2);
            if(count($arr_waktu) < 2) {
                $batas_waktu = "";
            } else {
                $batas_waktu = $arr_waktu[0]+1 .":". $arr_waktu[1];

                $new_treeid = $this->mslot->newTreeID($id_sidangTA, $parent_treeid);
                $tgl = $this->mslot->getDetailSlot($id_sidangTA, $parent_treeid);
                $data_entry_slotwaktu = array(
                    'ID_SLOT' => $this->mslot->newIDSlot(),
                    'TREEID' => $new_treeid,
                    'TGL' => $tgl->TGL,
                    'WAKTU' => $this->db->escape_like_str($this->input->post('waktu')),
                    'DESKRIPSI' => $this->db->escape_like_str($this->input->post('waktu'))." - ".$batas_waktu,
                    'SIDANGTA' => $this->db->escape_like_str($id_sidangTA),
                    'ID_KBK' => '0'
                );
                // tambahkan data ke Database
                $this->mslot->add($data_entry_slotwaktu);
                $this->setSemuaRuangAvailable($id_sidangTA, $new_treeid);
                $this->setDefaultRuangKBKAssignment($id_sidangTA, $new_treeid, "0");
                $this->lib_alert->success("Penambahan slot waktu pada jam ".$this->input->post('waktu')." - $batas_waktu berhasil");
                redirect("slot/slotWaktuAjaxRequest/$id_sidangTA/$parent_treeid/".$this->mslot->getLastIDSlot($id_sidangTA, $new_treeid));
            }
        } else {
            // get slot hari yg tersedia
            $data['slot_waktu'] = $this->mslot->getListSlotWaktu($id_sidangTA, $parent_treeid);
            $data['parent_treeid'] = $parent_treeid;
            $data['id_sidangTA'] = $id_sidangTA;

            $this->load->view('slot/slotWaktu', $data);
        }
    }

    function updateSlotWaktu($id_slot="", $waktu="") {
        // jika login admin
        if($this->lib_user->is_admin()) {
            // -------- CEK INPUT ------------
            if($id_slot != "" && $waktu != "" && $this->mslot->cekSlot($id_slot)) {
                // set data untuk update
                $arr_waktu = explode(":", $waktu, 2);
                if(count($arr_waktu) < 2) {
                    $batas_waktu = "";
                } else {
                    $batas_waktu = $arr_waktu[0]+1 .":". $arr_waktu[1];
                }
                $slot_child = $this->mslot->getDetailSlot2($id_slot);
                $tgl = $this->mslot->getDetailSlot($slot_child->SIDANGTA, substr($slot_child->TREEID, 0, 4));
                $data_update_slotwaktu = array(
                    'WAKTU' => $waktu,
                    'TGL' => $tgl->TGL, 
                    'DESKRIPSI' => $this->db->escape_like_str($waktu)." - ".$batas_waktu
                );
                // update data ke Database
                $this->mslot->update($data_update_slotwaktu, $id_slot);
                $this->setSemuaRuangAvailable($slot_child->SIDANGTA, $slot_child->TREEID);
                $this->setDefaultRuangKBKAssignment($slot_child->SIDANGTA, $slot_child->TREEID, "0");
                echo "$waktu - $batas_waktu &nbsp; <img src='".base_url()."assets/images/updated.png'>";
            } else {
                echo "<span style='color:red'>Data slot hari/tanggal tidak valid/kosong.</span> &nbsp; <img src='".base_url()."assets/images/failed.png'>";
            }
        } else {
            echo "<span style='color:red'>Waktu session login anda telah habis.</span> &nbsp; <img src='".base_url()."assets/images/failed.png'>";
        }
    }

    function hapusSlotWaktu($id_sidangTA="", $treeid="", $id_slot="") {
        $this->lib_user->cek_admin(true);
        
        foreach ($_POST as $key => $value) {
            if ($value=="on") {
                $slotWaktu = explode("_",$key);
                if ($slotWaktu[0]=="SLOTWAKTU") {
                    // $slotWaktu[1]=>ID SIDANG TA, $slotWaktu[2]=>TREEID, $slotWaktu[3]=>ID SLOT
                    // cek id sidang TA, treeid, slot id
                    $this->msidang->cekSidangTA($slotWaktu[1], true);
                    $this->mslot->cekTreeID($slotWaktu[2], true);
                    $this->mslot->cekSlot($slotWaktu[3], true);
                    
                    // cek apakah slot sudah dipakai oleh ruangan
                    if($this->mjadwalruangavail->cek(array("SIDANGTA"=>$slotWaktu[1], "ID_SLOT"=>$slotWaktu[2], "STATUS"=>2)))
                    {
                        $this->lib_alert->error('Gagal menghapus slot waktu, slot telah digunakan oleh ruangan');
                        redirect("slot/slotWaktuAjaxRequest/$slotWaktu[1]/".substr($slotWaktu[2],0,4));
                    }
                    // cek apakah slot sudah dipakai dosen
                    if($this->mjadwaldosenavail->cek(array("SIDANGTA"=>$slotWaktu[1], "ID_SLOT"=>$slotWaktu[2], "STATUS"=>2)))
                    {
                        $this->lib_alert->error('Gagal menghapus slot waktu, slot telah digunakan oleh dosen');
                        redirect("slot/slotWaktuAjaxRequest/$slotWaktu[1]/".substr($slotWaktu[2],0,4));
                    }
                }
            }
        }
        foreach ($_POST as $key => $value) {
            if ($value=="on") {
                $slotWaktu2 = explode("_",$key);
                if ($slotWaktu2[0]=="SLOTWAKTU") {
                    //get parent treeid & id sidang TA
                    $parent_treeid = substr($slotWaktu2[2], 0, strlen($slotWaktu2[2])-2);
                    $treeid = $slotWaktu2[2];
                    $id_sidangTA = $slotWaktu2[1];
                    $id_slot = $slotWaktu2[3];
                    $this->mjadwalruangavail->hapusJadwalRuangAvail(array("SIDANGTA"=>$id_sidangTA, "ID_SLOT"=>$treeid, "STATUS"=>'0'));
                    $this->mjadwaldosenavail->hapusPerSlotWaktu($id_sidangTA, $treeid);
                    // hapus slot dr database
                    $this->mslot->hapus($id_slot);
                    
                }
            }
        }
        $this->lib_alert->success("Slot waktu berhasil dihapus.");
        redirect("slot/slotWaktuAjaxRequest/$id_sidangTA/$parent_treeid");
    }

    function autoSlotWaktu($id_sidangTA="", $parent_treeid="") {
        $this->lib_user->cek_admin(true);
        
        $this->msidang->cekSidangTA($id_sidangTA, true);
        $this->mslot->cekTreeID($parent_treeid, true);

        $slotwaktu = array(
                        '08:00',
                        '09:00',
                        '10:00',
                        '11:00',
                        '12:00',
                        '13:00',
                        '14:00',
                        '15:00',
                        '16:00',
                        '17:00',
                        '18:00',
                        '19:00',
                        '20:00'
                        );
        $tgl = $this->mslot->getDetailSlot($id_sidangTA, $parent_treeid);
        for($i=0; $i<sizeof($slotwaktu); $i++) {
            $arr_waktu = explode(":", $slotwaktu[$i], 2);
            if(count($arr_waktu) < 2) {
                $batas_waktu = "";
            } else {
                $batas_waktu = $arr_waktu[0]+1 .":". $arr_waktu[1];
            }
            $data_entry_slotwaktu = array(
                'ID_SLOT' => $this->mslot->newIDSlot(),
                'TREEID' => $this->mslot->newTreeID($id_sidangTA, $parent_treeid),
                'WAKTU' => $slotwaktu[$i],
                'TGL' => $tgl->TGL,
                'DESKRIPSI' => $slotwaktu[$i]."-".$batas_waktu,
                'SIDANGTA' => $this->db->escape_like_str($id_sidangTA),
                'ID_KBK' => '0'
            );
            // tambahkan data ke Database
            $this->mslot->add($data_entry_slotwaktu);
        }
        $this->lib_alert->success("Penambahan slot waktu berhasil.");
        redirect("slot/slotWaktuAjaxRequest/$id_sidangTA/$parent_treeid");
    }
    
    function setSemuaRuangAvailable($id_sidangTA="", $treeid="")
    {
        $this->lib_user->cek_admin();
        
        $this->msidang->cekSidangTA($id_sidangTA, false);
        $this->mslot->cekTreeID($treeid, false);
        
        $ruang = $this->mruang->getList($id_sidangTA);

        foreach ($ruang as $row) {
            $data_jadwal_baru = array(
                'ID_JDW_RUANG' => $row->ID_JDW_RUANG,
                'ID_SLOT' => $treeid,
                'SIDANGTA' => $id_sidangTA // default STATUS 0
            );
            if($this->mjadwalruangavail->cek($data_jadwal_baru) == false)
                $this->mjadwalruangavail->addJadwalRuangAvail($data_jadwal_baru);
        }
    }
    
    function setDefaultRuangKBKAssignment($id_sidangTA="", $treeid="", $id_kbk="") {
        $this->lib_user->cek_admin();
        
        $this->msidang->cekSidangTA($id_sidangTA, false);
        $this->mdosen->cekKBK($id_kbk, false);
        $this->mslot->cekTreeID($treeid, false);
        
        $data_update_jadwal = array(
            'ID_KBK' => $id_kbk
        );
        
        $this->mjadwalruangavail->updateJadwalRuangAvailWithOptions($data_update_jadwal, array('SIDANGTA' => $id_sidangTA, 'ID_SLOT' => $treeid));
    }
}
?>