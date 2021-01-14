<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruangan extends MY_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model('m_ruangan','ruangan');
	}

	public function index()
	{	

        $per_page = '50';
		$total = $this->ruangan->get_all_ruangan();
		$search = decode($this->input->cookie('fruangan'));
		$data = $this->ruangan->get_all_ruangan($per_page, Offset(), $search);

		$D = [
			'title' => 'Daftar ruangan (Program Studi)',
			'pagin' => Pagin('master/ruangan/index', $total->num_rows(), $per_page),
			'data' => $data->result_array(),
			'gedung' => $this->db->order_by('nm_gedung', 'ASC')->get('gedung')->result_array(),
		];
		
		$this->render('v_ruangan_index', $D);
	}
	
	function data($param = "") {

		$param = decode($param);

		if (!isset($param)) {
			$this->form_validation->set_rules('kode_ruangan', 'Kode Ruangan', 'trim|required|is_unique[ruangan.kode_ruangan]', [
				'is_unique' => 'Kode Ruangan sudah terdaftar!',
				'required' => 'Kode Ruangan tidak boleh kosong!',
			]);
		}
		
		$this->form_validation->set_rules('nama_ruangan', 'Nama Ruangan', 'trim|required', [ 
			'required' => 'Nama Ruangan tidak boleh kosong!'
		]);
		$this->form_validation->set_rules('id_unit', 'Unit' , 'trim|required', [ 
			'required' => 'Unit tidak boleh kosong!'
		]);
		$this->form_validation->set_rules('id_gedung', 'Gedung' , 'trim|required', [ 
			'required' => 'Gedung tidak boleh kosong!'
		]);
		$this->form_validation->set_rules('kuota', 'Unit' , 'trim|required', [ 
			'required' => 'Kuota tidak boleh kosong!'
		]);
		if ($this->form_validation->run() == false) {
			$D = [
				'title' => 'Data ruangan',
				'data' => $this->ruangan->get_ruangan_id($param),
				'gedung' => $this->db->order_by('nm_gedung', 'ASC')->get('gedung')->result_array(),
				'unit' => $this->db->get_where('unit', ['jenis_unit' => '3'])->result_array()
			];
			$this->render('v_ruangan_data', $D);
		} else {
			$data = [
				'kode_ruangan' => $this->input->post('kode_ruangan', true),
				'nama_ruangan' => $this->input->post('nama_ruangan', true),
				'id_unit' => $this->input->post('id_unit', true),
				'id_gedung' => $this->input->post('id_gedung', true),
				'kuota' => $this->input->post('kuota', true),
			];

			if ($param) {
				$update = $this->ruangan->update_ruangan_id($param, $data);

				if ($update) {
					$this->session->set_flashdata('message', flashdata('Data berhasil diperbaharui!', 'success'));
				} else {
					$this->session->set_flashdata('message', flashdata('Data berhasil gagal diperbaharui!', 'danger'));
				}	
			} else {
				$insert = $this->ruangan->insert_ruangan_id($data);

				if ($insert) {

					$this->session->set_flashdata('message', flashdata('Data berhasil disimpan!', 'success'));
				} else {
					$this->session->set_flashdata('message', flashdata('Data berhasil gagal disimpan!', 'danger'));
				}
			}

			redirect('master/ruangan','refresh');
			
		}
	}

	public function delete($param)
    {
		$param = decode($param);
		$D = ['success' => FALSE, 'message' => 'Tidak ada perintah!'];
		$success = $this->ruangan->delete_ruangan_info($param);
		if ($success) {
			$D = ['success' => TRUE, 'message' => 'Data Berhasil dihapus'];
		} else {
			$D = ['success' => FALSE, 'message' => 'Data gagal dihapus'];
		}
		header('Content-Type: application/json'); 
		echo json_encode($D);
		exit();
    }
    
    
}
