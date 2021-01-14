<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
class M_mahasiswa extends CI_Model
{

    function get_all_mahasiswa($number="", $offset="", $search="")
    {
        return $query = $this->db->select('M.nim, M.nm_mhs')
                        ->order_by('nim', 'DESC')
                        ->get('mahasiswa M', $number, $offset);
    }

    function get_mahasiswa_id($param = "")
    {
        return $this->db->get_where('mahasiswa', ['id' => $param])->row_array();
    }

    public function delete_mahasiswa_info($id) // delate barang
    {
        $this->db->where('id', $id);
        return $this->db->delete('mahasiswa');
    }

}