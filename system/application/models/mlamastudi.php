<?php
class mlamastudi extends Model 
{

    function mlamastudi() 
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

    function getPeriode() 
    {
        $sql = "SELECT Distinct CONCAT_WS(' ', SEMESTER_SIDANG_TA, TAHUN_SIDANG_TA) AS periode FROM `sidang_ta` order by id_sidang_ta desc";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    /*function getListTAdanLamaStudi($id_periode="-1", $offset="", $perpage="") 
    {
        $sql = "select q2.id_proposal, q2.id_kbk, q2.nama_periode, q2.tgl_sidang_ta as tgl_sidprop, q2.tanggal_yudisium, ifnull(q1.tgl_sidang_ta_asli, q2.tanggal_yudisium) as tgl_sidang, q2.id_periode_lulus, q2.id_proposal, q2.judul_ta, q2.nrp, q2.nama_mahasiswa, ifnull(q1.lama,q2.lama) as lamastudi from 
                (
                    SELECT p.tgl_sidang_ta, p.tgl_sidang_ta_asli, p.id_proposal, p.judul_ta, m.nrp, m.nama_mahasiswa, substr(p.tgl_sidang_ta,1,10) as sidprop, (TO_DAYS(p.tgl_sidang_ta_asli) - TO_DAYS(substr(p.tgl_sidang_ta,1,10))) /30 as lama
                    FROM proposal p
                    JOIN mahasiswa m on m.nrp=p.nrp
                    where p.status='31' and tgl_sidang_ta_asli!='0000-00-00'
                )q1 right join 
                (
                    SELECT p.id_kbk, l.nama_periode, p.tgl_sidang_ta, l.tanggal_yudisium, l.id_periode_lulus, p.id_proposal, p.judul_ta, m.nrp, m.nama_mahasiswa, substr(p.tgl_sidang_ta,1,10) as sidprop, (TO_DAYS(l.TANGGAL_YUDISIUM) - TO_DAYS(substr(p.tgl_sidang_ta,1,10))) /30 as lama
                    FROM proposal p
                    JOIN periode_lulus l on p.id_periode_lulus=l.id_periode_lulus
                    JOIN mahasiswa m on m.nrp=p.nrp
                    where p.status='31'
                )q2 on q1.id_proposal=q2.id_proposal";
        $sql .= " where q2.tanggal_yudisium > '2006-1-1'";
        if($id_periode!="-1")
            $sql .= " and q2.id_periode_lulus='$id_periode'";
        $sql .= " order by q2.nrp";
        if($perpage!="")
            $sql .= " limit $offset, $perpage";
        $query = $this->db->query($sql);
        return $query->result();
    }*/
    
    function getListTAUpdate()
    {
        $sql = "select p.* from proposal p, sidang_ta s where p.status = 31 and 
            (p.sta is not null and p.sta != '') and  (p.sprop is not null and p.sprop != '') 
            and (p.tgl_sidang_ta is null or p.tgl_sidang_ta_asli = '0000-00-00') and s.id_sidang_ta =  p.sta 
            order by p.id_proposal desc";
        $query = $this->db->query($sql);
        
        return $query->result();
    } 
    
    function updateProposal($id_proposal, $data)
    {
        $this->db->where('ID_PROPOSAL', $id_proposal);
        $this->db->update('PROPOSAL', $data);
        if($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }
    
    function getListTAdanLamaStudi($periode="", $offset="", $perpage="") 
    {        
        $sql = "select m.nrp, m.nama_mahasiswa, s.semester_sidang_ta, s.tahun_sidang_ta, p.tgl_sidang_ta, p.tgl_sidang_ta_asli
                ,(TO_DAYS( p.tgl_sidang_ta_asli ) - TO_DAYS( p.tgl_sidang_ta )) /30 AS lama_studi
                from proposal p, mahasiswa m,  sidang_TA s where m.nrp = p.nrp and p.status = 31 and p.sta = s.id_sidang_TA and p.tgl_sidang_ta is not null
                and p.tgl_sidang_ta_asli != '0000-00-00'"; 
        
        if($periode!="")
        {
            $per = explode(" ",$periode);
            $sql .= " and s.semester_sidang_ta like '$per[0]' and s.tahun_sidang_ta like '$per[1]'";
        }
        
        if($perpage!="")
            $sql .= " limit $offset, $perpage";
        
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    /*function getWisudadanRataLamaStudi() 
    {
        $sql = "
            select q3.id_periode_lulus, q3.nama_periode, q3.tanggal_yudisium, avg(q3.lamastudi) as lama_total from (
                select q2.nama_periode, q2.tgl_sidang_ta as tgl_sidprop, q2.tanggal_yudisium, ifnull(q1.tgl_sidang_ta_asli, q2.tanggal_yudisium) as tgl_sidang, q2.id_periode_lulus, q2.id_proposal, q2.judul_ta, q2.nrp, q2.nama_mahasiswa, ifnull(q1.lama,q2.lama) as lamastudi 
                from 
                    ( 
                        SELECT p.tgl_sidang_ta, p.tgl_sidang_ta_asli, p.id_proposal, p.judul_ta, m.nrp, m.nama_mahasiswa, substr(p.tgl_sidang_ta,1,10) as sidprop, (TO_DAYS(p.tgl_sidang_ta_asli) - TO_DAYS(substr(p.tgl_sidang_ta,1,10))) /30 as lama 
                        FROM proposal p JOIN mahasiswa m on m.nrp=p.nrp where p.status='31' and tgl_sidang_ta_asli!='0000-00-00' 
                    )
                    q1 right join 
                    ( 
                        SELECT l.nama_periode, p.tgl_sidang_ta, l.tanggal_yudisium, l.id_periode_lulus, p.id_proposal, p.judul_ta, m.nrp, m.nama_mahasiswa, substr(p.tgl_sidang_ta,1,10) as sidprop, (TO_DAYS(l.TANGGAL_YUDISIUM) - TO_DAYS(substr(p.tgl_sidang_ta,1,10))) /30 as lama 
                        FROM proposal p JOIN periode_lulus l on p.id_periode_lulus=l.id_periode_lulus JOIN mahasiswa m on m.nrp=p.nrp where p.status='31' 
                    )q2 on q1.id_proposal=q2.id_proposal 
            ) q3 
            where q3.tanggal_yudisium > '2006-1-1'
            group by q3.id_periode_lulus order by q3.tanggal_yudisium desc
            ";
        $query = $this->db->query($sql);
        return $query->result();
    }*/
    
    function getWisudadanRataLamaStudi() 
    {
        $sql = "
                select s.semester_sidang_ta, s.tahun_sidang_ta
                , AVG((TO_DAYS( p.tgl_sidang_ta_asli ) - TO_DAYS( p.tgl_sidang_ta )) /30) AS lama_ratarata
                from proposal p, mahasiswa m,  sidang_TA s where m.nrp = p.nrp and p.status = 31 and p.sta = s.id_sidang_TA and p.tgl_sidang_ta is not null
                and p.tgl_sidang_ta_asli != '0000-00-00' group by s.semester_sidang_ta, tahun_sidang_ta order by s.id_sidang_TA desc
            ";
        $query = $this->db->query($sql);
        return $query->result();
    }
    


    function getTotalMahasiswaTA($tahun) {
      $sql = "SELECT sidang_ta.ID_SIDANG_TA,
                     sidang_ta.SEMESTER_SIDANG_TA,
                     sidang_ta.TAHUN_SIDANG_TA,
                     count(proposal.ID_PROPOSAL) as TOTAL
              FROM sidang_ta,
                   proposal
              WHERE YEAR(waktu_sidang_ta) > (YEAR(NOW()) - '$tahun')
              AND (proposal.`status` = 31 OR proposal.`STATUS` != 31)
              AND sidang_ta.ID_SIDANG_TA = proposal.STA
              GROUP BY sidang_ta.ID_SIDANG_TA,
                       sidang_ta.SEMESTER_SIDANG_TA,
                       sidang_ta.TAHUN_SIDANG_TA
              ORDER BY sidang_ta.ID_SIDANG_TA desc";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    function getYear() {
      $sql="SELECT distinct YEAR(WAKTU_SIDANG_TA) as tahun from sidang_ta";
      $query = $this->db->query($sql);
      return $query->result();
    }

    function getTotalMahasiswaTALulus($tahun) {
      $sql = "SELECT sidang_ta.ID_SIDANG_TA,
                     sidang_ta.SEMESTER_SIDANG_TA,
                     sidang_ta.TAHUN_SIDANG_TA,
                     count(proposal.ID_PROPOSAL) as TOTAL
              FROM sidang_ta,
                   proposal
              WHERE YEAR(waktu_sidang_ta) > (YEAR(NOW()) - '$tahun')
              AND proposal.`status` = 31
              AND sidang_ta.ID_SIDANG_TA = proposal.STA
              GROUP BY sidang_ta.ID_SIDANG_TA,
                       sidang_ta.SEMESTER_SIDANG_TA,
                       sidang_ta.TAHUN_SIDANG_TA
              ORDER BY sidang_ta.ID_SIDANG_TA desc";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    function getTotalPembimbingTA()
    {
        $sql = "SELECT dosen.nama_dosen, summary.pembimbing1 as nip, sum(summary.jumlah) as jumlah_bimbingan from
                (
                select pembimbing1, count(pembimbing1) as jumlah from proposal group by pembimbing1
                union
                select pembimbing2, count(pembimbing2) as jumlah from proposal group by pembimbing2
                ) summary join dosen on summary.pembimbing1 = dosen.NIP2010 where dosen.nama_dosen != '--' group by summary.pembimbing1";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getTotalPembimbingTAbyYear($year=NULL)
    {
      $year = is_null( $year) ? date('Y') : $year;
      $sql = "SELECT dosen.nama_dosen, summary.pembimbing1 as nip, sum(summary.jumlah) as jumlah_bimbingan from
                (
                select pembimbing1, count(pembimbing1) as jumlah, year(sidang_ta.WAKTU_SIDANG_TA) as tahun from proposal, sidang_ta where proposal.sta = sidang_ta.id_sidang_ta and year(sidang_ta.WAKTU_SIDANG_TA) = '$year' group by pembimbing1
                union
                select pembimbing2, count(pembimbing2) as jumlah, year(sidang_ta.WAKTU_SIDANG_TA) as tahun from proposal, sidang_ta where proposal.sta = sidang_ta.id_sidang_ta and year(sidang_ta.WAKTU_SIDANG_TA) = '$year' group by pembimbing2
                ) summary join dosen on summary.pembimbing1 = dosen.NIP2010 where dosen.nama_dosen != '--' group by summary.pembimbing1";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
}
?>
