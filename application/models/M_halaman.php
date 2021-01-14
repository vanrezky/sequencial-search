<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_halaman extends CI_Model
{

    function get_all_halaman($number = "", $offset = "", $search = "")
    {
        $search = $this->input->cookie('fhalaman');
        $this->db->select("halaman.*");
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('judul', $search, 'both');
            $this->db->like('isi', $search, 'both');
            $this->db->group_end();
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get('halaman', $number, $offset);
    }

    //==> ambil semua data halaman berdasarkan id
    function get_halaman_id($param = "")
    {
        return $this->db->get_where('halaman', ['id' => $param])->row_array();
    }

    public function delete_halaman_info($id) // delate halaman
    {
        $this->db->where('id', $id);
        return $this->db->delete('halaman');
    }

    public function simpan_halaman_info($data)
    {
        return $this->db->insert('halaman', $data);
    }

    public function update_halaman_info($id = "", $data = "") // update halaman
    {
        $this->db->where('id', $id);
        return $this->db->update('halaman', $data);
    }
}
