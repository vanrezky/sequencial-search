<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_costumer extends CI_Model
{

    function get_all_costumer($number = "", $offset = "", $search = "")
    {
        $search = $this->input->cookie('fcostumer');
        if (!empty($search)) $this->db->like('email', $search, 'both')->or_like('role', $search, 'both');
        $this->db->order_by('id', 'DESC');
        return $this->db->get('costumer', $number, $offset);
    }

    function get_costumer_id($param = "")
    {
        return $this->db->get_where('costumer', ['id' => $param])->row_array();
    }

    public function delete_costumer_info($id) // delate costumer
    {
        $this->db->where('id', $id);
        return $this->db->delete('costumer');
    }

    public function update_costumer_info($id = "", $data = "") // update costumer
    {
        $this->db->where('id', $id);
        return $this->db->update('costumer', $data);
    }
}
