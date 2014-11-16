<?php

class Proposal extends Controller {

    function Proposal()
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



    function cetakCover(){
        $this->load->library('phpword');
        $data['title'] = "Cetak Cover Proposal TA";

        $data['js_menu'] = "menuMahasiswa";

        $data['header'] = "headerMahasiswa";

        $data['content'] = "proposalTA/content-cetakCover";



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

        //cek apakah benar status login admin

        if($type!="mahasiswa")redirect('berita/lihatBerita','refresh');



        $this->load->model('mproposal');

        

        //cek apakah proposal sudah dibuat

        $data['proposal']=$this->mproposal->getLatestProposal($this->session->userdata('id'));

        $this->load->view('proposalTA/content-cetakCover', $data);

        //$this->load->view('template', $data);
    }



	public function cetakPersetujuan()

    {

        $data['title'] = "Cetak Cover Proposal TA";

        $data['js_menu'] = "menuMahasiswa";

        $data['header'] = "headerMahasiswa";

        $data['content'] = "proposalTA/content-cetakCover";



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



        //cek apakah benar status login admin

        if($type!="mahasiswa")redirect('berita/lihatBerita','refresh');



        $this->load->model('mproposal');



        //cek apakah proposal sudah dibuat

        $data['proposal']=$this->mproposal->getLatestProposal($this->session->userdata('id'));

        $this->load->view('proposalTA/content-cetakPersetujuan', $data);

        //$this->load->view('template', $data);

    }



    function buatProposal(){

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



        //cek apakah benar status login admin

        if($type!="mahasiswa")redirect('berita/lihatBerita','refresh');

        $this->load->model('mproposal');



        //cek apakah proposal sudah yang masih dalam status aktif sudah dibuat oleh mahasiswa atau belum

        if($this->mproposal->cekProposal($this->session->userdata('id'))){

            $data['title'] = "Proposal Baru";

            $data['js_menu'] = "menuMahasiswa";

            $data['header'] = "headerMahasiswa";

            $data['content'] = "proposalTA/content-buatProposal";

            

            $this->form_validation->set_rules('judul', 'Judul TA', 'required');

            $this->form_validation->set_rules('bidang_minat', 'Bidang minat', 'required');

            $this->form_validation->set_rules('abstraksi', 'Abstraksi', 'required');

            $this->form_validation->set_rules('keyword', 'Kata Kunci', 'required');

            $this->form_validation->set_rules('pembimbing1', 'Dosen Pembimbing 1', 'required');

            $this->form_validation->set_rules('pembimbing2', 'Dosen Pembimbing 2', 'required');



            $this->load->model('mdosen');

            $data['kbk']=$this->mdosen->getKBK();



            $data['dosen_pembimbing']=$this->mproposal->getListDosenPembimbing();



            if ($this->form_validation->run() == TRUE && $_FILES['file_proposal']['name']!="")

            {

                $this->load->model('mproposal');

                $hasil = $this->mproposal->buatProposal();

                $id_proposal="0";

                foreach($hasil as $row){

                    $id_proposal = $row->id_proposal;

                }



                $this->session->set_userdata('sukses', 'Proposal baru berhasil ditambahkan<br/>');



                //setting upload

                $config['upload_path'] = '/var/www/akademik/if/newMonta/assets/files/proposal/';

                $config['allowed_types'] = 'gif|jpg|png|ppt|pptx|doc|docx|xls|xlsx|swf|fla|rar|zip|html|pdf';

                $config['max_size']	= '10000';

                $config['encrypt_name'] = TRUE;



                $this->load->library('upload', $config);

                $this->upload->initialize($config);



                //upload sukses file proposal

                if($this->upload->do_upload('file_proposal')){

                    $data_upload = $this->upload->data('file_proposal');

                    $this->mproposal->tambahFileProposal($id_proposal, $data_upload, 'proposal');

                    $sukses=$this->session->userdata('sukses');

                    $sukses.="File Proposal berhasil ditambahkan<br/>";

                    $this->session->set_userdata('sukses', $sukses);

                }

                //upload gagal

                else{

    //              $error = array('error' => $this->upload->display_errors());

                    $this->session->set_userdata('error', $this->upload->display_errors());

                }



                //upload sukses file paper

                if($this->upload->do_upload('file_paper')){

                    $data_upload2 = $this->upload->data('file_paper');

                    $this->mproposal->tambahFileProposal($id_proposal, $data_upload2, 'paper');

                    $sukses=$this->session->userdata('sukses');

                    $sukses.="File Paper berhasil ditambahkan<br/>";

                    $this->session->set_userdata('sukses', $sukses);

                }

                //upload gagal

                /*else{

                    $error=$this->session->userdata('error');

                    $error.=$this->upload->display_errors();

                    $this->session->set_userdata('error', $error);

                }*/

             redirect('proposal/proposalSaya', 'refresh');

            }

            $data['leftSide'] = 'leftSide';

            $this->load->view('template', $data);

        }

        else{

            $data['title'] = "Proposal Baru";

            $data['js_menu'] = "menuMahasiswa";

            $data['header'] = "headerMahasiswa";

            $data['content'] = "proposalTA/content-buatProposalDitolak";

            $this->session->set_userdata('error', "Anda tidak dapat membuat proposal baru lagi, proposal Anda sudah terdaftar!!");

            $data['leftSide'] = 'leftSide';

            $this->load->view('template', $data);

        }



        

//        var_dump($_FILES['file_proposal']);

//        echo $this->input->post('file_proposal');

    }



    function proposalSaya(){

        //echo $this->uri->uri_string();

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



        //cek apakah benar status login admin

        if($type!="mahasiswa")redirect('berita/lihatBerita','refresh');



        $this->load->model('mproposal');



        $data['proposal']=$this->mproposal->getProposalSaya($this->session->userdata('id'));



        $data['title'] = "Proposal Saya";

        $data['js_menu'] = "menuMahasiswa";

        $data['header'] = "headerMahasiswa";

        $data['content'] = "proposalTA/content-proposalSaya";

        $data['leftSide'] = 'leftSide';

        $this->load->view('template', $data);

    }



    function ubahProposal(){

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



        //cek apakah benar status login admin

        if($type!="mahasiswa" && $type!='admin' && $type!='KBJ' && $type!='KCV' && $type!='SE')redirect('berita/lihatBerita','refresh');
		if($this->uri->segment(3, 0)==0) redirect('berita/lihatBerita','refresh');
        $this->load->model('mproposal');



        //cek apakah proposal sudah yang masih dalam status aktif sudah dibuat oleh mahasiswa atau belum

        if(!$this->mproposal->cekProposalSaya($this->session->userdata('id'), $this->uri->segment(3, 0)) || !$this->mproposal->cekProposalSaya($this->uri->segment(4, 0), $this->uri->segment(3, 0)))
		{

            $data['title'] = "Proposal Baru";

            $data['js_menu'] = "menuMahasiswa";

            $data['header'] = "headerMahasiswa";

            $data['content'] = "proposalTA/content-ubahProposal";



            $this->form_validation->set_rules('judul', 'Judul TA', 'required');

            $this->form_validation->set_rules('bidang_minat', 'Bidang minat', 'required');

            $this->form_validation->set_rules('abstraksi', 'Abstraksi', 'required');

            $this->form_validation->set_rules('keyword', 'Kata Kunci', 'required');

            $this->form_validation->set_rules('pembimbing1', 'Dosen Pembimbing 1', 'required');

            $this->form_validation->set_rules('pembimbing2', 'Dosen Pembimbing 2', 'required');



            $this->load->model('mproposal');

            $data['proposal']=$this->mproposal->getDetailProposalSaya($this->uri->segment(3, 0));
			$data['file_proposal']=$this->mproposal->getProposalFiles($this->uri->segment(3, 0));
            $this->load->model('mdosen');

            $data['kbk']=$this->mdosen->getKBK();



            $data['dosen_pembimbing']=$this->mproposal->getListDosenPembimbing();



            if ($this->form_validation->run() == TRUE)

            {

                $hasil = $this->mproposal->ubahProposal();

                $this->session->set_userdata('sukses', 'Proposal berhasil diubah<br/>');



                //setting upload

                $config['upload_path'] = '/var/www/akademik/if/newMonta/assets/files/proposal/';

                $config['allowed_types'] = 'gif|jpg|png|ppt|pptx|doc|docx|xls|xlsx|swf|fla|rar|zip|html|pdf';

                $config['max_size']	= '100000';

                $config['encrypt_name'] = TRUE;



                $this->load->library('upload', $config);

                $this->upload->initialize($config);



                //upload sukses file proposal

                if($this->upload->do_upload('file_proposal')){

                    $data_upload = $this->upload->data('file_proposal');

                    $this->mproposal->tambahFileProposal($this->uri->segment(3, 0), $data_upload, 'proposal');

                    $sukses=$this->session->userdata('sukses');

                    $sukses.="File Proposal berhasil ditambahkan<br/>";

                    $this->session->set_userdata('sukses', $sukses);

                }
				else 
				{
					$this->session->set_userdata('error', $this->upload->display_errors());
				}



                //upload sukses file paper

                if($this->upload->do_upload('file_paper')){

                    $data_upload2 = $this->upload->data('file_paper');

                    $this->mproposal->tambahFileProposal($this->uri->segment(3, 0), $data_upload2, 'paper');

                    $sukses=$this->session->userdata('sukses');

                    $sukses.="File Paper berhasil ditambahkan<br/>";

                    $this->session->set_userdata('sukses', $sukses);

                }

                

                //redirect('proposal/ubahProposal/'.$this->uri->segment(3, 0), $data);

            }

            //var_dump($data['proposal']);

        }
		else redirect('berita/lihatBerita', 'refresh');
        $this->load->view('proposalTA/content-ubahProposal', $data);

    }

    function hapusFileProposal($id_proposal="", $id_file_proposal=""){
        if($id_proposal=='' || $id_file_proposal==''){
            $this->session->set_userdata('error', "Berkas yang akan dihapus tidak valid atau Anda tidak mempunyai akses");
            redirect("proposal/ubahProposal/$id_proposal");
        }
        
        $this->load->model('mproposal');
        if($this->mproposal->hapusFileProposal($id_proposal, $id_file_proposal)) $this->session->set_userdata('sukses', "Berkas telah dihapus!");
        else $this->session->set_userdata('error', "Berkas2 yang akan dihapus tidak valid atau Anda tidak mempunyai akses");
        redirect("proposal/ubahProposal/$id_proposal");
    }

    function proposalBatal(){

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



        //cek apakah benar status login admin

        if($type!="mahasiswa")redirect('berita/lihatBerita','refresh');



        $this->load->model('mproposal');

        $id_proposal=$this->uri->segment(3, -1);

        

        //jika diakses lewat tombol batalkan

        if($id_proposal!=-1){

            $this->mproposal->batalProposal($id_proposal);

        }

        //tidak diakses lewat tombol batalkan

        else{

            $this->session->set_userdata('error', "Proposal tidak ditemukan");

            redirect('proposal/proposalSaya', "refresh");

        }

    }

}

?>