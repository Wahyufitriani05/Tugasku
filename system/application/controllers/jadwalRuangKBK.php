<?php
class JadwalRuangKBK extends Controller 
{

    function JadwalRuangKBK() 
    {
        parent::Controller();
        $this->load->library('lib_tugas_akhir');
        $this->load->library('lib_alert');
        $this->load->library('lib_user');
        $this->load->library('lib_js');
        $this->load->library('pquery');
        $this->load->model('mruang');
        $this->load->model('msidang');
        $this->load->model('mdosen');
        $this->load->model('mslot');
        $this->load->model('mjadwalruangavail');
    }

    function ruangKBKAssignment($id_sidangTA = NULL, $id_Ruangan = NULL)
    {
        $this->lib_user->cek_admin();
        if (empty($id_sidangTA)) {
            $id_sidangTA = $this->msidang->getIDSidangTAAktif();
        }
        if (empty($id_Ruangan)) {
            $id_Ruangan = $this->mruang->getDefaultIDRuang($id_sidangTA);
        }

        // pengambilan value FILTER SIDANG TA
        if($this->input->post('sidangTA')) {
            // dari method POST
            $id_sidangTA = $this->input->post('sidangTA');
            $id_Ruangan = $this->mruang->getDefaultIDRuang($id_sidangTA);
            redirect("jadwalRuangKBK/ruangKBKAssignment/$id_sidangTA/$id_Ruangan");
        }

        // pengambilan value FILTER ID RUANG SIDANG TA
        if($this->input->post('ruangSidangTA')) {
            // dari method POST
            $id_Ruangan = $this->input->post('ruangSidangTA');
            redirect("jadwalRuangKBK/ruangKBKAssignment/$id_sidangTA/$id_Ruangan");
        }
        
        $this->msidang->cekSidangTA($id_sidangTA, false);

        $data['kbk'] = $this->mdosen->listKBK();
        $data['slot'] = $this->mslot->getListSlot($id_sidangTA);

        $data['filterRuangan'] = $id_Ruangan;
        $data['listRuangan'] = $this->mruang->getList($id_sidangTA);
        $data['ruangan'] = $this->mruang->getList($id_sidangTA,$data['filterRuangan']);

        $ada_jadwal = array();
        $id_kbk = array();
        $status = array();
        $id_jdw_ruang_avail = array();
        foreach ($data['slot'] as $slot) {
            if(strlen($slot->TREEID)==6) {
                foreach ($data['ruangan'] as $ruangan) {
                    $jadwal_ruang = $this->mjadwalruangavail->getJadwalRuangAvail($ruangan->ID_JDW_RUANG, $slot->TREEID, $id_sidangTA);
                    if (count($jadwal_ruang) > 0){
                        $ada_jadwal[$slot->TREEID][$ruangan->ID_JDW_RUANG] = TRUE;
                        $id_kbk[$slot->TREEID][$ruangan->ID_JDW_RUANG] = $jadwal_ruang->ID_KBK;
                        $status[$slot->TREEID][$ruangan->ID_JDW_RUANG] = $jadwal_ruang->STATUS;
                        $id_jdw_ruang_avail[$slot->TREEID][$ruangan->ID_JDW_RUANG] = $jadwal_ruang->ID_JDW_RUANG_AVAIL;
                    } else {
                        $ada_jadwal[$slot->TREEID][$ruangan->ID_JDW_RUANG] = FALSE;
                    }
                }
            }
        }
        $data['ada_jadwal'] = $ada_jadwal;
        $data['id_kbk'] = $id_kbk;
        $data['status'] = $status;
        $data['id_jdw_ruang_avail'] = $id_jdw_ruang_avail;

        $data['list_sidangTA'] = $this->msidang->jadwalSidangTA();
        $data['id_sidangTA'] = $id_sidangTA;
        // set page information
        $data['title'] = "Ruang KBK Assignment";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        //$data['leftSide'] = 'leftSidePenjadwalan';
        $data['content'] = "jadwalRuangKBK/content-ruangKBKAssignment";

        $this->load->view('template', $data);
    }

    function updateRuangKBKAssignment($id_sidangTA="") {
        $this->lib_user->cek_admin();
        
        $this->msidang->cekSidangTA($id_sidangTA, false);
        
        // cek treeid
        foreach ($_POST as $key => $id_kbk) {
            $x = explode("_",$key);
            if ($x[0]=="IDKBK") {
                if($this->mjadwalruangavail->cek($x[1]) == FALSE) {
                    $this->lib_alert->warning("Data jadwal ruangan tidak ditemukan");
                    redirect('error/index');
                }
            }
        }

        foreach ($_POST as $key => $id_kbk) {
            $z = explode("_",$key);
            if ($z[0]=="IDKBK") {
                $id_jdw_ruang_avail = $z[1];
                $data_update_jadwal = array(
                    'ID_KBK' => $id_kbk
                );
                // update data ke Database
                $this->mjadwalruangavail->updateJadwalRuangAvail($data_update_jadwal, $id_jdw_ruang_avail);
            }
        }
        redirect("jadwalRuangKBK/ruangKBKAssignment/$id_sidangTA");
    }

    function setDefaultRuangKBKAssignment($id_sidangTA="", $id_jdw_ruang="", $id_kbk="") {
        $this->lib_user->cek_admin();
        
        $this->msidang->cekSidangTA($id_sidangTA, false);
        $this->mdosen->cekKBK($id_kbk, false);
        $this->mruang->cek($id_jdw_ruang, false);

        $data_update_jadwal = array(
            'ID_KBK' => $id_kbk
        );
        $this->mjadwalruangavail->updateJadwalRuangAvailBySidangDanRuang($data_update_jadwal, $id_sidangTA, $id_jdw_ruang);
        redirect("jadwalRuangKBK/ruangKBKAssignment/$id_sidangTA");
    }
}
?>