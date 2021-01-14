<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
class M_gedung extends CI_Model
{

    function get_all_gedung($number="", $offset="", $search="")
    {
        return $query = $this->db->order_by('id_gedung', 'DESC')->get('gedung', $number, $offset);
    }

    function get_gedung_id($param = "")
    {
        return $this->db->get_where('gedung', ['id_gedung' => $param])->row_array();
    }

    public function delete_gedung_info($id_gedung)
    {
        $this->db->where('id_gedung', $id_gedung);
        return $this->db->delete('gedung');
    }

}