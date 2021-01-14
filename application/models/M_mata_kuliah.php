<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
class M_mata_kuliah extends CI_Model
{

    function get_all_mata_kuliah($number="", $offset="", $search="")
    {   
        // if (!empty($search)) $this->db->like('nama_mata_kuliah', $search, 'both');
        return $this->db->select('mata_kuliah.*')
                        ->order_by('mata_kuliah.semester', 'ASC')
                        ->get('mata_kuliah', $number, $offset);
    }

    function get_mata_kuliah_id($param = "")
    {
        return $this->db->get_where('mata_kuliah', ['id_mata_kuliah' => $param])->row_array();
    }

    function insert_mata_kuliah_id($data)
    {
        return $this->db->insert('mata_kuliah', $data);
    }

    function update_mata_kuliah_id($param, $data)
    {
        return $this->db->update('mata_kuliah', $data, array('id_mata_kuliah' => $param));
    }
    

    public function delete_mata_kuliah_info($id) // delate barang
    {
        $this->db->where('id_mata_kuliah', $id);
        return $this->db->delete('mata_kuliah');
    }

}