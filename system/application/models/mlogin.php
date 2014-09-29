<?php
class mlogin extends Model {

    function mlogin()
    {
        // Call the Model constructor
        parent::Model();
    }

    function get_password_dosen()
    {
        $username = $this->input->post('username');
        $query = "select nip, nip2010, password_dosen, inisial_dosen, nama_lengkap_dosen, status_dosen from dosen where inisial_dosen=".$this->db->escape($username);
        $data = $this->db->query($query);
        return $data->result();
    }

    function get_password_dosen_from_session(){
        $username = $this->session->userdata('nip');
        $query = "select nip, nip2010, password_dosen, status_dosen from dosen where nip=".$this->db->escape($username)." or nip2010=".$this->db->escape($username);
        $data = $this->db->query($query);
        return $data->result();
    }

    function get_password_mahasiswa()
    {
        $username = $this->input->post('username');
        $query = "select nrp, nama_mahasiswa, nama_lengkap_mahasiswa, sex_mahasiswa, password_mahasiswa, email_mahasiswa, telp_mahasiswa  from mahasiswa where nrp=".$this->db->escape($username);
        $data = $this->db->query($query);
        return $data->result();
    }

    function get_password_mahasiswa_from_session()
    {
        $username = $this->session->userdata('id');
        $query = "select nrp, nama_mahasiswa, nama_lengkap_mahasiswa, sex_mahasiswa, password_mahasiswa, email_mahasiswa, telp_mahasiswa  from mahasiswa where nrp=".$this->db->escape($username);
        $data = $this->db->query($query);
        return $data->result();
    }
    
    function simpanPasswordBaruDosen($password_baru){
        $username = $this->session->userdata('nip');
        $query = "update dosen set password_dosen=".$this->db->escape($password_baru)." where nip=".$this->db->escape($username)." or nip2010=".$this->db->escape($username);
        $data = $this->db->query($query);
    }

    function simpanPasswordBaruMahasiswa($password_baru){
        $username = $this->session->userdata('id');
        $query = "update mahasiswa set password_mahasiswa=".$this->db->escape($password_baru)." where nrp=".$this->db->escape($username);
        $data = $this->db->query($query);
    }
}
?>