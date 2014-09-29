<?php

class mtopik extends Model {

    function mtopik() {
        parent::Model();
        $this->load->database();
    }

    function getTotalTopik($id_kbk, $id_status){
        $query="select id_topik from topik_ta";
        if($id_kbk!="0" || $id_status!="5")$query.=" where id_kbk!='0' ";
        if($id_kbk!="0")$query.=" and id_kbk=".$this->db->escape($id_kbk);
        if($id_status!="5")$query.=" and status_topik=".$this->db->escape($id_status);
        $data=$this->db->query($query);
        return count($data->result());
    }

    function getTotalTopikSaya($inisial_dosen){
        $query="select t.id_topik from topik_ta t, dosen d where (t.pembimbing_topik1=d.nip or t.pembimbing_topik1=d.nip2010) and d.inisial_dosen=".$this->db->escape($inisial_dosen);
        $data=$this->db->query($query);
        return count($data->result());
    }

    function getTotalTopikSearch($keywords){
        $query="select id_topik from topik_ta where abstraksi_topik like '%".$this->db->escape_like_str($keywords)."%'";
        $data=$this->db->query($query);
        return count($data->result());
    }

    function getListSummaryTopik($offset, $total_per_page, $id_kbk, $id_status){
        //setting local time language
        $query="SET lc_time_names = 'id_ID'"; // set indonesian
        $this->db->query($query);

        $query="select t.id_topik, DATE_FORMAT(t.tgl_topik, '%W %e %M %Y pukul %T WIB')waktu_topik, d.nama_dosen, d2.nama_dosen as nama_dosen2, t.id_kbk, k.nama_kbk, substr(t.abstraksi_topik, 1, 300)isi_topik, t.judul_topik, t.status_topik from topik_ta t, dosen d, dosen d2, kbk k where k.id_kbk=t.id_kbk and (t.pembimbing_topik1=d.nip or t.pembimbing_topik1=d.nip2010) and (t.pembimbing_topik2=d2.nip or t.pembimbing_topik2=d2.nip2010) ";
        if($id_kbk!="0")$query.="and t.id_kbk=".$this->db->escape($id_kbk)." ";
        if($id_status!="5")$query.="and t.status_topik=".$this->db->escape($id_status)." ";
        $query.="order by t.id_topik desc limit ".$this->db->escape_like_str($offset).", ".$this->db->escape_like_str($total_per_page);
        $data=$this->db->query($query);
        return $data->result();
    }

    function getListSummaryTopikSaya($offset, $total_per_page, $inisial_dosen){
        //setting local time language
        $query="SET lc_time_names = 'id_ID'"; // set indonesian
        $this->db->query($query);

        $query="select t.id_topik, t.waktu_topik, t.judul_topik,t.status_topik, coalesce(m.jumlah_approve, '0')as jumlah_approve from (select t.id_topik, t.tgl_topik as waktu_topik, t.judul_topik, t.status_topik from topik_ta t, dosen d where d.inisial_dosen=".$this->db->escape($inisial_dosen)." and (t.pembimbing_topik1=d.nip or t.pembimbing_topik1=d.nip2010) order by t.id_topik desc limit ".$this->db->escape_like_str($offset).", ".$this->db->escape_like_str($total_per_page).")t left join (select m.id_topik, count(*)as jumlah_approve from mahasiswa_minati_topik m, topik_ta t, dosen d where m.id_topik=t.id_topik and (t.pembimbing_topik1=d.nip or t.pembimbing_topik1=d.nip2010) and d.inisial_dosen=".$this->db->escape($inisial_dosen)." group by m.id_topik)m on m.id_topik=t.id_topik";
        $data=$this->db->query($query);
        return $data->result();
    }

    function getDetailUbahTopik($id_topik){
        //setting local time language
        $query="SET lc_time_names = 'id_ID'"; // set indonesian
        $this->db->query($query);

        $query="select t.id_topik, DATE_FORMAT(t.tgl_topik, '%W %e %M %Y pukul %T WIB')waktu_topik, t.id_kbk, d.nama_dosen, d2.nama_dosen  as nama_dosen2, d2.nip as nip2, d2.nip2010 as nip20102, t.abstraksi_topik, t.judul_topik, t.id_kbk, k.nama_kbk, t.status_topik from topik_ta t, dosen d, dosen d2, kbk k where k.id_kbk=t.id_kbk and (t.pembimbing_topik1=d.nip or t.pembimbing_topik1=d.nip2010) and (t.pembimbing_topik2=d2.nip or t.pembimbing_topik2=d2.nip2010) and t.id_topik=".$this->db->escape($id_topik);
        $data=$this->db->query($query);
        return $data->result();
    }

    function getListSummaryTopikSearch($offset, $total_per_page, $keywords){
        //setting local time language
        $query="SET lc_time_names = 'id_ID'"; // set indonesian
        $this->db->query($query);

        $query="select t.id_topik, DATE_FORMAT(t.tgl_topik, '%W %e %M %Y pukul %T WIB')waktu_topik, d.nama_dosen, d2.nama_dosen as nama_dosen2, t.id_kbk, k.nama_kbk, substr(t.abstraksi_topik,1, 300)isi_topik, t.judul_topik, t.status_topik from topik_ta t, dosen d, dosen d2, kbk k where k.id_kbk=t.id_kbk and (t.pembimbing_topik1=d.nip or t.pembimbing_topik1=d.nip2010) and (t.pembimbing_topik2=d2.nip or t.pembimbing_topik2=d2.nip2010) and t.abstraksi_topik like '%".$this->db->escape_like_str($keywords)."%' order by t.id_topik desc limit ".$this->db->escape_like_str($offset).", ".$this->db->escape_like_str($total_per_page);
        $data=$this->db->query($query);
        return $data->result();
    }

    function getDetailTopik($id_topik){
        //setting local time language
        $query="SET lc_time_names = 'id_ID'"; // set indonesian
        $this->db->query($query);

        $query="select t.id_topik, DATE_FORMAT(t.tgl_topik, '%W %e %M %Y pukul %T WIB')waktu_topik, d.nama_dosen, d2.nama_dosen as nama_dosen2, t.abstraksi_topik, t.judul_topik, t.id_kbk, k.nama_kbk, t.status_topik from topik_ta t, dosen d, dosen d2, kbk k where k.id_kbk=t.id_kbk and (t.pembimbing_topik1=d.nip or t.pembimbing_topik1=d.nip2010) and (t.pembimbing_topik2=d2.nip or t.pembimbing_topik2=d2.nip2010) and t.id_topik=".$this->db->escape($id_topik);
        $data=$this->db->query($query);
        return $data->result();
    }

    function status_topik_saya($nrp_mahasiswa){
        $query="select id_topik from mahasiswa_minati_topik where approve_dosen='1' and nrp=".$this->db->escape($nrp_mahasiswa);
        $data=$this->db->query($query);
        $hasil=$data->result();
        foreach($hasil as $row){
            return $row->id_topik;
        }
        return 0;
    }

    function getApprovedTopik($id_topik){
        $query="select t.id_topik, t.judul_topik from topik_ta t where t.id_topik='$id_topik'";
        $data=$this->db->query($query);
        return $data->result();
    }

    function statusMinatTopikMahasiswa($nrp_mahasiswa){
        $query="select id_topik from mahasiswa_minati_topik where nrp=".$this->db->escape($nrp_mahasiswa)." and (approve_dosen='0' or approve_dosen='1')";
        $data=$this->db->query($query);
        return count($data->result());
    }

    function StatusMinatTopikSekarang($nrp_mahasiswa, $id_topik){
        $query="select id_topik from mahasiswa_minati_topik where approve_dosen='0' and id_topik=".$this->db->escape($id_topik)." and nrp=".$this->db->escape($nrp_mahasiswa);
        $data=$this->db->query($query);
        return count($data->result());
    }
	
	function StatusProposalMahasiswa($nrp_mahasiswa){
		$query="select p.id_proposal from mahasiswa m, proposal p where p.nrp=m.nrp and (p.status='0' or p.status='1' or p.status='11' or p.status='12' or p.status='3' or p.status='31') and m.nrp=".$this->db->escape($nrp_mahasiswa);
		$data=$this->db->query($query);
		if(count($data->result())>=1)return false;
		else return true;
	}

    function ambilTopik($nrp, $id_topik){
        $query="insert into mahasiswa_minati_topik values(".$this->db->escape($id_topik).", ".$this->db->escape($nrp).", NOW(), '0')";
        $data=$this->db->query($query);
    }

    function batalTopik($nrp, $id_topik){
        $query="delete from mahasiswa_minati_topik where id_topik=".$this->db->escape($id_topik)." and nrp=".$this->db->escape($nrp);
        $data=$this->db->query($query);
    }

    function topikMilikDosen($inisial_dosen, $id_topik){
        $query="select t.id_topik from topik_ta t, dosen d where t.id_topik=".$this->db->escape($id_topik)." and (t.pembimbing_topik1=d.nip or t.pembimbing_topik1=d.nip2010) and d.inisial_dosen=".$this->db->escape($inisial_dosen);
        $data=$this->db->query($query);
        return count($data->result());
    }

    function getTopikFiles($id_topik){
        $query="select id_file_topik, nama_file, path_file from topik_files where id_topik='$id_topik'";
        $data=$this->db->query($query);
        return $data->result();
    }

    function tambahTopik(){
        $judul=$this->input->post('judul');
        $isi=$this->input->post('isi');
        $nip=$this->session->userdata('nip');
        $pembimbing2=  $this->input->post('pembimbing2');
        $kbk=  $this->input->post('minat');
        $query="insert into topik_ta values(null, '$kbk',".$this->db->escape($judul).", ".$this->db->escape($isi).", '$nip', '$pembimbing2', '0', NOW())";
        $this->db->query($query);

        $query="select max(id_topik)id_topik from topik_ta";
        $data=$this->db->query($query);
        return $data->result();
    }

    function ubahTopik($id_topik){
        $judul=$this->input->post('judul');
        $isi=$this->input->post('isi');
        $nip=$this->session->userdata('nip');
        $pembimbing2=  $this->input->post('pembimbing2');
        $kbk=  $this->input->post('minat');
        $query="update topik_ta set id_kbk='$kbk', judul_topik=".$this->db->escape($judul).", abstraksi_topik=".$this->db->escape($isi).", pembimbing_topik1='$nip', pembimbing_topik2='$pembimbing2' where id_topik=".$this->db->escape($id_topik);
        $this->db->query($query);

        $query="select max(id_topik)id_topik from topik_ta";
        $data=$this->db->query($query);
        return $data->result();
    }

    function mahasiswaMinatiTopik($id_topik){
        $query="select m.nrp, mhs.nama_lengkap_mahasiswa, m.tanggal_minati, mhs.sex_mahasiswa, mhs.telp_mahasiswa, m.approve_dosen from mahasiswa_minati_topik m, mahasiswa mhs where mhs.nrp=m.nrp and m.id_topik=".$this->db->escape($id_topik);
        $data=$this->db->query($query);
        return $data->result();
    }

    function approveTopik($id_topik, $nrp_mahasiswa, $approve_dosen){
        if($approve_dosen=="1"){
            $query="update mahasiswa_minati_topik set approve_dosen='2' where id_topik=".$this->db->escape($id_topik);
            $this->db->query($query);
            $query="update mahasiswa_minati_topik set approve_dosen='1' where id_topik=".$this->db->escape($id_topik)." and nrp=".$this->db->escape($nrp_mahasiswa);
            $this->db->query($query);
            $query="update topik_ta set status_topik='1' where id_topik=".$this->db->escape($id_topik);
            $this->db->query($query);
        }
        else if($approve_dosen=="0"){
            $query="update mahasiswa_minati_topik set approve_dosen='0' where id_topik=".$this->db->escape($id_topik);
            $this->db->query($query);
            $query="update topik_ta set status_topik='0' where id_topik=".$this->db->escape($id_topik);
            $this->db->query($query);
        }
    }

    function tambahFileTopik($id_topik, $data){
        $nama_file=$data['file_name'];
        $tipe_file=$data['file_type'];
        $original_name=$data['orig_name'];

        $query="insert into topik_files values(NULL, '$id_topik', '$original_name', '$tipe_file', '$nama_file')";
        $data=$this->db->query($query);
    }

    function getJudulTopik($id_topik){
        $query="select judul_topik from topik_ta where id_topik=".$this->db->escape($id_topik);
        $data=$this->db->query($query);
        return $data->result();
    }
}
?>
