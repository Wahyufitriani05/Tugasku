<?php
class mmahasiswa extends Model 
{
	
    function mmahasiswa() 
    {
        parent::Model();        
        $this->load->database();
    }

    function add($data) 
    {
        $this->db->insert(mahasiswa, $data);
    }
	
    function cek($filter) 
    {
        $this->db->select("NRP");
        $this->db->from("mahasiswa");
        if(is_array($filter))
            $this->db->where($filter);
        else
            $this->db->where("NRP", $this->db->escape_like_str($filter));
        $query = $this->db->get();
        if($query->num_rows() > 0) 
            return true;
        else
            return false;
    }
}

?>
