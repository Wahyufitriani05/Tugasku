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
        $filter_tahun = $this->input->get('filter_tahun');
        $filter_dosen = $this->input->get('filter_dosen');
        $filter_tipe = $this->input->get('filter_tipe');
        $filter_rmk = $this->input->get('filter_rmk');
        
        $data['filter'] = '';
        

        if($filter_tipe=='penguji') 
            //redirect(base_url().'index.php/lamastudi/statistikPengujiTA?filter_tahun='.$filter_tahun.'&filter_dosen='.$filter_dosen."&filter_tipe=".$filter_tipe); 
            redirect(base_url().'index.php/lamastudi/statistikPengujiTA?filter_tahun='.$filter_tahun.'&filter_tipe='.$filter_tipe.'&filter_rmk='.$filter_rmk); 
        
        if($filter_tahun=="" && $filter_dosen=="")
        {
            $data['filter'] = 'nama_dosen';
           $data['pembimbingTA'] = $this->mlamastudi->getTotalPembimbingTA($filter_rmk);
        }
        elseif($filter_tahun=="all" || $filter_dosen=="all")
        {
            //echo "TES";
           $data['filter'] = 'nama_dosen';
           $data['pembimbingTA'] = $this->mlamastudi->getTotalPembimbingTA($filter_rmk);
        }
        elseif($filter_tahun !='all' && !$filter_dosen )
        {
            //echo "TES";
            $data['filter'] = 'nama_dosen';
            $data['pembimbingTA'] = $this->mlamastudi->getTotalPembimbingTAbyYear($filter_tahun,$filter_rmk);
        }
        elseif(!$filter_tahun && $filter_dosen != 'all')
        {
         
            $data['filter'] = 'tahun';
            $data['pembimbingTA'] = $this->mlamastudi->getTotalPembimbingTAbyName($filter_dosen);
        }
        else
        {
           
            $data['filter'] = 'nama_dosen';
            $data['pembimbingTA'] = $this->mlamastudi->getTotalPembimbingTA($filter_rmk);
        }
        
        
        $data['tahun'] = $this->mlamastudi->getYear();
        $data['dosen'] = $this->mlamastudi->getTotalPembimbingTA($filter_rmk);
        $data['title'] = "Statistik Dosen Pembimbing TA";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['rmk'] = $this->mdosen->getKBK();
        $data['header'] = $this->lib_user->get_header();
        $data['filter_tahun'] = $filter_tahun;
        $data['filter_dosen'] = $filter_dosen;
        $data['filter_tipe'] = $filter_tipe;
        $data['filter_rmk'] = $filter_rmk;
        $data['content'] = "lamastudi/content-statistikpembimbingTA";
        $this->load->view('template', $data);
    }
    
    function statistikPengujiTA()
    {
        $this->update();
        $this->load->model('mjadwalmahasiswa');
        $this->load->model('mlamastudi');
        $filter_tahun = $this->input->get('filter_tahun');
        $filter_dosen = $this->input->get('filter_dosen');
        $filter_tipe = $this->input->get('filter_tipe');
        $filter_rmk = $this->input->get('filter_rmk');
        $data['filter'] = '';
        
        if($filter_tipe=='pembimbing') 
            //redirect(base_url().'index.php/lamastudi/statistikPembimbingTA?filter_tahun='.$filter_tahun.'&filter_dosen='.$filter_dosen."&filter_tipe=".$filter_tipe); 
            redirect(base_url().'index.php/lamastudi/statistikPembimbingTA?filter_tahun='.$filter_tahun.'&filter_tipe='.$filter_tipe.'&filter_rmk='.$filter_rmk); 
        
        if($filter_tahun=="" && $filter_dosen=="")
        {
            
           $data['filter'] = 'NAMA_DOSEN';
           $data['pengujiTA'] = $this->mjadwalmahasiswa->getTotalPenguji($filter_rmk);
        }
        elseif($filter_tahun=="all" || $filter_dosen=="all")
        {
           $data['filter'] = 'NAMA_DOSEN';
           $data['pengujiTA'] = $this->mjadwalmahasiswa->getTotalPenguji($filter_rmk);
        }
        elseif($filter_tahun !='all' && !$filter_dosen)
        {
            //echo "TA";
            $data['filter'] = 'NAMA_DOSEN';
            $data['pengujiTA'] = $this->mjadwalmahasiswa->getTotalPengujiByYear($filter_tahun,$filter_rmk);
        }
        elseif(!$filter_tahun && $filter_dosen != 'all')
        {
            //echo "TA";
            $data['filter'] = 'tahun';
            $data['pengujiTA'] = $this->mjadwalmahasiswa->getTotalPengujiByName($filter_dosen);
        }
        else
        {
            $data['filter'] = 'NAMA_DOSEN';
            $data['pengujiTA'] = $this->mjadwalmahasiswa->getTotalPenguji($filter_rmk);
        }
        //$data['pengujiTA'] = $this->mjadwalmahasiswa->getTotalPenguji();
        
        $data['dosen'] = $this->mjadwalmahasiswa->getTotalPenguji($filter_rmk);
        $data['tahun'] = $this->mjadwalmahasiswa->getYear();
        $data['title'] = "Statistik Dosen Penguji TA";
        $data['rmk'] = $this->mdosen->getKBK();
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['filter_tahun'] = $filter_tahun;
        $data['filter_dosen'] = $filter_dosen;
        $data['filter_tipe'] = $filter_tipe;
        $data['filter_rmk'] = $filter_rmk;
        $data['content'] = "lamastudi/content-statistikPengujiTA";
        $this->load->view('template', $data);
          
         
    }
    
    function detailMahasiswa()
    {
        $nama = $this->input->get('nama');
        $tahun = $this->input->get('tahun');
        $tipe = $this->input->get('tipe');
        $rmk = $this->input->get('rmk');
        
        $nip = $this->mdosen->getNIP($nama);
        
        
        
        $data['tipe'] = $tipe;
        $data['title'] = "List Mahasiswa";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['content'] = "lamastudi/content-detailMahasiswa";
        $data['listTA'] = $this->mproposal->getListTANew($nip, $tahun, $tipe, $rmk);
        //var_dump($data['listTA']);
        $this->load->view('template', $data);
        
        
    }
}

/* End of file lamastudi.php */
/* Location: ./system/application/controllers/lamastudi.php */
