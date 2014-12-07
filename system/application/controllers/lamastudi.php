<?php 
class Lamastudi extends Controller 
{
    function Lamastudi() 
    {
        parent::Controller();
        // load model, library, helper etc.
        $this->load->library('lib_alert');
        $this->load->library('lib_user');
        $this->load->library('lib_js');
        $this->load->library('lib_tugas_akhir');
        $this->load->library('pquery');
        $this->load->model('mprogres');
        $this->load->model('mdosen');
        $this->load->model('mproposal');
    }

    function index() 
    {
        $this->load->model('mlamastudi');
        // set title, menu, view
        $this->update();
        $data['title'] = "Lama Pengerjaan Tugas Akhir";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['content'] = "lamastudi/content-index";
        $data['list_ta'] = $this->mlamastudi->getListTAdanLamaStudi();   
        
        $this->load->view('template', $data);
    }
    
    function update()
    {
        $this->load->model('mlamastudi');
        $this->load->model('msidang');
        $this->load->model('mproposal');
        $rows = $this->mlamastudi->getListTAUpdate();
        $i = 0;
        foreach($rows as $row)
        {
            if($i==60) break;
            if($this->msidang->getDetailSidangTA($row->STA,$row->NRP)!=NULL)
            {
                //var_dump($row);
                $row->TGL_SIDANG_TA = date('Y-m-d', strtotime($this->msidang->getDetailSidangProposal($row->SPROP)->WAKTU));            
                $row->TGL_SIDANG_TA_ASLI = date('Y-m-d', strtotime($this->msidang->getDetailSidangTA($row->STA,$row->NRP)->DESKRIPSI));
                //echo date('Y-m-d', strtotime($this->msidang->getDetailSidangProposal($row->SPROP)->WAKTU));
                //echo date('d-m-Y', strtotime($this->msidang->getDetailSidangTA($row->STA,$row->NRP)->DESKRIPSI));
                $this->mproposal->update($row, $row->ID_PROPOSAL);         
                $i++;
            }
            //
        }
    }
    
    function perwisuda($id_periode_wisuda="-1") 
    {
        $this->load->model('mlamastudi');
        // set title, menu, view
        $data['title'] = "Lama Pengerjaan Tugas Akhir";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['content'] = "lamastudi/content-perwisuda";
        
        $data['periode'] = $this->mlamastudi->getPeriode();

        if($this->input->post('periodewisuda')!="")
        {
            $periode_wisuda = $this->input->post('periodewisuda');
            $this->session->set_userdata('periode',$periode_wisuda);
        }
        else if($id_periode_wisuda!="-1")
        {
             $periode_wisuda = $data['periode'][$id_periode_wisuda-1]->periode;
            $this->session->set_userdata('periode',$periode_wisuda);
        }
        else 
        {
            
            $periode_wisuda = "";
            //echo $data['periode'][0]->periode;
            $this->session->set_userdata('periode',$periode_wisuda);
        }

        $data['list_ta'] = $this->mlamastudi->getListTAdanLamaStudi($periode_wisuda);
        
        $this->load->view('template', $data);
    }
    
    function rataperwisuda() 
    {
        $this->load->model('mlamastudi');
        // set title, menu, view
        $data['title'] = "Rata-Rata Lama Pengerjaan Tugas Akhir";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['content'] = "lamastudi/content-rataperwisuda";
        $data['list_ta'] = $this->mlamastudi->getWisudadanRataLamaStudi();
        $this->load->view('template', $data);
    }

    function statistikTA()
    {
        $this->load->model('mlamastudi');
        $tes = $this->mlamastudi->getTotalMahasiswaTA(5);
        $count = 0;
        $newData = array();
        $maxArray = count($tes);

        for ($i=0; $i < $maxArray; $i++) { 
            if (($i != 0) && ($tes[$i]['SEMESTER_SIDANG_TA'] == $tes[$i-1]['SEMESTER_SIDANG_TA']) && $tes[$i]['TAHUN_SIDANG_TA'] == $tes[$i-1]['TAHUN_SIDANG_TA']) {
                $newData[$count-1]['TOTAL'] += $tes[$i]['TOTAL'];
            }
            else {
                $newData[$count] = $tes[$i];
                $count++;
            }
        }
        $data['mahasiswaTA'] = $newData;
        $tes = $this->mlamastudi->getTotalMahasiswaTALulus(5);
        $count = 0;
        $newData = array();
        $maxArray = count($tes);
        for ($i=0; $i < $maxArray; $i++) { 
            if (($i != 0) && ($tes[$i]['SEMESTER_SIDANG_TA'] == $tes[$i-1]['SEMESTER_SIDANG_TA']) && $tes[$i]['TAHUN_SIDANG_TA'] == $tes[$i-1]['TAHUN_SIDANG_TA']) {
                $newData[$count-1]['TOTAL'] += $tes[$i]['TOTAL'];
            }
            else {
                $newData[$count] = $tes[$i];
                $count++;
            }
        }
        $data['mahasiswaTALulus'] = $newData;
        $data['title'] = "Statistik Tugas Akhir Mahasiswa";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['content'] = "lamastudi/content-statistikTA";
        $this->load->view('template', $data);
    }

    function statistikPembimbingTA()
    {
        $this->load->model('mlamastudi');
        $filter_tahun = $this->input->post('filter_statistik_tahun');
        $filter_dosen = $this->input->post('filter_statistik_dosen');
        
        if($this->input->post('filter_statistik_tahun')!='all')
        {
            $filter_statistik_tahun = $this->input->post('filter_statistik_tahun');
            $data['pembimbingTA'] = $this->mlamastudi->getTotalPembimbingTAbyYear($filter_statistik_tahun);
        }
        elseif ($filter_tahun=="all" || $filter_dosen=="all")
        {
            echo "1";
            $data['pembimbingTA'] = $this->mlamastudi->getTotalPembimbingTA();
        }
        elseif($this->input->post('filter_statistik_dosen')!='all')
        {
            $filter_statistik_dosen = $this->input->post('filter_statistik_dosen');
            $data['pembimbingTA'] = $this->mlamastudi->getTotalPembimbingTAbyName($filter_statistik_dosen);
            var_dump($data['pembimbingTA']);
            exit();
        }
        else
        {
            $data['pembimbingTA'] = $this->mlamastudi->getTotalPembimbingTA();
        }
        $data['tahun'] = $this->mlamastudi->getYear();
        $data['dosen'] = $this->mlamastudi->getTotalPembimbingTA();
        $data['title'] = "Statistik Dosen Pembimbing TA";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['content'] = "lamastudi/content-statistikpembimbingTA";
        $this->load->view('template', $data);
    }
}

/* End of file lamastudi.php */
/* Location: ./system/application/controllers/lamastudi.php */
