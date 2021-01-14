<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
class M_kategori_pilihan extends CI_Model
{   
    public function get_all() {
        $this->db->select('id,nm_kategori,kategori_pilihan');
        $this->db->where('kategori.publish', 1);
        $this->db->order_by('kategori_pilihan', 'DESC');
        return $this->db->get('kategori')->result_array();
    }

    public function update_kategori_info($id= "", $data= "") 
    {
        $this->db->where('id', $id);
        return $this->db->update('kategori', $data);
    }

    public function hapus_info($id){
        return $this->db->delete('kategori_pilihan', ['id' => $id]);
    }

}