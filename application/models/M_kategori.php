<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
class M_kategori extends CI_Model
{

    function get_all_kategori($number="", $offset="", $search="")
    {
        $search = $this->input->cookie('fKategori');
        if(!empty($search))$this->db->like('nm_kategori', $search, 'both');
        return $this->db->order_by('urutan', 'ASC')->get('kategori', $number, $offset);
    }

    function get_kategori_id($param = "")
    {
        return $this->db->get_where('kategori', ['id' => $param])->row_array();
    }

    public function delete_kategori_info($id) // delate kategori
    {
        $this->db->where('id', $id);
        return $this->db->delete('kategori');
    }

    public function update_kategori_info($id= "", $data= "") // update kategori
    {
        $this->db->where('id', $id);
        return $this->db->update('kategori', $data);
    }

}