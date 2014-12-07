<?php
class mdosen extends Model {

    function mdosen()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database();
    }
    
    function getDosen()
    {
        $nip = $this->input->post('nip');
        $query = "select nip from dosen where nip=".$this->db->escape($nip);
        $data = $this->db->query($query);
        return $data->result();
    }
    
    function isDosenRMK($nip, $kbk)
    {
        $query = "select * from kbk_dosen kd, kbk k where kd.nip=".$this->db->escape($nip)." and kd.id_kbk = k.id_kbk and k.nama_kbk=".$this->db->escape($kbk);
        $data = $this->db->query($query);
        return $data->result();
    }

    function getDetailDosen(){
        $query="select d.nip, d.nip2010, d.nama_dosen, d.telp_dosen, d.nama_lengkap_dosen, d.jenis_kelamin, d.status_dosen, d.email_dosen, d.inisial_dosen, k.nama_kbk from dosen d, kbk k, kbk_dosen kd where (d.nip=kd.nip or d.nip2010=kd.nip) and k.id_kbk=kd.id_kbk and (d.nip=".$this->db->escape($this->uri->segment(3,'kosong'))." or d.nip2010=".$this->db->escape($this->uri->segment(3,'kosong')).") order by k.nama_kbk asc";
        $data=$this->db->query($query);
        return $data->result();
    }

    function updateDetailDosen(){
        $nip = $this->input->post('nip');
        $nip_lama = $this->session->userdata('nip_lama');
        $this->session->set_userdata('nip_lama', $nip);
        $nama= $this->input->post('nama');
        $nama_lengkap= $this->input->post('nama_lengkap');
        $email= $this->input->post('email');
        $inisial= $this->input->post('inisial');
        $telepon= $this->input->post('telepon');
        $jenis_kelamin= $this->input->post('jenis_kelamin');
        $status= $this->input->post('status');
        $query="update dosen set nip2010=".$this->db->escape($nip).", nama_dosen=".$this->db->escape($nama).", nama_lengkap_dosen=".$this->db->escape($nama_lengkap).", email_dosen=".$this->db->escape($email).", inisial_dosen=".$this->db->escape($inisial).", telp_dosen=".$this->db->escape($telepon).", jenis_kelamin=".$this->db->escape($jenis_kelamin).", status_dosen=".$this->db->escape($status);
        if($this->input->post('password')){
            $password=$this->encrypt->encode($this->input->post('password'), 'g7Rd7G8vhrD78yhv398hiDHrg89h34gh');
            $query=$query.", password_dosen=".$this->db->escape($password);
        }
        $query=$query." where nip=".$this->db->escape($nip_lama)." or nip2010=".$this->db->escape($nip_lama);
        return $this->db->query($query);
    }

    function updateKBKDosen($id_kbk, $nip_dosen, $perintah){
        
        $query1="select * from kbk_dosen where nip=".$this->db->escape($nip_dosen)." and id_kbk=".$this->db->escape($id_kbk);
        $data = $this->db->query($query1);
        $count = count($data->result());
        //tambah kbk dosen
        if($perintah==1 && $count==0)$query="insert into kbk_dosen values(".$this->db->escape($nip_dosen).",".$this->db->escape($id_kbk).")";
        //hapus kbk dosen
        else if($count>0)$query="delete from kbk_dosen where nip=".$this->db->escape($nip_dosen)." and id_kbk=".$this->db->escape($id_kbk);
        $this->db->query($query);
    }
    
    function updateStatusDosen($nip_dosen, $perintah){
        $query="";
        $query = "update dosen set status_dosen = " .$this->db->escape($perintah). " where nip = ". $nip_dosen;
        $this->db->query($query);
    }

    function getKBK($nama_kbk = NULL){
        if (empty($nama_kbk)) {
            $query="select id_kbk, nama_kbk, keterangan_kbk, status_kbk from kbk where id_kbk!=0 order by nama_kbk asc";
        }
        else {
            $query="select id_kbk, nama_kbk, keterangan_kbk, status_kbk from kbk where id_kbk!=0 and nama_kbk = '". $nama_kbk ."' limit 1";
        }
        $data = $this->db->query($query);
        //print_r($data->result()); die;
        return $data->result();
    }

    function tambahKBK(){
        $nama_kbk=$this->input->post('nama');
        $keterangan_kbk=$this->input->post('keterangan');
        $query="insert into kbk values(null, ".$this->db->escape($nama_kbk).",".$this->db->escape($keterangan_kbk).",'TIDAK DIPAKAI')";
        $this->db->query($query);
    }

    /*function getTotalDosen(){
        $query="select d.nip, ifnull(k.nama_kbk, 'kosong')as nama_kbk from dosen d, kbk k, kbk_dosen kd where (d.nip=kd.nip or d.nip2010=kd.nip) and k.id_kbk=kd.id_kbk order by d.nama_lengkap_dosen, k.nama_kbk asc";
        $data = $this->db->query($query);
        return count($data->result());
    }*/
    
    function getTotalDosen(){
        $query="select * from dosen";
        $data = $this->db->query($query);
        return count($data->result());
    }

    /*(function getTotalDosenSearch($nama){
        $query="select d.nip, ifnull(k.nama_kbk, 'kosong')as nama_kbk from dosen d, kbk k, kbk_dosen kd where (d.nip=kd.nip or d.nip2010=kd.nip) and k.id_kbk=kd.id_kbk and d.nama_dosen like '%".$this->db->escape_like_str($nama)."%' order by d.nama_lengkap_dosen, k.nama_kbk asc";
        $data = $this->db->query($query);
        return count($data->result());
    }*/
    
    function getTotalDosenSearch($nama){
        $query="select * from dosen d where d.nama_dosen like '%".$this->db->escape_like_str($nama)."%'";
        $data = $this->db->query($query);
        return count($data->result());
    }

    /*function getListDosenSearch($offset, $per_page, $nama){
        $query="select d.nip, d.nip2010, d.nama_lengkap_dosen, d.status_dosen, ifnull(k.nama_kbk, 'kosong')as nama_kbk from dosen d, kbk k, kbk_dosen kd where (d.nip=kd.nip or d.nip2010=kd.nip) and k.id_kbk=kd.id_kbk and d.nama_dosen like '%".$this->db->escape_like_str($nama)."%' order by d.nama_lengkap_dosen, k.nama_kbk asc limit $offset, $per_page";
        $data = $this->db->query($query);
        return $data->result();
    }*/
    
    function getListDosenSearch($offset, $per_page, $nama){
        $query="select d.nip, d.nip2010, d.nama_lengkap_dosen, d.status_dosen, ifnull(k.nama_kbk, 'kosong')as nama_kbk 
                from (SELECT d.nip, d.nip2010, d.nama_lengkap_dosen, d.status_dosen FROM dosen d 
                where d.nama_dosen like '%".$this->db->escape_like_str($nama)."%'
                ORDER BY d.nama_lengkap_dosen ASC limit $offset, $per_page) d left outer join 
                (select k.nama_kbk, kd.nip from kbk_dosen kd, kbk k
                where k.id_kbk = kd.id_kbk) k
                on(d.nip=k.nip or d.nip2010=k.nip) order by d.nama_lengkap_dosen, k.nama_kbk asc";
        $data = $this->db->query($query);
        return $data->result();
    }

    /*function getListDosen($offset, $per_page){
        $query="select d.nip, d.nip2010, d.nama_lengkap_dosen, d.status_dosen, ifnull(k.nama_kbk, 'kosong')as nama_kbk from 
        (SELECT *
        FROM dosen d
        ORDER BY d.nama_lengkap_dosen ASC
        limit $offset, $per_page) d, kbk k, kbk_dosen kd where (d.nip=kd.nip or d.nip2010=kd.nip) and k.id_kbk=kd.id_kbk order by d.nama_lengkap_dosen,  k.nama_kbk asc ";
        $data = $this->db->query($query);
        return $data->result();
    }*/
    
    function getListDosen($offset, $per_page){
        $query="select d.nip, d.nip2010, d.nama_lengkap_dosen, d.status_dosen, ifnull(k.nama_kbk, 'kosong')as nama_kbk 
                from (SELECT d.nip, d.nip2010, d.nama_lengkap_dosen, d.status_dosen FROM dosen d ORDER BY d.nama_lengkap_dosen ASC limit $offset, $per_page) d left outer join (select k.nama_kbk, kd.nip from kbk_dosen kd, kbk k
                where k.id_kbk = kd.id_kbk) k
                on(d.nip=k.nip or d.nip2010=k.nip) order by d.nama_lengkap_dosen, k.nama_kbk asc   ";
        $data = $this->db->query($query);
        return $data->result();
    }

    function insertDosen(){
        //insert record dosen baru
        $nip = $this->input->post('nip');
        $nama= $this->input->post('nama');
        $nama_lengkap= $this->input->post('nama_lengkap');
        $email= $this->input->post('email');
        $inisial= $this->input->post('inisial');
        $telepon= $this->input->post('telepon');
        $password=$this->encrypt->encode($this->input->post('password'), 'g7Rd7G8vhrD78yhv398hiDHrg89h34gh');
        $jenis_kelamin= $this->input->post('jenis_kelamin');
        $status= $this->input->post('status');
        $minat= $this->input->post('minat');
        //var_dump($minat);
        $query = "insert into dosen values(".$this->db->escape($nip).",".$this->db->escape($nip).",NULL,".$this->db->escape($status).",".$this->db->escape($nama).",".$this->db->escape($nama_lengkap).",".$this->db->escape($jenis_kelamin).",".$this->db->escape($telepon).",".$this->db->escape($email).",".$this->db->escape($password).",".$this->db->escape($inisial).")";
        $data = $this->db->query($query);

        //insert bidang minat dosen
        for($i=0;$i<sizeof($minat);$i++){
            $query ="insert into kbk_dosen values(".$this->db->escape($nip).",'$minat[$i]')";
            $this->db->query($query);
        }
        return $data;
    }
    
    function ubahStatusKBK($id_kbk, $command){
        $query="update kbk set status_kbk=".$this->db->escape($command)." where id_kbk=".$this->db->escape($id_kbk);
        $this->db->query($query);
    }

    function model_load_model($model_name) 
    {
        $CI =& get_instance();
        $CI->load->model($model_name);
        return $CI->$model_name;
    }
    
    function cekKBK($id_kbk='', $dialog='') 
    {
        $hasil = null;
        $this->db->select("ID_KBK");
        $this->db->from("kbk");
        $this->db->where("ID_KBK", $this->db->escape_like_str($id_kbk));
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
                $this->lib_alert->warning("KBK tidak ditemukan");
                redirect("error/index/".$dialog);
            }
        }
    }

    function cekDosen($nip="", $dialog="") 
    {
        $nip = $this->db->escape_like_str($nip);
        $hasil = null;
        $this->db->select("NIP, NIP2010");
        $this->db->from("dosen");
        $this->db->where("NIP", $nip);
        $this->db->or_where("NIP2010", $nip);
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
                $this->lib_alert->warning("Dosen tidak ditemukan");
                redirect("error/index/".$dialog);
            }
        }
    }

    function fieldDosen($field="", $nip="") 
    {        
        $this->db->select("$field");
        $this->db->from("dosen");
        $this->db->where("NIP", $this->db->escape_like_str($nip));
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0) 
            return $query->row()->$field;
        else
            return '-';
    }
    
    function nip2010($nip="") 
    {
        $nip = $this->db->escape_like_str($nip);
        $this->db->select("NIP2010");
        $this->db->from("dosen");
        $this->db->where("NIP", $nip);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0) 
        {
            $row = $query->row();
            if($row->NIP2010 == "")
                return $nip;
            else
                return $row->NIP2010;
        } 
        else 
        {
            return '-';
        }
    }
    
    function detailKBK($id_kbk) 
    {
        $this->db->select("*");
        $this->db->from("kbk");
        $this->db->where('ID_KBK', $this->db->escape_like_str($id_kbk));
        $query = $this->db->get();
        return $query->row();
    }

    function listKBK($nip="", $id_kbk="") 
    {
        $nip = $this->db->escape_like_str($nip);
        $id_kbk = $this->db->escape_like_str($id_kbk);
        if(empty($nip))
        {
            $sql = "SELECT * FROM kbk";
            if(! empty ($id_kbk))
                $sql .= " WHERE ID_KBK = $id_kbk";
        }
        else
        {
            $sql = "( SELECT kbk.* FROM kbk, kbk_dosen WHERE kbk.ID_KBK = kbk_dosen.ID_KBK AND kbk_dosen.NIP = '$nip' ) union ( SELECT * FROM kbk where ID_KBK = '0' )";
        }
        $query = $this->db->query($sql);
        return $query->result();
    }

    function listDosen($rmk='') 
    {
        
        $this->db->select("dosen.*");
        $this->db->from("dosen");
        $this->db->join('kbk_dosen','dosen.NIP = kbk_dosen.NIP');
        $this->db->not_like('dosen.NIP', '0000', 'after'); // kecuali NIP berawalan 00000 (admin, admin kbk)
        $this->db->not_like('dosen.NIP', '051100009'); // kecuali NIP 
        $this->db->not_like('dosen.NIP', '000011111'); // kecuali NIP 
        $this->db->not_like('dosen.NIP', '051100006'); // kecuali NIP 
        $this->db->not_like('dosen.NIP', '051100001'); // kecuali NIP 
        $this->db->order_by('dosen.NAMA_DOSEN', 'ASC');
        $this->db->where('dosen.status_dosen',2);
        if($rmk != '')
        {            
            $this->db->where('kbk_dosen.ID_KBK',$rmk);
        }
        else
        {
            $this->db->distinct();
        }
        $query = $this->db->get();
        return $query->result();
    }

    function namaDosen($nip = NULL, $nip2010 = NULL) {
        $this->db->select("NAMA_LENGKAP_DOSEN");
        $this->db->from("dosen");
        $this->db->not_like('dosen.NIP', '0000', 'after');
        if ($nip) {
            $this->db->where("NIP",$nip);
        }
        if ($nip2010) {
            $this->db->where("NIP2010",$nip2010);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $nama = $query->row();
            return $nama->NAMA_LENGKAP_DOSEN;
        }
        else {
            return NULL;
        }
    }
}
?>