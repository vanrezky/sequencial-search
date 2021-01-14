<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
class M_informasi extends CI_Model
{
    public function simpan_info($data){
        $this->db->where('id', 1);
        return $this->db->update('setting', $data);
    }

}