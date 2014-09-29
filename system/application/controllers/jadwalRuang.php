<?php

class JadwalRuang extends Controller 
{
    
    function JadwalRuang() 
    {
        parent::Controller();
        $this->load->library('lib_user');
        $this->load->library('lib_alert');
        $this->load->library('lib_tugas_akhir');
        $this->load->library('lib_js');
        $this->load->library('pquery');
        $this->load->model('mruang');
        $this->load->model('msidang');
        $this->load->model('mslot');
        $this->load->model('mjadwalruangavail');
        $this->load->model('mjadwalmahasiswa');
    }

    function index() 
    {
        $this->ruangAvailability();
    }
    
    function ruangAvailability() 
    {
        $this->lib_user->cek_admin();
        
        $data['title'] = "Room Availability";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['content'] = "jadwalRuang/content-ruangAvailability";
        // get SIDANG TA
        if($this->input->post('sidangTA') != '') 
        {
            $id_sidangTA = $this->input->post('sidangTA');
            redirect("jadwalRuang/ruangAvailability/$id_sidangTA");
        } 
        else 
        {
            $id_sidangTA = $this->uri->segment(3, $this->msidang->getIDSidangTAAktif());
        }

        $this->msidang->cekSidangTA($id_sidangTA, true);

        $data['slot'] = $this->mslot->getListSlot($id_sidangTA);
        $data['ruangan'] = $this->mruang->getList($id_sidangTA);
        $status = array();
        foreach ($data['slot'] as $slot) {
            if(strlen($slot->TREEID)==6) {
                foreach ($data['ruangan'] as $ruangan) {
                    $jadwal_ruang = $this->mjadwalruangavail->getJadwalRuangAvail($ruangan->ID_JDW_RUANG, $slot->TREEID, $id_sidangTA);
                    if (count($jadwal_ruang) > 0){
                        $status[$slot->TREEID][$ruangan->ID_JDW_RUANG] = $jadwal_ruang->STATUS;
                    }
                }
            }
        }
        $data['status'] = $status;
        $data['list_sidangTA'] = $this->msidang->jadwalSidangTA();
        $data['id_sidangTA'] = $id_sidangTA;
        $this->load->view('template', $data);
    }

    function resetJadwalRuangan($id_sidangTA="", $id_ruang="", $treeid="") 
    {
        $this->lib_user->cek_admin();
        
        $this->msidang->cekSidangTA($id_sidangTA, false);
        $this->mslot->cekTreeID($treeid, false);
        $this->mruang->cek($id_ruang, false);
        // reset jadwal ruang availability
        $this->mjadwalruangavail->resetJadwalRuangAvail($id_sidangTA, $id_ruang, $treeid);

        // reset ruang availability pada tabel jadwal mahasiswa
        $data_jdw_mhs = array(
            "ID_JDW_RUANG" => '0',
            "ID_JDW_RUANG_AVAIL" => '0'
        );
        $options_jdw_mhs = array(
            "SIDANGTA"=>$id_sidangTA,
            "ID_JDW_RUANG"=>$id_ruang,
            "ID_SLOT"=>$treeid
        );
        $this->mjadwalmahasiswa->update($data_jdw_mhs, $options_jdw_mhs);

        // get ID jadwal mahasiswa yang baru diupdate
        $options_jdw_mhs_2 = array(
            "SIDANGTA"=>$id_sidangTA,
            "ID_JDW_RUANG"=>'0',
            "ID_SLOT"=>$treeid
        );
        $id_jdw_mhs = $this->mjadwalmahasiswa->field("ID_JDW_MHS", $options_jdw_mhs_2);

        // get status sidang yang baru
        $status = $this->mjadwalmahasiswa->statusSidang($id_jdw_mhs, $id_sidangTA);

        // update status baru
        $data_jdw_mhs = array(
            "STATUS" => $status
        );
        $this->mjadwalmahasiswa->update($data_jdw_mhs, $options_jdw_mhs_2);
        
        redirect("jadwalRuang/ruangAvailability/$id_sidangTA");
    }

    function updateJadwalRuangan($id_sidangTA="") 
    {
        $this->lib_user->cek_admin();
        
        $this->msidang->cekSidangTA($id_sidangTA, false);
        
        // cek treeid
        foreach ($_POST as $key => $value) {
            if ($value=="on") {
                $x = explode("_",$key);
                if ($x[0]=="AVAIL") {
                    if($this->mslot->cekTreeID($x[1]) == FALSE || $this->mruang->cek($x[2]) == FALSE) {
                        redirect('error/index');
                    }
                }
            }
        }

        // hapus jadwal semua ruangan dengan id sidangta=xxx dan status=0
        $this->mjadwalruangavail->hapusSemuaJadwalRuangAvail($id_sidangTA, '0');
        foreach ($_POST as $key => $value) {
            if ($value=="on") {
                $z = explode("_",$key);
                if ($z[0]=="AVAIL") {
                    $treeid = $z[1];
                    $id_ruang = $z[2];
                    $data_jadwal_baru = array(
                        'ID_JDW_RUANG' => $id_ruang,
                        'ID_SLOT' => $treeid,
                        'SIDANGTA' => $id_sidangTA // default STATUS 0
                    );
                    // tambahkan data ke Database
                    $this->mjadwalruangavail->addJadwalRuangAvail($data_jadwal_baru);
                }
            }
        }
        redirect("jadwalRuang/ruangAvailability/$id_sidangTA");
    }

    // me-reset/mengosongkan jadwal semua dosen
    function resetJadwalSemuaRuangan($id_sidangTA="") 
    {
        $this->lib_user->cek_admin();
        
        $this->msidang->cekSidangTA($id_sidangTA, false);

        $this->mjadwalruangavail->resetSemuaJadwalRuangAvail($id_sidangTA);
        redirect("jadwalRuang/ruangAvailability/$id_sidangTA");
    }

    function emptyJadwalRuangan($id_sidangTA="") 
    {
        $this->lib_user->cek_admin();
        
        $this->msidang->cekSidangTA($id_sidangTA, false);

        $this->mjadwalruangavail->hapusSemuaJadwalRuangAvail($id_sidangTA);
        redirect("jadwalRuang/ruangAvailability/$id_sidangTA");
    }

    function autoRuangAvailability($id_sidangTA="")
    {
        $this->lib_user->cek_admin();
        
        $this->msidang->cekSidangTA($id_sidangTA, false);

        // hapus semua jadwal dgn id sidangta=xxx
        $this->mjadwalruangavail->hapusSemuaJadwalRuangAvail($id_sidangTA);

        $slot = $this->mslot->getListSlot($id_sidangTA);
        $ruangan = $this->mruang->getList($id_sidangTA);

        foreach ($slot as $row) {
            if(strlen($row->TREEID)==6) {
                foreach ($ruangan as $row2) {
                    $data_jadwal_baru = array(
                        'ID_JDW_RUANG' => $row2->ID_JDW_RUANG,
                        'ID_SLOT' => $row->TREEID,
                        'SIDANGTA' => $id_sidangTA // default STATUS 0
                    );
                    $this->mjadwalruangavail->addJadwalRuangAvail($data_jadwal_baru);
                }
            }
        }
        redirect("jadwalRuang/ruangAvailability/$id_sidangTA");
    }
}
?>