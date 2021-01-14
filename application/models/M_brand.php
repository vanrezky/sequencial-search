<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
class M_brand extends CI_Model
{

    function get_all_brand($number="", $offset="", $search="")
    {
        $search = $this->input->cookie('fBrand');
        if(!empty($search))$this->db->like('nm_brand', $search, 'both');
        return $this->db->order_by('urutan', 'ASC')->get('brand', $number, $offset);
    }

    function get_brand_id($param = "")
    {
        return $this->db->get_where('brand', ['id' => $param])->row_array();
    }

    public function delete_brand_info($id) // delate brand
    {
        $this->db->where('id', $id);
        return $this->db->delete('brand');
    }

    public function update_brand_info($id= "", $data= "") // update brand
    {
        $this->db->where('id', $id);
        return $this->db->update('brand', $data);
    }

    public function save_brand_info($data= "") // save brand
    {
        return $this->db->insert('brand', $data);
    }

}