<?php

class Mahasiswa extends Controller 
{
    
    function Mahasiswa() 
    {
        parent::Controller();
        $this->load->library('lib_js');
        $this->load->library('lib_user');
    }	
    
    function index()
    {   
        $this->pendaftaranMahasiswa();
    }

    function pendaftaranMahasiswa()
    {
        // autentikasi
        $this->lib_user->cek_admin();
        
        $data['title'] = 'Pendaftaran Mahasiswa TA';
        $data['js_menu'] = $this->lib_user->get_javascript_menu();
        $data['header'] = $this->lib_user->get_header();
        $data['leftSide'] = 'leftSide';
        // load model, library, helper etc.
        $path = $_SERVER['DOCUMENT_ROOT']."assets/files/registrasi/";
        //echo $path;
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'xls';
        $config['max_size']	= '1000';
        $this->load->library('upload', $config);
        // jika upload gagal
        if ($this->upload->do_upload() == false)
        {
            $data['content'] = "mahasiswa/content-pendaftaran";
            $data['upload_error'] = $this->upload->display_errors();
            $this->load->view('template', $data);
        }
        else
        {
            $data['content'] = "mahasiswa/content-konfirmasiPendaftaran";
            // get data yang diupload
            $upload_data = $this->upload->data();
            // load model, library, helper etc.
            $this->load->model('mmahasiswa');
            $this->load->library('excel_reader');
            // set output Encoding.
            $this->excel_reader->setOutputEncoding('CP1251');
            // filename with fullpath
            $file =  $path.$upload_data['file_name'] ;
            $this->excel_reader->read($file);
            error_reporting(E_ALL ^ E_NOTICE);
            // read sheet 1
            $isi_file = $this->excel_reader->sheets[0] ;
            $daftar_sukses = array();
            $jumlah_sukses = 0;
            $daftar_gagal = array();
            $jumlah_gagal = 0;
            // looping baca file per baris, dimulai dari baris ke-2
            for ($i = 2; $i <= $isi_file['numRows']; $i++) 
            {
                // nrp, kolom 1
                $nrp =  $isi_file['cells'][$i][1];
                // nama, kolom 2
                $nama = $isi_file['cells'][$i][2];
                $password = $isi_file['cells'][$i][1];
                // enkrip password
                //$password = $this->encrypt->encode($isi_file['cells'][$i][1], 'g7Rd7G8vhrD78yhv398hiDHrg89h34gh');
                //cek mahasiswa (terdaftar/belum)
                if($this->mmahasiswa->cek($nrp) == false) {
                    $data_mahasiswaTA = array(
                        'nrp' => $this->db->escape_like_str($nrp),
                        'nama_mahasiswa' => $this->db->escape_like_str($nama),
                        'nama_lengkap_mahasiswa' => $this->db->escape_like_str($nama),
                        'password_mahasiswa' => $this->db->escape_like_str($password)
                    );
                    $this->mmahasiswa->add($data_mahasiswaTA);
                    $daftar_sukses[$jumlah_sukses]['nrp'] = $nrp;
                    $daftar_sukses[$jumlah_sukses]['nama'] = $nama;
                    $jumlah_sukses++;
                } else {
                    $daftar_gagal[$jumlah_gagal]['nrp'] = $nrp;
                    $daftar_gagal[$jumlah_gagal]['nama'] = $nama;
                    $jumlah_gagal++;
                }
            }
            $data['daftar_sukses'] = $daftar_sukses;
            $data['daftar_gagal'] = $daftar_gagal;
            $this->load->view('template', $data);
        }
    }



}

?>
