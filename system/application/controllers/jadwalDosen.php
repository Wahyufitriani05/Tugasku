<?php
class JadwalDosen extends Controller 
{
    var $session_ci;
    function JadwalDosen() 
    {
        parent::Controller();
        $this->load->library('lib_tugas_akhir');
        $this->load->library('lib_alert');
        $this->load->library('lib_user');
        $this->load->library('lib_js');
        $this->load->library('pquery');
        $this->load->model('msidang');
        $this->load->model('mdosen');
        $this->load->model('mslot');
        $this->load->model('mjadwaldosenavail');
        $this->session_ci = new CI_Session();
    }

    function dosenAvailability() 
    {
        //$this->lib_user->cek_admin_dosen();
        $this->lib_user->cek_admin_dosen_kbk();
        $nip_login = $this->session->userdata('nip');
        
        if($this->lib_user->is_admin_kbk())
        {
            $rmk = $this->mdosen->listKBK($nip_login);
        }

        if($this->input->post('sidangTA')) {
            $id_sidangTA = $this->input->post('sidangTA');
            if($this->input->post('parent_treeid') != $this->input->post('current_parent_treeid'))
                $parent_treeid = $this->input->post('parent_treeid');
            else
                $parent_treeid = $this->mslot->getTreeIDFirstParentSlot($id_sidangTA);
            redirect("jadwalDosen/dosenAvailability/$id_sidangTA/$parent_treeid");
        } else {
            $id_sidangTA = $this->uri->segment(3, $this->msidang->getIDSidangTAAktif());
            $parent_treeid = $this->uri->segment(4, $this->mslot->getTreeIDFirstParentSlot($id_sidangTA));
            //var_dump($parent_treeid);
        }
        
        $this->msidang->cekSidangTA($id_sidangTA, false);
        $this->mslot->cekTreeID($parent_treeid, false);

        // set jadwal dan dosen
        if($this->session->userdata('type') == 'admin' || $this->session->userdata('type') == 'dosen')
            $data['dosen'] = $this->mdosen->listDosen();
        else if($this->lib_user->is_admin_kbk())
            $data['dosen'] = $this->mdosen->listDosen($rmk[0]->ID_KBK);

        $data['slot_waktu'] = $this->mslot->getListSlotWaktu($id_sidangTA, $parent_treeid);
        //var_dump($data['slot_waktu']);
        $status_jadwal = array();
        $id_proposal = array();
        $id_jdw_avail = array();
        foreach ($data['dosen'] as $dosen) {
            foreach ($data['slot_waktu'] as $slot_waktu) {
                $jadwal_dosen = $this->mjadwaldosenavail->detail(array("SIDANGTA" => $id_sidangTA, "ID_SLOT" => $slot_waktu->TREEID, "NIP" => $dosen->NIP));
                if (count($jadwal_dosen) > 0){
                    $status_jadwal[$dosen->NIP][$slot_waktu->TREEID] = $jadwal_dosen->STATUS;
                    $id_proposal[$dosen->NIP][$slot_waktu->TREEID] = $jadwal_dosen->ID_PROPOSAL;
                    $id_jdw_avail[$dosen->NIP][$slot_waktu->TREEID] = $jadwal_dosen->ID_JDW_AVAIL;
                    
                }
            }
        }
        $data['status_jadwal'] = $status_jadwal;
        $data['id_proposal'] = $id_proposal;
        $data['id_jdw_avail'] = $id_jdw_avail;
        $data['list_sidangTA'] = $this->msidang->jadwalSidangTA();
        $data['list_slotHari'] = $this->mslot->getListSlotHari($id_sidangTA); // get slot hari atau parent slot dari slot waktu
        $data['id_sidangTA'] = $id_sidangTA;
        $data['parent_treeid'] = $parent_treeid;
        //var_dump($parent_treeid);
        // set page information
        $data['title'] = "Dosen Availability";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        //$data['leftSide'] = 'leftSidePenjadwalan';
        $data['content'] = "jadwalDosen/content-dosenAvailability";

        $this->load->view('template', $data);
    }

    function resetPerSlotHari($id_sidangTA="", $parent_treeid="") 
    {
        $this->lib_user->cek_admin();
        
        $this->msidang->cekSidangTA($id_sidangTA, false);
        $this->mslot->cekTreeID($parent_treeid, false);
        $this->mjadwaldosenavail->resetPerSlotHari($id_sidangTA, $parent_treeid);
        redirect("jadwalDosen/dosenAvailability/$id_sidangTA/$parent_treeid");
    }

    function reset($id_jdw_avail="") 
    {
        $this->lib_user->cek_admin();
        
        $this->mjadwaldosenavail->cek($id_jdw_avail, false);
        $this->mjadwaldosenavail->reset($id_jdw_avail);
        $detail = $this->mjadwaldosenavail->detail($id_jdw_avail);
        redirect("jadwalDosen/dosenAvailability/$detail->SIDANGTA/".substr($detail->ID_SLOT, 0, 4));
    }

    // dosen availability all
    function penjadwalanAutomatis($id_sidangTA="", $parent_treeid="")
    {
        //$this->lib_user->cek_admin();
        
        $this->msidang->cekSidangTA($id_sidangTA, false);
        $this->mslot->cekTreeID($parent_treeid, false);
        
        $arrayslotwaktu = $this->mslot->getListSlotWaktu($id_sidangTA, $parent_treeid);
        $arraydosen = $this->mdosen->listDosen();
        
        set_time_limit (0);        
        
        $j = 0;
        foreach($arrayslotwaktu as $slotwaktu) { 
            //if($j>200) break;
            foreach ($arraydosen as $dosen) {                
                if(count($this->mjadwaldosenavail->getDetailAvail($id_sidangTA, $slotwaktu->TREEID, $dosen->NIP)) == 0)
                {
                    if(($this->lib_user->is_admin_kbk() && $this->mdosen->isDosenRMK($dosen->NIP,$this->session_ci->userdata('type')))||($this->session->userdata['type']=='dosen'&& $dosen->NIP == $this->session->userdata['nip']) || $this->session->userdata['type']=='admin')
                    {
                        $data_jadwal_baru = array(
                            'NIP' => $dosen->NIP,
                            'ID_SLOT' => $slotwaktu->TREEID,
                            'SIDANGTA' => $id_sidangTA // default STATUS 0
                        );
                        // tambahkan data ke Database
                        $this->mjadwaldosenavail->add($data_jadwal_baru);
                        $j++;
                    }
                }
            }   
        }
        
        redirect("jadwalDosen/dosenAvailability/$id_sidangTA/$parent_treeid");
    }
    
    // update waktu luang dosen
    function updateJadwalDosen($id_sidangTA="", $parent_treeid="") 
    {
        $this->lib_user->cek_admin_dosen_kbk();
        
        $this->msidang->cekSidangTA($id_sidangTA, false);
        $this->mslot->cekTreeID($parent_treeid, false);
        // cek treeid dengan parent-nya
        foreach ($_POST as $key => $value) {
            if ($value=="on") {
                $x = explode("_",$key);
                if ($x[0]=="AVAIL") 
                {
                    if($parent_treeid != substr($x[1], 0, 4)) 
                    {
                        $this->lib_alert->error('Data slot hari dan slot waktu dosen tidak cocok!');
                        redirect('error/index');
                    }
                }
            }
        }

        /*
        //penjadwalan untuk dosen avalaibility 
        if($this->session->userdata['type']=='dosen')            
            $this->mjadwaldosenavail->hapusPerSlotHariDosen($id_sidangTA, $parent_treeid, $this->session->userdata['nip']);
        else
            $this->mjadwaldosenavail->hapusPerSlotHari($id_sidangTA, $parent_treeid);
        */

        
        
        $arrayslotwaktu = $this->mslot->getListSlotWaktu($id_sidangTA, $parent_treeid);
        $arraydosen = $this->mdosen->listDosen();
           
        $array = array();
        
        foreach ($arraydosen as $dosen) {
            $array[$dosen->NIP] = array();
            foreach($arrayslotwaktu as $slotwaktu) {                            
                $array[$dosen->NIP][$slotwaktu->TREEID] = 0;                  
            }               
        } 
        
        
        foreach ($_POST as $key => $value) {            
            //var_dump($_POST);
            if ($value=="on") {
                $z = explode("_",$key);                
                if ($z[0]=="AVAIL" || $z[0]=="NOTAVAIL") {
                    $treeid = $z[1];
                    $nip = $z[2];                    
                    $array[$nip][$treeid] = 1;
                    if(count($this->mjadwaldosenavail->getDetailAvail($id_sidangTA, $treeid, $nip)) == 0)
                    {                       
                        //echo $NIP." - ".$treeid." - ".$id_sidangTA;
                        $data_jadwal_baru = array(
                            'NIP' => $nip,
                            'ID_SLOT' => $treeid,
                            'SIDANGTA' => $id_sidangTA // default STATUS 0
                        );
                        // tambahkan data ke Database
                        $this->mjadwaldosenavail->add($data_jadwal_baru);
                    }
                }                
            }            
        }
        
        
        foreach ($arraydosen as $dosen) {
            
            foreach($arrayslotwaktu as $slotwaktu) {                            
                if($array[$dosen->NIP][$slotwaktu->TREEID]==0)
                {
                    if(($this->lib_user->is_admin_kbk() && $this->mdosen->isDosenRMK($dosen->NIP,$this->session_ci->userdata('type'))) || ($this->session->userdata['type']=='dosen'&& $dosen->NIP == $this->session->userdata['nip']) || $this->session->userdata['type']=='admin')
                    {
                        if(count($this->mjadwaldosenavail->getDetailAvail($id_sidangTA, $slotwaktu->TREEID, $dosen->NIP)) > 0)
                        {                          
                            $this->mjadwaldosenavail->hapusPerSlotWaktuDosen($id_sidangTA, $slotwaktu->TREEID, $dosen->NIP);
                        }
                    }
                }
            }               
        }
       redirect("jadwalDosen/dosenAvailability/$id_sidangTA/".substr($treeid, 0, 4));
    }
}
?>