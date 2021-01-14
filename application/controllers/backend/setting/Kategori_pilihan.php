<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_pilihan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_kategori_pilihan','kategori_pilihan');
    }

    public function index() {
        $D = [
            'title' => 'kategori pilihan',
            'data'  => $this->kategori_pilihan->get_all(),
        ];

		$this->render('v_kategori_pilihan_index', $D);
    }

    public function changePublish($param = "") {
        $param = decode($param);
        $csrfNewHash = $this->security->get_csrf_hash();
        $D = ['success' => FALSE, 'message' => 'Tidak ada perintah!', 'csrfNewHash' => $csrfNewHash]; // tidak ada perintah

        if ($param) {
            $count = $this->db->get_where('kategori', ['kategori_pilihan' => 1 ])->result_array();

            $data = $this->db->get_where('kategori', ['id' => $param])->row_array();
            $S['kategori_pilihan'] = ($data['kategori_pilihan'] == 1 ? 0 : 1);

            if ($data['kategori_pilihan'] == 1) {
                // nonaktifkan kategori
                $this->kategori_pilihan->update_kategori_info($param, $S);
                $D = ['success' => TRUE, 'message' => 'Kategori berhasil dinonaktifkan!', 'btn' => 'btn-warning' , 'csrfNewHash' => $csrfNewHash];
            } else {
                //aktifkan ketegori
                if (count($count) >= 3) {
                    $D = ['success' => FALSE, 'message' => 'Maksimal kategori pilihan berjumlah 3!', 'csrfNewHash' => $csrfNewHash];
                } else {
                $this->kategori_pilihan->update_kategori_info($param, $S);
                $D = ['success' => TRUE, 'message' => 'Kategori berhasil diaktifkan!', 'btn' => 'btn-success', 'csrfNewHash' => $csrfNewHash];
                }
            }
        }

        header('Content-Type: application/json'); 
		echo json_encode($D);
		exit();
    }

}