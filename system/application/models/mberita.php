<?php
class mberita extends Model {

    function mberita()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database();
    }

    function getTotalBerita(){
        $query="select id_berita from berita";
        $data=$this->db->query($query);
        return count($data->result());
    }

    function getThreeTopBerita(){
        $query="select id_berita, judul_berita from berita order by id_berita desc limit 0, 3 ";
        $data=$this->db->query($query);
        return $data->result();
    }

    function getTotalBeritaSearch($keywords){
        $query="select id_berita from berita where isi_berita like '%".$this->db->escape_like_str($keywords)."%'";
        $data=$this->db->query($query);
        return count($data->result());
    }

    function getListSummaryBerita($offset, $total_per_page){
        //setting local time language
        $query="SET lc_time_names = 'id_ID'"; // set indonesian
        $this->db->query($query);

        $query="select b.id_berita, DATE_FORMAT(b.waktu_berita, '%W %e %M %Y pukul %T WIB')waktu_berita, d.nama_dosen, substr(b.isi_berita,1, 300)isi_berita, b.judul_berita from berita b, dosen d where (b.nip=d.nip or b.nip=d.nip2010) and b.nip!='' order by b.id_berita desc limit ".$this->db->escape_like_str($offset).", ".$this->db->escape_like_str($total_per_page);
        $data=$this->db->query($query);
        return $data->result();
    }

    function getListSummaryBeritaSearch($offset, $total_per_page, $keywords){
        //setting local time language
        $query="SET lc_time_names = 'id_ID'"; // set indonesian
        $this->db->query($query);

        $query="select b.id_berita, DATE_FORMAT(b.waktu_berita, '%W %e %M %Y pukul %T WIB')waktu_berita, d.nama_dosen, substr(b.isi_berita,1, 300)isi_berita, b.judul_berita from berita b, dosen d where (b.nip=d.nip or b.nip=d.nip2010) and b.nip!='' and b.isi_berita like '%".$this->db->escape_like_str($keywords)."%' order by b.id_berita desc limit ".$this->db->escape_like_str($offset).", ".$this->db->escape_like_str($total_per_page);
        $data=$this->db->query($query);
        return $data->result();
    }

    function getDetailBerita($id_berita){
        //setting local time language
        $query="SET lc_time_names = 'id_ID'"; // set indonesian
        $this->db->query($query);

        $query="select DATE_FORMAT(b.waktu_berita, '%W %e %M %Y pukul %T WIB')waktu_berita, d.nama_dosen, b.isi_berita, b.judul_berita from berita b, dosen d where (b.nip=d.nip or b.nip=d.nip2010) and b.nip!='' and b.id_berita=".$this->db->escape($id_berita);
        $data=$this->db->query($query);
        return $data->result();
    }

    function getBeritaFiles($id_berita){
        $query="select id_file_berita, nama_file, path_file from berita_files where id_berita='$id_berita'";
        $data=$this->db->query($query);
        return $data->result();
    }

    function tambahBerita(){
        $judul=$this->input->post('judul');
        $isi=$this->input->post('isi');
        $nip=$this->session->userdata('nip');
        $query="insert into berita values(null, NOW(), '$nip', ".$this->db->escape($isi).", '1', '1', ".$this->db->escape($judul).")";
        $this->db->query($query);

        $query="select max(id_berita)id_berita from berita";
        $data=$this->db->query($query);
        return $data->result();
    }
    function hapusBerita($id_berita){
        $query="delete from berita where id_berita=".$this->db->escape($id_berita);
        $data=$this->db->query($query);

        $query="delete from berita_files where id_berita=".$this->db->escape($id_berita);
        $data=$this->db->query($query);
    }
	function ubahBerita($id_berita){
        $judul=$this->input->post('judul');
        $isi=$this->input->post('isi');
        $query="update berita set waktu_berita=NOW(), isi_berita=".$this->db->escape($isi).", judul_berita=".$this->db->escape($judul)." where id_berita=".$this->db->escape($id_berita);
        $this->db->query($query);

        $query="select max(id_berita)id_berita from berita";
        $data=$this->db->query($query);
        return $data->result();
    }

    function tambahFileBerita($id_berita, $data){
        $nama_file=$data['file_name'];
        $tipe_file=$data['file_type'];
        $original_name=$data['orig_name'];
        
        $query="insert into berita_files values(NULL, '$id_berita', '$original_name', '$tipe_file', '', '$nama_file')";
        $data=$this->db->query($query);
    }
}
?>