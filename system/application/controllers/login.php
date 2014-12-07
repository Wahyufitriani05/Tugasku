<?php
class Login extends Controller {

    function Login()
    {
        parent::Controller();
        $this->load->library('lib_js');
        $type = $this->session->userdata('type');
        if(!isset($type)) {
            $string = "Anda tidak dapat mengakses halaman ini!!!";
            redirect('berita', 'refresh');
        }
        else{
            $this->load->library('encrypt');
            $this->form_validation->set_error_delimiters('<br/><font color="red">* ', '</font>');
            $kode_enkripsi='g7Rd7G8vhrD78yhv398hiDHrg89h34gh';
        }
    }
    
    function index()
    {
        $data['title'] = "Login newMonta";
        $data['js_menu'] = "menuGuest";
        $data['header'] = "headerGuest";
        $data['content'] = "content";
        if($this->session->userdata('type')=="dosen"){
            $data['js_menu'] = "menuDosen";
            $data['header'] = "headerDosen";
        }
        else if($this->session->userdata('type')=="admin"){
            $data['js_menu'] = "menuAdmin";
            $data['header'] = "headerAdmin";
        }
        $this->load->view('template', $data);
    }

    function ubahPassword()
    {
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
        else if($type=='KBJ' || $type=='KCV' || $type=='RPL' || $type=='AJK' || $type=='MI' || $type=='DTK' || $type=='AP' || $type=='IGS')
        {
            $data['js_menu'] = "menuKBK";
            $data['header'] = "headerAdmin";
        }

        //cek apakah benar status login admin
        if($type!="mahasiswa" && $type!="dosen" && $type!="admin" && $type!="KBJ" && $type!="KCV" && $type!="RPL" && $type!="AJK" && $type!="MI" && $type!="DTK" && $type!="AP" && $type!="IGS")redirect('berita/lihatBerita','refresh');

        $this->form_validation->set_rules('password_lama', 'Password Lama', 'required');
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[5]');
        $this->form_validation->set_rules('re_password_baru', 'Ulangi Password Baru', 'required|matches[password_baru]');
        
        if ($this->form_validation->run() == TRUE)
        {
            $this->load->model('mlogin');
            if($this->session->userdata('type')=='mahasiswa'){
                $password_benar=false;
                $hasil = $this->mlogin->get_password_mahasiswa_from_session();
                foreach($hasil as $row){
                    //$password_sekarang=$this->encrypt->decode($row->password_mahasiswa, 'g7Rd7G8vhrD78yhv398hiDHrg89h34gh');
                    $password_sekarang = $row->password_mahasiswa;

                    if($password_sekarang==$this->input->post('password_lama'))$password_benar=true;
                }
                if($password_benar){
                    //$password_baru=$this->encrypt->encode($this->input->post('password_baru'), 'g7Rd7G8vhrD78yhv398hiDHrg89h34gh');
                    $password_baru=$this->input->post('password_baru');
                    $this->mlogin->simpanPasswordBaruMahasiswa($password_baru);
                    $this->session->set_userdata('sukses', 'Password berhasil diubah');
                }
            }
            else {
                $password_benar=false;
                $hasil = $this->mlogin->get_password_dosen_from_session();
                foreach($hasil as $row){
                    //$password_sekarang=$this->encrypt->decode($row->password_dosen, 'g7Rd7G8vhrD78yhv398hiDHrg89h34gh');
                    $password_sekarang = $row->password_dosen;
                    
                    if($password_sekarang==$this->input->post('password_lama'))$password_benar=true;
                }
                if($password_benar){
                    //$password_baru=$this->encrypt->encode($this->input->post('password_baru'), 'g7Rd7G8vhrD78yhv398hiDHrg89h34gh');
                    $password_baru=$this->input->post('password_baru');
                    $this->mlogin->simpanPasswordBaruDosen($password_baru);
                    $this->session->set_userdata('sukses', 'Password berhasil diubah');
                }
            }
        }
        $this->load->view('login/ubahPassword');
    }

    function masuk(){
        $data['title'] = "Login newMonta";
        $data['js_menu'] = "menuGuest";
        $data['header'] = "headerGuest";
        $data['content'] = "content";
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() != TRUE)
        {
            $data['js_menu'] = "menuGuest";
            $this->load->view('template',$data);
        }
        else{
            $this->load->model('mlogin');
            $hasil = $this->mlogin->get_password_dosen();
            $isDosen=false;
            foreach($hasil as $row)
            {
                $isDosen=true;
                //$password = $this->encrypt->decode($row->password_dosen, 'g7Rd7G8vhrD78yhv398hiDHrg89h34gh');
                $password = $row->password_dosen;
                if($password==$this->input->post('password'))
                {
                    $this->session->set_userdata('id', $this->input->post('username'));
                    
                    //if($row->nip2010!="")$this->session->set_userdata('nip', $row->nip2010);
                    //else $this->session->set_userdata('nip', $row->nip);
					$this->session->set_userdata('nip', $row->nip);

                    //session head admin
                    if($row->inisial_dosen=="ADM"){
                        $this->session->set_userdata('type', 'admin');
                        $this->session->set_userdata('nama', 'HeadAdministrator');
                        $data['js_menu'] = "menuAdmin";
                        $data['header'] = "headerAdmin";
                    }
                    else if($row->inisial_dosen=="KBJ"){
                        $this->session->set_userdata('type', 'KBJ');
                        $this->session->set_userdata('nama', 'AdminKBJ');
                        $data['js_menu'] = "menuKBK";
                        $data['header'] = "headerAdmin";
                    }
                    else if($row->inisial_dosen=="KCV"){
                        $this->session->set_userdata('type', 'KCV');
                        $this->session->set_userdata('nama', 'AdminKCV');
                        $data['js_menu'] = "menuKBK";
                        $data['header'] = "headerAdmin";
                    }
                    else if($row->inisial_dosen=="RPL"){
                        $this->session->set_userdata('type', 'RPL');
                        $this->session->set_userdata('nama', 'AdminRPL');
                        $data['js_menu'] = "menuKBK";
                        $data['header'] = "headerAdmin";
                    }
                    else if($row->inisial_dosen=="AJK"){
                        $this->session->set_userdata('type', 'AJK');
                        $this->session->set_userdata('nama', 'AdminAJK');
                        $data['js_menu'] = "menuKBK";
                        $data['header'] = "headerAdmin";
                    }
                    else if($row->inisial_dosen=="MI"){
                        $this->session->set_userdata('type', 'MI');
                        $this->session->set_userdata('nama', 'AdminMI');
                        $data['js_menu'] = "menuKBK";
                        $data['header'] = "headerAdmin";
                    }
                    else if($row->inisial_dosen=="DTK"){
                        $this->session->set_userdata('type', 'DTK');
                        $this->session->set_userdata('nama', 'AdminDTK');
                        $data['js_menu'] = "menuKBK";
                        $data['header'] = "headerAdmin";
                    }
                    else if($row->inisial_dosen=="AP"){
                        $this->session->set_userdata('type', 'AP');
                        $this->session->set_userdata('nama', 'AdminAP');
                        $data['js_menu'] = "menuKBK";
                        $data['header'] = "headerAdmin";
                    }
                    else if($row->inisial_dosen=="IGS"){
                        $this->session->set_userdata('type', 'IGS');
                        $this->session->set_userdata('nama', 'AdminIGS');
                        $data['js_menu'] = "menuKBK";
                        $data['header'] = "headerAdmin";
                    }
                    //session dosen
                    else {
                        $this->session->set_userdata('type', 'dosen');
                        $this->session->set_userdata('nama', $row->nama_lengkap_dosen);
                        $data['js_menu'] = "menuDosen";
                        $data['header'] = "headerDosen";
                    }
                    redirect('berita/lihatBerita', 'refresh');
                    exit(0);
                }
                //else redirect('template', 'refresh');
            }

            //cek login mahasiswa
            if(!$isDosen){
                $hasil = $this->mlogin->get_password_mahasiswa();
                foreach($hasil as $row)
                {
                    //$password = $this->encrypt->decode($row->password_mahasiswa, 'g7Rd7G8vhrD78yhv398hiDHrg89h34gh');
                    $password = $row->password_mahasiswa;
                    if($password==$this->input->post('password'))
                    {
                        //set session nrp mahasiswa
                        $this->session->set_userdata('id', $this->input->post('username'));

                        //set session tipe mahasiswa
                        $this->session->set_userdata('type', 'mahasiswa');
                        
                        //set session nama mahasiswa
                        $this->session->set_userdata('nama', $row->nama_lengkap_mahasiswa);
                        
                        $data['js_menu'] = "menuMahasiswa";
                        $data['header'] = "headerMahasiswa";

                        redirect('berita/lihatBerita', 'refresh');
                        exit(0);
                    }
                    else redirect('berita/lihatBerita', 'refresh');
                }
            }
            redirect('berita', 'refresh');
        }
    }

    function keluar(){
        $data['title'] = "Log Out";
        $data['js_menu'] = "menuMahasiswa";
        $data['header'] = "headerMahasiswa";
        $data['content'] = "content";
        $this->session->sess_destroy();
        redirect('berita/lihatBerita');
    }
}
