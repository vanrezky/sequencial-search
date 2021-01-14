<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Costumer extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_costumer','costumer');
	}

	public function index()
	{
		$per_page = '10';
		$total = $this->costumer->get_all_costumer();
		$data = $this->costumer->get_all_costumer($per_page, Offset());

		$D = [
			'title' => 'Daftar costumer',
			'pagin' => Pagin('master/costumer/index', $total->num_rows(), $per_page),
			'data' => $data->result_array(),
		];

		$this->render('v_costumer_index', $D);
	}

	public function changePublish($param = "")
    {
		$param = decode($param); // decode paramenter
		$csrfNewHash = $this->security->get_csrf_hash();
		$D = ['success' => FALSE, 'message' => 'Tidak ada perintah', 'csrfNewHash' => $csrfNewHash]; // tidak ada perintah
		
		if ($param) {
			$data = $this->db->select('aktif')->get_where('costumer', ['id' => $param])->row_array();
			$S['aktif'] = $data['aktif'] == 1 ? 0 : 1;

			$success = $this->costumer->update_costumer_info($param, $S);

			if ($success) {
				$D = [
					'success' => TRUE, 
					'message' => ($data['aktif'] == 1 ? 'costumer berhasil di unpublish!' : 'costumer berhasil di publish!'), 
					'btn' => ($data['aktif'] == 1 ? 'btn-warning' : 'btn-success') , 
					'csrfNewHash' => $csrfNewHash
				];
			} else {
				$D = ['success' => TRUE, 'message' => 'costumer gagal dipublikasi!', 'csrfNewHash' => $csrfNewHash];
			}
		}
		header('Content-Type: application/json'); 
		echo json_encode($D);
		exit();

	}


	public function delete($param = ""){
		$param = decode($param);
		$D = ['success' => FALSE, 'message' => 'Tidak ada perintah'];
		if ($param) {
			$success = $this->costumer->delete_costumer_info($param);
			if ($success) {
				$D = ['success' => TRUE, 'message' => 'Data Berhasil dihapus'];
			} else {
				$D = ['success' => FALSE, 'message' => 'Data gagal dihapus'];
			}
			
		}
		header('Content-Type: application/json'); 
		echo json_encode($D);
		exit();

	}
	
	public function preview($id) {
		$id = decode($id);
		$D = ['success' => FALSE, 'message' => 'Tidak ada perintah!'];

		if ($id) {

			$data = $this->costumer->get_costumer_id($id);

			$H = '';
			// $H .= "<li class='list-group-item'><img class='rounded mx-auto d-block img-thumbnail' src='" . base_url('uploads/produk/3da746d6a607b5457e33fafd3997d974.png') . "'></li>";
			$H .= "<li class='list-group-item'><b>Nama:</b> $data[c_nama]</li>";
			$H .= "<li class='list-group-item'><b>Email:</b> $data[c_email]</li>";
			$H .= "<li class='list-group-item'><b>No HP:</b> $data[c_nohp]</li>";
			$H .= "<li class='list-group-item'><b>Alamat:</b> $data[c_alamat]</li>";
			$H .= "<li class='list-group-item'><b>Provinsi:</b> $data[c_provinsi]</li>";
			$H .= "<li class='list-group-item'><b>Kabupaten:</b> $data[c_kabupaten]</li>";
			$H .= "<li class='list-group-item'><b>Kode Pos:</b> $data[c_kodepos]</li>";
			
			$D = [
				'data' => $H,
			];
		}
		
		header('Content-Type: application/json'); 
		echo json_encode($D);
		exit();
	}
}
