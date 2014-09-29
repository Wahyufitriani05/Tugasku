<?php
class msidang extends Model 
{

    function msidang() 
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
    
     // tambah jadwal Sidang Proposal 
    function addSidangProposal($data) 
    {
        $this->db->insert('sidang_proposal', $data);
    }

    // tambah jadwal Sidang TA
    function addSidangTA($data) 
    {
        $this->db->insert('sidang_ta', $data);
    }

    // update jadwal Sidang Proposal 
    function updateSidangProposal($data, $id_sidprop) 
    {
        $this->db->update('sidang_proposal', $data, array('ID_SIDANG_PROP' => $this->db->escape_like_str($id_sidprop)));
    }
	
    // update status jadwal Sidang Proposal 
    function updateStatusSidangProposal($id_sidprop, $waktu_entri) 
    {
        $id_sidprop = $this->db->escape_like_str($id_sidprop);
        $waktu_entri = $this->db->escape_like_str($waktu_entri);
        $this->db->select("STATUS_SIDANG_PROP");
        $this->db->from("sidang_proposal");
        $this->db->where("ID_SIDANG_PROP", $id_sidprop);
        $query = $this->db->get();
        $result = $query->row();
        if($result->STATUS_SIDANG_PROP == 0)
            $this->db->update('sidang_proposal', array('STATUS_SIDANG_PROP' => 1, 'WAKTU_SIDANG_PROP' => $waktu_entri), array('ID_SIDANG_PROP' => $id_sidprop));
        elseif($result->STATUS_SIDANG_PROP == 1)
            $this->db->update('sidang_proposal', array('STATUS_SIDANG_PROP' => 0, 'WAKTU_SIDANG_PROP' => $waktu_entri), array('ID_SIDANG_PROP' => $id_sidprop));
    }
    
    // update jadwal Sidang TA
    function updateSidangTA($data, $id_sidTA) 
    {
        $this->db->update('sidang_ta', $data, array('ID_SIDANG_TA' => $this->db->escape_like_str($id_sidTA)));
    }

    // update status jadwal Sidang TA
    function updateStatusSidangTA($status) 
    {
        $this->db->update('sidang_ta', array('STATUS_SIDANG_TA' => $this->db->escape_like_str($status)));
    }
	
    // hapus jadwal Sidang Proposal
    function hapusSidangProposal($id_sidprop) 
    {
        $this->db->delete('sidang_proposal', array('ID_SIDANG_PROP' => $this->db->escape_like_str($id_sidprop)));
    }

    // hapus jadwal Sidang TA
    function hapusSidangTA($id_sidTA) 
    {
        $this->db->delete('sidang_ta', array('ID_SIDANG_TA' => $this->db->escape_like_str($id_sidTA)));
    }
    
    // get list jadwal sidang proposal
    function jadwalSidangProposal($id_kbk, $status="") 
    {
        $this->db->select("sidang_proposal.*, kbk.NAMA_KBK");
        $this->db->from("sidang_proposal");
        $this->db->join("kbk", "kbk.ID_KBK = sidang_proposal.ID_KBK");
        $this->db->where("sidang_proposal.ID_KBK", $this->db->escape_like_str($id_kbk));
        if(! empty($status))
            $this->db->where("sidang_proposal.STATUS_SIDANG_PROP", $this->db->escape_like_str($status));
        $this->db->order_by("sidang_proposal.WAKTU", "DESC");
        $query = $this->db->get();
        return $query->result();
    }

    // get list jadwal sidang TA
    function jadwalSidangTA() 
    {
        $this->db->select("sidang_ta.*");
        $this->db->from("sidang_ta");
        $this->db->order_by("ID_SIDANG_TA","DESC");
        $query = $this->db->get();
        return $query->result();
    }
    
    // cek sidang proposal
    function cekSidangProposal($filter="") 
    {
        $hasil = null;
        $this->db->select("ID_SIDANG_PROP");
        $this->db->from("sidang_proposal");
        if(is_array($filter))
            $this->db->where($filter);
        else
            $this->db->where("ID_SIDANG_PROP", $this->db->escape_like_str($filter));
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0) 
            return TRUE;
        else 
            return FALSE;
        if(empty ($dialog)) 
        {
            return $hasil;
        } 
        else 
        {
            if(! $hasil) 
            {
                $this->lib_alert->warning("Sidang proposal tidak ditemukan");
                redirect("error/index/".$dialog);
            }
        }
    }

    // cek sidang TA
    function cekSidangTA($filter="", $dialog="") 
    {
        $hasil = null;
        $this->db->select("ID_SIDANG_TA");
        $this->db->from("sidang_ta");
        if(is_array($filter))
            $this->db->where($filter);
        else
            $this->db->where("ID_SIDANG_TA", $this->db->escape_like_str($filter));
        $this->db->limit(1);
        $query = $this->db->get();
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
                $this->lib_alert->warning("Sidang TA tidak ditemukan");
                redirect("error/index/".$dialog);
            }
        }
    }

    function fieldSidangProp($field="", $id_sidProp='') 
    {
        $this->db->select("$field");
        $this->db->from("sidang_proposal");
        $this->db->where("ID_SIDANG_PROP", $this->db->escape_like_str($id_sidProp));
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

    // get periode sidang TA
    function periodeSidangTA($id_sidTA='') 
    {
        $this->db->select("SEMESTER_SIDANG_TA,TAHUN_SIDANG_TA");
        $this->db->from("sidang_ta");
        $this->db->where("ID_SIDANG_TA", $this->db->escape_like_str($id_sidTA));
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0) 
        {
            $row = $query->row();
            return $row->SEMESTER_SIDANG_TA." ".$row->TAHUN_SIDANG_TA;
        } 
        else 
        {
            return '-';
        }
    }
    
    function getIDSidPropTerbaru($id_kbk) 
    {
        $this->db->select("ID_SIDANG_PROP");
        $this->db->from("sidang_proposal");
        $this->db->where("STATUS_SIDANG_PROP", 1);
        $this->db->where("ID_KBK", $this->db->escape_like_str($id_kbk));
        $this->db->order_by("WAKTU", "DESC");
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0) 
        {
            $row = $query->row();
            return $row->ID_SIDANG_PROP;
        } 
        else 
        {
            return '';
        }
    }
    
    // get ID Sidang TA yang aktif
    function getIDSidangTAAktif() 
    {
        $this->db->select("sidang_ta.ID_SIDANG_TA");
        $this->db->from("sidang_ta");
        $this->db->where("sidang_ta.STATUS_SIDANG_TA", 1);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0) 
        {
            $row = $query->row();
            return $row->ID_SIDANG_TA;
        } 
        else 
        {
            return '-';
        }
    }
    
    // get ID Sid Prop terbaru
    function getLastIDSidangProp() 
    {
        $this->db->select_max("ID_SIDANG_PROP","ID_SIDANG_PROP");
        $query = $this->db->get("sidang_proposal");
        $hasil = $query->row();
        return $hasil->ID_SIDANG_PROP;
    }

    // get ID Sid TA terbaru
    function getLastIDSidangTA() 
    {
        $this->db->select_max("ID_SIDANG_TA","ID_SIDANG_TA");
        $query = $this->db->get("sidang_ta");
        $hasil = $query->row();
        return $hasil->ID_SIDANG_TA;
    }
    
    // get list proposal TA yang maju sidang proposal
    function getListProposalMajuSidangProp($id_kbk, $id_sid_prop="", $offset="", $jumlah_per_page="") 
    {
        $mdosen = $this->model_load_model('mdosen');
        $sql = "SELECT pr.ID_PROPOSAL , pr.SPROP, pr.JUDUL_TA, pr.NRP, mhs.NAMA_LENGKAP_MAHASISWA, pr.STATUS, ds1.NAMA_LENGKAP_DOSEN as PEMBIMBING1, ds2.NAMA_LENGKAP_DOSEN as PEMBIMBING2
                FROM proposal pr, mahasiswa mhs, dosen ds1, dosen ds2
                WHERE  mhs.NRP = pr.NRP
                AND ds1.NIP = pr.PEMBIMBING1
                AND ds2.NIP = pr.PEMBIMBING2
                AND pr.ID_KBK = '".$this->db->escape_like_str($id_kbk)."'
                AND (pr.STATUS = '0' OR pr.STATUS = '1' OR pr.STATUS = '11' OR pr.STATUS = '12')";
        if(! empty ($id_sid_prop))
            $sql .= " AND pr.SPROP = '".$this->db->escape_like_str($id_sid_prop)."'";
        else
            $sql .= " AND (pr.SPROP IS NULL OR pr.SPROP = '')"; 
        $sql .= " ORDER BY pr.ID_PROPOSAL asc, pr.STATUS desc";
//        if($jumlah_per_page!="") {
//            $end_row = $offset + $jumlah_per_page - 1;
//            $sql = $sql." LIMIT $offset, $jumlah_per_page";
//        }
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    function getListProposalMajuSidangProp_Darurat($id_kbk, $id_sid_prop="", $offset="", $jumlah_per_page="", $tgl_sidprop="") 
    {
        $mdosen = $this->model_load_model('mdosen');
        $sql = "SELECT pr.ID_PROPOSAL , pr.SPROP, pr.JUDUL_TA, pr.NRP, mhs.NAMA_LENGKAP_MAHASISWA, pr.STATUS, ds1.NAMA_LENGKAP_DOSEN as PEMBIMBING1, ds2.NAMA_LENGKAP_DOSEN as PEMBIMBING2
                FROM proposal pr, mahasiswa mhs, dosen ds1, dosen ds2
                WHERE  mhs.NRP = pr.NRP
                AND ds1.NIP = pr.PEMBIMBING1
                AND ds2.NIP = pr.PEMBIMBING2
                AND pr.ID_KBK = '".$this->db->escape_like_str($id_kbk)."'";
        if(! empty ($id_sid_prop))
            $sql .= " AND (pr.SPROP = '".$this->db->escape_like_str($id_sid_prop)."' or pr.TGL_SIDANG_TA = '".$this->db->escape_like_str($tgl_sidprop)."')";
        else
            $sql .= " AND (pr.SPROP IS NULL OR pr.SPROP = '')"; 
        //$sql .= " AND pr.TGL_SIDANG_TA = '".$this->db->escape_like_str($tgl_sidprop)."'";
        $sql .= " ORDER BY pr.ID_PROPOSAL asc, pr.STATUS desc";
//        if($jumlah_per_page!="") {
//            $end_row = $offset + $jumlah_per_page - 1;
//            $sql = $sql." LIMIT $offset, $jumlah_per_page";
//        }
        $query = $this->db->query($sql);
        return $query->result();
    }

}
?>