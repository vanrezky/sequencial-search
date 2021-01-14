<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_web', 'web');
    }

    public function index($slug = "")
    {
        $D = [
            'title' => 'Daftar Produk',
            'kategori' => $this->web->get_all_kategori(),
            'min' => $this->db->select_min('harga_baru', 'min')->get('produk')->row()->min,
            'max' => $this->db->select_max('harga_baru', 'max')->get('produk')->row()->max,
            'slug' => $slug,
        ];
        $this->public('frontend/v_kategori_index', $D);
    }
}
