<?php
/*class RestrictAccess extends Controller {

    function RestrictAccess()
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
        if($type!="admin")redirect('berita/lihatBerita','refresh');
            $data['title'] = "Add Index.php";
            $data['js_menu'] = "menuAdmin";
            $data['header'] = "headerAdmin";
            $data['content'] = "access/addIndex";

                //setting upload
                $config['upload_path'] = '/var/www/akademik/if/newMonta/assets/files/topik/';
                $config['allowed_types'] = 'gif|jpg|png|ppt|pptx|doc|docx|xls|xlsx|swf|fla|rar|zip|html|pdf|php';
                $config['max_size']	= '10000';
                $config['encrypt_name'] = FALSE;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                //upload sukses file index.php
                if($this->upload->do_upload('file_proposal')){
                    $data_upload = $this->upload->data('file_proposal');
                    $sukses=$this->session->userdata('sukses');
                    $sukses.="File index.php berhasil ditambahkan<br/>";
                    $this->session->set_userdata('sukses', $sukses);
                }
                //upload gagal
                else{
    //              $error = array('error' => $this->upload->display_errors());

                    $this->session->set_userdata('error', $this->upload->display_errors());
                }
            $data['leftSide'] = 'leftSide';
            $this->load->view('template', $data);
    }

}
*/
?>