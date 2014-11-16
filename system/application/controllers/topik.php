<?php



class Topik extends Controller {



    function Topik() {

        parent::Controller();

        $this->load->library('lib_js');

        $this->form_validation->set_error_delimiters('<font color="red">* ', '</font>');

    }



    function index() {

        redirect('topik/lihatTopik', 'refresh');

    }



    function lihatTopik() {

        $data['title'] = "Topik TA";

        $data['js_menu'] = "menuGuest";

        $data['header'] = "headerGuest";

        $data['content'] = "topik/content-lihatTopik";

        $data['leftSide'] = 'leftSide';

        $type='guest';

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



        //filter dengan kbk atau status topik

        $filter_kbk=$this->uri->segment(3, 0);

        $filter_status=$this->uri->segment(4, 5);

        $temp_kbk=$this->input->post('kbk');

        $temp_status=$this->input->post('status');

        if($temp_kbk!="")$filter_kbk=$temp_kbk;

        if($temp_status!="")$filter_status=$temp_status;

        

        // pagination

        $this->load->model('mtopik');

        $config['uri_segment']=5;

        $config['base_url'] = site_url('topik/lihatTopik/'.$filter_kbk."/".$filter_status."/"); // URL tempat anda ingin menampilkan fasilitas paging-nya

        $config['total_rows'] = $this->mtopik->getTotalTopik($filter_kbk, $filter_status);

        $config['per_page'] = '5' ;  // jumlah data yang akan ditampilkasn di setiap page-nya

        $config['num_links'] = 10;

        $config['first_link'] = 'Awal';

        $config['last_link'] = 'Akhir';

        $config['next_link'] = 'Selanjutnya';

        $config['prev_link'] = 'Sebelumnya';

        $this->pagination->initialize($config);

        $offset = $this->uri->segment(5, 0); //ngambil batas akhir row pada halaman sebelumnya

        if(!ctype_digit($offset))$offset=0; //mengubah default segment jika bukan numeric

        $data['topik']=$this->mtopik->getListSummaryTopik($offset, $config['per_page'], $filter_kbk, $filter_status);

        $data['type']=$type;

        $data['id_kbk']=$filter_kbk;

        $data['id_status']=$filter_status;

        $nrp_mahasiswa = 0;

        $nrp_mahasiswa = $this->session->userdata('id');

        $data['id_topik']=$this->mtopik->status_topik_saya($nrp_mahasiswa);

        if($data['id_topik']!=0){

            $data['topik_approved']=$this->mtopik->getApprovedTopik($data['id_topik']);

        }



        //list kbk yang ada

        $this->load->model('mdosen');

        $data['kbk']=$this->mdosen->getKBK();

        $this->load->view('template', $data);

    }



    function cariTopik(){

        $data['title'] = "Topik TA";

        $data['js_menu'] = "menuGuest";

        $data['header'] = "headerGuest";

        $data['content'] = "topik/content-cariTopik";

        $data['leftSide'] = 'leftSide';

        $type='guest';

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



        // pagination

        $this->load->model('mtopik');

        $keywords=$this->input->post('search');

        if($keywords=="")$keywords=$this->uri->segment(3,'Masukkan Kata Kunci di sini...');

        $config['base_url'] = site_url('topik/cariTopik/'.$keywords); // URL tempat anda ingin menampilkan fasilitas paging-nya

        $config['total_rows'] = $this->mtopik->getTotalTopikSearch($keywords);

        $config['per_page'] = '5' ;  // jumlah data yang akan ditampilkasn di setiap page-nya

        $config['num_links'] = 10;

        $config['uri_segment'] = 4;

        $config['first_link'] = 'Awal';

        $config['last_link'] = 'Akhir';

        $config['next_link'] = 'Selanjutnya';

        $config['prev_link'] = 'Sebelumnya';

        $this->pagination->initialize($config);

        $offset = $this->uri->segment(4, 0); //ngambil batas akhir row pada halaman sebelumnya

        if(!ctype_digit($offset))$offset=0; //mengubah default segment jika bukan numeric



        $data['topik']=$this->mtopik->getListSummaryTopikSearch($offset, $config['per_page'], $keywords);

        $data['keywords']=$keywords;

        $data['type']=$type;



        //list kbk yang ada

        $this->load->model('mdosen');

        $data['kbk']=$this->mdosen->getKBK();



        $this->load->view('template', $data);

    }



    function detailTopik(){

        $data['title'] = "Topik TA";

        $data['js_menu'] = "menuGuest";

        $data['header'] = "headerGuest";

        $data['content'] = "topik/content-detailTopik";

        $data['leftSide'] = 'leftSide';



        $type='guest';

        $type=$this->session->userdata('type');

        if($type=='admin')

        {

            $data['js_menu'] = "menuAdmin";

            $data['header'] = "headerAdmin";

        }

        else if($type=='dosen')

        {

            $data['js_menu'] = "menuDosen";

            $data['header'] = "headerDosen";

        }

        else if($type=='mahasiswa')

        {

            $data['js_menu'] = "menuMahasiswa";

            $data['header'] = "headerMahasiswa";

        }

        else if($type=='KBJ' || $type=='KCV' || $type=='RPL' || $type=='AJK' || $type=='MI' || $type=='DTK' || $type=='AP' || $type=='IGS')
        {

            $data['js_menu'] = "menuKBK";

            $data['header'] = "headerAdmin";

        }



        $id_topik=$this->uri->segment(3, 0);

        if(!ctype_digit($id_topik))$id_topik=0; //mengubah default segment jika bukan numeric



        if($id_topik==0) redirect('topik/lihatTopik');

        else{

            $this->load->model('mtopik');

            $data['topik']=$this->mtopik->getDetailTopik($id_topik);



            $data['file_topik']=$this->mtopik->getTopikFiles($id_topik);

            $data['type']=$type;



            if($type=="mahasiswa"){

                $nrp_mahasiswa=$this->session->userdata['id'];

                $data['jumlah_topik_yang_diajukan']=$this->mtopik->statusMinatTopikMahasiswa($nrp_mahasiswa);

                $data['minati_topik_sekarang']=$this->mtopik->StatusMinatTopikSekarang($nrp_mahasiswa, $id_topik);
				$data['belum_punya_proposal']=$this->mtopik->StatusProposalMahasiswa($nrp_mahasiswa);
            }

            else if($type=="dosen" || $type=="admin"){

                $inisial_dosen=$this->session->userdata['id'];

                $data['topik_dosen']=$this->mtopik->topikMilikDosen($inisial_dosen, $id_topik);

            }



            $this->load->view('template', $data);

        }

    }



    function topikSaya(){

        $data['title'] = "Topik Saya";

        $data['js_menu'] = "menuGuest";

        $data['header'] = "headerGuest";

        $data['content'] = "topik/content-lihatTopikSaya";

        $data['leftSide'] = 'leftSide';

        $type='guest';

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



        if($type!="dosen" && $type!="admin" && $type!="KBJ" && $type!="KCV" && $type!="RPL" && $type!="AJK" && $type!="MI" && $type!="DTK" && $type!="AP" && $type!="IGS"){

            redirect('topik/lihatTopik', 'refresh');

        }



        // pagination

        $inisial_dosen=$this->session->userdata('id');

        $this->load->model('mtopik');

        $config['uri_segment']=3;

        $config['base_url'] = site_url('topik/topikSaya/'); // URL tempat anda ingin menampilkan fasilitas paging-nya

        $config['total_rows'] = $this->mtopik->getTotalTopikSaya($inisial_dosen);

        $config['per_page'] = '10' ;  // jumlah data yang akan ditampilkasn di setiap page-nya

        $config['num_links'] = 10;

        $config['first_link'] = 'Awal';

        $config['last_link'] = 'Akhir';

        $config['next_link'] = 'Selanjutnya';

        $config['prev_link'] = 'Sebelumnya';

        $this->pagination->initialize($config);

        $offset = $this->uri->segment(3, 0); //ngambil batas akhir row pada halaman sebelumnya

        if(!ctype_digit($offset))$offset=0; //mengubah default segment jika bukan numeric



        $data['topik']=$this->mtopik->getListSummaryTopikSaya($offset, $config['per_page'], $inisial_dosen);

        $data['type']=$type;



        $this->load->view('template', $data);

    }



    function tambahTopik() {

        //larangan selain tipe dosen dan admin

        $type='guest';

        if(isset($this->session->userdata['type']))$type=$this->session->userdata['type'];

        if($type!='dosen' && $type!='admin'&& $type!="KBJ" && $type!="KCV" && $type!="RPL" && $type!="AJK" && $type!="MI" && $type!="DTK" && $type!="AP" && $type!="IGS")

        {

            redirect('topik/lihatTopik', 'refresh');

        }



        //setting menu, judul dan js menu

        $data['title'] = "Tambah Topik TA";

        $data['js_menu'] = "menuAdmin";

        $data['header'] = "headerAdmin";

        $data['content'] = "topik/content-buatTopik";

        $data['leftSide'] = 'leftSide';



        if($type=='dosen')

        {

            $data['title'] = "Tambah Topik TA";

            $data['js_menu'] = "menuAdmin";

            $data['header'] = "headerAdmin";

            $data['content'] = "topik/content-buatTopik";

        }

        else if($type=='KBJ' || $type=='KCV' || $type=='RPL' || $type=='AJK' || $type=='MI' || $type=='DTK' || $type=='AP' || $type=='IGS')

        {

            $data['js_menu'] = "menuKBK";

            $data['header'] = "headerAdmin";

        }



        $this->form_validation->set_rules('judul', 'Judul Topik', 'required');

        $this->form_validation->set_rules('isi', 'Isi Topik', 'required');



        $isi_berita=$this->input->post('isi');



        $this->load->model('mdosen');

        $data['kbk']=$this->mdosen->getKBK();

        $data['dosen']=$this->mdosen->getListDosen(0, 1000);



        if ($this->form_validation->run() == TRUE)

        {

            $this->load->model('mtopik');

            $hasil = $this->mtopik->tambahTopik();

            $id_topik="0";

            foreach($hasil as $row){

                $id_topik = $row->id_topik;

            }



            //setting upload

            $config['upload_path'] = '/var/www/akademik/if/newMonta/assets/files/topik/';

            $config['allowed_types'] = 'gif|jpg|png|ppt|pptx|doc|docx|xls|xlsx|swf|fla|rar|zip|html|pdf|txt';

            $config['max_size']	= '10000';

            $config['encrypt_name'] = TRUE;



            $this->load->library('upload', $config);

            $this->upload->initialize($config);



            $jumlah_file=$this->input->post('jumlah_file');

            for($i=1; $i<=$jumlah_file; $i++){

                $input="file_".$i;



                //upload sukses

                if($this->upload->do_upload($input)){

                    $data_upload = $this->upload->data();

                    $this->mtopik->tambahFileTopik($id_topik, $data_upload);

                }

                //upload gagal

                else{

                    $this->session->set_userdata('error', $this->upload->display_errors());

                }

            }

            $this->session->set_userdata('sukses', 'Topik Baru berhasil ditambahkan');

        }

        $this->load->view('template', $data);

    }



    function ubahTopik(){

        //larangan selain tipe dosen dan admin

        $type='guest';

        if(isset($this->session->userdata['type']))$type=$this->session->userdata['type'];

        if($type!='dosen' && $type!='admin' && $type!="KBJ" && $type!="KCV" && $type!="RPL" && $type!="AJK" && $type!="MI" && $type!="DTK" && $type!="AP" && $type!="IGS")

        {

            redirect('topik/lihatTopik', 'refresh');

        }



        $this->form_validation->set_rules('judul', 'Judul Topik', 'required');

        $this->form_validation->set_rules('isi', 'Isi Topik', 'required');



        $isi_berita=$this->input->post('isi');

        $data['title']="Ubah Topik";



        $this->load->model('mdosen');

        $data['kbk']=$this->mdosen->getKBK();

        $data['dosen']=$this->mdosen->getListDosen(0, 1000);

        $id_topik=$this->uri->segment(3, 0);

        if(!ctype_digit($id_topik))$id_topik=0;

        if($id_topik==0)redirect('topik/lihatTopik', 'refresh');

        $this->load->model('mtopik');
        if ($this->form_validation->run() == TRUE)

        {

            $hasil = $this->mtopik->ubahTopik($id_topik);

            $this->session->set_userdata('sukses', 'Topik berhasil diubah');

        }

        $data['topik']=$this->mtopik->getDetailUbahTopik($id_topik);

        $data['id_topik']=$id_topik;

        $this->load->view('topik/content-ubahTopik', $data);

    }



    function statusTopik(){

        //larangan selain tipe dosen dan admin

        $type='guest';

        if(isset($this->session->userdata['type']))$type=$this->session->userdata['type'];

        if($type!='dosen' && $type!='admin' && $type!="KBJ" && $type!="KCV" && $type!="RPL" && $type!="AJK" && $type!="MI" && $type!="DTK" && $type!="AP" && $type!="IGS")

        {

            redirect('topik/lihatTopik', 'refresh');

        }

        $data['title']="Mahasiswa Peminat Topik TA";

        $nrp_mahasiswa=$this->uri->segment(4, 0);

        $approve_dosen=$this->uri->segment(5, 5);

        $id_topik=$this->uri->segment(3, 0);

        if(!ctype_digit($id_topik))$id_topik=0;

        if($id_topik==0)redirect('topik/lihatTopik', 'refresh');



        $this->load->model('mtopik');

        if(($approve_dosen=="1" || $approve_dosen=="0") && $nrp_mahasiswa!="0")$this->mtopik->approveTopik($id_topik, $nrp_mahasiswa, $approve_dosen);

        $data['id_topik']=$id_topik;

        $data['mahasiswa']=$this->mtopik->mahasiswaMinatiTopik($id_topik);

        $data['judul_topik']=$this->mtopik->getJudulTopik($data['id_topik']);

        $this->load->view('topik/content-mahasiswa-minatiTopik', $data);

    }



    function ambilTopik(){

        if(isset($this->session->userdata['type']))$type=$this->session->userdata['type'];

        if($type!='mahasiswa')
        {
            redirect('topik/lihatTopik', 'refresh');
        }

        $id_topik=$this->input->post('id_topik');

        $uri=$this->input->post('uri');

        if($id_topik!=""){

            $nrp=$this->session->userdata['id'];

            $this->load->model('mtopik');

            $this->mtopik->ambilTopik($nrp, $id_topik);

            redirect($uri, 'refresh');

        }

        else {

            redirect('topik/lihatTopik', 'refresh');

        }

    }



    function batalTopik(){

        if(isset($this->session->userdata['type']))$type=$this->session->userdata['type'];

        if($type!='mahasiswa')

        {

            redirect('topik/lihatTopik', 'refresh');

        }

        $id_topik=$this->input->post('id_topik');

        $uri=$this->input->post('uri');

        if($id_topik!=""){

            $nrp=$this->session->userdata['id'];

            $this->load->model('mtopik');

            $this->mtopik->batalTopik($nrp, $id_topik);

            redirect($uri, 'refresh');

        }

        else {

            redirect('topik/lihatTopik', 'refresh');

        }

    }



    function dariDosen($NIP_Dosen="") {

        if($NIP_Dosen=="") {

            listDosen();

            return;

        }

    }



    function listDosen() {



    }



    function saya() {



    }



    function suka() {

        

    }



}

?>