<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('m_auth','MAUTH');
	}

	public function index()
    {
        if ($this->session->has_userdata('email')) {
            
            redirect('dashboard');
        }
        // validasi email
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [ 
            'required' => 'Email tidak boleh kosong!',
            'valid_email' => 'Email tidak valid!'
        ]);
        // validasi password
        $this->form_validation->set_rules('password', 'Password', 'trim|required', [
            'required' => 'Password tidak boleh kosong!',
        ]);

        if ($this->form_validation->run()== false) { // jika form validasi salah

            $data['title'] = 'Login Page';

            $this->load->view('v_auth_login', $data); // load view

        } else {  
            $dt['email']     = htmlspecialchars($this->input->post('email'));
            $dt['password']  = htmlspecialchars($this->input->post('password'));

            $this->MAUTH->getLoginData($dt);
        }
    }
    
    function logout () {

        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', flashdata('Anda berhasil keluar!', 'success'));
        redirect('auth');
    }
	
	function lupa_password()
	{
		$this->load->view('v_auth_lupa_password');
	}
}
