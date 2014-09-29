<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Lib_tugas_akhir 
{
    var $STATUS = array(
        array('id'=>'0','nama'=>'Mendaftar'),
        array('id'=>'1','nama'=>'Tunggu Sidang Proposal'),
        array('id'=>'11','nama'=>'Revisi'),
        array('id'=>'12','nama'=>'OK'),
        array('id'=>'13','nama'=>'Ditolak'),
        array('id'=>'2','nama'=>'Batal'),
        array('id'=>'3','nama'=>'Maju Sidang'),
        array('id'=>'31','nama'=>'Lulus'),
        array('id'=>'32','nama'=>'Tidak Lulus')
    );
    
    function Lib_tugas_akhir() 
    {       
    }

    function list_status($id_array="") 
    {
        $result = array();
        if(empty($id_array)) 
        {
            for ($j=0; $j<sizeof($this->STATUS); $j++) 
            {
                array_push($result, array(
                    'id'=>$this->STATUS[$j]['id'],
                    'nama'=>$this->STATUS[$j]['nama']
                ));
            }
        } 
        else 
        {
            for($i=0; $i<sizeof($id_array); $i++) 
            {
                for ($j=0; $j<sizeof($this->STATUS); $j++) 
                {
                    if ($this->STATUS[$j]['id'] == $id_array[$i]) 
                    {
                        array_push($result, array(
                            'id'=>$this->STATUS[$j]['id'],
                            'nama'=>$this->STATUS[$j]['nama']
                        ));
                    }
                }
            }
        }
        return $result;
    }
    
    function nama_status($id) 
    {
        $found = false;
        for ($i=0; $i<sizeof($this->STATUS); $i++) 
        {
            if ($this->STATUS[$i]['id']==$id) 
            {
                $found = true;
                $result = $this->STATUS[$i]['nama'];
                break;
            }
        }
        if ($found == false)
            return '-';
        else
            return $result;
    }

    function is_status($id) 
    {
        $found = false;
        for ($i=0; $i<sizeof($this->STATUS); $i++) 
        {
            if ($this->STATUS[$i]['id']==$id) 
            {
                $found = true;
                break;
            }
        }
        return $found;
    }

}
?>
