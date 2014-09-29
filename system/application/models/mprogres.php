<?php
class mprogres extends Model 
{

    function mprogres() 
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
        $this->db->insert("progress_ta", $data);
    }

    function update($data, $id_progress) 
    {
        $this->db->update("progress_ta", $data, array('ID_PROGRESS' => $this->db->escape_like_str($id_progress)));
    }

    function hapus($id_progress) 
    {
        $this->db->delete("progress_ta", array('ID_PROGRESS' => $this->db->escape_like_str($id_progress)));
    }
    
    function getList($id_proposal) 
    {
        $this->db->select("progress_ta.*, dosen.NAMA_LENGKAP_DOSEN as PEMBIMBING");
        $this->db->from("progress_ta");
        $this->db->from("dosen");
        $this->db->where("progress_ta.NIP = dosen.NIP");
        $this->db->where("progress_ta.ID_PROPOSAL", $this->db->escape_like_str($id_proposal));
        $this->db->order_by("progress_ta.TGL_PROGRESS", 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
    
    function getDetail($id_progress) 
    {
        $this->db->select("progress_ta.*, dosen.NAMA_LENGKAP_DOSEN as PEMBIMBING");
        $this->db->from("progress_ta");
        $this->db->from("dosen");
        $this->db->where("progress_ta.NIP = dosen.NIP");
        $this->db->where("progress_ta.ID_PROGRESS", $this->db->escape_like_str($id_progress));
        $query = $this->db->get();
        return $query->row();
    }
    
    function getLastID($id_proposal) 
    {
        $this->db->select_max("ID_PROGRESS");
        $this->db->from("progress_ta");
        $this->db->where("ID_PROPOSAL", $this->db->escape_like_str($id_proposal));
        $query = $this->db->get();
        $hasil = $query->row();
        return $hasil->ID_PROGRESS;
    }
    
    function cekProgresTA($id_proposal="", $id_progress="", $dialog="", $redirect_page="error/index/") 
    {
        $hasil = null;
        $sql = "
            SELECT progress_ta.ID_PROGRESS
            FROM progress_ta
            WHERE progress_ta.ID_PROPOSAL = '".$this->db->escape_like_str($id_proposal)."'
            AND progress_ta.ID_PROGRESS = '".$this->db->escape_like_str($id_progress)."'
            LIMIT 1
        ";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0)
            $hasil = TRUE;
        else
            $hasil = FALSE;
        if(empty ($dialog)) 
        {
            return $hasil;
        } 
        else 
        {
            if(! $hasil) 
            {
                $this->lib_alert->warning("Data bimbingan tugas akhir tidak ditemukan");
                if($redirect_page == "error/index/")
                    redirect($redirect_page.$dialog);
                else
                    redirect($redirect_page);
            }
        }
    }

    
    function cekPembimbingProgresTA($nip="", $id_progress="", $dialog="", $redirect_page="error/index/") 
    {
        $hasil = null;
        $sql = "
            SELECT progress_ta.ID_PROGRESS
            FROM progress_ta
            WHERE (progress_ta.NIP = '".$this->db->escape_like_str($nip)."' OR progress_ta.NIP = '000000000')
            AND progress_ta.ID_PROGRESS = '".$this->db->escape_like_str($id_progress)."'
            LIMIT 1
        ";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0)
            $hasil = TRUE;
        else
            $hasil = FALSE;
        if(empty ($dialog)) 
        {
            return $hasil;
        } 
        else 
        {
            if(! $hasil) 
            {
                $this->lib_alert->warning("Halaman hanya bisa diakses oleh dosen yang bersangkutan");
                if($redirect_page == "error/index/")
                    redirect($redirect_page.$dialog);
                else
                    redirect($redirect_page);
            }
        }
    }

    function field($field="", $id_progresTA='') 
    {
        $this->db->select("$field");
        $this->db->from("progress_ta");
        $this->db->where("ID_PROGRESS", $this->db->escape_like_str($id_progresTA));
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
    
    

    

    

    

		
}

?>
