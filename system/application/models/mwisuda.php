<?php
class mwisuda extends Model 
{
    
    function mwisuda() 
    {
        parent::Model();    
        $this->load->database();
    }

    // <object> utk memanggil class model lain
    function model_load_model($model_name) {
        $CI =& get_instance();
        $CI->load->model($model_name);
        return $CI->$model_name;
    }

    // <int> get new ID periode wisuda
    function newIDWisuda() {
        $this->db->select_max('ID_PERIODE_WISUDA');
        $query = $this->db->get("periode_wisuda");

        if($query->num_rows() > 0) {
            $row = $query->row();
            return $row->ID_PERIODE_WISUDA+1;
        } else {
            return 1;
        }
    }

    // <boolean> cek periode wisuda
    function cekWisuda($id_wisuda="") {
        if(empty ($id_wisuda))
            return FALSE;
        
        $this->db->select("ID_PERIODE_WISUDA");
        $this->db->from("periode_wisuda");
        $this->db->where("ID_PERIODE_WISUDA", $id_wisuda);
        $this->db->limit(1);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
		
    // <object array> get list periode wisuda
    function getListWisuda() {
        $this->db->select("periode_wisuda.*");
        $this->db->from("periode_wisuda");
        $this->db->order_by("ID_PERIODE_WISUDA","DESC");
        $query = $this->db->get();
        
        return $query->result();
    }
	
    // tambah periode wisuda
    function addWisuda($data) {
        $this->db->insert(periode_wisuda, $data);
    }
	
    // update periode wisuda
    function updateWisuda($data, $id_wisuda) {
        $this->db->update(periode_wisuda, $data, array('ID_PERIODE_WISUDA' => $id_wisuda));
    }
	
    // update status semua periode wisuda
    function updateStatusWisuda($status) {
        $this->db->update(periode_wisuda, array('AKTIF' => $status));
    }
	
    // hapus periode wisuda
    function hapusWisuda($id_wisuda) {
        $this->db->delete(periode_wisuda, array('ID_PERIODE_WISUDA' => $id_wisuda));
    }
	
	
}
?>