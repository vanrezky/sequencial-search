<?php
class MY_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('m_auth', 'MAUTH');
        $this->load->model('m_menu', 'MMENU');
    }

    function render($view, $data)
    {
        if ($this->session->has_userdata('email')) {
            $title['title'] = $data['title'];
            $role_id = decode($this->session->userdata('role_id'));
            $menu_array = array();
            $menu = $this->MMENU->get_menu($role_id);

            foreach ($menu as $row => $value) {
                $id = $value['id'];
                $menu_array[] = array(
                    'menu_utama' => $value,
                    'sub' => $this->MMENU->get_sub_menu($id),

                );
            }
            $sidebar['navigasi'] = $menu_array;
            $sidebar['user'] = $this->db->get_where('user', ['email' => decode($this->session->userdata('email'))])->row_array();

            $this->load->view('backend/templates/header', $title);
            $this->load->view('backend/templates/navbar');
            $this->load->view('backend/templates/sidebar', $sidebar);
            $this->load->view('backend/templates/csrf');
            $this->load->view('backend/' . $view, $data);
            $this->load->view('backend/templates/sidebar_right');
            $this->load->view('backend/templates/footer');
        } else {
            redirect('auth');
        }
    }



    function public($view, $data, $home = FALSE)
    {

        $title['title'] = $data['title']; #ambil title dari controller
        
        $navbar = [];
        $navbar['kategori'] = $this->db->get_where('kategori', ['publish' => 1])->result_array();  #load kategori yang dipublish
        $navbar['halaman'] = $this->db->select('slug, judul')->get_where('halaman', ['publish' => 1])->result_array();
        $this->load->view('frontend/templates/header', $title);
        $this->load->view('frontend/templates/navbar', $navbar);

        if ($home === TRUE) {
            #load view slider
            $this->load->view('frontend/templates/slider');
            #load view service (kategori)
            $this->load->view('frontend/templates/kategori', $navbar);
        } else {
            $this->load->view('frontend/templates/breadcrumb');
        }

        $this->load->view($view, $data); #load view dari controller dan data

        // $this->load->view('frontend/templates/brand');

        #load view footer dan script
        $this->load->view('frontend/templates/footer');
        $this->load->view('frontend/templates/script');
    }
}
