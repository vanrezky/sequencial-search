<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
	public function get_content_dashboard()
	{
		$this->db->select("(
					SELECT COUNT(CS.`id`) 
					FROM costumer CS
				) costumer,(
					SELECT COUNT(P.`id`) 
					FROM produk P
				) produk,(
					SELECT COUNT(K.`id`) 
					FROM kategori K
				) kategori,(
					SELECT COUNT(O.`id`) 
					FROM orderan O
				) orderan");
		$query = $this->db->get();
		return $query->row_array();
	}

	public function getPesanan()
	{
		$this->db->select("O.*,(
					SELECT SUM(OD.`produk_qty`) 
					FROM orderan_detail OD
					WHERE OD.`orderan_id` = O.id
				)items,(
					SELECT P.`gambar`
                    FROM orderan_detail OD2
                    LEFT JOIN produk P ON OD2.`produk_id` = P.`id`
                    WHERE OD2.`orderan_id` = O.id
                    LIMIT 1
				)gambar");
		$this->db->order_by('O.id', 'DESC');
		$this->db->limit('15');
		return $this->db->get('orderan O')->result_array();
	}
}
