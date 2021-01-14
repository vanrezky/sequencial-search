<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
class M_ruangan extends CI_Model
{

    function get_all_ruangan($number="", $offset="", $search="")
    {   
        if (!empty($search)) $this->db->like('nama_ruangan', $search, 'both');
        return $this->db->select('ruangan.*, gedung.nm_gedung, unit.nama_unit')
                        ->join('gedung', 'ruangan.id_gedung=gedung.id_gedung', 'LEFT')
                        ->join('unit', 'ruangan.id_unit=unit.id_unit', 'left')
                        ->order_by('ruangan.kode_ruangan', 'ASC')
                        ->get('ruangan', $number, $offset);
    }

    function get_ruangan_id($param = "")
    {
        return $this->db->get_where('ruangan', ['id_ruangan' => $param])->row_array();
    }

    function insert_ruangan_id($data)
    {
        return $this->db->insert('ruangan', $data);
    }

    function update_ruangan_id($param, $data)
    {
        return $this->db->update('ruangan', $data, array('id_ruangan' => $param));
    }
    

    public function delete_ruangan_info($id) // delate barang
    {
        $this->db->where('id_ruangan', $id);
        return $this->db->delete('ruangan');
    }

}