<?php

class Berita extends Controller {



    function Berita()
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

    function visimisi() 
    {
      $data['title'] = "Visi & Misi";

        $data['js_menu'] = "menuGuest";

        $data['header'] = "headerGuest";

        $data['content'] = "berita/content-detailVisi";

        $data['leftSide'] = 'leftSide';



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

        else if($type=='NCC' || $type=='KCV' || $type=='RPL' || $type=='AJK' || $type=='MI' || $type=='DTK' || $type=='AP' || $type=='IGS')

        {

            $data['js_menu'] = "menuKBK";

            $data['header'] = "headerAdmin";

        }
        $this->load->view('template', $data);
    }

    function lihatBerita(){

        $data['title'] = "Daftar Berita";

        $data['js_menu'] = "menuGuest";

        $data['header'] = "headerGuest";

        $data['content'] = "berita/content-lihatBerita";

        $data['leftSide'] = 'leftSide';

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

        else if($type=='NCC' || $type=='KCV' || $type=='RPL' || $type=='AJK' || $type=='MI' || $type=='DTK' || $type=='AP' || $type=='IGS')

        {

            $data['js_menu'] = "menuKBK";

            $data['header'] = "headerAdmin";

        }



        // pagination

        $this->load->model('mberita');

        $config['base_url'] = site_url('berita/lihatBerita/'); // URL tempat anda ingin menampilkan fasilitas paging-nya

        $config['total_rows'] = $this->mberita->getTotalBerita();

        $config['per_page'] = '5' ;  // jumlah data yang akan ditampilkasn di setiap page-nya

        $config['num_links'] = 10;

        $config['first_link'] = 'Awal';

        $config['last_link'] = 'Akhir';

        $config['next_link'] = 'Selanjutnya';

        $config['prev_link'] = 'Sebelumnya';

        $this->pagination->initialize($config);

        $offset = $this->uri->segment(3, 0); //ngambil batas akhir row pada halaman sebelumnya

        if(!ctype_digit($offset))$offset=0; //mengubah default segment jika bukan numeric



        $data['berita']=$this->mberita->getListSummaryBerita($offset, $config['per_page']);

        $data['type']=$type;



        $this->load->view('template', $data);

    }



    function cariBerita(){

        $data['title'] = "Daftar Berita";

        $data['js_menu'] = "menuGuest";

        $data['header'] = "headerGuest";

        $data['content'] = "berita/content-lihatBerita";

        $data['leftSide'] = 'leftSide';



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

        else if($type=='NCC' || $type=='KCV' || $type=='RPL' || $type=='AJK' || $type=='MI' || $type=='DTK' || $type=='AP' || $type=='IGS')

        {

            $data['js_menu'] = "menuKBK";

            $data['header'] = "headerAdmin";

        }



        // pagination

        $this->load->model('mberita');

        $keywords=$this->input->post('search');

        if($keywords=="")$keywords=$this->uri->segment(3,'Masukkan Kata Kunci di sini...');

        $config['base_url'] = site_url('berita/cariBerita/'.$keywords); // URL tempat anda ingin menampilkan fasilitas paging-nya

        $config['total_rows'] = $this->mberita->getTotalBeritaSearch($keywords);

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



        $data['berita']=$this->mberita->getListSummaryBeritaSearch($offset, $config['per_page'], $keywords);

        $data['keywords']=$keywords;

        $data['type']=$type;



        $this->load->view('template', $data);

    }



    function detailBerita(){

        $data['title'] = "Daftar Berita";

        $data['js_menu'] = "menuGuest";

        $data['header'] = "headerGuest";

        $data['content'] = "berita/content-detailBerita";

        $data['leftSide'] = 'leftSide';



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

        else if($type=='NCC' || $type=='KCV' || $type=='RPL' || $type=='AJK' || $type=='MI' || $type=='DTK' || $type=='AP' || $type=='IGS')

        {

            $data['js_menu'] = "menuKBK";

            $data['header'] = "headerAdmin";

        }

        

        $id_berita=$this->uri->segment(3, 0);

        if(!ctype_digit($id_berita))$id_berita=0; //mengubah default segment jika bukan numeric



        if($id_berita==0) redirect('berita/lihatBerita');

        else{

            $this->load->model('mberita');

            $data['berita']=$this->mberita->getDetailBerita($id_berita);



            $data['file_berita']=$this->mberita->getBeritaFiles($id_berita);



            $this->load->view('template', $data);

        }

    }

	function ubahBerita(){

        $data['title'] = "Ubah Berita";

        $data['js_menu'] = "menuAdmin";

        $data['header'] = "headerAdmin";

        $data['content'] = "berita/content-ubahBerita";

        $data['leftSide'] = 'leftSide';



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

        else if($type=='NCC' || $type=='KCV' || $type=='RPL' || $type=='AJK' || $type=='MI' || $type=='DTK' || $type=='AP' || $type=='IGS')

        {

            $data['js_menu'] = "menuKBK";

            $data['header'] = "headerAdmin";

        }

        

        //cek apakah benar status login admin

        if($type!="admin" && $type!="NCC" && $type!="KCV" && $type!="RPL" && $type!="AJK" && $type!="MI" && $type!="DTK" && $type!="AP" && $type!="IGS")redirect('berita/lihatBerita','refresh');



        $this->form_validation->set_rules('judul', 'Judul Berita', 'required');

        $this->form_validation->set_rules('isi', 'Isi Berita', 'required');



        $isi_berita=$this->input->post('isi');

		$id_berita=$this->uri->segment(3, 0);
        if(!ctype_digit($id_berita))$id_berita=0;
        if($id_berita==0)redirect('berita/lihatBerita', 'refresh');
        $this->load->model('mberita');

        if ($this->form_validation->run() == TRUE)
        {

            $this->load->model('mberita');

            $hasil = $this->mberita->ubahBerita($id_berita);

            $id_berita="0";

            foreach($hasil as $row){

                $id_berita = $row->id_berita;

            }

            

            //setting upload

            $config['upload_path'] = '/var/www/akademik/if/newMonta/assets/files/berita/';

            $config['allowed_types'] = 'gif|jpg|png|ppt|pptx|doc|docx|xls|xlsx|swf|fla|rar|zip|html|pdf';

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

                    $this->mberita->tambahFileBerita($id_berita, $data_upload);

                }

                //upload gagal

                else{

//                    $error = array('error' => $this->upload->display_errors());

                    //$this->session->set_userdata('error', $this->upload->display_errors());

                }

            }

            $this->session->set_userdata('sukses', 'Berita Baru berhasil ditambahkan');
        }
        $data['berita']=$this->mberita->getDetailBerita($id_berita);
       	$data['id_berita']=$id_berita;
        $this->load->view('berita/content-ubahBerita', $data);
    }

    function tambahBerita(){

        $data['title'] = "Tambah Berita";

        $data['js_menu'] = "menuAdmin";

        $data['header'] = "headerAdmin";

        $data['content'] = "berita/content-buatBerita";

        $data['leftSide'] = 'leftSide';



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

        else if($type=='NCC' || $type=='KCV' || $type=='RPL' || $type=='AJK' || $type=='MI' || $type=='DTK' || $type=='AP' || $type=='IGS')

        {

            $data['js_menu'] = "menuKBK";

            $data['header'] = "headerAdmin";

        }

        

        //cek apakah benar status login admin

        if($type!="admin" && $type!="NCC" && $type!="KCV" && $type!="RPL" && $type!="AJK" && $type!="MI" && $type!="DTK" && $type!="AP" && $type!="IGS")redirect('berita/lihatBerita','refresh');



        $this->form_validation->set_rules('judul', 'Judul Berita', 'required');

        $this->form_validation->set_rules('isi', 'Isi Berita', 'required');



        $isi_berita=$this->input->post('isi');



        if ($this->form_validation->run() == TRUE)

        {

            $this->load->model('mberita');

            $hasil = $this->mberita->tambahBerita();

            $id_berita="0";

            foreach($hasil as $row){

                $id_berita = $row->id_berita;

            }

            

            //setting upload

            $config['upload_path'] = '/var/www/akademik/if/newMonta/assets/files/berita/';

            $config['allowed_types'] = 'gif|jpg|png|ppt|pptx|doc|docx|xls|xlsx|swf|fla|rar|zip|html|pdf';

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

                    $this->mberita->tambahFileBerita($id_berita, $data_upload);

                }

                //upload gagal

                else{

//                    $error = array('error' => $this->upload->display_errors());

                    $this->session->set_userdata('error', $this->upload->display_errors());

                }

            }

            $this->session->set_userdata('sukses', 'BeritabBaru berhasil ditambahkan');

        }

        $this->load->view('template', $data);

    }

    function hapusBerita(){
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

        else if($type=='NCC' || $type=='KCV' || $type=='RPL' || $type=='AJK' || $type=='MI' || $type=='DTK' || $type=='AP' || $type=='IGS')
        {

            $data['js_menu'] = "menuKBK";

            $data['header'] = "headerAdmin";

        }

        

        //cek apakah benar status login admin

        if($type!="admin" && $type!="NCC" && $type!="KCV" && $type!="RPL" && $type!="AJK" && $type!="MI" && $type!="DTK" && $type!="AP" && $type!="IGS")redirect('berita/lihatBerita','refresh');
	  $id_berita=$this->uri->segment(3, 0);
	  $this->load->model('mberita');
	  $this->mberita->hapusBerita($id_berita);
	  redirect('berita/lihatBerita','refresh');
	}
}