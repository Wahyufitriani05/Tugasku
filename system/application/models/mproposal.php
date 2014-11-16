<?php
class mproposal extends Model 
{
    
    function mproposal() 
    {
        parent::Model();
        $this->load->database();
    }

    function judulTA($id_proposal='') {
        if(empty ($id_proposal))
            return '-';

        $this->db->select("proposal.JUDUL_TA");
        $this->db->from("proposal");
        $this->db->where("proposal.ID_PROPOSAL", $id_proposal);
        $this->db->limit(1);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            $row = $query->row();
            return $row->JUDUL_TA;
        } else {
            return '-';
        }
    }

    function getListDosenPembimbing(){
        //$query="select nama_lengkap_dosen, nip, nip2010 from dosen where status_dosen!='0' order by nama_lengkap_dosen asc";
        $query="select nama_lengkap_dosen, nip, nip2010 from dosen where inisial_dosen!='adm' and inisial_dosen!='kbj' and inisial_dosen!='kcv' and inisial_dosen!='rpl' and inisial_dosen!='ajk' and inisial_dosen!='mi' and inisial_dosen!='dtk' and inisial_dosen!='ap' and inisial_dosen!='igs' and nip!='0000' order by nama_lengkap_dosen asc";
        $data=$this->db->query($query);
        return $data->result();
    }

    function getLatestProposal($nrp)
    {
        $query="select p.id_proposal, DATE_FORMAT(p.tanggal_masuk, '%Y')tahun_proposal, p.nrp, p.judul_ta, m.nama_lengkap_mahasiswa, d1.nip2010 as pembimbing1, d2.nip2010 as pembimbing2, d1.nama_lengkap_dosen as dosen1, d2.nama_lengkap_dosen as dosen2 from proposal p, mahasiswa m, dosen d1, dosen d2 where p.nrp=m.nrp and (p.pembimbing1=d1.nip or p.pembimbing1=d1.nip2010) and (p.pembimbing2=d2.nip or p.pembimbing2=d2.nip2010) and p.nrp=".$this->db->escape($nrp)." and (p.status='0' or p.status='1' or p.status='11' or p.status='12' or p.status='3' or p.status='31' or p.status='32') order by p.id_proposal DESC limit 0, 1";
        return $this->db->query($query);
    }

    function cekProposal($nrp){
        $query="select * from proposal where nrp=".$this->db->escape($nrp)." and (status='0' or status='1' or status='11' or status='12' or status='3' or status='31' or status='32')";
        $data=$this->db->query($query);
        if($data->num_rows()>0) return false;
        else return true;
    }

    function cekProposalSaya($nrp, $id_proposal){
        $query="select * from proposal where id_proposal=".$this->db->escape($id_proposal)." and nrp=".$this->db->escape($nrp)." and (status='0' or status='1' or status='11')";
        $data=$this->db->query($query);
        if($data->num_rows()>0) return false;
        else return true;
    }

    function buatProposal(){
        $judul=$this->input->post('judul');
        $bidang_minat=$this->input->post('bidang_minat');
        $abstraksi=$this->input->post('abstraksi');
        $keyword=$this->input->post('keyword');
        $pembimbing1=$this->input->post('pembimbing1');
        $pembimbing2=$this->input->post('pembimbing2');
        $nrp=$this->session->userdata('id');

        $query="insert into proposal(pembimbing1, pembimbing2, nrp, judul_ta, status, abstraksi, tanggal_masuk, keyword, id_kbk) values('$pembimbing1', '$pembimbing2', '$nrp', ".$this->db->escape($judul).", '0', ".$this->db->escape($abstraksi).", NOW(), ".$this->db->escape($keyword).", '$bidang_minat')";
        $this->db->query($query);

        $query="select max(id_proposal)id_proposal from proposal";
        $data=$this->db->query($query);
        return $data->result();
    }

    function ubahProposal(){
        $judul=$this->input->post('judul');
        $bidang_minat=$this->input->post('bidang_minat');
        $abstraksi=$this->input->post('abstraksi');
        $keyword=$this->input->post('keyword');
        $pembimbing1=$this->input->post('pembimbing1');
        $pembimbing2=$this->input->post('pembimbing2');
        $nrp=$this->session->userdata('id');
        $id_proposal=$this->uri->segment(3, 0);

        $query="update proposal set judul_ta=".$this->db->escape($judul).", id_kbk='$bidang_minat', abstraksi=".$this->db->escape($abstraksi).", keyword=".$this->db->escape($keyword).", pembimbing1='$pembimbing1', pembimbing2='$pembimbing2' where id_proposal='$id_proposal'";
        $this->db->query($query);

        $query="select max(id_proposal)id_proposal from proposal";
        $data=$this->db->query($query);
        return $data->result();
    }

    function tambahFileProposal($id_proposal, $data, $jenis='1'){
        $nama_file=$data['file_name'];
        $tipe_file=$data['file_type'];
        //$original_name=$data['orig_name'];
        $original_name="Proposal_".$this->session->userdata('id')."_".$id_proposal;
		if($jenis=="paper") 
		{
			$file_saya=$this->getPaperFiles($id_proposal);
			$paper=1;
			foreach($file_saya as $row){
				$paper++;
			}
			$original_name="Pendukung_".$paper."_".$this->session->userdata('id');
		}
        $query="insert into prop_files values(NULL, '$id_proposal', '$original_name', '$tipe_file', '$nama_file')";
        $data=$this->db->query($query);
    }

    function hapusFileProposal($id_proposal='0', $id_file_proposal='0'){
        if($this->cekProposalSaya($this->session->userdata('id'), $id_proposal)) return false;
        $query="delete from prop_files where id_proposal=".$this->db->escape($id_proposal)." and id_file_prop=".$this->db->escape($id_file_proposal);
        $this->db->query($query);
        return true;
    }
    function getPaperFiles($id_proposal){
        $query="select pf.id_proposal, pf.nama_file, pf.path_file from prop_files pf, proposal p where p.id_proposal=pf.id_proposal and p.id_proposal=".$this->db->escape($id_proposal)." and pf.nama_file like 'Pendukung%'";
        $result=$this->db->query($query);
        return $result->result();
    }

    function getProposalSaya($nrp){
        //setting local time language
        $query="SET lc_time_names = 'id_ID'"; // set indonesian
        $this->db->query($query);
        
        $query="select p.id_proposal, DATE_FORMAT(p.tanggal_masuk, '%e %M %Y')tanggal_masuk, p.judul_ta, p.abstraksi, p.pembimbing1 as nip_pembimbing1, p.pembimbing2 as nip_pembimbing2, d1.nama_lengkap_dosen as pembimbing1, d2.nama_lengkap_dosen as pembimbing2, p.status  from proposal p, dosen d1, dosen d2 where (p.pembimbing1=d1.nip or p.pembimbing1=d1.nip2010) and (p.pembimbing2=d2.nip or p.pembimbing2=d2.nip2010) and p.nrp=".$this->db->escape($nrp)." order by p.id_proposal desc";
        $data=$this->db->query($query);
        return $data;
    }

    function getDetailProposalSaya($id_proposal){
        $query="select p.id_proposal, p.tanggal_masuk, p.judul_ta, p.abstraksi, p.pembimbing1 as nip_pembimbing1, p.pembimbing2 as nip_pembimbing2, d1.nama_lengkap_dosen as pembimbing1, d2.nama_lengkap_dosen as pembimbing2, p.status, k.nama_kbk, p.keyword  from proposal p, dosen d1, dosen d2, kbk k where (p.pembimbing1=d1.nip or p.pembimbing1=d1.nip2010) and (p.pembimbing2=d2.nip or p.pembimbing2=d2.nip2010) and p.id_kbk=k.id_kbk and p.id_proposal=".$this->db->escape($id_proposal);
        $data=$this->db->query($query);
        return $data->result();
    }

    function batalProposal($id_proposal){
        $nrp=$this->session->userdata('id');
        $query="select id_proposal from proposal where nrp=".$this->db->escape($nrp)." and id_proposal=".$this->db->escape($id_proposal);
        $data=$this->db->query($query);

        //proposal ditemukan
        if($data->num_rows>0){
            $query="update proposal set status='2' where id_proposal=".$this->db->escape($id_proposal);
            $this->db->query($query);
            $this->session->set_userdata('sukses', 'Proposal berhasil dibatalkan');
        }
        //proposal tidak ditemukan
        else{
            $this->session->set_userdata('error', "Proposal tidak ditemukan");
        }
        redirect('proposal/proposalSaya', 'refresh');
    }

    function getProposalFiles($id_proposal){
        $query="select pf.id_file_prop ,pf.id_proposal, pf.nama_file, pf.path_file from prop_files pf, proposal p where p.id_proposal=pf.id_proposal and p.id_proposal=".$this->db->escape($id_proposal);
        $result=$this->db->query($query);
        return $result->result();
    }
    
    function model_load_model($model_name) 
    {
        $CI =& get_instance();
        $CI->load->model($model_name);
        return $CI->$model_name;
    }
    
    function update($data, $id_proposal) 
    {
        $this->db->update("proposal", $data, array('ID_PROPOSAL' => $this->db->escape_like_str($id_proposal)));
    } 
    
    function getListTA($id_kbk="", $status="", $offset="", $jumlah_per_page="", $pembimbing="", $sort_by="", $sort_type="") 
    {
        $id_kbk = $this->db->escape_like_str($id_kbk);
        $status = $this->db->escape_like_str($status);
        $pembimbing = $this->db->escape_like_str($pembimbing);
        $list_sort_by = array(
            '1' => 'pr.ID_PROPOSAL',
            '2' => 'kbk.NAMA_KBK',
            '3' => 'pr.STATUS',
            '4' => 'mhs.NRP',
            '5' => 'mhs.NAMA_LENGKAP_MAHASISWA',
            '6' => 'pr.JUDUL_TA'
        );
        $sql = "
            SELECT pr.ID_PROPOSAL, pr.JUDUL_TA, pr.STATUS, kbk.NAMA_KBK, mhs.NRP, mhs.NAMA_LENGKAP_MAHASISWA, ds1.NAMA_LENGKAP_DOSEN as PEMBIMBING1, ds2.NAMA_LENGKAP_DOSEN as PEMBIMBING2
            FROM proposal pr
            JOIN mahasiswa mhs ON mhs.NRP = pr.NRP
            JOIN kbk kbk ON kbk.ID_KBK = pr.ID_KBK
            JOIN dosen ds1 ON ds1.NIP = pr.PEMBIMBING1
            JOIN dosen ds2 ON ds2.NIP = pr.PEMBIMBING2
            ";
        if($id_kbk != "-1")         // -1 = tidak ada filter kbk
            $sql .= " AND pr.ID_KBK='$id_kbk'";
        if($status != "-1")         // -1 = tidak ada filter status
            $sql .= " AND pr.STATUS='$status'";
        if($pembimbing != "-1")     // -1 = tidak ada filter dosen pembimbing
            $sql .= " AND (pr.PEMBIMBING1 LIKE '$pembimbing' OR pr.PEMBIMBING2 LIKE '$pembimbing')";
        if($sort_by != "")
            $sql .= " ORDER BY $list_sort_by[$sort_by] $sort_type";
        else
            $sql .= " ORDER BY pr.ID_PROPOSAL desc,pr.STATUS asc";
        // limit result
        if($jumlah_per_page != "") 
        {
            $end_row = $offset + $jumlah_per_page - 1;
            $sql = $sql." LIMIT $offset, $jumlah_per_page";
        }
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    function cariTA($kriteria="", $keyword="", $id_kbk="", $status="", $dosen="", $offset="", $jumlah_per_page="", $sort_by="", $sort_type="") 
    {
        $keyword = $this->db->escape_like_str($keyword);
        $id_kbk = $this->db->escape_like_str($id_kbk);
        $status = $this->db->escape_like_str($status);
        $list_sort_by = array(
            '1' => 'pr.ID_PROPOSAL',
            '2' => 'kbk.NAMA_KBK',
            '3' => 'pr.STATUS',
            '4' => 'mhs.NRP',
            '5' => 'mhs.NAMA_LENGKAP_MAHASISWA',
            '6' => 'pr.JUDUL_TA'
        );
        if($kriteria == "judul")
            $sql = "
                SELECT pr.ID_PROPOSAL, pr.JUDUL_TA, pr.STATUS, kbk.NAMA_KBK, mhs.NRP, mhs.NAMA_LENGKAP_MAHASISWA, ds1.NAMA_LENGKAP_DOSEN as PEMBIMBING1, ds2.NAMA_LENGKAP_DOSEN as PEMBIMBING2
                FROM proposal pr
                JOIN mahasiswa mhs ON mhs.NRP = pr.NRP
                JOIN kbk kbk ON kbk.ID_KBK = pr.ID_KBK
                JOIN dosen ds1 ON ds1.NIP = pr.PEMBIMBING1
                JOIN dosen ds2 ON ds2.NIP = pr.PEMBIMBING2
                WHERE pr.JUDUL_TA LIKE '%$keyword%'
                ";
        elseif($kriteria == "nama_mhs")
            $sql = "
                SELECT pr.ID_PROPOSAL, pr.JUDUL_TA, pr.STATUS, kbk.NAMA_KBK, mhs.NRP, mhs.NAMA_LENGKAP_MAHASISWA, ds1.NAMA_LENGKAP_DOSEN as PEMBIMBING1, ds2.NAMA_LENGKAP_DOSEN as PEMBIMBING2
                FROM proposal pr
                JOIN mahasiswa mhs ON mhs.NRP = pr.NRP
                JOIN kbk kbk ON kbk.ID_KBK = pr.ID_KBK
                JOIN dosen ds1 ON ds1.NIP = pr.PEMBIMBING1
                JOIN dosen ds2 ON ds2.NIP = pr.PEMBIMBING2
                WHERE (mhs.NAMA_MAHASISWA LIKE '%$keyword%'
                OR mhs.NAMA_LENGKAP_MAHASISWA LIKE '%$keyword%'
                )
                ";
        elseif($kriteria == "nrp_mhs")
            $sql = "
                SELECT pr.ID_PROPOSAL, pr.JUDUL_TA, pr.STATUS, kbk.NAMA_KBK, mhs.NRP, mhs.NAMA_LENGKAP_MAHASISWA, ds1.NAMA_LENGKAP_DOSEN as PEMBIMBING1, ds2.NAMA_LENGKAP_DOSEN as PEMBIMBING2
                FROM proposal pr
                JOIN mahasiswa mhs ON mhs.NRP = pr.NRP
                JOIN kbk kbk ON kbk.ID_KBK = pr.ID_KBK
                JOIN dosen ds1 ON ds1.NIP = pr.PEMBIMBING1
                JOIN dosen ds2 ON ds2.NIP = pr.PEMBIMBING2
                WHERE mhs.NRP LIKE '%$keyword%'
                ";
        else
            $sql = "
                SELECT pr.ID_PROPOSAL, pr.JUDUL_TA, pr.STATUS, kbk.NAMA_KBK, mhs.NRP, mhs.NAMA_LENGKAP_MAHASISWA, ds1.NAMA_LENGKAP_DOSEN as PEMBIMBING1, ds2.NAMA_LENGKAP_DOSEN as PEMBIMBING2
                FROM proposal pr
                JOIN mahasiswa mhs ON mhs.NRP = pr.NRP
                JOIN kbk kbk ON kbk.ID_KBK = pr.ID_KBK
                JOIN dosen ds1 ON ds1.NIP = pr.PEMBIMBING1
                JOIN dosen ds2 ON ds2.NIP = pr.PEMBIMBING2
                WHERE (pr.JUDUL_TA LIKE '%$keyword%'
                OR pr.ID_PROPOSAL LIKE '%$keyword%'
                OR mhs.NRP LIKE '%$keyword%'
                OR mhs.NAMA_MAHASISWA LIKE '%$keyword%'
                OR mhs.NAMA_LENGKAP_MAHASISWA LIKE '%$keyword%'
                OR pr.PEMBIMBING1 LIKE '%$keyword%'
                OR pr.PEMBIMBING2 LIKE '%$keyword%'
                OR ds1.nama_lengkap_dosen LIKE '%$keyword%'
                OR ds2.nama_lengkap_dosen LIKE '%$keyword%'
                )
                ";
        if($id_kbk != "-1")
            $sql .= "AND pr.ID_KBK='$id_kbk' ";
        if($status != "-1")
           $sql .= "AND pr.STATUS='$status' ";
        if($dosen != "-1")
           $sql .= "AND (pr.PEMBIMBING1='$dosen' OR pr.PEMBIMBING2='$dosen')";
        if($sort_by != "")
            $sql .= " ORDER BY $list_sort_by[$sort_by] $sort_type";
        else
            $sql .= " ORDER BY pr.ID_PROPOSAL desc,pr.STATUS asc";
        if($jumlah_per_page!="") 
        {
            $end_row = $offset + $jumlah_per_page - 1;
            $sql = $sql." LIMIT $offset, $jumlah_per_page";
        }
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    function getDetail($id_proposal) 
    {
        $sql = "
            SELECT pr.tgl_sidang_ta_asli, l.tanggal_yudisium, pr.tgl_sidang_ta, (TO_DAYS(l.tanggal_yudisium) - TO_DAYS(substr(pr.tgl_sidang_ta,1,10))) /30 as lama_yudisium, (TO_DAYS(pr.tgl_sidang_ta_asli) - TO_DAYS(substr(pr.tgl_sidang_ta,1,10))) /30 as lama_sidang, pr.id_proposal, pr.judul_ta, pr.abstraksi, pr.status, pr.revisi_proposal, kbk.nama_kbk, mhs.nrp, mhs.nama_lengkap_mahasiswa, ds1.nama_lengkap_dosen as pembimbing1, ds2.nama_lengkap_dosen as pembimbing2
            FROM proposal pr 
            JOIN mahasiswa mhs ON mhs.nrp = pr.nrp 
            JOIN kbk kbk ON kbk.id_kbk = pr.id_kbk 
            JOIN dosen ds1 ON ds1.nip = pr.pembimbing1 
            JOIN dosen ds2 ON ds2.nip = pr.pembimbing2
            LEFT JOIN periode_lulus l ON l.id_periode_lulus=pr.id_periode_lulus
            WHERE pr.id_proposal = '".$this->db->escape_like_str($id_proposal)."' 
            ";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    function updateRevisiProposal($id_proposal,$revisi)
    {
        $sql = "
            UPDATE proposal SET revisi_proposal = '".$revisi."' WHERE id_proposal = ".$id_proposal."";
        $query = $this->db->query($sql);
    }

    function getRevisiProposal($id_proposal)
    {
        $query = $this->db->get_where('proposal', array('id_proposal' => $id_proposal));
        if ($query->num_rows() > 0) {
            return $query->first_row('array')['REVISI_PROPOSAL'];
        }
        else {
            return NULL;
        }
    }
    
    function cek($filter="", $dialog="", $redirect_page="error/index/") 
    {
        $hasil = null;
        $this->db->select("ID_PROPOSAL");
        $this->db->from("proposal");
        if(is_array($filter))
            $this->db->where($filter);
        else
            $this->db->where("ID_PROPOSAL", $this->db->escape_like_str($filter));
        $this->db->limit(1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if($query->num_rows() > 0)
            $hasil = TRUE;
        else
            $hasil = FALSE;

        if(empty ($dialog)) 
        {
            return $hasil;
        } else 
        {
            if(! $hasil) 
            {
                $this->lib_alert->warning("Tugas akhir tidak ditemukan");
                if($redirect_page == "error/index/")
                    redirect($redirect_page.$dialog);
                else
                    redirect($redirect_page);
            }
        }
    }

    function cekPembimbingTA($id_proposal="", $nip="", $dialog="", $redirect_page="error/index/") 
    {
        $id_proposal = $this->db->escape_like_str($id_proposal);
        $nip = $this->db->escape_like_str($nip);
        $hasil = null;
        $sql = "
            SELECT proposal.ID_PROPOSAL
            FROM proposal
            WHERE proposal.ID_PROPOSAL = '$id_proposal'
            AND (
                proposal.PEMBIMBING1 = '$nip'
                OR proposal.PEMBIMBING2 = '$nip'
            )
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
            if(! $hasil) {
                $this->lib_alert->warning("Halaman hanya bisa diakses oleh dosen yang bersangkutan");
                if($redirect_page == "error/index/")
                    redirect($redirect_page.$dialog);
                else
                    redirect($redirect_page);
            }
        }
    }

    function fieldTA($field="", $id_proposal="") 
    {
        $this->db->select("$field");
        $this->db->from("proposal");
        $this->db->where("ID_PROPOSAL", $this->db->escape_like_str($id_proposal));
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row()->$field;
        else
            return '-';
    }

    
}
?>