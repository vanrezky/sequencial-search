<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
class M_produk extends CI_Model
{

    function get_all_produk($number="", $offset="")
    {
        $search = $this->input->cookie('fProduk');
        
        $this->db->select('P.*, B.nm_brand, K.nm_kategori');
        $this->db->join('brand B', 'P.brand=B.id', 'left');
        $this->db->join('kategori K', 'P.kategori=K.id', 'left');
        $this->db->order_by('P.id', 'DESC');
        if(!empty($search))$this->db->like('title', $search, 'both')->or_like('deskripsi_singkat', $search, 'both');
        return $this->db->get('produk P', $number, $offset);
    }

    function get_produk_id($param = "")
    {
        return $this->db->get_where('produk', ['id' => $param])->row_array();
    }

    public function delete_produk_info($id) // delate produk
    {
        $this->db->where('id', $id);
        return $this->db->delete('produk');
    }

    public function simpan_produk_info($data){
        return $this->db->insert('produk', $data);
    }

    public function update_produk_info($id= "", $data= "") // update produk
    {
        $this->db->where('id', $id);
        return $this->db->update('produk', $data);
    }

}