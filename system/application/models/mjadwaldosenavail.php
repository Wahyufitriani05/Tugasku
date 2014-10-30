<?php
class mjadwaldosenavail extends Model 
{

    function mjadwaldosenavail() 
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
        $this->db->insert("jadwal_availability", $data);
    }
    
    function update($data, $options) 
    {
        $this->db->update("jadwal_availability", $data, $options);
    }

    function reset($id_jdw_avail) 
    {
        $this->db->update("jadwal_availability", array('STATUS' => 0), array('ID_JDW_AVAIL' => $id_jdw_avail));
    }

    function resetPerSlotHari($id_sidangTA, $parent_treeid) 
    {
        $sql = "UPDATE jadwal_availability SET STATUS='0' WHERE SIDANGTA='$id_sidangTA' AND ID_SLOT LIKE '$parent_treeid%'";
        $this->db->query($sql);
    }

    function hapusPerSlotHari($id_sidangTA, $parent_treeid) 
    {
        $this->db->where('SIDANGTA', $id_sidangTA);
        $this->db->like('ID_SLOT', $parent_treeid, 'after');  // TREEID like '$parent_id%'
        $this->db->where('STATUS', 0);
        $this->db->delete("jadwal_availability");
    }
    
    function hapusPerSlotHariDosen($id_sidangTA, $parent_treeid, $NIP)
    {
        $this->db->where('SIDANGTA', $id_sidangTA);
        $this->db->like('ID_SLOT', $parent_treeid, 'after');  // TREEID like '$parent_id%'
        $this->db->where('STATUS', 0);
        $this->db->where('NIP', $NIP);
        $this->db->delete("jadwal_availability");
    }
    
    function hapusPerSlotWaktu($id_sidangTA, $treeid) 
    {
        $this->db->where('SIDANGTA', $id_sidangTA);
        $this->db->like('ID_SLOT', $treeid);  // TREEID like '$treeid'
        $this->db->where('STATUS', 0);
        $this->db->delete("jadwal_availability");
    }
    
    function detail($options="") 
    {
        $this->db->select("*");
        $this->db->from("jadwal_availability");
        if(is_array($options))
            $this->db->where($options);
        else
            $this->db->where('ID_JDW_AVAIL', $options);
        $query = $this->db->get();
        return $query->row();
    }
    
    function field($field="", $options="") 
    {
        $this->db->select("$field");
        $this->db->from("jadwal_availability");
        $this->db->where($options);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row()->$field;
        else
            return '-';
    }

    function cek($options='', $dialog='') 
    {
        $hasil = null;
        $this->db->select("ID_JDW_AVAIL");
        $this->db->from("jadwal_availability");
        if(is_array($options))
            $this->db->where($options);
        else
            $this->db->where("ID_JDW_AVAIL", $this->db->escape_like_str($options));
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
                $this->lib_alert->warning("Jadwal dosen tidak ditemukan");
                redirect("error/index/".$dialog);
            }
        }
    } 

    function listAvailableDosen($id_sidangTA, $id_proposal, $treeid, $id_kbk) 
    {
        $mjadwalmahasiswa = $this->model_load_model('mjadwalmahasiswa');
        $dosenTerpakai = $mjadwalmahasiswa->detail(array("ID_PROPOSAL" => $id_proposal, "SIDANGTA" => $id_sidangTA));
        $listDosenTerpakai = array("$dosenTerpakai->NIP1","$dosenTerpakai->NIP2","$dosenTerpakai->NIP3","$dosenTerpakai->NIP4");
        $this->db->select("jadwal_availability.*, dosen.NAMA_DOSEN");
        $this->db->from("jadwal_availability");
        $this->db->from("kbk_dosen");
        $this->db->from("dosen");
        $this->db->where("jadwal_availability.NIP = kbk_dosen.NIP");
        $this->db->where("jadwal_availability.NIP = dosen.NIP");
        $this->db->where("jadwal_availability.SIDANGTA", $id_sidangTA);
        $this->db->where("jadwal_availability.ID_SLOT", $treeid);
        $this->db->where("kbk_dosen.ID_KBK", $id_kbk);
        $this->db->where_not_in("jadwal_availability.NIP", $listDosenTerpakai);
        $this->db->order_by("kbk_dosen.ID_KBK", "ASC");
        $query = $this->db->get();
        return $query->result();
    }
    
    function slotPembimbing($id_sidangTA, $nip1, $nip2, $p2boleh) 
    {
        if ($p2boleh=='0') 
        {
            $sql = "
                select * from
                (
                    select A1.NIP as NIP1,A2.NIP as NIP2,A1.ID_SLOT as ID_SLOT1,A2.ID_SLOT as ID_SLOT2,A1.ID_JDW_AVAIL as ID_JDW_AVAIL1, A2.ID_JDW_AVAIL as ID_JDW_AVAIL2 from
                    (
                        select * from jadwal_availability where SIDANGTA='$id_sidangTA' and NIP='$nip1' and STATUS='0'
                    ) as A1,
                    (
                        select * from jadwal_availability where SIDANGTA='$id_sidangTA' and NIP='$nip2' and STATUS='0'
                    ) as A2
                    where A1.ID_SLOT=A2.ID_SLOT
                    UNION ALL
                    select A1.NIP as NIP1,'',A1.ID_SLOT,'',A1.ID_JDW_AVAIL as ID_JDW_AVAIL1,'' from jadwal_availability as A1 where SIDANGTA='$id_sidangTA' and NIP='$nip1' and STATUS='0'
                ) as X1
            ";
        }
        if ($p2boleh=='1') 
        {
            $sql = "
                select * from
                (
                    select A1.NIP as NIP1,A2.NIP as NIP2,A1.ID_SLOT as ID_SLOT1,A2.ID_SLOT as ID_SLOT2,A1.ID_JDW_AVAIL as ID_JDW_AVAIL1, A2.ID_JDW_AVAIL as ID_JDW_AVAIL2 from
                    (
                        select * from jadwal_availability where SIDANGTA='$id_sidangTA' and NIP='$nip1' and STATUS='0'
                    ) as A1,
                    (
                        select * from jadwal_availability where SIDANGTA='$id_sidangTA' and NIP='$nip2' and STATUS='0'
                    ) as A2
                    where A1.ID_SLOT=A2.ID_SLOT
                    UNION ALL
                    select A1.NIP as NIP1,'',A1.ID_SLOT,'',A1.ID_JDW_AVAIL as ID_JDW_AVAIL1,'' from jadwal_availability as A1 where SIDANGTA='$id_sidangTA' and NIP='$nip1' and STATUS='0'
                    UNION ALL
                    select '',A1.NIP as NIP1,'',A1.ID_SLOT,'',A1.ID_JDW_AVAIL as ID_JDW_AVAIL1 from jadwal_availability as A1 where SIDANGTA='$id_sidangTA' and NIP='$nip2'and STATUS='0'
                ) as X1
            ";
        }
        $query = $this->db->query($sql);
        return $query->row();
    }

    function countSlotAvailPembimbing1($id_sidangTA,$treeid,$id_kbk,$nip1) {
        $sql="
            select count(*) as JUM
            from jadwal_availability J,kbk_dosen K
            where K.NIP=J.NIP and
            J.NIP='" . $nip1 ."' and
            STATUS='2' and
            ID_KBK='$id_kbk' and
            SIDANGTA='$id_sidangTA' and
            substring(ID_SLOT,1,4)='" . substr($treeid,0,4)."'
        ";
        $query = $this->db->query($sql);
        return $query->row()->JUM;
    }
    
    function createTablePengujiAvailTemp($id_sidangTA, $treeid, $id_kbk, $nip1, $nip2) 
    {
        $this->db->query("drop table if exists penguji_avail_temp1");
        $this->db->query("drop table if exists penguji_avail_temp2");
        if (($nip2=='')||($nip2=='-')) 
            $tbh=" J.NIP<>'".$nip1."'";
        else 
            $tbh=" (J.NIP<>'".$nip1."' and J.NIP<>'".$nip2."')";
        $sql = "
            create temporary table penguji_avail_temp1
            select J.*,K.ID_KBK,0 as JUM
            from jadwal_availability J,kbk_dosen K,dosen P
            where J.SIDANGTA='$id_sidangTA'
            and  J.STATUS='0'
            and SIDANGTA='$id_sidangTA'
            and ID_SLOT='$treeid'
            and ID_KBK='$id_kbk'
            and P.NIP=K.NIP
            and K.NIP=J.NIP
            and $tbh
            order by P.SENIOR desc,NIP asc
        ";
        $this->db->query($sql);
    }

    function createTablePengujiAvailTemp2($id_sidangTA, $treeid, $id_kbk, $nip1, $nip2, $nipx) 
    {
        if (($nip2=='')||($nip2=='-')) 
            $tbh=" (J.NIP<>'".$nip1 ."' and J.NIP<>'".$nipx."')";
        else 
            $tbh=" (J.NIP<>'".$nip1 ."' and J.NIP<>'".$nip2 ."' and J.NIP<>'".$nipx."')";
        $sq2 = "
            create temporary table penguji_avail_temp2
            select J.*,K.ID_KBK,0 as JUM
            from jadwal_availability J,kbk_dosen K,dosen P
            where J.SIDANGTA='$id_sidangTA' and
            J.STATUS='0' and
            SIDANGTA='$id_sidangTA' and
            ID_SLOT='$treeid' and
            ID_KBK='$id_kbk' and 
            P.NIP=K.NIP and
            K.NIP=J.NIP and
            $tbh
            order by NIP desc
        ";
        $this->db->query($sq2);
    }

    function tablePengujiAvailTemp1() 
    {
        $sql="select * from penguji_avail_temp1 order by JUM asc";
        $query = $this->db->query($sql);
        return $query->row();
    }
    
    function tablePengujiAvailTemp2() 
    {
        $sql="select * from penguji_avail_temp2 order by JUM asc limit 5";
        $query = $this->db->query($sql);
        return $query->row();
    }
    
    function countTablePengujiAvailTemp1() 
    {
        $sql="select * from penguji_avail_temp1 order by JUM asc";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

}
?>
