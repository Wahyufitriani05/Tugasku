<?php
class mslot extends Model 
{
    
    function mslot() 
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

    // tambah slot
    function add($data) 
    {
        $this->db->insert('jadwal_slot', $data);
    }

    // update slot
    function update($data, $id_slot) 
    {
        $this->db->update('jadwal_slot', $data, array('ID_SLOT' => $this->db->escape_like_str($id_slot)));
    }

    // hapus slot
    function hapus($id_slot) 
    {
        $this->db->delete('jadwal_slot', array('ID_SLOT' => $this->db->escape_like_str($id_slot)));
    }
    
    // get semua slot (hari & waktu) dg parameter sidang TA
    function getListSlot($id_sidangTA) 
    {
        $this->db->select("*");
        $this->db->from("jadwal_slot");
        $this->db->where("SIDANGTA", $this->db->escape_like_str($id_sidangTA));
        $this->db->where("LENGTH(TREEID) > 2"); // panjang treeid > 2
        $this->db->order_by("TREEID","ASC");
        $query = $this->db->get();
        return $query->result();
    }
    
    // get list slot hari
    function getListSlotHari($id_sidangTA) 
    {
        $this->db->select("*");
        $this->db->select("DATE_FORMAT(TGL,'%d %M %Y') as STRING_TGL", FALSE );
        $this->db->from("jadwal_slot");
        $this->db->like('TREEID', '00', 'after');  // TREEID like '00%'
        $this->db->where("LENGTH(TREEID)", 4, FALSE); // panjang treeid = 4
        $this->db->where("SIDANGTA", $this->db->escape_like_str($id_sidangTA));
        $this->db->order_by("TGL","DESC");
        $query = $this->db->get();
        return $query->result();
    }

    // get list slot waktu
    function getListSlotWaktu($id_sidangTA, $parent_treeid) 
    {
        $id_sidangTA = $this->db->escape_like_str($id_sidangTA);
        $parent_treeid = $this->db->escape_like_str($parent_treeid);
        $this->db->select("*");
        $this->db->select("DATE_FORMAT(TGL,'%d %M %Y') as STRING_TGL", FALSE );
        $this->db->from("jadwal_slot");
        $this->db->like('TREEID', $parent_treeid, 'after');  // TREEID like '$parent_id%'
        $this->db->where("LENGTH(TREEID)", strlen($parent_treeid)+2, FALSE); // panjang treeid child = panjang treeid parent + 2
        $this->db->where("SIDANGTA", $this->db->escape_like_str($id_sidangTA));
        $this->db->order_by("WAKTU","ASC");
        $query = $this->db->get();
        return $query->result();
    }

    // get detail slot dg parameter sidang TA dan TreeID
    function getDetailSlot($id_sidangTA, $treeid) 
    {
        $this->db->select("*");
        $this->db->from("jadwal_slot");
        $this->db->where("SIDANGTA", $this->db->escape_like_str($id_sidangTA));
        $this->db->where("TREEID", $this->db->escape_like_str($treeid));
        $query = $this->db->get();
        return $query->row();
    }
    
    // get detail slot dg parameter sidang TA dan TreeID
    function getDetailSlot2($id_slot) 
    {
        $this->db->select("*");
        $this->db->from("jadwal_slot");
        $this->db->where("ID_SLOT", $this->db->escape_like_str($id_slot));
        $query = $this->db->get();
        return $query->row();
    }
    
    function field($field="", $id_slot="") 
    {
        $this->db->select("$field");
        $this->db->from("jadwal_slot");
        $this->db->where("ID_SLOT", $this->db->escape_like_str($id_slot));
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
    
    function newIDSlot() 
    {
        $this->db->select_max('ID_SLOT');
        $query = $this->db->get("jadwal_slot");
        if($query->num_rows() > 0) 
        {
            $row = $query->row();
            return $row->ID_SLOT+1;
        } 
        else 
        {
            return 1;
        }
    }

    function newTreeID($id_sidangTA, $parent_treeid) 
    {
        $id_sidangTA = $this->db->escape_like_str($id_sidangTA);
        $parent_treeid = $this->db->escape_like_str($parent_treeid);
        $this->db->select("TREEID");
        $this->db->from("jadwal_slot");
        $this->db->like('TREEID', $parent_treeid, 'after');  // TREEID like '$parent_id%'
        $this->db->where("LENGTH(TREEID)", strlen($parent_treeid)+2, FALSE); // panjang treeid child = panjang treeid parent + 2
        $this->db->where("SIDANGTA", $this->db->escape_like_str($id_sidangTA));
        $this->db->order_by("TREEID","DESC");
        $this->db->limit(1);
        $query = $this->db->get(); // mendapatkan treeid slot terakhir yg dibuat dgn id_sidangTA=xx dan $parent_treeid=xx
        if($query->num_rows() > 0)
                $row = $query->row();
        else
                $row->TREEID = 0;
        $nextID = intval(substr($row->TREEID,strlen($row->TREEID)-2,strlen($row->TREEID)))+1; // mendapatkan next id dr child slot, misal treeid slot terakhir 0013, maka nextID = 14 (2 digit terakhir)
        $nextTreeID = $parent_treeid.str_repeat('0',2-strlen($nextID)).$nextID; // ditambahkan parent_treeid sebelum nextID

        return $nextTreeID; // treeid slot baru
    }

    function cekSlot($options="", $dialog="") 
    {
        $hasil = null;
        $this->db->select("ID_SLOT");
        $this->db->from("jadwal_slot");
        if(is_array($options))
            $this->db->where($options);
        else
            $this->db->where("ID_SLOT", $this->db->escape_like_str($options));
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
                $this->lib_alert->warning("Slot sidang TA tidak ditemukan");
                redirect("error/index/".$dialog);
            }
        }
    }

    function cekTreeID($treeid="", $dialog="") 
    {
        $hasil = null;
        $this->db->select("TREEID");
        $this->db->from("jadwal_slot");
        $this->db->where("TREEID", $this->db->escape_like_str($treeid));
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
                $this->lib_alert->warning("Slot sidang TA tidak ditemukan");
                redirect("error/index/".$dialog);
            }
        }
    }

    // cek slot apakah slot punya child?
    function cekChild($id_sidangTA="", $parent_treeid="") 
    {
        $this->db->select("ID_SLOT");
        $this->db->from("jadwal_slot");
        $this->db->like('TREEID', $this->db->escape_like_str($parent_treeid), 'after');
        $this->db->where("SIDANGTA", $this->db->escape_like_str($id_sidangTA));
        $query = $this->db->get();
        if($query->num_rows() > 1) 
            return TRUE;
        else 
            return FALSE;
    }

    // get TreeID dari Slot Hari/Parent Pertama pada sidang TA
    function getTreeIDFirstParentSlot($id_sidangTA) 
    {
        $this->db->select("TREEID");
        $this->db->from("jadwal_slot");
        $this->db->where("SIDANGTA", $this->db->escape_like_str($id_sidangTA));
        $this->db->where("LENGTH(TREEID)", 4, FALSE); // panjang treeid = 4
        $this->db->order_by("TREEID","ASC");
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0) 
        {
            $row = $query->row();
            return $row->TREEID;
        } 
        else 
        {
            return '-';
        }
    }

    // get ID slot terbaru
    function getLastIDSlot($id_sidangTA, $treeid) 
    {
        $this->db->select_max("ID_SLOT","ID_SLOT");
        $this->db->from("jadwal_slot");
        $this->db->where("jadwal_slot.SIDANGTA", $this->db->escape_like_str($id_sidangTA));
        $this->db->where("jadwal_slot.TREEID", $this->db->escape_like_str($treeid));
        $query = $this->db->get();
        $hasil = $query->row();
        return $hasil->ID_SLOT;
    }
    
    

}
?>