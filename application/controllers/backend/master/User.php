<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		is_logged_in(); // cek login
		$this->load->model('m_user', 'user');
		$this->load->library('encryption');
	}

	public function index()
	{
		$per_page = '10';
		$total = $this->user->get_all_user();
		$data = $this->user->get_all_user($per_page, Offset());

		$D = [
			'title' => 'Daftar User',
			'pagin' => Pagin('master/user/index', $total->num_rows(), $per_page),
			'data' => $data->result_array(),
		];

		$this->render('v_user_index', $D);
	}

	public function data($param = "")
	{
		$user = new $this->user;
		$param = decode($param);

		$D = [
			'title' => 'Data User',
			'role' => $user->get_all_role(),
			'data' => $user->get_user_id($param),
			'edit' => $param ? TRUE : FALSE,
		];

		$this->render('v_user_data', $D);
	}

	public function simpan($param = "")
	{
		$user = (new $this->user);
		$param = decode($param);
		$csrfNewHash = $this->security->get_csrf_hash();
		$D = ['success' => FALSE, 'message' => 'Tidak ada perintah!', 'csrfNewHash' => $csrfNewHash];

		if (!$param) {
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]', [
				'is_unique' => 'Email sudah terdaftar!',
				'required' => 'Email tidak boleh kosong!',
				'valid_email' => 'Email tidak valid!'
			]);
		}
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required', [
			'required' => 'Nama tidak Boleh Kosong!'
		]);
		if (!$param) {
			$this->form_validation->set_rules('pass1', 'Password', 'trim|required|min_length[4]|matches[pass2]', [
				'required' => 'Password tidak boleh kosong!',
				'min_length' => 'Password terlalu singkat!',
				'matches' => 'Password tidak cocok!'
			]);
			$this->form_validation->set_rules('pass2', 'Password', 'trim|required', [
				'required' => 'Retype Password tidak boleh kosong!',
			]);
		}
		$this->form_validation->set_rules('role_id', 'Role', 'trim|required', [
			'required' => 'Role tidak Boleh Kosong!'
		]);

		if ($this->form_validation->run() == FALSE) {
			$error = validation_errors();
			$D = ['success' => FALSE, 'message' => $error, 'csrfNewHash' => $csrfNewHash];
		} else {

			if ($user->get_user_id($param)) {

				$data = [
					'nama' => htmlspecialchars($this->input->post('nama', true)),
					'role_id' => decode($this->input->post('role_id', true)),
					'aktif' => '1',
				];
				$this->db->update('user', $data, array('id' => $param));
				$D = ['success' => TRUE, 'message' => 'Akun berhasil diupdate!', 'csrfNewHash' => $csrfNewHash];
			} else {

				$data = [
					'nama' => htmlspecialchars($this->input->post('nama', true)),
					'email' => htmlspecialchars($this->input->post('email', true)),
					'image' => 'default.png',
					'role_id' => decode($this->input->post('role_id', true)),
					'aktif' => '1',
					'date_created' => current_timestamp(),
					'password' => password_hash($this->input->post('pass1', true), PASSWORD_DEFAULT)
				];

				$success = $this->db->insert('user', $data);
				$D = ['success' => TRUE, 'message' => 'Akun berhasil ditambahkan!', 'csrfNewHash' => $csrfNewHash];
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
			$success = $this->user->delete_user_info($param);
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

	public function changePassword($param = "")
	{
		$param = decode($param);
		$csrfNewHash = $this->security->get_csrf_hash();
		$D = ['success' => FALSE, 'message' => 'Tidak ada perintah', 'csrfNewHash' => $csrfNewHash];
		if ($param) {

			$this->form_validation->set_rules('pass', 'Password', 'trim|required|min_length[4]', [
				'required' => 'Password tidak boleh kosong!',
				'min_length' => 'Password terlalu singkat!',
			]);

			if ($this->form_validation->run() == FALSE) {
				$D = ['success' => FALSE, 'message' => validation_errors(), 'csrfNewHash' => $csrfNewHash];
			} else {

				$data = array(
					'password' => password_hash($this->input->post('pass', true), PASSWORD_DEFAULT),
				);
				$success = $this->user->update_user_info($param, $data);
				if ($success) {
					$D = ['success' => TRUE, 'message' => 'Password berhasil disimpan!', 'csrfNewHash' => $csrfNewHash];
				} else {
					$D = ['success' => FALSE, 'message' => 'Password gagal diubah!', 'csrfNewHash' => $csrfNewHash];
				}
			}
		}
		header('Content-Type: application/json');
		echo json_encode($D);
		exit();
	}
}
