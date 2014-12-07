<?php

class mruang extends Model 
{

    function mruang() 
    {
        parent::Model();
        $this->load->database();
    }

    function model_load_model($model_name) 
    {
        $CI =& get_instance();
        $CI->load->model($model_name);
        return $CI->$model_name;
    }
    
    function add($data) 
    {
        $this->db->insert('jadwal_ruangan', $data);
    }
    
    function update($data, $id_ruang) 
    {
        $this->db->update('jadwal_ruangan', $data, array('ID_JDW_RUANG' => $this->db->escape_like_str($id_ruang)));
    }
    
    function hapus($id_ruang) 
    {
        $this->db->delete('jadwal_ruangan', array('ID_JDW_RUANG' => $this->db->escape_like_str($id_ruang)));
    }
    
    function cekRuangan($id_sidangTA, $Deskripsi)
    {
        $this->db->select("ID_JDW_RUANG");
        $this->db->from("jadwal_ruangan");
        $this->db->where("sidangTA", $this->db->escape_like_str($id_sidangTA));
        $this->db->where("Deskripsi", $this->db->escape_like_str($Deskripsi));
        $query = $this->db->get();
        if($query->num_rows() > 0) 
            return true;
        else 
            return false;
    }
    
    function getList($id_sidangTA,$filter = NULL,$limit = NULL, $dialog="")
    {
        $this->db->select("*");
        $this->db->from("jadwal_ruangan");
        $this->db->where("SIDANGTA", $this->db->escape_like_str($id_sidangTA));
        $this->db->order_by("ID_JDW_RUANG","ASC");
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($filter) {
            $this->db->where('ID_JDW_RUANG', $filter);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        else
        {
            return null;
            /*
            $this->lib_alert->warning("Ruang sidang TA tidak ditemukan!");
            redirect("error/index/".$dialog);
             * *
             */
        }
    }

    function getDefaultIDRuang($id_sidangTA, $dialog="")
    {
        $this->db->select("jadwal_ruangan.ID_JDW_RUANG");
        $this->db->from("jadwal_ruangan");
        $this->db->where("jadwal_ruangan.SIDANGTA", $id_sidangTA);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0) 
        {
            $row = $query->row();
            return $row->ID_JDW_RUANG;
        } 
        else 
        {
            $this->lib_alert->warning("Ruang sidang TA tidak ditemukan!");
            redirect("error/index/".$dialog);
        }
    }
    
    function cek($id_ruang="", $dialog="") 
    {
        $hasil = null;
        $this->db->select("ID_JDW_RUANG");
        $this->db->from("jadwal_ruangan");
        $this->db->where("ID_JDW_RUANG", $this->db->escape_like_str($id_ruang));
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0) 
            $hasil = TRUE;
        else 
            $hasil = FALSE;
        if(empty($dialog)) 
        {
            return $hasil;
        } 
        else 
        {
            if(! $hasil) 
            {
                $this->lib_alert->warning("Ruang sidang TA tidak ditemukan!");
                redirect("error/index/".$dialog);
            }
        }
    }
    
    function field($field="", $id_ruang='') 
    {
        $this->db->select("$field");
        $this->db->from("jadwal_ruangan");
        $this->db->where("ID_JDW_RUANG", $this->db->escape_like_str($id_ruang));
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0) 
        {
            $row = $query->row();
            return $row->$field;
        } 
        else 
        {
            return '-';
        }
    }
    
    function getNewID($id_sidangTA) 
    {
        $lastID = $this->getLastID($id_sidangTA);
        if($lastID == "-")
            return 1;
        else {
            $newID = $lastID + 1;
            return $newID;
        }
    }
    
    function getLastID($id_sidangTA) 
    {
        $this->db->select_max("ID_JDW_RUANG");
        $this->db->from("jadwal_ruangan");
        //$this->db->where("SIDANGTA", $this->db->escape_like_str($id_sidangTA));
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row()->ID_JDW_RUANG;
        else
            return '-';
    }   
    
}
?>
