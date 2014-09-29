<?php
class Kbk extends Controller {

    function Kbk()
    {
        parent::Controller();
        $this->load->library('lib_js');
        $this->form_validation->set_error_delimiters('<font color="red">* ', '</font>');
    }

    var $title = 'Title';
    var $js_menu = 'menuGuest';
    var $header = 'headerGuest';

    function index()
    {
        redirect('berita/lihatBerita','refresh');
    }

    function ubahKBK(){
        $data['title'] = "Bidang Minat";
        $data['js_menu'] = "menuAdmin";
        $data['header'] = "headerAdmin";
        $data['leftSide'] = 'leftSide';

        $tipe="guest";
        $tipe=$this->session->userdata('type');
        if($tipe!="admin") redirect('berita/lihatBerita', 'refresh');
        
        $data['content'] = "kbkDosen/content-daftarKBK";

        $this->form_validation->set_rules('nama', 'Nama KBK', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan KBK', 'required');

        $this->load->model('mdosen');
        $nama=$this->input->post('nama');
        $keterangan=$this->input->post('keterangan');

        if ($this->form_validation->run() == TRUE && $nama!="Masukkan Nama KBK di sini..." && $keterangan!="Masukkan Keterangan KBK di sini...")
        {
            $this->mdosen->tambahKBK();
            $this->session->set_userdata('sukses','KBK baru berhasil ditambahkan');
        }
        
        $data['kbk'] = $this->mdosen->getKBK();
        $this->load->view('template', $data);
    }

    function daftarDosen()
    {
        $data['title'] = "Daftar Dosen & KBK";
        $data['js_menu'] = "menuAdmin";
        $data['header'] = "headerAdmin";
        $data['leftSide'] = 'leftSide';

        $tipe="guest";
        $tipe=$this->session->userdata('type');

        if($tipe=="admin"){
            $data['js_menu'] = "menuAdmin";
            $data['header'] = "headerAdmin";
        }
        else if($tipe=="dosen"){
            $data['js_menu'] = "menuDosen";
            $data['header'] = "headerDosen";
        }
        if($tipe!="admin")redirect('berita/lihatberita', 'refresh');
        
        $data['content'] = "kbkDosen/content-daftarDosen";
        
        $this->load->model('mdosen');
        $data['kbk'] = $this->mdosen->getKBK();

        // pagination
        $config['base_url'] = site_url('kbk/daftarDosen/'); // URL tempat anda ingin menampilkan fasilitas paging-nya
        $config['total_rows'] = $this->mdosen->getTotalDosen();
        $config['per_page'] = '50' ;  // jumlah data yang akan ditampilkasn di setiap page-nya
        $config['num_links'] = 10;
        $config['first_link'] = 'Awal';
        $config['last_link'] = 'Akhir';
        $config['next_link'] = 'Selanjutnya';
        $config['prev_link'] = 'Sebelumnya';
        $this->pagination->initialize($config);
        $offset = $this->uri->segment(3, 0); //ngambil batas akhir row pada halaman sebelumnya
        $data['dosen'] = $this->mdosen->getListDosen($offset, $config['per_page']);
        $data['type']=$tipe;
        $this->load->view('template', $data);
    }

    function tambahDosen()
    {
        $this->form_validation->set_rules('nip', 'NIP Dosen', 'required|numeric|max_length(30)');
        $this->form_validation->set_rules('nama', 'Nama Dosen', 'required');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap Dosen', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('telepon', 'Telepon Dosen', 'required|numeric');
        $this->form_validation->set_rules('inisial', 'Inisial Dosen', 'required');
        $this->form_validation->set_rules('status', 'Status Dosen', 'required');
        $this->form_validation->set_rules('minat[]', 'Bidang Minat', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('password', 'Password Dosen', 'required');
        $this->form_validation->set_rules('password2', 'Ulangi Password Dosen', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE)
        {
            $data['title'] = "Dosen Baru";
            $data['js_menu'] = "menuAdmin";
            $data['header'] = "headerAdmin";
            $data['leftSide'] = 'leftSide';

            $tipe="guest";
            $tipe=$this->session->userdata('type');
            if($tipe!="admin") redirect('berita/lihatBerita', 'refresh');
            
            $data['content'] = "kbkDosen/content-tambahDosen";

            $this->load->model('mdosen');
            $data['kbk']=$this->mdosen->getKBK();
            $this->load->view('template', $data);
        }
        else
        {
            $this->load->model('mdosen');
            //cek apakah sudah ada dosen dengan nip yang sama
            $hasil = $this->mdosen->getDosen();
            $sudah_ada=false;
            foreach($hasil as $row){
                $sudah_ada=true;
            }
            if(!$sudah_ada){
                //belum ada dosen yang bersangkutan
                $this->mdosen->insertDosen();
                $nip = $this->input->post('nip');
                $this->session->set_userdata('sukses','Dosn dengan NIP '.$nip.' berhasil ditambahkan');
                redirect('kbk/tambahDosen');
            }
            else{
                //sudah ada dosen yang bersangkutan
                $nip = $this->input->post('nip');
                $this->session->set_userdata('error','Tidak bisa menambah dosen baru. Dosn dengan NIP '.$nip.' sudah ada');
                $data['title'] = "Dosen Baru";
                $data['js_menu'] = "menuAdmin";
                $data['header'] = "headerAdmin";
                $data['content'] = "kbkDosen/content-tambahDosen";
                $this->load->view('template', $data);
            }
        }
    }

    function ubahDosen(){
        $tipe="guest";
        $tipe=$this->session->userdata('type');
        if($tipe=="admin"){
            $data['js_menu'] = "menuAdmin";
            $data['header'] = "headerAdmin";
        }
        else if($tipe=="dosen"){
            $data['js_menu'] = "menuDosen";
            $data['header'] = "headerDosen";
        }
        if($tipe!="admin")redirect('berita/lihatberita', 'refresh');
        $data['title'] = "Ubah Dosen";

        $this->form_validation->set_rules('nip', 'NIP Dosen', 'required|numeric|max_length(30)');
        $this->form_validation->set_rules('nama', 'Nama Dosen', 'required');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap Dosen', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('telepon', 'Telepon Dosen', 'required|numeric');
        $this->form_validation->set_rules('inisial', 'Inisial Dosen', 'required');
        $this->form_validation->set_rules('status', 'Status Dosen', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('password', 'Password Dosen', 'matches[password2]');
//        $this->form_validation->set_rules('password2', 'Ulangi Password Dosen', 'matches[password]');

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->model('mdosen');
            $data['kbk']=$this->mdosen->getKBK();
            $data['dosen']=  $this->mdosen->getDetailDosen();
            $this->load->view('kbkDosen/content-ubahDosen', $data);
        }
        else{
            //ubah detail dosen
            $this->load->model('mdosen');
            $this->mdosen->updateDetailDosen();
            $nip = $this->input->post('nip');
            $this->session->set_userdata('sukses','Dosn dengan NIP '.$nip.' berhasil diupdate');
            $this->load->view('kbkDosen/content-ubahDosen');
        }
    }

    function ubahKBKDosen(){
        $tipe="guest";
        $tipe=$this->session->userdata('type');
        if($tipe=="admin"){
            $data['js_menu'] = "menuAdmin";
            $data['header'] = "headerAdmin";
        }
        else if($tipe=="dosen"){
            $data['js_menu'] = "menuDosen";
            $data['header'] = "headerDosen";
        }
        if($tipe!="admin")redirect('berita/lihatberita', 'refresh');

        $id_kbk=$this->uri->segment(3, 0);
        $nip_dosen=$this->uri->segment(4,0);
        $perintah=$this->uri->segment(5,0);
        
        if($id_kbk!=0 && $nip_dosen!=0 && $perintah!=0){
            $this->load->model('mdosen');
            $this->mdosen->updateKBKDosen($id_kbk, $nip_dosen, $perintah);
            $this->session->set_userdata('sukses','KBK Dosen dengan NIP '.$nip_dosen.' berhasil diupdate');
        }
        redirect('kbk/daftarDosen','refresh');
    }

    function cariDosen(){
        $data['title'] = "Daftar Dosen & KBK";
        $data['js_menu'] = "menuAdmin";
        $data['header'] = "headerAdmin";
        $data['content'] = "kbkDosen/content-daftarDosen";
        $data['leftSide'] = 'leftSide';

        $tipe="guest";
        $tipe=$this->session->userdata('type');

        if($tipe=="admin"){
            $data['js_menu'] = "menuAdmin";
            $data['header'] = "headerAdmin";
        }
        else if($tipe=="dosen"){
            $data['js_menu'] = "menuDosen";
            $data['header'] = "headerDosen";
        }
        if($tipe!="admin")redirect('berita/lihatberita', 'refresh');

        $this->load->model('mdosen');
        $data['kbk'] = $this->mdosen->getKBK();

        // pagination
        $nama=$this->input->post('search');
        if($nama=="")$nama=$this->uri->segment(3,'kosong');
        $config['base_url'] = site_url('kbk/cariDosen/'.$nama); // URL tempat anda ingin menampilkan fasilitas paging-nya
        $config['total_rows'] = $this->mdosen->getTotalDosenSearch($nama);
        $config['per_page'] = '50' ;  // jumlah data yang akan ditampilkasn di setiap page-nya
        $config['num_links'] = 10;
        $config['uri_segment'] = 4;
        $config['first_link'] = 'Awal';
        $config['last_link'] = 'Akhir';
        $config['next_link'] = 'Selanjutnya';
        $config['prev_link'] = 'Sebelumnya';
        $this->pagination->initialize($config);
        $offset = $this->uri->segment(4, 0); //ngambil batas akhir row pada halaman sebelumnya
        $data['dosen'] = $this->mdosen->getListDosenSearch($offset, $config['per_page'], $nama);
        $data['type']=$tipe;
        $this->load->view('template', $data);
    }

    function ubahStatus(){
        $tipe="guest";
        $tipe=$this->session->userdata('type');

        if($tipe=="admin"){
            $data['js_menu'] = "menuAdmin";
            $data['header'] = "headerAdmin";
        }
        else if($tipe=="dosen"){
            $data['js_menu'] = "menuDosen";
            $data['header'] = "headerDosen";
        }
        if($tipe!="admin")redirect('berita/lihatberita', 'refresh');

        $this->load->model('mdosen');
        $id_kbk=$this->uri->segment(3, 0);
        $command="TIDAK DIPAKAI";
        if($this->uri->segment(4, 0)==1)$command="DIPAKAI";
        $this->mdosen->ubahStatusKBK($id_kbk, $command);
        redirect('kbk/ubahKBK', 'refresh');
    }
}