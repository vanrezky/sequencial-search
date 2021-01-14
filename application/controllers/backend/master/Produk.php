<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		is_logged_in(); #cek apakah sudah login.
		$this->load->model('m_produk', 'produk'); #load model produk.
		$this->load->library('image_lib'); #load library image
	}

	public function index()
	{
		$per_page = '10'; #banyaknya data yang ditampilkan
		$total = $this->produk->get_all_produk(); #ambil semua data produk
		$data = $this->produk->get_all_produk($per_page, Offset());

		$D = [
			'title' => 'Daftar produk',
			'pagin' => Pagin('master/produk/index', $total->num_rows(), $per_page),
			'data' => $data->result_array(),
		];

		$this->render('v_produk_index', $D);
	}

	public function data($param = "")
	{
		$produk = new $this->produk;
		$param = decode($param); #decode parameter

		$D = [
			'title' => 'Data produk',
			'brand' => $this->db->where('publish', 1)->get('brand')->result_array(),
			'kategori' => $this->db->where('publish', 1)->get('kategori')->result_array(),
			'data' => $produk->get_produk_id($param),
			'warna' => $this->db->get('warna')->result_array(),
			'ukuran' => $this->db->get('ukuran')->result_array(),
			'edit' => $param ? TRUE : FALSE,
		];

		$this->render('v_produk_data', $D);
	}

	public function simpan($param = "")
	{
		$param = decode($param);
		$csrfNewHash = $this->security->get_csrf_hash();
		$D = ['success' => FALSE, 'message' => 'Tidak ada perintah', 'csrfNewHash' => $csrfNewHash];
		#==================== Start Form validasi==============
		$this->form_validation->set_rules('title', 'Nama Produk', 'trim|required', [
			'required' => 'Nama produk tidak boleh kosong!'
		]);
		if (!$param) {
			$this->form_validation->set_rules('slug', 'Slug', 'trim|required|is_unique[produk.slug]', [
				'is_unique' => 'Slug sudah terdaftar!',
				'required' => 'Slug tidak boleh kosong!',
			]);
		}
		$this->form_validation->set_rules('harga_baru', 'Harga Baru', 'trim|required|numeric', [
			'required' => 'Harga baru tidak boleh kosong!',
			'numeric' => 'Harga baru harus berupa angka!'
		]);
		$this->form_validation->set_rules('harga_lama', 'Harga lama', 'trim|numeric', [
			'numeric' => 'Harga lama harus berupa angka!'
		]);
		$this->form_validation->set_rules('kuantitas', 'Kuantitas', 'trim|numeric', [
			'numeric' => 'Kuantitas harus berupa angka!'
		]);
		$this->form_validation->set_rules('berat', 'Berat', 'trim|required|numeric', [
			'required' => 'Berat tidak boleh kosong!',
			'numeric' => 'Berat harus berupa angka!'
		]);
		$this->form_validation->set_rules('deskripsi_singkat', 'Deskripsi Singkat', 'trim|required', [
			'required' => 'Deskripsi singkat tidak boleh kosong!'
		]);
		$this->form_validation->set_rules('brand', 'Brand', 'trim|required', [
			'required' => 'Brand tidak boleh kosong!'
		]);
		$this->form_validation->set_rules('kategori', 'Kategori', 'trim|required', [
			'required' => 'Kategori tidak boleh kosong!'
		]);
		$this->form_validation->set_rules('publish', 'Publish', 'trim|required', [
			'required' => 'Publish tidak boleh kosong!'
		]);
		# ================== end form validasi ====================

		if ($this->form_validation->run() == FALSE) { #jika form tidak valid
			$error = validation_errors();
			$D = ['success' => FALSE, 'message' => $error, 'csrfNewHash' => $csrfNewHash];
		} else {
			# data yang akan dimasukkan ke tabel produk
			$data = array();
			$data['title'] = htmlspecialchars($this->input->post('title', true));
			$data['slug'] = htmlspecialchars($this->input->post('slug', true));
			$data['harga_baru'] = htmlspecialchars($this->input->post('harga_baru', true));
			$data['harga_lama'] = htmlspecialchars($this->input->post('harga_lama', true));
			$data['kuantitas'] = htmlspecialchars($this->input->post('kuantitas', true));
			$data['deskripsi_singkat'] = htmlspecialchars($this->input->post('deskripsi_singkat', true));
			$data['deskripsi'] = htmlspecialchars($this->input->post('deskripsi', true));
			$data['kategori'] = htmlspecialchars($this->input->post('kategori', true));
			$data['brand'] = htmlspecialchars($this->input->post('brand', true));
			$data['publish'] = htmlspecialchars($this->input->post('publish', true));
			$data['berat'] = htmlspecialchars($this->input->post('berat', true));
			//variasi
			$warna = $this->input->post('warna', true);
			$ukuran = $this->input->post('ukuran', true);

			$data['variasi'] = (!empty($warna)  ? 1 : (!empty($ukuran) ? 1 : 0));
			$data['warna'] = !empty($warna) ? implode(',', $warna) : NULL;
			$data['ukuran'] = !empty($ukuran) ? implode(',', $ukuran) : NULL;

			if ($param) {
				$data['date_update'] = current_timestamp();
			} else {
				$data['user'] = decode($this->session->userdata('email'));
				$data['date_created'] = current_timestamp();
			}

			if (!empty($_FILES['gambar']['name'])) {
				$config['upload_path'] = './uploads/produk/';
				$config['allowed_types'] = 'jpg|png';
				$config['encrypt_name'] = TRUE;

				$this->upload->initialize($config);

				if (!$this->upload->do_upload('gambar')) {
					$error = $this->upload->display_errors();
					array_push($cek, $error);
				} else {
					if ($param) {
						$gambar = $this->db->select('gambar')->get_where('produk', ['id' => $param])->row()->gambar;
						if (!empty($gambar)) {
							unlink('uploads/produk/' . $gambar);
							unlink('uploads/produk/medium/' . $gambar);
							unlink('uploads/produk/small/' . $gambar);
						}
					}
					$post_image = $this->upload->data();

					$config['image_library'] = 'GD2';
					$config['source_image'] = './uploads/produk/' . $post_image['file_name'];
					$config['create_thumb'] = FALSE;
					$config['maintain_ratio'] = FALSE;
					$config['quality'] = '100%';
					$config['width'] = 1000;
					$config['height'] = 1000;
					$config['new_image'] = './uploads/produk/' . $post_image['file_name'];
					$this->load->library('image_lib', $config);
					if (!$this->image_lib->resize()) {
						$error = $this->upload->display_errors();
						array_push($cek, $error);
					} else {

						$data['gambar'] = $post_image['file_name'];
						$this->image_lib->clear();
						$this->_create_thumbs($post_image['file_name']);
					}
				}
			}
			if (!empty($cek)) {
				$D = ['success' => FALSE, 'message' => "<ol><li>" . implode("</li><li>", $cek) . "</li></ol>", 'csrfNewHash' => $csrfNewHash];
			} else {
				if ($param) {
					$this->produk->update_produk_info($param, $data);
					$D = ['success' => TRUE, 'message' => 'Produk berhasil diperbaharui!'];
				} else {
					$this->produk->simpan_produk_info($data);
					$D = ['success' => TRUE, 'message' => 'Produk berhasil disimpan!'];
				}
			}
		}
		header('Content-Type: application/json');
		echo json_encode($D);
		exit();
	}

	public function delete($param = "")
	{
		$param = decode($param);
		$D = ['success' => FALSE, 'message' => 'Tidak ada perintah'];
		if ($param) {
			$success = $this->produk->delete_produk_info($param);
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
	private function _create_thumbs($file_name)
	{

		$config = array(
			array(
				'image_library' => 'GD2',
				'source_image' => './uploads/produk/' . $file_name,
				'maintain_ration' => FALSE,
				'width'	=> 250,
				'height' => 250,
				'new_image' => './uploads/produk/medium/' . $file_name,

			),
			array(
				'image_library' => 'GD2',
				'source_image' => './uploads/produk/' . $file_name,
				'maintain_ration' => FALSE,
				'width'	=> 75,
				'height' => 75,
				'new_image' => './uploads/produk/small/' . $file_name,

			),
		);
		$this->load->library('image_lib', $config[0]);
		foreach ($config as $key => $value) {
			$this->image_lib->initialize($value);
			if (!$this->image_lib->resize()) {
				return false;
			} else {
				// return
				$this->image_lib->clear();
			}
		}
	}

	public function changePublish($param = "")
	{
		$param = decode($param); // decode paramenter
		$csrfNewHash = $this->security->get_csrf_hash();
		$D = ['success' => FALSE, 'message' => 'Tidak ada perintah', 'csrfNewHash' => $csrfNewHash]; // tidak ada perintah

		if ($param) {
			$data = $this->db->select('publish')->get_where('produk', ['id' => $param])->row_array();
			$S['publish'] = $data['publish'] == 1 ? 0 : 1;

			$success = $this->produk->update_produk_info($param, $S);

			if ($success) {
				$D = [
					'success' => TRUE,
					'message' => ($data['publish'] == 1 ? 'Produk berhasil di unpublish!' : 'Produk berhasil di publish!'),
					'btn' => ($data['publish'] == 1 ? 'btn-warning' : 'btn-success'),
					'csrfNewHash' => $csrfNewHash
				];
			} else {
				$D = ['success' => TRUE, 'message' => 'Produk gagal dipublikasi!', 'csrfNewHash' => $csrfNewHash];
			}
		}
		header('Content-Type: application/json');
		echo json_encode($D);
		exit();
	}

	function ajaxvariasi()
	{
		$warna = $this->db->get('warna')->result_array();

		$warna_array = array();
		foreach ($warna as $key => $value) {
			$warna_array[] = [
				'id' => $value['id'],
				'warna' => $value['warna']
			];
		}

		$ukuran = $this->db->get('ukuran')->result_array();
		$ukuran_array = array();
		foreach ($ukuran as $key => $value) {
			$ukuran_array[] = [
				'id' => $value['id'],
				'ukuran' => $value['ukuran']
			];
		}

		$D = [
			'warna' => $warna_array,
			'ukuran' => $ukuran_array
		];

		header('Content-Type: application/json');
		echo json_encode($D);
		exit();
	}

	public function detail($param)
	{
		$param = decode($param);
		$data = $this->produk->get_produk_id($param);
		$csrfNewHash = $this->security->get_csrf_hash();
		if (!$param) {
			$D = ['success' => FALSE, 'message' => 'Tidak ada perintah!', 'csrfNewHash' => $csrfNewHash];
		} else {
			if ($data) {

				$H = '';

				$D = ['success' => TRUE, 'data' => $H, 'csrfNewHash' => $csrfNewHash];
			} else {
				$D = ['success' => FALSE, 'message' => 'data produk tidak ditemukan', 'csrfNewHash' => $csrfNewHash];
			}
		}
		header('Content-Type: application/json');
		echo json_encode($D);
		exit();
	}
}
