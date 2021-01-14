<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends MY_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model('m_unit','unit');
	}

	public function index()
	{	

        $per_page = '50';
		$total = $this->unit->get_all_unit();
		$search = decode($this->input->cookie('fIdunit'));
		$data = $this->unit->get_all_unit($per_page, Offset(), $search);

		$D = [
			'title' => 'Daftar Unit (Fakultas / Prodi)',
			'pagin' => Pagin('master/unit/index', $data->num_rows(), $per_page),
			'data' => $data->result_array(),
			'fakultas' => $this->db->get_where('unit', ['jenis_unit' => '2'])->result_array(),
		];
		
		$this->render('v_unit_index', $D);
	}
	
	public function data($param = "") {

		$param = decode($param);

		if (!isset($param)) {
			$this->form_validation->set_rules('kode_unit', 'Kode Lembaga', 'trim|required|is_unique[unit.kode_unit]', [
				'is_unique' => 'Kode Lembaga sudah terdaftar!',
				'required' => 'Kode Lembaga tidak boleh kosong!',
			]);
		}
		
		$this->form_validation->set_rules('nama_unit', 'Nama lembaga', 'trim|required', [ 
			'required' => 'Nama lembaga tidak boleh kosong!'
		]);
		$this->form_validation->set_rules('jenis_unit', 'Jenis lembaga' , 'trim|required', [ 
			'required' => 'Jenis lembaga tidak boleh kosong!'
		]);

		if ($this->input->post('jenis_unit') == 3) {
			$this->form_validation->set_rules('induk_unit', 'Fakultas' , 'trim|required', [ 
				'required' => 'Fakultas harus dipilih!'
			]);
			$this->form_validation->set_rules('idjenjang_unit', 'Jenjang pendidikan' , 'trim|required', [ 
				'required' => 'Jenjang pendidikan harus dipilih!'
			]);
		}

		if ($this->form_validation->run() == false) {
			$D = [
				'title' => 'Data unit',
				'data' => $this->unit->get_unit_id($param),
				'jejang' => $this->db->get('jenjang_unit')->result_array(),
				'unit' => $this->db->get_where('unit', ['jenis_unit' => '2'])->result_array(),
			];
			$this->render('v_unit_data', $D);
		} else {
			$data = [
				'kode_unit' => $this->input->post('kode_unit', true),
				'nama_unit' => $this->input->post('nama_unit', true),
				'jenis_unit' => $this->input->post('jenis_unit', true),
			];

			if ($this->input->post('jenis_unit') == 3) {
				$data['induk_unit'] = $this->input->post('induk_unit', true);
				$data['idjenjang_unit'] = $this->input->post('idjenjang_unit', true);
			}

			if ($param) {
				$update = $this->unit->update_unit_id($param, $data);

				if ($update) {
					$this->session->set_flashdata('message', flashdata('Data berhasil diperbaharui!', 'success'));
				} else {
					$this->session->set_flashdata('message', flashdata('Data berhasil gagal diperbaharui!', 'danger'));
				}	
			} else {
				$insert = $this->unit->insert_unit_id($data);

				if ($insert) {

					$this->session->set_flashdata('message', flashdata('Data berhasil disimpan!', 'success'));
				} else {
					$this->session->set_flashdata('message', flashdata('Data gagal disimpan!', 'danger'));
				}
			}

			redirect('master/unit','refresh');
			
		}

		
	}
    
    public function delete($param = ""){
		$param = decode($param);
		$D = ['success' => FALSE, 'message' => 'Tidak ada perintah'];
		if ($param) {
			$exist = $this->db->get_where('mahasiswa', ['id_unit' => $param])->row_array();
			if ($exist) {
				$D = ['success' => FALSE, 'message' => 'Data telah digunakan'];
			} else {
				
				$success = $this->unit->delete_unit_info($param);
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
}
