<?php
class jadwalMahasiswa extends Controller 
{
    function jadwalMahasiswa() 
    {
        parent::Controller();
        $this->load->library('lib_tugas_akhir'); 

        $this->load->library('lib_alert');

        $this->load->library('lib_user');

        $this->load->library('lib_js');

        $this->load->library('pquery');

        $this->load->model('mjadwalmahasiswa');

        $this->load->model('mproposal');

        $this->load->model('mjadwalruangavail');

        $this->load->model('msidang');

        $this->load->model('mruang');

        $this->load->model('mdosen');

        $this->load->model('mslot');

        $this->load->model('mjadwaldosenavail');



        $jadwalmhs = array(

            'ID_PROPOSAL'=>'0',

            'NIP1'=>'0',

            'NIP2'=>'0',

            'NIP3'=>'0',

            'NIP4'=>'0',

            'ID_SLOT'=>'0',

            'STATUS'=>'0',

            'SIDANGTA'=>'0',

            'ID_JDW_RUANG'=>'0',

            'ID_KBK'=>'0',

            'UP_NIP1'=>'0',

            'UP_NIP2'=>'0',

            'UP_NIP3'=>'0',

            'UP_NIP4'=>'0',

            'ID_JDW_RUANG_AVAIL'=>'0',

            'MASUK'=>'0'

        );

    }



    function index() {

        redirect("jadwalMahasiswa/pesertaSidang");

    }



     // filtering KBK TA

    function filterKBK() {

        // pengambilan value FILTER KBK

        if($this->input->post('kbk') != '') {

            // dari method POST

            $id_kbk = $this->input->post('kbk');

            $this->session->set_userdata('kbk', $id_kbk);

        } elseif($this->session->userdata('kbk')) {

            // dari session

            $id_kbk = $this->session->userdata('kbk');

        } else {

            $id_kbk = '-1';

        }

        // cek validitas value FILTER, jika tak valid, set to default

        if(! $this->mdosen->cekKBK($id_kbk))

            $id_kbk = '-1'; // -1 => semua KBK



        return $id_kbk;

    }



     // filtering dosen

    function filterDosen() {

        // pengambilan value FILTER DOSEN

        if($this->input->post('dosen') != '') {

            // dari method POST

            $dosen = $this->input->post('dosen');

            $this->session->set_userdata('dosen', $dosen);

        } elseif($this->session->userdata('dosen')) {

            // dari session

            $dosen = $this->session->userdata('dosen');

        } else {

            $dosen = '-1';

        }

        // cek validitas value FILTER, jika tak valid, set to default

        if(! $this->mdosen->cekDosen($dosen))

            $dosen = '-1'; // -1 => semua KBK



        return $dosen;

    }



    function pesertaSidang(){

        $this->lib_user->cek_admin();

        // pengambilan value FILTER SIDANG TA

        if($this->input->post('sidangTA')) {

            // dari method POST

            $id_sidangTA = $this->input->post('sidangTA');

            redirect("jadwalMahasiswa/pesertaSidang/$id_sidangTA");

        } else {

            $id_sidangTA = $this->uri->segment(3, $this->msidang->getIDSidangTAAktif());

        }



        $this->msidang->cekSidangTA($id_sidangTA, "redirect");



        $data['list_proposal'] = $this->mjadwalmahasiswa->listProposalMajuSidang2ShowAll($id_sidangTA);

        //var_dump($data['list_proposal']);

        $jadwal_mhs = array();

        $ada_jadwal = array();

        foreach ($data['list_proposal'] as $row) {

            //dipertanyakan
            //$row->NAMA_KBK = $this->mdosen->detailKBK($row->ID_KBK)->NAMA_KBK;

            $jdw_mhs_tmp = $this->mjadwalmahasiswa->jadwalSidangTA(0, $row->ID_PROPOSAL, $id_sidangTA);

            if (count($jdw_mhs_tmp) > 0){

                $ada_jadwal[$row->ID_PROPOSAL] = TRUE;

                $jadwal_mhs[$row->ID_PROPOSAL] = $jdw_mhs_tmp;

            } else {

                $ada_jadwal[$row->ID_PROPOSAL] = FALSE;

            }

        }



        $data['ada_jadwal'] = $ada_jadwal;

        $data['jadwal_mhs'] = $jadwal_mhs;



        $data['list_sidangTA'] = $this->msidang->jadwalSidangTA();

        $data['id_sidangTA'] = $id_sidangTA;

        $data['list_kbk'] = $this->mdosen->listKBK();

        //$data['list_ruang'] = $this->mruang->getList($id_sidangTA);

        // set page information

        $data['title'] = "Peserta Sidang TA";

        $data['js_menu'] = $this->lib_user->get_javascript_menu();

        $data['header'] = $this->lib_user->get_header();

        //$data['leftSide'] = 'leftSidePenjadwalan';

        $data['content'] = "jadwalMahasiswa/content-pesertaSidang";



        $this->load->view('template', $data);

    }

    

    function jadwalSidangTA(){

        // filtering KBK

        $id_kbk = $this->filterKBK();

        $nip = $this->filterDosen();

        

        $id_sidangTA = $this->msidang->getIDSidangTAAktif();

        $data['list_proposal'] = $this->mjadwalmahasiswa->listProposalMajuSidang2($id_sidangTA, $id_kbk, $nip);        

        $jadwal_mhs = array();

        $ada_jadwal = array();

        foreach ($data['list_proposal'] as $row) {

            $row->NAMA_KBK = $this->mdosen->detailKBK($row->ID_KBK)->NAMA_KBK;

            $jdw_mhs_tmp = $this->mjadwalmahasiswa->jadwalSidangTA(1, $row->ID_PROPOSAL, $id_sidangTA, 6, $nip);

            if (count($jdw_mhs_tmp) > 0){

                $ada_jadwal[$row->ID_PROPOSAL] = TRUE;

                $jadwal_mhs[$row->ID_PROPOSAL] = $jdw_mhs_tmp;

            } else {

                $ada_jadwal[$row->ID_PROPOSAL] = FALSE;

            }

        }



        $data['ada_jadwal'] = $ada_jadwal;

        $data['jadwal_mhs'] = $jadwal_mhs;

        $data['kbk'] = $this->mdosen->listKBK();

        $data['dosen'] = $this->mdosen->listDosen();

        // set page information

        $data['title'] = "Jadwal Sidang TA";

        $data['js_menu'] = $this->lib_user->get_javascript_menu();

        $data['header'] = $this->lib_user->get_header();

        //$data['leftSide'] = 'leftSidePenjadwalan';

        $data['content'] = "jadwalMahasiswa/content-jadwalSidangTA";

        $this->load->view('template', $data);
    }

	function unduhBeritaAcara(){
        $type=$this->session->userdata('type');

        if($type=='dosen')

        {

            $data['js_menu'] = "menuDosen";

            $data['header'] = "headerDosen";

        }

        else if($type=='mahasiswa')

        {

            $data['js_menu'] = "menuMahasiswa";

            $data['header'] = "headerMahasiswa";

        }

        else if($type=='admin')

        {

            $data['js_menu'] = "menuAdmin";

            $data['header'] = "headerAdmin";

        }

        else if($type=='NCC' || $type=='KCV' || $type=='SE')

        {

            $data['js_menu'] = "menuKBK";

            $data['header'] = "headerAdmin";

        }
        //cek apakah benar status login admin
        if($type!="admin")redirect('berita/lihatBerita','refresh');
		
		//cek id proposal yang dicetak berita acaranya
		$id_proposal=$this->uri->segment(3, 0);
		if($id_proposal==0)redirect('berita/lihatBerita','refresh');

        // filtering KBK
        $id_kbk = $this->filterKBK();
        $nip = $this->filterDosen();

        $id_sidangTA = $this->msidang->getIDSidangTAAktif();

        $data['list_proposal'] = $this->mjadwalmahasiswa->listProposalMajuSidang2UntukBeritaAcara($id_sidangTA, $id_kbk, $nip, $id_proposal);

        $jadwal_mhs = array();

        $ada_jadwal = array();

        foreach ($data['list_proposal'] as $row) {

            $row->NAMA_KBK = $this->mdosen->detailKBK($row->ID_KBK)->NAMA_KBK;

            $jdw_mhs_tmp = $this->mjadwalmahasiswa->jadwalSidangTA(1, $row->ID_PROPOSAL, $id_sidangTA, 6, $nip);

            if (count($jdw_mhs_tmp) > 0){

                $ada_jadwal[$row->ID_PROPOSAL] = TRUE;

                $jadwal_mhs[$row->ID_PROPOSAL] = $jdw_mhs_tmp;

            } else {

                $ada_jadwal[$row->ID_PROPOSAL] = FALSE;

            }

        }



        $data['ada_jadwal'] = $ada_jadwal;

        $data['jadwal_mhs'] = $jadwal_mhs;

        $data['kbk'] = $this->mdosen->listKBK();

        $data['dosen'] = $this->mdosen->listDosen();

		$this->load->view('jadwalMahasiswa/content-unduhjadwalSidangTA', $data);
	}

    function statusTA()
    {

        $this->lib_user->cek_admin();

        $id_kbk = $this->filterKBK();

        $data['list_proposal'] = $this->mjadwalmahasiswa->listProposalBelumMajuSidang($id_kbk);

        $data['list_status'] = $this->lib_tugas_akhir->list_status();

        $data['list_sidangTA'] = $this->msidang->jadwalSidangTA();

        $data['kbk'] = $this->mdosen->listKBK();

        // set page information

        $data['title'] = "Jadwal Sidang TA";

        $data['js_menu'] = $this->lib_user->get_javascript_menu();

        $data['header'] = $this->lib_user->get_header();

        //$data['leftSide'] = 'leftSidePenjadwalan';

        $data['content'] = "jadwalMahasiswa/content-statusTA";



        $this->load->view('template', $data);

    }



    function updateStatusTA () {

        $this->lib_user->cek_admin();

        $x = $_POST['status'];

        $y = $_POST['sidangTA'];



        foreach ($x as  $key => $value) {

            $data = array (

                "STATUS" => $value

            );

            $this->mproposal->update($data, $key);

        }



        foreach ($y as  $key => $value) {

            $data = array (

                "STA" => $value

            );

            $this->mproposal->update($data, $key);

        }



        redirect("jadwalMahasiswa/statusTA");

    }



    function gantiKBK($id_sidangTA="", $id_proposal="", $id_kbk_baru="") {

        // cek argumen

        if(! $this->msidang->cekSidangTA($id_sidangTA) || ! $this->mproposal->cek($id_proposal) || ! $this->mdosen->cekKBK($id_kbk_baru)) {

            echo "<img src='".base_url()."assets/images/failed.png'>";

        } else {

            // update KBK Proposal

            $id_kbk_lama = $this->mproposal->fieldTA("ID_KBK", $id_proposal);

            $data = array('ID_KBK' => $id_kbk_baru);

            $options = array('ID_PROPOSAL'=>$id_proposal,'SIDANGTA'=>$id_sidangTA, 'ID_KBK'=>$id_kbk_lama);

            // update data ke Database

            $this->mproposal->update($data, $id_proposal);

            $this->mjadwalmahasiswa->update($data, $options);

            echo "<img src='".base_url()."assets/images/updated.png'>";

        }

    }



    function gantiRuangSidang($id_sidangTA="", $id_jdw_mhs="") {

        $this->lib_user->cek_admin(true);

        $data_jdw_mhs = $this->mjadwalmahasiswa->detail($id_jdw_mhs);

        

        $id_proposal = $data_jdw_mhs->ID_PROPOSAL;

        $treeid = $data_jdw_mhs->ID_SLOT;

        $data['list_ruang_avail'] = $this->mjadwalruangavail->getListJadwaRuangAvail($id_sidangTA, $treeid);

        $data['id_sidangTA'] = $id_sidangTA;

        $data['id_proposal'] = $id_proposal;

        $data['id_jdw_mhs'] = $id_jdw_mhs;

        $data['content'] = "jadwalMahasiswa/gantiRuangSidang";



        $this->load->view("tb_template", $data);

    }



    function confirmGantiRuangSidang($id_sidangTA="", $id_jdw_mhs="", $id_jdw_ruang_avail_baru="") {

        $this->lib_user->cek_admin(true);

        $detail_jdw_mhs = $this->mjadwalmahasiswa->detail($id_jdw_mhs);

        $id_proposal = $detail_jdw_mhs->ID_PROPOSAL;

        $id_kbk = $detail_jdw_mhs->ID_KBK;

        $treeid = $detail_jdw_mhs->ID_SLOT;

        $id_jdw_ruang_lama = $detail_jdw_mhs->ID_JDW_RUANG;

        $id_jdw_ruang_baru = $this->mjadwalruangavail->field("ID_JDW_RUANG", $id_jdw_ruang_avail_baru);



        // update jadwal mahasiswa baru

        $data_jdw_mhs = array(

            'ID_JDW_RUANG' => $id_jdw_ruang_baru,

            "ID_JDW_RUANG_AVAIL" => $id_jdw_ruang_avail_baru

        );

        $this->mjadwalmahasiswa->update($data_jdw_mhs, $id_jdw_mhs);



        // update jadwal ruang avail yg lama

        $data_jdw_ruang_avail_lama = array(

            'STATUS' => '0',

            'ID_KBK' => '0',

            'ID_PROPOSAL' => '0'

        );

        $options_jdw_ruang_avail_baru = array(

            'STATUS' => '2',

            'SIDANGTA' => $id_sidangTA,

            'ID_SLOT' => $treeid,

            'ID_PROPOSAL' => $id_proposal,

            'ID_JDW_RUANG' => $id_jdw_ruang_lama

        );

        $this->mjadwalruangavail->updateJadwalRuangAvailWithOptions($data_jdw_ruang_avail_lama, $options_jdw_ruang_avail_baru);



        // update jadwal ruang avail baru

        $data_jdw_ruang_avail_baru = array(

            'STATUS' => '2',

            'ID_KBK' => $id_kbk,

            'ID_PROPOSAL' => $id_proposal

        );

        $options_jdw_ruang_avail_baru = array(

            'STATUS' => '0',

            'SIDANGTA' => $id_sidangTA,

            'ID_SLOT' => $treeid,

            'ID_JDW_RUANG' => $id_jdw_ruang_baru

        );

        //echo "$id_sidangTA $treeid $id_jdw_ruang_lama $id_proposal $id_jdw_ruang_baru";

        $this->mjadwalruangavail->updateJadwalRuangAvailWithOptions($data_jdw_ruang_avail_baru, $options_jdw_ruang_avail_baru);

       

        // get status sidang yang baru

        $status = $this->mjadwalmahasiswa->statusSidang($id_jdw_mhs, $id_sidangTA);



        // update status baru

        $data_jdw_mhs = array(

            "STATUS" => $status

        );

        $this->mjadwalmahasiswa->update($data_jdw_mhs, $id_jdw_mhs);

        echo "<body onload='self.parent.tb_refresh(true)'></body>";

    }



    function gantiPembimbing($no="",$id_sidangTA="", $id_proposal="") {

        $this->lib_user->cek_admin(true);

        if($no != 1 && $no != 2) 

        {

            $this->lib_alert->error('Jumlah maksimum dosen pembimbing hanya dua!');

            redirect('error/index/'.true);

        }

        $this->mproposal->cek($id_proposal, true);



        $data['list_dosen'] = $this->mjadwalmahasiswa->listAvailableDosenPembimbing($id_sidangTA, $id_proposal);

        $data['no'] = $no;

        $data['id_proposal'] = $id_proposal;

        $data['id_sidangTA'] = $id_sidangTA;

        $data['content'] = 'jadwalMahasiswa/gantiPembimbing';

        $this->load->view('tb_template', $data);

    }



    function confirmGantiPembimbing($no="", $id_sidangTA="", $id_proposal="", $nip_pengganti="") {

        $this->lib_user->cek_admin(true);

        if($no != 1 && $no != 2) 

        {

            $this->lib_alert->error('Jumlah maksimum dosen pembimbing hanya dua!');

            redirect('error/index/'.true);

        }

        $this->mproposal->cek($id_proposal, true);

        

        



        if($nip_pengganti != "" && ! $this->mdosen->cekDosen($nip_pengganti)) {

            $this->lib_alert->warning("Data dosen tidak ditemukan");

            redirect('error/index/'.true);

        }



        // update Dosen Pembimbing Proposal di tabel proposal

        $data_TA = array("PEMBIMBING$no" => $nip_pengganti);

        $this->mproposal->update($data_TA, $id_proposal);

        

        // update Dosen Pembimbing Proposal di tabel jadwal mahasiswa

        $data_jdw_mhs = array("NIP$no" => $nip_pengganti);

        $options = array("ID_PROPOSAL"=>$id_proposal,"SIDANGTA"=>$id_sidangTA);

        $this->mjadwalmahasiswa->update($data_jdw_mhs, $options);

        

        echo "<body onload='self.parent.tb_refresh(true)'></body>";

    }



    function gantiPenguji($no="", $id_sidangTA="", $id_proposal="", $id_jdw_mhs="") {

        $this->lib_user->cek_admin(true);

        $id_kbk = $this->mproposal->fieldTA("ID_KBK", $id_proposal);

        $treeid =  $this->mjadwalmahasiswa->field("ID_SLOT", array("ID_PROPOSAL" => $id_proposal, "SIDANGTA" => $id_sidangTA));

        $data['list_dosen_blm_diassign'] = $this->mjadwalmahasiswa->listNotAssignedDosen($id_sidangTA, $id_proposal, $id_kbk);

        $data['list_dosen_avail'] = $this->mjadwaldosenavail->listAvailableDosen($id_sidangTA, $id_proposal, $treeid, $id_kbk);

        $data['no'] = $no;

        $data['id_proposal'] = $id_proposal;

        $data['id_sidangTA'] = $id_sidangTA;

        $data['id_jdw_mhs'] = $id_jdw_mhs;

        $data['content'] = 'jadwalMahasiswa/gantiPenguji';

        $this->load->view('tb_template', $data);

    }



    function confirmGantiPenguji($no="", $id_sidangTA="", $id_proposal="", $nip_pengganti="", $id_jdw_mhs="", $id_jdw_avail="") {

        $this->lib_user->cek_admin(true);

        $treeid = $this->mjadwalmahasiswa->field("ID_SLOT", array("ID_PROPOSAL" => $id_proposal, "SIDANGTA" => $id_sidangTA));

        $field_nip_yg_diganti = "NIP".($no+2);

        $nip_yg_diganti = $this->mjadwalmahasiswa->field($field_nip_yg_diganti, array("ID_PROPOSAL" => $id_proposal, "SIDANGTA" => $id_sidangTA));



        // update jadwal avail dosen lama

        $data_jdw_dosen_avail_lama = array(

            "STATUS" => "0",

            "ID_PROPOSAL" => "0"

        );

        $options_jdw_dosen_avail_lama = array(

            "SIDANGTA" => $id_sidangTA,

            "ID_SLOT" => $treeid,

            "NIP" => $nip_yg_diganti

        );

        //echo "$id_sidangTA $treeid $nip_yg_diganti";

        $this->mjadwaldosenavail->update($data_jdw_dosen_avail_lama, $options_jdw_dosen_avail_lama);



        // jika dosen telah di-assign dan avail pada jam tsb

        if(! empty ($id_jdw_avail)) {

            $data_jdw_dosen_avail_baru = array(

                "STATUS" => "2",

                "ID_PROPOSAL" => $id_proposal

            );

            $options_jdw_dosen_avail_baru = array(

                "SIDANGTA" => $id_sidangTA,

                "ID_SLOT" => $treeid,

                "NIP" => $nip_pengganti

            );

            $this->mjadwaldosenavail->update($data_jdw_dosen_avail_baru, $options_jdw_dosen_avail_baru);

        } else {

            $data_jdw_dosen_avail_baru = array(

                "STATUS" => "2",

                "ID_PROPOSAL" => $id_proposal,

                "SIDANGTA" => $id_sidangTA,

                "ID_SLOT" => $treeid,

                "NIP" => $nip_pengganti

            );

            //echo "$id_proposal $treeid $nip_pengganti";

            $this->mjadwaldosenavail->add($data_jdw_dosen_avail_baru);

            $id_jdw_avail = $this->mjadwaldosenavail->field("ID_JDW_AVAIL", $data_jdw_dosen_avail_baru);

        }



        // update nip & slot avail penguji pada tabel mahasiswa

        $data_jdw_mhs = array(

            "$field_nip_yg_diganti" => $nip_pengganti,

            "UP_$field_nip_yg_diganti" => $id_jdw_avail

        );

        $options3 = array(

            "SIDANGTA" => $id_sidangTA,

            "ID_JDW_MHS" => $id_jdw_mhs

        );

        //echo "$field_nip_yg_diganti : $nip_pengganti, UP_$field_nip_yg_diganti : $id_jdw_avail, $id_jdw_mhs";

        $this->mjadwalmahasiswa->update($data_jdw_mhs, $options3);



        echo "<body onload='self.parent.tb_refresh(true)'></body>";

    }



    // cari pembimbing

    function updateJadwalPesertaSidang($id_sidangTA="") {

        $this->lib_user->cek_admin();

        foreach ($_POST as $a=>$b) {

            $z=explode("_",$a);

            if ($z[0]=="CARIJADWAL") {

                $id_sidangTA = $z[1];

                $id_proposal = $z[2];

                $id_kbk = $this->mproposal->fieldTA("ID_KBK", $id_proposal);

                $nip1 = $this->mproposal->fieldTA("PEMBIMBING1", $id_proposal);

                $nip2 = $this->mproposal->fieldTA("PEMBIMBING2", $id_proposal);

                $nrp = $this->mproposal->fieldTA("NRP", $id_proposal);

                $this->cariSlotPembimbing($id_kbk,$nip1,$nip2,$nrp,$id_proposal,$id_sidangTA,$jadwalmhs,'0',$id_kbk);

                $this->cariPenguji($jadwalmhs);

                $this->cariRuangan($jadwalmhs);

                $this->confirmed($jadwalmhs);

            }

            if ($z[0]=="DELETE") {

                $id_sidangTA=$z[1];

                $id_jdw_mhs=$z[2];

                $this->bebaskan($id_jdw_mhs,$id_sidangTA);

            }

            if ($z[0]=="SWITCH") {

                $id_sidangTA=$z[1];

                $id_jdw_mhs=$z[2];

                $this->switchPenguji($id_jdw_mhs);

            }

	}

        redirect("jadwalMahasiswa/pesertaSidang/$id_sidangTA");

    }



    function switchPenguji($id_jdw_mhs)

    {

        $this->lib_user->cek_admin();

        $detail_jdw_mhs = $this->mjadwalmahasiswa->detail($id_jdw_mhs);

        $this->mjadwalmahasiswa->update(array("NIP3" => $detail_jdw_mhs->NIP4, "NIP4" => $detail_jdw_mhs->NIP3), $id_jdw_mhs);

    }

    

    function publish($id_sidangTA, $publish=0)

    {

        $this->lib_user->cek_admin();

        $this->mjadwalmahasiswa->update(array("SHOW_ME" => $publish), array("SIDANGTA" => $id_sidangTA));

        $this->session->set_userdata('publish',$publish);

        redirect("jadwalMahasiswa/pesertaSidang/$id_sidangTA");

    }

    

    function bebaskan($id_jdw_mhs,$id_sidangTA) {

        $this->lib_user->cek_admin();

        $jdw_mhs = $this->mjadwalmahasiswa->detail($id_jdw_mhs);

        $data = array(

            "STATUS" => "0",

            "ID_PROPOSAL" => "0"

        );

        $options = array(

            "ID_JDW_AVAIL" => $jdw_mhs->UP_NIP1,

            "SIDANGTA" => $id_sidangTA

        );

        $this->mjadwaldosenavail->update($data, $options);

        $options = array(

            "ID_JDW_AVAIL" => $jdw_mhs->UP_NIP2,

            "SIDANGTA" => $id_sidangTA

        );

        $this->mjadwaldosenavail->update($data, $options);

        $options = array(

            "ID_JDW_AVAIL" => $jdw_mhs->UP_NIP3,

            "SIDANGTA" => $id_sidangTA

        );

        $this->mjadwaldosenavail->update($data, $options);

        $options = array(

            "ID_JDW_AVAIL" => $jdw_mhs->UP_NIP4,

            "SIDANGTA" => $id_sidangTA

        );

        $this->mjadwaldosenavail->update($data, $options);

        $options = array(

            "ID_JDW_RUANG_AVAIL" => $jdw_mhs->ID_JDW_RUANG_AVAIL,

            "SIDANGTA" => $id_sidangTA

        );

        $this->mjadwalruangavail->updateJadwalRuangAvailWithOptions($data, $options);



        $this->mjadwalmahasiswa->backup($id_jdw_mhs);



        $this->mjadwalmahasiswa->hapus($id_jdw_mhs);

    }



    function cariSlotPembimbing($id_kbk,$nip1,$nip2,$nrp,$id_proposal,$id_sidangTA,&$jadwalmhs,$p2boleh,$id_kbk) {

        $this->lib_user->cek_admin();

        $slotPembimbing = $this->mjadwaldosenavail->slotPembimbing($id_sidangTA, $nip1, $nip2, $p2boleh);

        if (count($slotPembimbing)>0) {

            // slot pembimbing2 penuh

            if ($slotPembimbing->ID_SLOT2=='') {

                $jadwalmhs['ID_PROPOSAL']="$id_proposal";

                $jadwalmhs['NIP1']="$nip1";

                $jadwalmhs['NIP2']="$nip2";

                $jadwalmhs['NIP3']='';

                $jadwalmhs['NIP4']='';

                $jadwalmhs['ID_SLOT']=$slotPembimbing->ID_SLOT1;

                $jadwalmhs['STATUS']='1';

                $jadwalmhs['SIDANGTA']=$id_sidangTA;

                $jadwalmhs['ID_JDW_RUANG']='1';

                $jadwalmhs['ID_KBK']="$id_kbk";

                $jadwalmhs['UP_NIP1']=$slotPembimbing->ID_JDW_AVAIL1;

                $jadwalmhs['UP_NIP2']='';

                $jadwalmhs['UP_NIP3']='';

                $jadwalmhs['UP_NIP4']='';

                $jadwalmhs['ID_JDW_RUANG_AVAIL']='';

                $jadwalmhs['MASUK']='0';

            } else {

                // ada slot kosong utk pembimbing 1 & 2

                $jadwalmhs['ID_PROPOSAL']="$id_proposal";

                $jadwalmhs['NIP1']="$nip1";

                $jadwalmhs['NIP2']="$nip2";

                $jadwalmhs['NIP3']='';

                $jadwalmhs['NIP4']='';

                $jadwalmhs['ID_SLOT']=$slotPembimbing->ID_SLOT1;

                $jadwalmhs['STATUS']='1';

                $jadwalmhs['SIDANGTA']=$id_sidangTA;

                $jadwalmhs['ID_JDW_RUANG']='0';

                $jadwalmhs['ID_KBK']="$id_kbk";

                $jadwalmhs['UP_NIP1']=$slotPembimbing->ID_JDW_AVAIL1;

                $jadwalmhs['UP_NIP2']=$slotPembimbing->ID_JDW_AVAIL2;

                $jadwalmhs['UP_NIP3']='';

                $jadwalmhs['UP_NIP4']='';

                $jadwalmhs['ID_JDW_RUANG_AVAIL']='';

                $jadwalmhs['MASUK']='0';

            }

        } else {

            // slot semua pembimbing penuh

            $jadwalmhs['ID_PROPOSAL']="$id_proposal";

            $jadwalmhs['NIP1']="$nip1";

            $jadwalmhs['NIP2']="$nip2";

            $jadwalmhs['NIP3']='';

            $jadwalmhs['NIP4']='';

            $jadwalmhs['ID_SLOT']='';

            $jadwalmhs['STATUS']='2';

            $jadwalmhs['SIDANGTA']=$id_sidangTA;

            $jadwalmhs['ID_JDW_RUANG']='0';

            $jadwalmhs['ID_KBK']="$id_kbk";

            $jadwalmhs['UP_NIP1']='';

            $jadwalmhs['UP_NIP2']='';

            $jadwalmhs['UP_NIP3']='';

            $jadwalmhs['UP_NIP4']='';

            $jadwalmhs['ID_JDW_RUANG_AVAIL']='';

            $jadwalmhs['MASUK']='0';

        }

        return 0;

    }



    function cariPenguji(&$jadwalmhs) {

        $this->lib_user->cek_admin();

        if ($jadwalmhs['STATUS']!='1') {

            return 0;

        }

        $id_sidangTA = $jadwalmhs['SIDANGTA'];

        $id_kbk = $jadwalmhs['ID_KBK'];

        $treeid=$jadwalmhs['ID_SLOT'];

        $nip1 = $jadwalmhs['NIP1'];

        $nip2=$jadwalmhs['NIP2'];



        $this->mjadwaldosenavail->createTablePengujiAvailTemp($id_sidangTA, $treeid, $id_kbk, $nip1, $nip2);



        $jum = $this->mjadwaldosenavail->countSlotAvailPembimbing1($id_sidangTA, $treeid, $id_kbk, $nip1);



        $jumlah_penguji_avail_temp = $this->mjadwaldosenavail->countTablePengujiAvailTemp1();

        $penguji_avail_temp = $this->mjadwaldosenavail->tablePengujiAvailTemp1();



        if ($jumlah_penguji_avail_temp>0) {

            if ($jumlah_penguji_avail_temp>1) {

                $this->mjadwaldosenavail->createTablePengujiAvailTemp2($id_sidangTA, $treeid, $id_kbk, $nip1, $nip2, $penguji_avail_temp->NIP);

                $penguji_avail_temp2 = $this->mjadwaldosenavail->tablePengujiAvailTemp2();

                $jadwalmhs['NIP3']=$penguji_avail_temp->NIP;

                $jadwalmhs['NIP4']=$penguji_avail_temp2->NIP;

                $jadwalmhs['STATUS']='3'; //sudah menemukan penguji (1) dan (2)



                $jadwalmhs['UP_NIP3']=$penguji_avail_temp->ID_JDW_AVAIL;

                $jadwalmhs['UP_NIP4']=$penguji_avail_temp2->ID_JDW_AVAIL;

                $jadwalmhs['MASUK']='1';

            } else {

                $jadwalmhs['NIP3']=$penguji_avail_temp->NIP;

                $jadwalmhs['NIP4']='000000000';

                $jadwalmhs['STATUS']='4'; //tidak menemukan penguji (2)



                $jadwalmhs['UP_NIP3']=$penguji_avail_temp->ID_JDW_AVAIL;

                $jadwalmhs['MASUK']='1';

                //echo "Penguji 2 kosong <br>";

            }

        } else {

            $jadwalmhs['NIP3']='000000000';

            $jadwalmhs['NIP4']='000000000';

            $jadwalmhs['STATUS']='5'; //tidak menemukan semua penguji

            $jadwalmhs['MASUK']='1';

            //echo "Penguji 1 & 2 kosong <br>";

        }

    }



    function cariRuangan(&$jadwalmhs) {

        $this->lib_user->cek_admin();

        $treeid=$jadwalmhs['ID_SLOT'];

        $id_kbk = $jadwalmhs['ID_KBK'];

        $id_sidangTA = $jadwalmhs['SIDANGTA'];

        $nip1 = $jadwalmhs['NIP1'];

        $nip2=$jadwalmhs['NIP2'];

        

        if (($jadwalmhs['STATUS']!='3')) {

            return 0;

        }



        $options = array(

            "ID_SLOT" => $treeid,

            "ID_KBK" => $id_kbk,

            "SIDANGTA" => $id_sidangTA,

            "STATUS" => "0"

        );

        $ruang_avail = $this->mjadwalruangavail->getJadwalRuangAvail2($options);



        if (count($ruang_avail)>0) { // ada ruangan

            $jadwalmhs['ID_JDW_RUANG']=$ruang_avail->ID_JDW_RUANG;

            $jadwalmhs['ID_JDW_RUANG_AVAIL']=$ruang_avail->ID_JDW_RUANG_AVAIL;

            $jadwalmhs['STATUS']='6';

            $jadwalmhs['MASUK']='1';

        } else {

            $jadwalmhs['ID_JDW_RUANG']='0';

            $jadwalmhs['STATUS']='7'; // tidak ada ruangan available

            $jadwalmhs['ID_JDW_RUANG_AVAIL']='';

            $jadwalmhs['MASUK']='1';

            //echo "Tidak ada ruangan $treeid $id_kbk $id_sidangTA 0<br>";

        }

    }



    function confirmed($jadwalmhs) {

        $this->lib_user->cek_admin();

        $statusku = $jadwalmhs['STATUS'];

        $ismasuk = $jadwalmhs['MASUK'];



        if ($statusku=='6') {

            if (($jadwalmhs['UP_NIP1']<>'') || ($jadwalmhs['UP_NIP1']<>'-')) {

                $data = array(

                    "STATUS" => "2",

                    "ID_PROPOSAL" => $jadwalmhs['ID_PROPOSAL']

                );

                $options = array("ID_JDW_AVAIL" => $jadwalmhs['UP_NIP1']);

                $this->mjadwaldosenavail->update($data, $options);

            }



            if (($jadwalmhs['UP_NIP2']<>'') || ($jadwalmhs['UP_NIP2']<>'-')) {

                $data = array(

                    "STATUS" => "2",

                    "ID_PROPOSAL" => $jadwalmhs['ID_PROPOSAL']

                );

                $options = array("ID_JDW_AVAIL" => $jadwalmhs['UP_NIP2']);

                $this->mjadwaldosenavail->update($data, $options);

            }



            if (($jadwalmhs['UP_NIP3']<>'') || ($jadwalmhs['UP_NIP3']<>'-')) {

                $data = array(

                    "STATUS" => "2",

                    "ID_PROPOSAL" => $jadwalmhs['ID_PROPOSAL']

                );

                $options = array("ID_JDW_AVAIL" => $jadwalmhs['UP_NIP3']);

                $this->mjadwaldosenavail->update($data, $options);

            }



            if (($jadwalmhs['UP_NIP4']<>'') || ($jadwalmhs['UP_NIP4']<>'-')) {

                $data = array(

                    "STATUS" => "2",

                    "ID_PROPOSAL" => $jadwalmhs['ID_PROPOSAL']

                );

                $options = array("ID_JDW_AVAIL" => $jadwalmhs['UP_NIP4']);

                $this->mjadwaldosenavail->update($data, $options);

            }



            if ($jadwalmhs['ID_JDW_RUANG_AVAIL']<>'') {

                $data = array(

                    "STATUS" => "2",

                    "ID_PROPOSAL" => $jadwalmhs['ID_PROPOSAL']

                );

                $options = array("ID_JDW_RUANG_AVAIL" => $jadwalmhs['ID_JDW_RUANG_AVAIL']);

                $this->mjadwalruangavail->updateJadwalRuangAvailWithOptions($data, $options);

            }

        }



        if ($statusku=='7') {

            if (($jadwalmhs['UP_NIP1']<>'') || ($jadwalmhs['UP_NIP1']<>'-')) {

                $data = array(

                    "STATUS" => "2",

                    "ID_PROPOSAL" => $jadwalmhs['ID_PROPOSAL']

                );

                $options = array("ID_JDW_AVAIL" => $jadwalmhs['UP_NIP1']);

                $this->mjadwaldosenavail->update($data, $options);

            }



            if (($jadwalmhs['UP_NIP2']<>'') || ($jadwalmhs['UP_NIP2']<>'-')) {

                $data = array(

                    "STATUS" => "2",

                    "ID_PROPOSAL" => $jadwalmhs['ID_PROPOSAL']

                );

                $options = array("ID_JDW_AVAIL" => $jadwalmhs['UP_NIP2']);

                $this->mjadwaldosenavail->update($data, $options);

            }



            if (($jadwalmhs['UP_NIP3']<>'') || ($jadwalmhs['UP_NIP3']<>'-')) {

                $data = array(

                    "STATUS" => "2",

                    "ID_PROPOSAL" => $jadwalmhs['ID_PROPOSAL']

                );

                $options = array("ID_JDW_AVAIL" => $jadwalmhs['UP_NIP3']);

                $this->mjadwaldosenavail->update($data, $options);

            }



            if (($jadwalmhs['UP_NIP4']<>'') || ($jadwalmhs['UP_NIP4']<>'-')) {

                $data = array(

                    "STATUS" => "2",

                    "ID_PROPOSAL" => $jadwalmhs['ID_PROPOSAL']

                );

                $options = array("ID_JDW_AVAIL" => $jadwalmhs['UP_NIP4']);

                $this->mjadwaldosenavail->update($data, $options);

            }



        }



        if ($statusku=='4') {

            if (($jadwalmhs['UP_NIP1']<>'') || ($jadwalmhs['UP_NIP1']<>'-')) {

                $data = array(

                    "STATUS" => "2",

                    "ID_PROPOSAL" => $jadwalmhs['ID_PROPOSAL']

                );

                $options = array("ID_JDW_AVAIL" => $jadwalmhs['UP_NIP1']);

                $this->mjadwaldosenavail->update($data, $options);

            }



            if (($jadwalmhs['UP_NIP2']<>'') || ($jadwalmhs['UP_NIP2']<>'-')) {

                $data = array(

                    "STATUS" => "2",

                    "ID_PROPOSAL" => $jadwalmhs['ID_PROPOSAL']

                );

                $options = array("ID_JDW_AVAIL" => $jadwalmhs['UP_NIP2']);

                $this->mjadwaldosenavail->update($data, $options);

            }



            if (($jadwalmhs['UP_NIP3']<>'') || ($jadwalmhs['UP_NIP3']<>'-')) {

                $data = array(

                    "STATUS" => "2",

                    "ID_PROPOSAL" => $jadwalmhs['ID_PROPOSAL']

                );

                $options = array("ID_JDW_AVAIL" => $jadwalmhs['UP_NIP3']);

                $this->mjadwaldosenavail->update($data, $options);

            }



            if (($jadwalmhs['UP_NIP4']<>'') || ($jadwalmhs['UP_NIP4']<>'-')) {

                $data = array(

                    "STATUS" => "2",

                    "ID_PROPOSAL" => $jadwalmhs['ID_PROPOSAL']

                );

                $options = array("ID_JDW_AVAIL" => $jadwalmhs['UP_NIP4']);

                $this->mjadwaldosenavail->update($data, $options);

            }



        }



        if ($statusku=='5') {

            if (($jadwalmhs['up_nip1']<>'') || ($jadwalmhs['up_nip1']<>'-')) {

                    $sql="update jadwal_availability set status='2',propid=" . $jadwalmhs['propid'] . " where id='". $jadwalmhs['up_nip1']. "'";

                    mysql_query($sql);

            }



            if (($jadwalmhs['up_nip2']<>'') || ($jadwalmhs['up_nip2']<>'-')) {

                    $sql="update jadwal_availability set status='2',propid=" . $jadwalmhs['propid'] . " where id='". $jadwalmhs['up_nip2']. "'";

                    mysql_query($sql);

            }



        }



        if ($ismasuk=='1') {

            //echo "update";

            $data = array(

                "ID_PROPOSAL" => $jadwalmhs['ID_PROPOSAL'],

                "NIP1" => $jadwalmhs['NIP1'],

                "NIP2" => $jadwalmhs['NIP2'],

                "NIP3" => $jadwalmhs['NIP3'],

                "NIP4" => $jadwalmhs['NIP4'],

                "ID_SLOT" => $jadwalmhs['ID_SLOT'],

                "STATUS" => $jadwalmhs['STATUS'],

                "SIDANGTA" => $jadwalmhs['SIDANGTA'],

                "ID_JDW_RUANG" => $jadwalmhs['ID_JDW_RUANG'],

                "ID_KBK" => $jadwalmhs['ID_KBK'],

                "UP_NIP1" => $jadwalmhs['UP_NIP1'],

                "UP_NIP2" => $jadwalmhs['UP_NIP2'],

                "UP_NIP3" => $jadwalmhs['UP_NIP3'],

                "UP_NIP4" => $jadwalmhs['UP_NIP4'],

                "ID_JDW_RUANG_AVAIL" => $jadwalmhs['ID_JDW_RUANG_AVAIL']

            );

            $this->mjadwalmahasiswa->add($data);

        }



    }

   

    // kemungkinanpenguji

    function cariJadwal($id_sidangTA="",$nip_pemb1="",$nip_pemb2="",$id_prop="",$id_kbk=""){

        $this->lib_user->cek_admin();

        //var_dump($nip_pemb2);

        $list_slot = $this->mslot->getListSlot($id_sidangTA);

        //var_dump($list_slot);

        foreach ($list_slot as $slot) {

            $cekKosongPembimbing = $this->mjadwalmahasiswa->cekAvailabilityDosen($id_sidangTA, $slot->TREEID, $id_kbk, $nip_pemb1, $nip_pemb2);

            

            if($cekKosongPembimbing) {

                $slot->JADWAL_AVAIL = $this->mjadwalmahasiswa->listAvailableJadwal($id_sidangTA, $slot->TREEID, $id_kbk);

                //var_dump($slot->JADWAL_AVAIL);

            } else {

                $slot->JADWAL_AVAIL = null;

            }

            $slot->DOSEN_AVAIL = $this->mjadwalmahasiswa->listAvailableDosen($id_sidangTA, $slot->TREEID, $id_kbk);

        }



        $data['parameter'] = array(

            "SIDANGTA" => $id_sidangTA,

            "NIP1" => $nip_pemb1,

            "NIP2" => $nip_pemb2,

            "IDPROPOSAL" => $id_prop,

            "IDKBK" => $id_kbk

        );

        $data['list_slot'] = $list_slot;

        $data['content'] = "jadwalMahasiswa/cariJadwal";



        $this->load->view("tb_template", $data);

    }



    function pilihPenguji($id_sidangTA="",$nip_pemb1="",$nip_pemb2="",$id_prop="",$id_kbk="", $treeid="", $id_jdw_ruang_avail="") {

        $this->lib_user->cek_admin(true);

        $this->form_validation->set_rules('idproposal', 'idproposal', 'required');

        $this->form_validation->set_rules('idkbk', 'idkbk', 'required');

        $this->form_validation->set_rules('idslot', 'idslot', 'required');

        $this->form_validation->set_rules('sidangta', 'sidangta', 'required');

        $this->form_validation->set_rules('nip1', 'nip1', 'required');

        $this->form_validation->set_rules('availnip1', 'availnip1', 'required');

        $this->form_validation->set_rules('nip2', 'nip2', 'required');

        $this->form_validation->set_rules('availnip2', 'availnip2', 'required');

        $this->form_validation->set_rules('idjdwruangavail', 'idjdwruangavail', 'required');

                

        // cek apakah ada input

        if ($this->form_validation->run()==FALSE) {

            $avail_nip1 = $this->mjadwalmahasiswa->idJadwalAvailDosen($id_sidangTA, $treeid, $id_kbk, $nip_pemb1);

            $avail_nip2 = $this->mjadwalmahasiswa->idJadwalAvailDosen($id_sidangTA, $treeid, $id_kbk, $nip_pemb2);

            $list_dosen_free = $this->mjadwalmahasiswa->listAvailableDosenPenguji($id_sidangTA, $treeid, $id_kbk, $nip_pemb1, $nip_pemb2);



            $data['parameter'] = array(

                "SIDANGTA" => $id_sidangTA,

                "NIP1" => $nip_pemb1,

                "NIP2" => $nip_pemb2,

                "IDPROPOSAL" => $id_prop,

                "IDKBK" => $id_kbk,

                "IDSLOT" => $treeid,

                "IDJDWRUANGAVAIL" => $id_jdw_ruang_avail,

                "AVAILNIP1" => $avail_nip1,

                "AVAILNIP2" => $avail_nip2

            );

            $data['list_dosen_free'] = $list_dosen_free;

            $data['content'] = "jadwalMahasiswa/pilihPenguji";



            $this->load->view("tb_template", $data);

        } else {

            $jadwalmhs['NIP3']='';

            $jadwalmhs['NIP4']='';

            $jadwalmhs['UP_NIP3']='';

            $jadwalmhs['UP_NIP4']='';



            $jum=0;

            foreach ($_POST as $a=>$b) {

                if ($b=="on") {

                    if (substr($a,0,4)=="nipx") {

                            $jum++;

                            $x=explode("_", $a);

                            if ($jum==1) {

                                    $jadwalmhs['NIP3']=$x[2];

                                    $jadwalmhs['UP_NIP3']=$x[1];

                            }



                            if ($jum==2) {

                                    $jadwalmhs['NIP4']=$x[2];

                                    $jadwalmhs['UP_NIP4']=$x[1];

                            }



                    }

                }

            }



            $data_ruang_avail = array (

                "ID_KBK" => $this->db->escape_like_str($this->input->post('idkbk'))

            );

            $options = array(

                "ID_JDW_RUANG_AVAIL" => $this->db->escape_like_str($this->input->post('idjdwruangavail')),

                "ID_SLOT" => $this->db->escape_like_str($this->input->post('idslot'))



            );

            $this->mjadwalruangavail->updateJadwalRuangAvailWithOptions($data_ruang_avail, $options);

            

            $jadwalmhs['ID_PROPOSAL']=$this->input->post('idproposal');

            $jadwalmhs['NIP1']=$this->input->post('nip1');

            $jadwalmhs['NIP2']=$this->input->post('nip2');

            $jadwalmhs['ID_SLOT']=$this->input->post('idslot');

            $jadwalmhs['STATUS']='6';

            $jadwalmhs['SIDANGTA']=$this->input->post('sidangta');

            $jadwalmhs['ID_JDW_RUANG']=$this->mjadwalmahasiswa->idRuangan($this->input->post('idjdwruangavail'), $this->input->post('idslot'));

            $jadwalmhs['ID_KBK']=$this->input->post('idkbk');

            $jadwalmhs['UP_NIP1']=$this->input->post('availnip1');

            $jadwalmhs['UP_NIP2']=$this->input->post('availnip2');

            $jadwalmhs['ID_JDW_RUANG_AVAIL']=$this->input->post('idjdwruangavail');

            $jadwalmhs['MASUK']='1';

            $this->confirmed($jadwalmhs);



            echo "<body onload='self.parent.tb_refresh(true)'></body>";

        }

    }



    

//

//    function publishJadwalMajuSidang($id_sidangTA="") {

//

//    }

//

//    function unpublishJadwalMajuSidang($id_sidangTA="") {

//

//    }

//

//    function resetAllJadwalMajuSidang($id_sidangTA="") {

//

//    }

//

//    // bebas

//    function deleteJadwalMajuSidang($id_sidangTA="", $id_jdw_mhs="") {

//

//    }

//

//    // switch

//    function switchDosenPenguji($id_proposal="", $id_sidangTA="", $nip_penguji1="", $nip_penguji2="", $id_jdw_mhs="") {

//

//    }



    



    





    // --------------------------------- akhir : MAJU SIDANG --------------------------------------

	

}

?>