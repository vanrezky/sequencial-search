<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_orderan extends CI_Model
{

    function get_all_orderan($number = "", $offset = "", $search = "")
    {
        $search = $this->input->cookie('forderan');
        $this->db->select("orderan.*, costumer.c_nama, costumer.c_nohp, (
					SELECT SUM(OD.`produk_qty`) 
					FROM orderan_detail OD
					WHERE OD.`orderan_id` = orderan.id
				)items");
        // if (!empty($search)) $this->db->like('email', $search, 'both')->or_like('role', $search, 'both');
        $this->db->join('costumer', 'orderan.email_customer=costumer.c_email', 'INNER');
        $this->db->order_by('id', 'DESC');
        return $this->db->get('orderan', $number, $offset);
    }

    //==> ambil semua data orderan berdasarkan id
    function getInfo($param = "")
    {
        return $this->db->get_where('orderan', ['id' => $param])->row_array();
    }

    //==> ambil semua data orderan detail berdasarkan id orderan
    function getInfoDetail($param = "")
    {
        $this->db->select('OD.*, (
					SELECT W.`warna`
                    FROM warna W
                    WHERE OD.`warna_id` = W.id
                    LIMIT 1
				)warna, (
					SELECT U.`ukuran`
                    FROM ukuran U
                    WHERE OD.`ukuran_id` = U.id
                    LIMIT 1
				)ukuran');
        $this->db->where('OD.orderan_id', $param);
        $query = $this->db->get('orderan_detail OD');
        return $query->result_array();
    }

    // ambil data costumer berdasarkan email
    function getCostumer($email)
    {
        $this->db->select('*');
        $this->db->where('c_email', $email);
        return $this->db->get('costumer')->row_array();
    }
    public function updateInfo($id = "", $data = "") // update orderan
    {
        $this->db->where('id', $id);
        return $this->db->update('orderan', $data);
    }
}
