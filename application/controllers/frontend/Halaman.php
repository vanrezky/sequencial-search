<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Halaman extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_web', 'web');
    }

    public function detail($slug = "")
    {
        $data = $this->db->get_where('halaman', ['slug' => $slug])->row_array();
        if (!empty($data)) {
            $D = [
                'title' => 'Halaman',
                'data' => $data
                // 'produk_pilihan' => (new $this->web),
                // 'kategori_pilihan' => $this->web->get_kategori_pilihan(),
            ];
            $this->public('frontend/v_halaman_index', $D);
        } else {
            redirect('404');
        }
    }
}
