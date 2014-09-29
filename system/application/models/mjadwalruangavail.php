<?php
class mjadwalruangavail extends Model 
{

    function mjadwalruangavail() 
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

    function field($field="", $id_jdw_ruang_avail="") 
    {
        $this->db->select("$field");
        $this->db->from("jadwal_ruangan_avail");
        $this->db->where("ID_JDW_RUANG_AVAIL", $id_jdw_ruang_avail);
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row()->$field;
        else
            return '-';
    }
    
    function cek($options="", $dialog="") 
    {
        $this->db->select("ID_JDW_RUANG_AVAIL");
        $this->db->from("jadwal_ruangan_avail");
        if(is_array($options))
            $this->db->where($options);
        else
            $this->db->where("ID_JDW_RUANG_AVAIL", $this->db->escape_like_str($options));
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
                $this->lib_alert->warning("Jadwal ruang tidak ditemukan.");
                redirect("error/index/".$dialog);
            }
        }
    }

    function getJadwalRuangAvail($id_jdw_ruang, $treeid, $id_sidangTA) 
    {
        $this->db->select("*");
        $this->db->from("jadwal_ruangan_avail");
        $this->db->where("ID_JDW_RUANG", $id_jdw_ruang);
        $this->db->where('ID_SLOT', $treeid);
        $this->db->where("SIDANGTA", $id_sidangTA);
        $query = $this->db->get();

        return $query->row();
    }

    function getJadwalRuangAvail2($options) {
        $this->db->select("*");
        $this->db->from("jadwal_ruangan_avail");
        $this->db->where($options);
        $this->db->order_by("ID_KBK");
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    // <object array> get list jadwal ruang avail
    function getListJadwaRuangAvail($id_sidangTA, $treeid) {
        $this->db->select("
                jadwal_ruangan_avail.*, jadwal_ruangan.DESKRIPSI
                ");
        $this->db->from("jadwal_ruangan_avail");
        $this->db->from("jadwal_ruangan");
        $this->db->where("jadwal_ruangan_avail.ID_JDW_RUANG = jadwal_ruangan.ID_JDW_RUANG");
        $this->db->where("jadwal_ruangan_avail.ID_SLOT", $treeid);
        $this->db->where("jadwal_ruangan_avail.SIDANGTA", $id_sidangTA);
        $this->db->where("jadwal_ruangan_avail.STATUS", '0');
        $query = $this->db->get();

        return $query->result();
    }

    // tambah jadwal ruangan
    function addJadwalRuangAvail($data) {
        $this->db->insert("jadwal_ruangan_avail", $data);
    }

    // update jadwal ruang avail
    function updateJadwalRuangAvail($data, $id_jdw_ruang_avail) {
        $this->db->update("jadwal_ruangan_avail", $data, array('ID_JDW_RUANG_AVAIL' => $id_jdw_ruang_avail));
    }

    // update jadwal ruang avail
    function updateJadwalRuangAvailBySidangDanRuang($data, $id_sidangTA, $id_jdw_ruang) {
        $this->db->update("jadwal_ruangan_avail", $data, array('SIDANGTA' => $id_sidangTA, 'ID_JDW_RUANG' => $id_jdw_ruang));
    }

    // update jadwal ruang avail
    function updateJadwalRuangAvailWithOptions($data, $options) {
        $this->db->update("jadwal_ruangan_avail", $data, $options);
    }


    // reset jadwal ruangan
    function resetJadwalRuangAvail($id_sidangTA, $id_ruang, $treeid) {
        $data = array(
            'ID_PROPOSAL' => '',
            'STATUS' => '0'
        );

        $this->db->where('SIDANGTA', $id_sidangTA);
        $this->db->where('ID_SLOT', $treeid);
        $this->db->where('ID_JDW_RUANG', $id_ruang);
        $this->db->update("jadwal_ruangan_avail", $data);
    }

    // reset jadwal ruangan
    function resetSemuaJadwalRuangAvail($id_sidangTA) {
        $data = array(
            'ID_PROPOSAL' => '',
            'STATUS' => '0'
        );

        $this->db->where('SIDANGTA', $id_sidangTA);
        $this->db->update("jadwal_ruangan_avail", $data);
    }

    // hapus jadwal ruangan
    function hapusSemuaJadwalRuangAvail($id_sidangTA, $status='') {
        $this->db->where('SIDANGTA', $id_sidangTA);
        if($status != '')
            $this->db->where('STATUS', $status);
        $this->db->delete("jadwal_ruangan_avail");
    }
    
    // hapus jadwal ruangan
    function hapusJadwalRuangAvail($options="") {
        if(is_array($options))
            $this->db->where($options);
        else
            $this->db->where("ID_JDW_RUANG_AVAIL", $this->db->escape_like_str($options));
        $this->db->delete("jadwal_ruangan_avail");
    }

    

}
?>