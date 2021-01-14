<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pembayaran extends CI_Model
{

    function get_all_pembayaran($number = "", $offset = "", $search = "")
    {
        $search = $this->input->cookie('fpembayaran');
        $this->db->select("bank.*");
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('id', $search, 'both');
            $this->db->like('atas_nama', $search, 'both');
            $this->db->group_end();
        }

        $this->db->order_by('id', 'DESC');
        return $this->db->get('bank', $number, $offset);
    }

    //==> ambil semua data pembayaran berdasarkan id
    function get_pembayaran_id($param = "")
    {
        if (!empty($param)) {
            return $this->db->get_where('bank', ['id' => $param])->row_array();
        }
        return false;
    }

    public function delete_pembayaran_info($id) // delate pembayaran
    {
        $this->db->where('id', $id);
        return $this->db->delete('bank');
    }

    public function simpan_pembayaran_info($data)
    {
        return $this->db->insert('bank', $data);
    }

    public function update_pembayaran_info($id = "", $data = "") // update pembayaran
    {
        $this->db->where('id', $id);
        return $this->db->update('bank', $data);
    }
}
