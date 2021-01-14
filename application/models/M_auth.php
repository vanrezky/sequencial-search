<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class M_auth extends CI_Model
{

    public function get_user_login()
    {
        $email = (decode($this->session->userdata('email')));
        
        $this->db->select('*');
        $this->db->from('tb_user');
        $this->db->join('tb_user_role', 'tb_user.role_id=tb_user_role.id', 'left');
        $this->db->where('email', $email);
        $info = $this->db->get();
        return $info->row_array();
    }

    public function getLoginData($data)

    {

        $email = $this->input->post('email', true); // dari form input email
        $password = $this->input->post('password', true); //dari form input password

        $user = $this->db->get_where('user', ['email' => $email])->row_array(); //ambil data berdasarkan email

        //jika user ada
        if ($user) {
            //jika user aktif
            if ($user['aktif'] == 1) {
                // cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => (encode($user['email'])),
                        'role_id' => (encode($user['role_id'])),
                    ];
                    $this->session->set_userdata($data);
                    redirect('dashboard');

                } else {
                    $this->session->set_flashdata('message', flashdata('Password Salah!', 'danger'));
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', flashdata('Account Tidak Aktif!', 'danger'));
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', flashdata('Email belum terdaftar!', 'danger'));
            redirect('auth');
        }
    }
}
