<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Brand extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_brand', 'brand');
		is_logged_in();
	}

	public function index()
	{
		$data = $this->brand->get_all_brand();

		$D = [
			'title' => 'Daftar brand',
			'data' => $data->result_array(),
		];

		$this->render('v_brand_index', $D);
	}

	public function data($param = "")
	{
		$brand = new $this->brand;
		$param = decode($param);

		$D = [
			'title' => 'Data brand',
			'data' => $brand->get_brand_id($param),
		];

		$this->render('v_brand_data', $D);
	}

	public function simpan($param = "")
	{

		$param = decode($param);
		$csrfNewHash = $this->security->get_csrf_hash();

		$D = ['success' => FALSE, 'message' => 'Tidak ada perintah', 'csrfNewHash' => $csrfNewHash]; // tidak ada perintah

		$this->form_validation->set_rules('nm_brand', 'Nama brand', 'trim|required', [
			'required' => 'Nama brand tidak Boleh Kosong!'
		]);
		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|max_length[150]', [
			'max_length' => 'Maksimum deskripsi adalah 150 huruf!'
		]);
		$this->form_validation->set_rules('urutan', 'Urutan', 'trim|numeric', [
			'numeric' => 'Urutan harus menggunakan angka!'
		]);

		if ($this->form_validation->run() == FALSE) {
			$error = validation_errors();
			$D = ['success' => FALSE, 'message' => $error, 'csrfNewHash' => $csrfNewHash];
		} else {

			$data = array();
			$data['nm_brand'] = htmlspecialchars($this->input->post('nm_brand', true));
			$data['deskripsi'] = htmlspecialchars($this->input->post('deskripsi', true));
			$data['urutan'] = htmlspecialchars($this->input->post('urutan', true));
			$data['publish'] = htmlspecialchars($this->input->post('publish', true));

			if (!empty($_FILES['gambar']['name'])) {
				$config['upload_path'] = './uploads/brand/';
				$config['allowed_types'] = 'jpg|png';
				$config['encrypt_name'] = TRUE;

				$this->upload->initialize($config);

				if (!$this->upload->do_upload('gambar')) {
					$error = $this->upload->display_errors();
					array_push($cek, $error);
				} else {

					if ($param) { //apakah melakukan update
						$gambar = $this->db->select('gambar')->get_where('brand', ['id' => $param])->row()->gambar;
						if (!empty($gambar)) unlink('uploads/brand/' . $gambar); //
					}

					$post_image = $this->upload->data();

					$config['image_library'] = 'GD2';
					$config['source_image'] = './uploads/brand/' . $post_image['file_name'];
					$config['create_thumb'] = FALSE;
					$config['maintain_ratio'] = FALSE;
					$config['quality'] = '90%';
					$config['width'] = 195;
					$config['height'] = 72;
					$config['new_image'] = './uploads/brand/' . $post_image['file_name'];
					$this->load->library('image_lib', $config);
					if (!$this->image_lib->resize()) {
						array_push($cek, $error);
					} else {

						$data['gambar'] = $post_image['file_name'];
						$this->image_lib->clear();
					}
				}
			}
			if (!empty($cek)) {
				$D = ['success' => FALSE, 'message' => "<ol><li>" . implode("</li><li>", $cek) . "</li></ol>", 'csrfNewHash' => $csrfNewHash];
			} else {
				if ($param) {
					$this->brand->update_brand_info($param, $data);
					$D = ['success' => TRUE, 'message' => 'Brand berhasil diperbaharui!', 'csrfNewHash' => $csrfNewHash];
				} else {
					$this->brand->save_brand_info($data);
					$D = ['success' => TRUE, 'message' => 'Brand berhasil disimpan!', 'csrfNewHash' => $csrfNewHash];
				}
			}
		}

		header('Content-Type: application/json');
		echo json_encode($D);
		exit();
	}

	public function delete($param)
	{
		$param = decode($param); // decode paramenter

		if ($param) {

			$exist = $this->db->get_where('produk', ['brand' => $param])->row_array(); // cek apakah data sudah digunakan
			if ($exist) {
				$D = ['success' => FALSE, 'message' => 'Data telah digunakan'];
			} else {
				$success = $this->brand->delete_brand_info($param); // hapus data

				if ($success) {
					$D = ['success' => TRUE, 'message' => 'Data Berhasil dihapus'];
				} else {
					$D = ['success' => FALSE, 'message' => 'Data gagal dihapus'];
				}
			}
		}

		header('Content-Type: application/json');
		echo json_encode($D);
		exit();
	}

	public function changePublish($param = "")
	{
		$param = decode($param); // decode paramenter

		$csrfNewHash = $this->security->get_csrf_hash();
		$D = ['success' => FALSE, 'message' => 'Tidak ada perintah', 'csrfNewHash' => $csrfNewHash]; // tidak ada perintah

		if ($param) {
			$data = $this->db->get_where('brand', ['id' => $param])->row_array();
			if ($data) {

				$S['publish'] = $data['publish'] == 1 ? 0 : 1;

				$success = $this->brand->update_brand_info($param, $S);

				if ($success) {
					$D = [
						'success' => TRUE,
						'message' => ($data['publish'] == 1 ? 'Brand berhasil di unpublish!' : 'Brand berhasil di publish!'),
						'btn' => ($data['publish'] == 1 ? 'btn-warning' : 'btn-success'),
						'csrfNewHash' => $csrfNewHash
					];
				} else {
					$D = ['success' => TRUE, 'message' => 'Kategori gagal dipublikasi!', 'csrfNewHash' => $csrfNewHash];
				}
			}
		}
		header('Content-Type: application/json');
		echo json_encode($D);
		exit();
	}
}
