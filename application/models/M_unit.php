<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
class M_unit extends CI_Model
{

    function get_all_unit($number="", $offset="", $search="")
    {   
        if ($search == 'FAKULTAS') {
            $this->db->where('jenis_unit', '2');
        } else {
            $this->db->where('induk_unit', $search);
        }
        
        return $this->db->get('unit', $number, $offset);
    }

    function get_unit_id($param = "")
    {
        return $this->db->get_where('unit', ['id_unit' => $param])->row_array();
    }

    function insert_unit_id($data)
    {
        return $this->db->insert('unit', $data);
    }

    function update_unit_id($param, $data)
    {
        return $this->db->update('unit', $data, array('id_unit' => $param));
    }
    

    public function delete_unit_info($id) // delate unit
    {
        $this->db->where('id_unit', $id);
        return $this->db->delete('unit');
    }

}