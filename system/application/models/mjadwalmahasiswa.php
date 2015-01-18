<?php
class mjadwalmahasiswa extends Model 
{
    
    function mjadwalmahasiswa() 
    {
        parent::Model();   
        $this->load->database();
    }

    function update_jadwal_mhs($id_jdw_mhs, $revisi, $tipe)
    {
        if($tipe==1)
        {
            $sql = "
                UPDATE jadwal_mhs SET revisi1 = '".$revisi."' WHERE id_jdw_mhs = ".$id_jdw_mhs."";
        }
        else
        {
             $sql = "
                UPDATE jadwal_mhs SET revisi2 = '".$revisi."' WHERE id_jdw_mhs = ".$id_jdw_mhs."";
        }
        $query = $this->db->query($sql);
    }
    
    function model_load_model($model_name) 
    {
        $CI =& get_instance();
        $CI->load->model($model_name);
        return $CI->$model_name;
    }

    function statusSidang($id_jdw_mhs, $id_sidangTA) 
    {
        $data_jdw_mhs = $this->detail($id_jdw_mhs);
        if ($data_jdw_mhs->UP_NIP1!="")
            $status = '1';
        else 
            $status = '2';
        if($data_jdw_mhs->NIP3!="") 
        {
            if($data_jdw_mhs->NIP4!="") 
                $status = '3';
            else
                $status = '4';
        }
        else 
        {
            $status = '5';
        }
        if($data_jdw_mhs->ID_JDW_RUANG!="" && $data_jdw_mhs->ID_JDW_RUANG!='0' && $data_jdw_mhs->ID_JDW_RUANG_AVAIL!="" && $data_jdw_mhs->ID_JDW_RUANG_AVAIL!="0") 
            $status = '6';
        else 
            $status = '7';
        return $status;
    }
    
    function field($field="", $options) 
    {
        $this->db->select("jadwal_mhs.$field");
        $this->db->from("jadwal_mhs");
         if(is_array($options))
            $this->db->where($options);
        else
            $this->db->where('ID_JDW_MHS', $options);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row()->$field;
        else
            return '-';
    }
    
    function listProposalMajuSidang($id_sidangTA, $id_kbk="-1") 
    {
        $this->db->select("
                proposal.*,
                kbk.NAMA_KBK,
                ds1.INISIAL_DOSEN as INISIAL_PEMBIMBING1, ds1.NAMA_LENGKAP_DOSEN as NAMA_PEMBIMBING1,ds1.NIP2010 as NIP2010_PEMBIMBING1,
                ds2.INISIAL_DOSEN as INISIAL_PEMBIMBING2, ds2.NAMA_LENGKAP_DOSEN as NAMA_PEMBIMBING2,ds2.NIP2010 as NIP2010_PEMBIMBING2,
                mahasiswa.NRP, mahasiswa.NAMA_LENGKAP_MAHASISWA
            ");
        $this->db->from("proposal");
        $this->db->from("kbk");
        $this->db->from("dosen ds1");
        $this->db->from("dosen ds2");
        $this->db->from("mahasiswa");
        $this->db->where("proposal.NRP = mahasiswa.NRP");
        $this->db->where("proposal.PEMBIMBING1 = ds1.NIP");
        $this->db->where("proposal.PEMBIMBING2 = ds2.NIP");
        $this->db->where("proposal.ID_KBK = kbk.ID_KBK");
        $this->db->where("proposal.STATUS", 3);
        $this->db->where("STA", $id_sidangTA);
        if($id_kbk != "-1")
            $this->db->where("proposal.ID_KBK", $id_kbk);
        $this->db->order_by("ID_KBK","ASC");
        $this->db->order_by("proposal.PEMBIMBING1","ASC");
        $this->db->order_by("proposal.PEMBIMBING2","ASC");
        $query = $this->db->get();
        $prop = $query->result();
        //echo $this->db->last_query();

        return $prop;
    }

    function listProposalMajuSidang2($id_sidangTA, $id_kbk="-1", $nip="-1", $id_proposal = NULL) 
    {
        $query="SET lc_time_names = 'id_ID'"; // set indonesian        
        $this->db->query($query);
        $sql2 = " SELECT jadwal_mhs.*, jadwal_ruangan.DESKRIPSI, ds1.NIP2010 as NIP2010_PENGUJI1, ds1.INISIAL_DOSEN as INISIAL_PENGUJI1, ds1.NAMA_LENGKAP_DOSEN as PENGUJI1, ds2.NIP2010 as NIP2010_PENGUJI2, ds2.INISIAL_DOSEN as INISIAL_PENGUJI2, ds2.NAMA_LENGKAP_DOSEN as PENGUJI2, concat(jsh.DESKRIPSI, ' ', jsw.DESKRIPSI) as WAKTU, jsw.DESKRIPSI as JAMTEPAT, DATE_FORMAT(jsh.TGL, '%W, %e %M %Y') as WAKTU_SIDANG, jsw.TGL, jsw.WAKTU as JAM, concat(DATE_FORMAT(jsh.TGL, '%W, %e %M %Y'), ' Pukul ', TIME_FORMAT(jsw.WAKTU, '%H:%m'),'-',TIME_FORMAT(ADDTIME(jsw.WAKTU, '0 1:0:0'), '%H:%m')) as WAKTUHARI 
              FROM (jadwal_mhs, jadwal_ruangan, dosen ds1, dosen ds2, jadwal_slot jsw, jadwal_slot jsh) 
              WHERE `jadwal_mhs`.`ID_JDW_RUANG` = jadwal_ruangan.ID_JDW_RUANG 
              AND `jadwal_mhs`.`NIP3` = ds1.NIP 
              AND `jadwal_mhs`.`NIP4` = ds2.NIP 
              AND `jadwal_mhs`.`SIDANGTA` = jsw.SIDANGTA 
              AND `jadwal_mhs`.`ID_SLOT` = jsw.TREEID 
              AND `jadwal_mhs`.`SIDANGTA` = jsh.SIDANGTA 
              AND substr(jadwal_mhs.ID_SLOT,1,4) = jsh.TREEID 
              AND `jadwal_mhs`.`SIDANGTA` = jsw.SIDANGTA 
              AND `jadwal_mhs`.`ID_SLOT` = jsw.TREEID";
        if ($id_proposal) {
          $sql2 .= " AND `jadwal_mhs`.`ID_PROPOSAL` = '$id_proposal'";
        }
        $sql2 .= " ORDER BY ID_KBK ASC, TGL DESC, JAM ASC";
        $sql = "
            select q.*, r.* from (
              SELECT `proposal`.*, `kbk`.`NAMA_KBK`, `ds1`.`INISIAL_DOSEN` as INISIAL_PEMBIMBING1, `ds1`.`NAMA_LENGKAP_DOSEN` as NAMA_PEMBIMBING1, `ds1`.`NIP2010` as NIP2010_PEMBIMBING1, `ds2`.`INISIAL_DOSEN` as INISIAL_PEMBIMBING2, `ds2`.`NAMA_LENGKAP_DOSEN` as NAMA_PEMBIMBING2, `ds2`.`NIP2010` as NIP2010_PEMBIMBING2, `mahasiswa`.`NAMA_LENGKAP_MAHASISWA` 
              FROM (`proposal`, `kbk`, `dosen` ds1, `dosen` ds2, `mahasiswa`) 
              WHERE `proposal`.`NRP` = mahasiswa.NRP 
              AND `proposal`.`PEMBIMBING1` = ds1.NIP 
              AND `proposal`.`PEMBIMBING2` = ds2.NIP 
              AND `proposal`.`ID_KBK` = kbk.ID_KBK 
              AND `proposal`.`STATUS` = 3
              AND `STA` = '$id_sidangTA' 
              ORDER BY `ID_KBK` ASC, `proposal`.`PEMBIMBING1` ASC, `proposal`.`PEMBIMBING2` ASC
            )q left join
            (
              ".$sql2."
            )r on q.id_proposal=r.id_proposal 
            WHERE r.SHOW_ME = 1 ";
        if($id_kbk != "-1") {
            $sql .= "AND q.ID_KBK = $id_kbk ";
        }
        if($nip != "-1") {
            $sql .= "AND (r.NIP1 = $nip OR r.NIP2 = $nip OR r.NIP3 = $nip OR r.NIP4 = $nip)";
        }
        $sql .= "order by r.tgl asc, r.jam asc, r.deskripsi asc";
         $query = $this->db->query($sql);
        return $query->result();
    }
	
    function listProposalMajuSidang2UntukBeritaAcara($id_sidangTA, $id_kbk="-1", $nip="-1", $id_proposal)
    {
	    //setting local time language
        $query="SET lc_time_names = 'id_ID'"; // set indonesian
        $this->db->query($query);
		
        $sql = "
            select q.*, r.* from (
              SELECT `proposal`.*, `kbk`.`NAMA_KBK`, `ds1`.`INISIAL_DOSEN` as INISIAL_PEMBIMBING1, `ds1`.`NAMA_LENGKAP_DOSEN` as NAMA_PEMBIMBING1, `ds1`.`NIP2010` as NIP2010_PEMBIMBING1, `ds2`.`INISIAL_DOSEN` as INISIAL_PEMBIMBING2, `ds2`.`NAMA_LENGKAP_DOSEN` as NAMA_PEMBIMBING2, `ds2`.`NIP2010` as NIP2010_PEMBIMBING2, `mahasiswa`.`NAMA_LENGKAP_MAHASISWA` 
              FROM (`proposal`, `kbk`, `dosen` ds1, `dosen` ds2, `mahasiswa`) 
              WHERE `proposal`.`NRP` = mahasiswa.NRP
			  AND `proposal`.id_proposal=".$id_proposal." 
              AND `proposal`.`PEMBIMBING1` = ds1.NIP 
              AND `proposal`.`PEMBIMBING2` = ds2.NIP 
              AND `proposal`.`ID_KBK` = kbk.ID_KBK 
              AND `proposal`.`STATUS` = 3 
              AND `STA` = '$id_sidangTA' 
              ORDER BY `ID_KBK` ASC, `proposal`.`PEMBIMBING1` ASC, `proposal`.`PEMBIMBING2` ASC
            )q left join
            (
              SELECT jadwal_mhs.*, jadwal_ruangan.DESKRIPSI, ds1.NIP2010 as NIP2010_PENGUJI1, ds1.INISIAL_DOSEN as INISIAL_PENGUJI1, ds1.NAMA_LENGKAP_DOSEN as PENGUJI1, ds2.NIP2010 as NIP2010_PENGUJI2, ds2.INISIAL_DOSEN as INISIAL_PENGUJI2, ds2.NAMA_LENGKAP_DOSEN as PENGUJI2, concat(DATE_FORMAT(jsh.TGL, '%W, %e %M %Y'), ' Pukul ', TIME_FORMAT(jsw.WAKTU, '%H:%m'),'-',TIME_FORMAT(ADDTIME(jsw.WAKTU, '0 1:0:0'), '%H:%m')) as WAKTU, concat(TIME_FORMAT(jsw.WAKTU, '%H:%m'),'-',TIME_FORMAT(ADDTIME(jsw.WAKTU, '0 1:0:0'), '%H:%m'))as jam_sidang, DATE_FORMAT(jsh.TGL, '%e %M %Y')TGL, jsw.WAKTU as JAM
              FROM (jadwal_mhs, jadwal_ruangan, dosen ds1, dosen ds2, jadwal_slot jsw, jadwal_slot jsh) 
              WHERE `jadwal_mhs`.`ID_JDW_RUANG` = jadwal_ruangan.ID_JDW_RUANG 
              AND `jadwal_mhs`.`NIP3` = ds1.NIP 
              AND `jadwal_mhs`.`NIP4` = ds2.NIP 
              AND `jadwal_mhs`.`SIDANGTA` = jsw.SIDANGTA 
              AND `jadwal_mhs`.`ID_SLOT` = jsw.TREEID 
              AND `jadwal_mhs`.`SIDANGTA` = jsh.SIDANGTA 
              AND substr(jadwal_mhs.ID_SLOT,1,4) = jsh.TREEID 
              AND `jadwal_mhs`.`SIDANGTA` = jsw.SIDANGTA 
              AND `jadwal_mhs`.`ID_SLOT` = jsw.TREEID 
              ORDER BY ID_KBK ASC, TGL DESC, JAM ASC
            )r on q.id_proposal=r.id_proposal 
            WHERE r.SHOW_ME = 1 ";
        if($id_kbk != "-1") {
            $sql .= "AND q.ID_KBK = $id_kbk ";
        }
        if($nip != "-1") {
            $sql .= "AND (r.NIP1 = $nip OR r.NIP2 = $nip OR r.NIP3 = $nip OR r.NIP4 = $nip)";
        }
        $sql .= "order by r.deskripsi asc,r.tgl asc, r.jam asc";
         $query = $this->db->query($sql);
        return $query->result();
    }
    
    function listProposalMajuSidang2ShowAll($id_sidangTA, $id_kbk="-1", $nip="-1") 
    {
      $tambahan = NULL;

      if ($id_kbk != "-1") {

        $tambahan = " AND `proposal`.`ID_KBK` = " . $id_kbk . " ";

      }
      
        $sql = "

            select q.ID_KBK as ID_KBK_ASLI, q.ID_PROPOSAL as ID_PROPOSAL_ASLI, q.*, r.* from (
              SELECT `proposal`.*, `kbk`.`NAMA_KBK`, `ds1`.`INISIAL_DOSEN` as INISIAL_PEMBIMBING1, `ds1`.`NAMA_LENGKAP_DOSEN` as NAMA_PEMBIMBING1, `ds1`.`NIP2010` as NIP2010_PEMBIMBING1, `ds2`.`INISIAL_DOSEN` as INISIAL_PEMBIMBING2, `ds2`.`NAMA_LENGKAP_DOSEN` as NAMA_PEMBIMBING2, `ds2`.`NIP2010` as NIP2010_PEMBIMBING2, `mahasiswa`.`NAMA_LENGKAP_MAHASISWA` 
              FROM (`proposal`, `kbk`, `dosen` ds1, `dosen` ds2, `mahasiswa`) 
              WHERE `proposal`.`NRP` = mahasiswa.NRP 
              AND `proposal`.`PEMBIMBING1` = ds1.NIP 
              AND `proposal`.`PEMBIMBING2` = ds2.NIP 
              AND `proposal`.`ID_KBK` = kbk.ID_KBK 
              AND `proposal`.`STATUS` = 3
              $tambahan
              AND `STA` = '$id_sidangTA' 
              ORDER BY `ID_KBK` ASC, `proposal`.`PEMBIMBING1` ASC, `proposal`.`PEMBIMBING2` ASC
            )q left join
            (
              SELECT jadwal_mhs.*, jadwal_ruangan.DESKRIPSI, ds1.NIP as NIP_PENGUJI1, ds1.NIP2010 as NIP2010_PENGUJI1, ds1.INISIAL_DOSEN as INISIAL_PENGUJI1, ds1.NAMA_LENGKAP_DOSEN as PENGUJI1, ds2.NIP as NIP_PENGUJI2, ds2.NIP2010 as NIP2010_PENGUJI2, ds2.INISIAL_DOSEN as INISIAL_PENGUJI2, ds2.NAMA_LENGKAP_DOSEN as PENGUJI2, concat(jsh.DESKRIPSI, ' ', jsw.DESKRIPSI) as WAKTU, jsw.TGL, jsw.WAKTU as JAM, concat(DATE_FORMAT(jsh.TGL, '%W, %e %M %Y'), ' Pukul ', TIME_FORMAT(jsw.WAKTU, '%H:%m'),'-',TIME_FORMAT(ADDTIME(jsw.WAKTU, '0 1:0:0'), '%H:%m')) as WAKTUHARI
              FROM (jadwal_mhs, jadwal_ruangan, dosen ds1, dosen ds2, jadwal_slot jsw, jadwal_slot jsh) 
              WHERE `jadwal_mhs`.`ID_JDW_RUANG` = jadwal_ruangan.ID_JDW_RUANG 
              AND `jadwal_mhs`.`NIP3` = ds1.NIP 
              AND `jadwal_mhs`.`NIP4` = ds2.NIP 
              AND `jadwal_mhs`.`SIDANGTA` = jsw.SIDANGTA 
              AND `jadwal_mhs`.`ID_SLOT` = jsw.TREEID 
              AND `jadwal_mhs`.`SIDANGTA` = jsh.SIDANGTA 
              AND substr(jadwal_mhs.ID_SLOT,1,4) = jsh.TREEID 
              AND `jadwal_mhs`.`SIDANGTA` = jsw.SIDANGTA 
              AND `jadwal_mhs`.`ID_SLOT` = jsw.TREEID 
              ORDER BY ID_KBK ASC, TGL DESC, JAM ASC
            )r on q.id_proposal=r.id_proposal 
            order by r.tgl asc, r.jam asc, r.deskripsi asc
        ";
         $query = $this->db->query($sql);
        return $query->result();
    }

    function listProposalBelumMajuSidang($id_kbk) 
    {
        $sql = "
            SELECT *
            FROM (
                SELECT (TO_DAYS(NOW()) - TO_DAYS(p.TGL_SIDANG_PROP)) /30 AS lama, p.* , k.NAMA_KBK , 
                    d.INISIAL_DOSEN AS INISIAL_PEMBIMBING1, d.NAMA_LENGKAP_DOSEN AS NAMA_PEMBIMBING1, d.NIP2010 AS NIP2010_PEMBIMBING1, 
                    d2.INISIAL_DOSEN AS INISIAL_PEMBIMBING2, d2.NAMA_LENGKAP_DOSEN AS NAMA_PEMBIMBING2, d2.NIP2010 AS NIP2010_PEMBIMBING2, 
                    m.NAMA_LENGKAP_MAHASISWA
                FROM proposal p, kbk k, dosen d, dosen d2, mahasiswa m
                WHERE p.NRP=m.NRP
                AND p.PEMBIMBING1=d.NIP
                AND p.PEMBIMBING2=d2.NIP
                AND p.ID_KBK=k.ID_KBK
                AND p.STATUS NOT IN (0,1,11,2,31,32)
                AND k.ID_KBK=$id_kbk
                ORDER BY p.ID_KBK ASC , p.PEMBIMBING1 ASC , p.PEMBIMBING2 ASC
            )q1
        "; //WHERE q1.lama < 30
        $query = $this->db->query($sql);
        $prop = $query->result();

        return $prop;
    }

    function listProposalBelumMajuSidangNew($id_kbk) 
    {
        
        $sql = "
            SELECT q1.*, ifnull(count( p.id_proposal ),0) AS BIMBINGAN
            FROM (
                SELECT (TO_DAYS(NOW()) - TO_DAYS(p.TGL_SIDANG_PROP)) /30 AS lama, p.* , k.NAMA_KBK , 
                    d.INISIAL_DOSEN AS INISIAL_PEMBIMBING1, d.NAMA_LENGKAP_DOSEN AS NAMA_PEMBIMBING1, d.NIP2010 AS NIP2010_PEMBIMBING1, 
                    d2.INISIAL_DOSEN AS INISIAL_PEMBIMBING2, d2.NAMA_LENGKAP_DOSEN AS NAMA_PEMBIMBING2, d2.NIP2010 AS NIP2010_PEMBIMBING2, 
                    m.NAMA_LENGKAP_MAHASISWA
                FROM proposal p, kbk k, dosen d, dosen d2, mahasiswa m
                WHERE p.NRP=m.NRP
                AND p.PEMBIMBING1=d.NIP
                AND p.PEMBIMBING2=d2.NIP
                AND p.ID_KBK=k.ID_KBK
                AND p.STATUS NOT IN (0,1,11,2,31,32) ";
        if($id_kbk!=-1)
                $sql .= " AND k.ID_KBK=$id_kbk ";
        $sql .= "ORDER BY p.ID_KBK ASC , p.PEMBIMBING1 ASC , p.PEMBIMBING2 ASC
            )q1 left outer join progress_ta p
                on p.id_proposal = q1.id_proposal
                GROUP BY id_proposal
        "; //WHERE q1.lama < 30
        $query = $this->db->query($sql);
        $prop = $query->result();

        return $prop;
    }
    
    function jadwalSidangTA($publish=1, $id_proposal, $id_sidangTA, $status_jadwal="", $nip="-1") 
    {
        $this->db->select("jadwal_mhs.*, jadwal_ruangan.DESKRIPSI, 
            ds1.NIP2010 as NIP2010_PENGUJI1, ds1.INISIAL_DOSEN as INISIAL_PENGUJI1, ds1.NAMA_LENGKAP_DOSEN as PENGUJI1,
            ds2.NIP2010 as NIP2010_PENGUJI2, ds2.INISIAL_DOSEN as INISIAL_PENGUJI2, ds2.NAMA_LENGKAP_DOSEN as PENGUJI2,
            concat(jsh.DESKRIPSI,' ',jsw.DESKRIPSI) as WAKTU, jsw.TGL, jsw.WAKTU as JAM", FALSE);
        $this->db->from("jadwal_mhs");
        $this->db->from("jadwal_ruangan");
        $this->db->from("dosen ds1");
        $this->db->from("dosen ds2");
        $this->db->from("jadwal_slot jsw");
        $this->db->from("jadwal_slot jsh");
        $this->db->where("jadwal_mhs.ID_JDW_RUANG = jadwal_ruangan.ID_JDW_RUANG");
        $this->db->where("jadwal_mhs.NIP3 = ds1.NIP");
        $this->db->where("jadwal_mhs.NIP4 = ds2.NIP");
        $this->db->where("jadwal_mhs.SIDANGTA = jsw.SIDANGTA");
        $this->db->where("jadwal_mhs.ID_SLOT = jsw.TREEID");
        $this->db->where("jadwal_mhs.SIDANGTA = jsh.SIDANGTA");
        $this->db->where("substr(jadwal_mhs.ID_SLOT,1,4) = jsh.TREEID");
        $this->db->where("jadwal_mhs.SIDANGTA = jsw.SIDANGTA");
        $this->db->where("jadwal_mhs.ID_SLOT = jsw.TREEID");
        $this->db->where("jadwal_mhs.ID_PROPOSAL", $id_proposal);
        $this->db->where("jadwal_mhs.SIDANGTA", $id_sidangTA);
        if($publish == 1) {
            $this->db->where("jadwal_mhs.SHOW_ME", $publish);
        }
        if(! empty ($status_jadwal)) {
            $this->db->where("jadwal_mhs.STATUS", $status_jadwal);
        }
        if($nip != "-1") {
            $where = "(NIP1 = '$nip' OR NIP2 = '$nip' OR NIP3 = '$nip' OR NIP4 = '$nip')";
            $this->db->where($where);
        }
        $this->db->order_by("ID_KBK", "ASC");
        $this->db->order_by("TGL", "DESC");
        $this->db->order_by("JAM", "ASC");
        $query = $this->db->get();
        $result = $query->row();
        if($query->num_rows()>0) {
            switch ($result->STATUS) {
                case 6:
                    $result->NAMA_STATUS = 'OK'; // tambahkam data NAMA_STATUS
                    break;
                case 7:
                    $result->NAMA_STATUS = 'Tidak Ada Ruangan';
                    break;
                case 4:
                    $result->NAMA_STATUS = 'Hanya Ada 1 Penguji';
                    break;
                case 5:
                    $result->NAMA_STATUS = 'Tidak Ada Slot Penguji (2)';
                    break;
                case 2:
                    $result->NAMA_STATUS = 'Tidak Ada Slot Pembimbing';
                    break;
                default:
                    $result->NAMA_STATUS = 'Bermasalah';
                    break;
            }
        }
        return $result;
    }

    function detail($options) 
    {
        $this->db->select("*");
        $this->db->from("jadwal_mhs");
        if(is_array($options)) 
        {
            $this->db->where($options);
            $this->db->limit(1);
        }
        else 
        {
            $this->db->where("ID_JDW_MHS", $options);
        }
        $query = $this->db->get();
        return $query->row();
    }

    function update($data, $options) 
    {
        if(is_array($options))
            $this->db->update("jadwal_mhs", $data, $options);
        else
            $this->db->update("jadwal_mhs", $data, array('ID_JDW_MHS' => $options));
    }

    function add($data) 
    {
        $this->db->insert("jadwal_mhs", $data);
    }

    function backup($id_jdw_mhs) 
    {
        $sql = "insert into jadwal_mhs_lama select * from jadwal_mhs where ID_JDW_MHS='$id_jdw_mhs'";
        $this->db->query($sql);
    }

    function hapus($id_jdw_mhs) 
    {
        $this->db->where('ID_JDW_MHS', $id_jdw_mhs);
        $this->db->delete("jadwal_mhs");
    }

    function listNotAssignedDosen($id_sidangTA, $id_proposal, $id_kbk) 
    {
        $dosenTerpakai = $this->detail(array("ID_PROPOSAL" => $id_proposal, "SIDANGTA" => $id_sidangTA));
        $sql = "
            select D.NIP,D.INISIAL_DOSEN, D.NAMA_DOSEN from dosen D, kbk_dosen KD
            where D.NIP = KD.NIP and KD.ID_KBK='$id_kbk' and (D.NIP<>'00000' and D.NIP<>'$dosenTerpakai->NIP1' and D.NIP<>'$dosenTerpakai->NIP2' and D.NIP<>'$dosenTerpakai->NIP3' and D.NIP<>'$dosenTerpakai->NIP4')
            and D.NIP not in (
                select NIP1 as nip from (
                    select  distinct NIP1 from jadwal_mhs
                    union
                    select distinct NIP2 from jadwal_mhs
                    union
                    select distinct NIP3 from jadwal_mhs
                    union
                    select distinct NIP4 from jadwal_mhs
                ) as X1 where NIP1<>'' order by NIP
            )
        ";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    function getJadwalMahasiswa($ID_JDW_MHS) 
    {
        
        $sql = "select * from jadwal_mhs where ID_JDW_MHS = '$ID_JDW_MHS'";        
        $query = $this->db->query($sql);
        if($this->db->affected_rows() > 0)
        {
            foreach ($query->result() as $row) 
            {
                return $row;
            }
        }
        
    }
    
    function listAvailableJadwal($id_sidangTA, $treeid, $id_kbk) 
    {
        $sql = "SELECT JRA.*, JR.DESKRIPSI, K.NAMA_KBK
                FROM jadwal_ruangan_avail JRA, jadwal_ruangan JR, kbk K
                WHERE JRA.ID_JDW_RUANG = JR.ID_JDW_RUANG
                AND JRA.ID_KBK = K.ID_KBK
                AND JRA.SIDANGTA = '$id_sidangTA'
                AND JRA.ID_SLOT = '$treeid'
                AND JRA.STATUS = '0'
                AND JRA.ID_JDW_RUANG_AVAIL NOT
                IN (

                SELECT ID_JDW_RUANG_AVAIL
                FROM jadwal_mhs
                WHERE SIDANGTA = '$id_sidangTA'
                AND ID_KBK = '$id_kbk'
                )";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function listAvailableDosen($id_sidangTA, $treeid, $id_kbk) 
    {
        $sql = "SELECT JA.ID_SLOT, KD.NIP, JA.STATUS, D.INISIAL_DOSEN
                FROM jadwal_availability JA, kbk_dosen KD, dosen D
                WHERE KD.NIP = JA.NIP
                AND KD.NIP = D.NIP
                AND KD.ID_KBK = '$id_kbk'
                AND JA.SIDANGTA = '$id_sidangTA'
                AND JA.ID_SLOT = '$treeid'
                AND D.STATUS_DOSEN = 2 
                ORDER BY JA.ID_SLOT, KD.NIP";
        $query = $this->db->query($sql);
        return $query->result();
    }

    /*
    function listAvailableDosenPenguji($id_sidangTA, $treeid, $id_kbk, $nip1, $nip2) 
    {
        $sql = "SELECT JA.ID_JDW_AVAIL, JA.ID_SLOT, KD.NIP, JA.STATUS, D.INISIAL_DOSEN, D.NAMA_DOSEN
                FROM jadwal_availability JA, kbk_dosen KD, dosen D
                WHERE KD.NIP = JA.NIP
                AND KD.NIP = D.NIP
                AND KD.ID_KBK = '$id_kbk'
                AND JA.SIDANGTA = '$id_sidangTA'
                AND JA.ID_SLOT = '$treeid'
                AND JA.STATUS = '0'
                AND D.STATUS_DOSEN = 2 
                AND (
                KD.NIP <> '$nip1'
                AND KD.NIP <> '$nip2'
                )
                ORDER BY JA.ID_SLOT, KD.NIP";
        $query = $this->db->query($sql);
        return $query->result();
    }
     * 
     */
    
    
    
    function listAvailableDosenPenguji($id_sidangTA, $treeid, $id_kbk, $nip1, $nip2) 
    {
        $sql = "
                select d.*, ifnull(sum(sum.jumlah),0) as jumlahPenguji from (
                Select d.*, ifnull(sum(sum.jumlah),0) as jumlahBimbingan from       
                (SELECT JA.ID_JDW_AVAIL, JA.ID_SLOT, KD.NIP, JA.STATUS, D.INISIAL_DOSEN, D.NAMA_DOSEN
                FROM jadwal_availability JA, kbk_dosen KD, dosen D
                WHERE KD.NIP = JA.NIP
                AND KD.NIP = D.NIP
                AND KD.ID_KBK = '$id_kbk'
                AND JA.SIDANGTA = '$id_sidangTA'
                AND JA.ID_SLOT = '$treeid'
                AND JA.STATUS = '0'
                AND D.STATUS_DOSEN = 2 
                AND (
                KD.NIP <> '$nip1'
                AND KD.NIP <> '$nip2'
                )
                ORDER BY JA.ID_SLOT, KD.NIP) d left outer join (
                    SELECT NIP1, count(id_jdw_mhs) as jumlah FROM `jadwal_mhs` where sidangTA = $id_sidangTA group by NIP1 union
                    SELECT NIP2, count(id_jdw_mhs) as jumlah FROM `jadwal_mhs` where sidangTA = $id_sidangTA group by NIP2 ) sum
                    on sum.NIP1 = d.nip group by d.nip) d left outer join (
                    SELECT NIP3, count(id_jdw_mhs) as jumlah FROM `jadwal_mhs` where sidangTA = $id_sidangTA group by NIP3 union
                    SELECT NIP4, count(id_jdw_mhs) as jumlah FROM `jadwal_mhs` where sidangTA = $id_sidangTA group by NIP4 ) sum
                    on sum.NIP3 = d.nip group by d.nip";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    
    function listAvailableDosenNew($id_sidangTA, $treeid, $id_kbk) 
    {
        $sql = "SELECT JA.ID_JDW_AVAIL, JA.ID_SLOT, KD.NIP, JA.STATUS, D.INISIAL_DOSEN, D.NAMA_DOSEN
                FROM jadwal_availability JA, kbk_dosen KD, dosen D
                WHERE KD.NIP = JA.NIP
                AND KD.NIP = D.NIP
                AND KD.ID_KBK = '$id_kbk'
                AND JA.SIDANGTA = '$id_sidangTA'
                AND JA.ID_SLOT = '$treeid'
                AND JA.STATUS = '0'
                AND D.STATUS_DOSEN = 2                 
                ORDER BY JA.ID_SLOT, KD.NIP";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    function listAvailableDosenPembimbing($id_sidangTA, $id_proposal) 
    {
        $dosenTerpakai = $this->detail(array("ID_PROPOSAL" => $id_proposal, "SIDANGTA" => $id_sidangTA));
        $this->db->select("*");
        $this->db->from("dosen");
        if(! empty($dosenTerpakai))
            $this->db->where_not_in("NIP", array("$dosenTerpakai->NIP1","$dosenTerpakai->NIP2","$dosenTerpakai->NIP3","$dosenTerpakai->NIP4"));
        $this->db->not_like('NIP', '00000', 'after');
        $this->db->order_by('NIP', 'ASC');
        
        $this->db->where("STATUS_DOSEN",2);
        
        $query = $this->db->get();
        return $query->result();
    }

    function cekAvailabilityDosen($id_sidangTA, $treeid, $id_kbk, $nip1, $nip2) 
    {
        $sql = "SELECT JA.ID_JDW_AVAIL, JA.ID_SLOT, KD.NIP, JA.STATUS
                FROM jadwal_availability JA, kbk_dosen KD, dosen D
                WHERE KD.NIP = JA.NIP
                AND KD.ID_KBK = '$id_kbk'
                AND JA.SIDANGTA = '$id_sidangTA'
                AND JA.ID_SLOT = '$treeid'
                AND JA.STATUS = '0'
                AND KD.NIP = D.NIP AND JA.NIP = D.NIP AND D.STATUS_DOSEN!=0
                AND KD.NIP = '$nip1'";
                
                $sql.=" ORDER BY JA.ID_SLOT, JA.NIP";
         $query = $this->db->query($sql);
         if(count($query->result()) > 0)
             return TRUE;
         else
             return FALSE;
    }

    function idJadwalAvailDosen($id_sidangTA, $treeid, $id_kbk, $nip) 
    {
        $sql = "SELECT JA.ID_JDW_AVAIL, JA.ID_SLOT, KD.NIP, JA.STATUS
                FROM jadwal_availability JA, kbk_dosen KD
                WHERE KD.NIP = JA.NIP
                AND KD.ID_KBK = '$id_kbk'
                AND JA.SIDANGTA = '$id_sidangTA'
                AND JA.ID_SLOT = '$treeid'
                AND KD.NIP = '$nip'
                ORDER BY JA.ID_SLOT, KD.NIP
                LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->result();
        $id = "";
        foreach($result as $res) {
             $id = $res->ID_JDW_AVAIL;
        }
        return $id;
    }

    function idRuangan($id_jdw_ruang_avail, $id_slot) 
    {
        $sql="select ID_JDW_RUANG from jadwal_ruangan_avail where ID_JDW_RUANG_AVAIL='"  . $id_jdw_ruang_avail. "' and ID_SLOT='" . $id_slot ."'";
        $query = $this->db->query($sql);
        $hasil = $query->row();
        return $hasil->ID_JDW_RUANG;
    }

    function cekLembarPenilaian($id_proposal,$nip) {
      $this->db->select('ID_LEMBAR_PENILAIAN');
      $this->db->where('NIP_DOSEN',$nip);
      $this->db->from('lembar_penilaian');
      $this->db->where('ID_PROPOSAL',$id_proposal);
      $this->db->order_by('ID_LEMBAR_PENILAIAN', "desc");
      $this->db->limit(1);
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
        $id_lembar_penilaian = $query->row();
        return $id_lembar_penilaian->ID_LEMBAR_PENILAIAN;
      }
      else {
        return NULL;
      }
    }

    function insertLembarPenilaian($id_proposal,$nip_dosen,$nilai1,$nilai2,$nilai3,$nilai4) {
      $data = array(
        'ID_PROPOSAL' => $id_proposal,
        'NIP_DOSEN' => $nip_dosen,
        'UNSUR_1' => $nilai1,
        'UNSUR_2' => $nilai2,
        'UNSUR_3' => $nilai3,
        'UNSUR_4' => $nilai4
      );
      $this->db->insert('lembar_penilaian', $data); 
    }

    function updateLembarPenilaian($flag,$nilai1,$nilai2,$nilai3,$nilai4) {
      $data = array(
        'UNSUR_1' => $nilai1,
        'UNSUR_2' => $nilai2,
        'UNSUR_3' => $nilai3,
        'UNSUR_4' => $nilai4
      );
      $this->db->where('ID_LEMBAR_PENILAIAN', $flag);
      $this->db->update('lembar_penilaian', $data); 
    }

    function getLembarPenilaian($id_proposal,$nip) {
      $this->db->select('*');
      $this->db->where('ID_PROPOSAL',$id_proposal);
      $this->db->where('NIP_DOSEN',$nip);
      $this->db->from('lembar_penilaian');
      $this->db->order_by('ID_LEMBAR_PENILAIAN', "desc");
      $this->db->limit(1);
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
        return $query->row();
      }
      else {
        return NULL;
      }
    }

    function getTotalPenguji($rmk="")
    {      
        
      $sql = " SELECT d.nama_dosen as NAMA_DOSEN, d.nip as nip, ifnull(sum(summary.jumlah),0)as jumlah_penguji from 
          (select distinct d.nip, d.nama_dosen, d.status_dosen from dosen d, kbk_dosen kbk where ";
        
         if($rmk!='' && $rmk!='all')
            $sql .= " kbk.id_kbk = $rmk and ";
         
        $sql .= " kbk.nip = d.nip) d left outer join ";
        
        $sql  .= "(
                select nip3, count(nip3) as jumlah from jadwal_mhs ";
      if($rmk!='' && $rmk!='all')
                $sql.= " where jadwal_mhs.id_kbk = $rmk "; 
        
        $sql .= " group by nip3
                union
                select nip4, count(nip4) as jumlah from jadwal_mhs ";
        if($rmk!='' && $rmk!='all')
                $sql.= " where jadwal_mhs.id_kbk = $rmk "; 
        
        $sql .= " group by nip4
                ) summary  on summary.nip3 = d.NIP where d.status_dosen != 0 and d.nama_dosen  not like '%Admin%' and d.nama_dosen != '' and d.nama_dosen != '--' group by summary.nip3 order by d.nama_dosen asc ";
        
      $query = $this->db->query($sql);
      
      
      return $query->result_array();
    }

    function getTotalPengujiEmpty($rmk="")
    {
        $sql = "SELECT d.nama_dosen as NAMA_DOSEN, d.nip, 0 as jumlah_penguji from dosen d, kbk_dosen kbk where ";
        
         if($rmk!='' && $rmk!='all')
            $sql .= " kbk.id_kbk = $rmk and ";
         
        $sql .= " kbk.nip = d.nip";
        
        $sql .= " and d.status_dosen != 0 and d.nama_dosen not like '%Admin%' and d.nama_dosen != '' and d.nama_dosen != '--' order by d.nama_dosen asc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function getTotalPengujiByYear($year=null,$rmk="")
    {
      $year = is_null( $year) ? date('Y') : $year;
      $sql = "SELECT d.nama_dosen as NAMA_DOSEN, d.nip, ifnull(sum(summary.jumlah),0) as jumlah_penguji, summary.tahun from ";
      
      $sql .= "  (select distinct d.nip, d.nama_dosen, d.status_dosen from dosen d, kbk_dosen kbk where ";
        
         if($rmk!='' && $rmk!='all')
            $sql .= " kbk.id_kbk = $rmk and ";
         
        $sql .= " kbk.nip = d.nip) d left outer join ";
      
        $sql .= " (
                select nip3, count(nip3) as jumlah, year(p.tgl_sidang_ta_asli) as tahun from jadwal_mhs jm, proposal p where jm.id_proposal = p.id_proposal and year(p.tgl_sidang_ta_asli)='$year' ";
      if($rmk!='' && $rmk!='all')
                $sql.= " and p.id_kbk = $rmk "; 
      $sql .= " group by nip3
                union
                select nip4, count(nip4) as jumlah ,year(p.tgl_sidang_ta_asli) as tahun from jadwal_mhs jm, proposal p where jm.id_proposal = p.id_proposal and year(p.tgl_sidang_ta_asli)='$year' ";
      if($rmk!='' && $rmk!='all')
                $sql.= " and p.id_kbk = $rmk ";       
      $sql .= " group by nip4
                ) summary on summary.nip3 = d.nip where d.status_dosen != 0 and d.nama_dosen  not like '%Admin%' and d.nama_dosen != '' and d.nama_dosen != '--' group by summary.nip3 order by d.nama_dosen asc";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    function getTotalPengujiByName($nip=null)
    {
      $sql = "SELECT dosen.NAMA_DOSEN, summary.nip3 as nip, sum(summary.jumlah) as jumlah_penguji, summary.tahun from
                (
                select nip3, count(nip3) as jumlah, year(timestamp) as tahun from jadwal_mhs group by nip3, tahun
                union
                select nip4, count(nip4) as jumlah ,year(timestamp) as tahun from jadwal_mhs group by nip4, tahun
                ) summary left join dosen on summary.nip3 = dosen.NIP where dosen.NAMA_DOSEN != '' and summary.nip3 = '$nip' and summary.tahun != '0' group by summary.nip3, summary.tahun order by dosen.nama_dosen asc";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    function getYear()
    {
      $sql="SELECT distinct YEAR(timestamp) as tahun from jadwal_mhs where YEAR(timestamp) != '0000' order by YEAR(timestamp) desc limit 0,5";
      $query = $this->db->query($sql);
      return $query->result();
      # code...
    }
}
?>