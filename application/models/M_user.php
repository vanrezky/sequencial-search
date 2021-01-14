<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
class M_user extends CI_Model
{

    function get_all_role(){ 
        $hsl=$this->db->get('user_role')->result_array();
        return $hsl;
    }

    function get_all_user($number="", $offset="", $search="")
    {
        $search = $this->input->cookie('fUser');
        $this->db->join('user_role', 'user_role.id_role=user.role_id', 'left');
        if(!empty($search))$this->db->like('email', $search, 'both')->or_like('role', $search, 'both');
        
        return $this->db->get('user', $number, $offset);
    }

    function get_user_id($param = "")
    {
        return $this->db->get_where('user', ['id' => $param])->row_array();
    }

    public function delete_user_info($id) // delate user
    {
        $this->db->where('id', $id);
        return $this->db->delete('user');
    }

    public function update_user_info($id= "", $data= "") // update user
    {
        $this->db->where('id', $id);
        return $this->db->update('user', $data);
    }

}