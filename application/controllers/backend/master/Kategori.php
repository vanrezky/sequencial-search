<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_kategori','kategori');
	}

	public function index()
	{
		$per_page = '10';
		$total = $this->kategori->get_all_kategori();
		$data = $this->kategori->get_all_kategori($per_page, Offset());

		$D = [
			'title' => 'Daftar kategori',
			'pagin' => Pagin('master/kategori/index', $total->num_rows(), $per_page),
			'data' => $data->result_array(),
		];

		$this->render('v_kategori_index', $D);
	}

	public function data($param = "") {
		$kategori = new $this->kategori;
		$data['id'] = '';

		$param = !empty($param) ? decode($param) : '';

		$D = [
			'title' => 'Data Kategori',
			'data' => $kategori->get_kategori_id($param),
		];

		$this->render('v_kategori_data', $D);

			
	}

	public function simpan($param = "") {

		$param = decode($param);
		$csrfNewHash = $this->security->get_csrf_hash();
		$D = ['success' => FALSE, 'message' => 'Tidak ada perintah', 'csrfNewHash' => $csrfNewHash];

		$this->form_validation->set_rules('title', 'Nama kategori', 'trim|required', [ 
			'required' => 'Nama kategori tidak Boleh Kosong!'
		]);
		if (!$param) {
			$this->form_validation->set_rules('slug', 'Slug', 'trim|required|is_unique[kategori.slug]', [
				'is_unique' => 'Slug sudah terdaftar!',
				'required' => 'Slug tidak boleh kosong!',
				]);
			}
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
			$data = [
				'slug' => htmlspecialchars($this->input->post('slug', true)),
				'nm_kategori' => htmlspecialchars($this->input->post('title', true)),
				'deskripsi' => htmlspecialchars($this->input->post('deskripsi', true)),
				'publish' => htmlspecialchars($this->input->post('publish', true)),
				'urutan' => htmlspecialchars($this->input->post('urutan', true)),
			];

			if (!empty($_FILES['gambar']['name'])) {
				$config['upload_path'] = './uploads/kategori/';
				$config['allowed_types'] = 'jpg|png';
				$config['encrypt_name'] = TRUE;

				$this->upload->initialize($config);

				if (!$this->upload->do_upload('gambar')) {
					$error = $this->upload->display_errors();
					array_push($cek, $error);
				}
				else {
					if ($param) {
						$gambar = $this->db->select('gambar')->get_where('kategori', ['id' => $param])->row()->gambar;
						if (!empty($gambar)) {
							unlink('uploads/kategori/'.$gambar);
						}
					}
					
					$post_image = $this->upload->data();

					$config['image_library']='GD2';
					$config['source_image']='./uploads/kategori/'.$post_image['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '100%';
					$config['width']= 62;
					$config['height']= 62;
					$config['new_image']= './uploads/kategori/'.$post_image['file_name'];
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
				$D = ['success' => FALSE, 'message' => "<ol><li>" . implode("</li><li>", $cek) ."</li></ol>", 'csrfNewHash' => $csrfNewHash];
			} else {
				if ($this->kategori->get_kategori_id($param)) {
					$success = $this->db->update('kategori', $data, array('id' => $param));
					
					$D = ['success' => TRUE, 'message' => 'Kategori berhasil diupdate!', 'csrfNewHash' => $csrfNewHash];
				} else {
					$success = $this->db->insert('kategori', $data);
					$D = ['success' => TRUE, 'message' => 'Kategori berhasil disimpan!', 'csrfNewHash' => $csrfNewHash];
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
		
		$D = ['success' => FALSE, 'message' => 'Tidak ada perintah']; // tidak ada perintah
		
		if ($param) {

			$exist = $this->db->get_where('produk', ['kategori' => $param])->row_array(); // cek apakah data sudah digunakan
			if ($exist) {
				$D = ['success' => FALSE, 'message' => 'Data telah digunakan'];

			} else {
				$success = $this->kategori->delete_kategori_info($param); // hapus data

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
			$data = $this->db->get_where('kategori', ['id' => $param])->row_array();
			if ($data) {

				$S['publish'] = $data['publish'] == 1 ? 0 : 1;

				$success = $this->kategori->update_kategori_info($param, $S);

				if ($success) {
					$D = [
						'success' => TRUE, 
						'message' => ($data['publish'] == 1 ? 'Kategori berhasil di unpublish!' : 'Kategori berhasil di publish!'), 
						'btn' => ($data['publish'] == 1 ? 'btn-warning' : 'btn-success') , 
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
