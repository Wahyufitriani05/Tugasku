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
        $data['title'] = "Lama Pengerjaan Tugas Akhir";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['content'] = "lamastudi/content-index";
        $data['list_ta'] = $this->mlamastudi->getListTAdanLamaStudi();
        $this->load->view('template', $data);
    }
    
    function perwisuda($id_periode_wisuda="-1") 
    {
        $this->load->model('mlamastudi');
        // set title, menu, view
        $data['title'] = "Lama Pengerjaan Tugas Akhir";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['content'] = "lamastudi/content-perwisuda";
        if($this->input->post('periodewisuda')!="")
        {
            $periode_wisuda = $this->input->post('periodewisuda');
            $this->session->set_userdata('periode',$periode_wisuda);
        }
        else 
        {
            $periode_wisuda = $id_periode_wisuda;
            $this->session->set_userdata('periode',$periode_wisuda);
        }
        $data['list_ta'] = $this->mlamastudi->getListTAdanLamaStudi($periode_wisuda);
        $data['periode'] = $this->mlamastudi->getPeriode();
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
        $data['title'] = "Statistik Tugas Akhir Mahasiswa";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['content'] = "lamastudi/content-statistikTA";
        $this->load->view('template', $data);
    }

    function statistikPembimbingTA()
    {
        $this->load->model('mlamastudi');
        $tes = $this->mlamastudi->getTotalPembimbingTA();
        $count = 0;
        $newData = array();
        $maxArray = count($tes);

        // for ($i=0; $i < $maxArray; $i++) { 
        //         $newData[$i] = $tes[$i];
            
        // }

        //var_dump($newData);
        $data['pembimbingTA'] = $tes;
        $data['title'] = "Statistik Dosen Pembimbing TA";
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['content'] = "lamastudi/content-statistikpembimbingTA";
        $this->load->view('template', $data);
    }
}

/* End of file lamastudi.php */
/* Location: ./system/application/controllers/lamastudi.php */
