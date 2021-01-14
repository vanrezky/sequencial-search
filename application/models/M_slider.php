<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
class M_slider extends CI_Model
{
    public function update_info($id, $data){
        $this->db->where('id', $id);
        return $this->db->update('slider', $data);
    }

}