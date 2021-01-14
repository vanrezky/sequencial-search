<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_pembayaran', 'pembayaran');
        is_logged_in();
    }

    public function index()
    {
        $per_page = '10';
        $total = $this->pembayaran->get_all_pembayaran();
        $data = $this->pembayaran->get_all_pembayaran($per_page, Offset());

        $D = [
            'title' => 'Daftar pembayaran',
            'pagin' => Pagin('pembayaran/index', $total->num_rows(), $per_page),
            'data' => $data->result_array(),
        ];

        $this->render('v_pembayaran_index', $D);
    }

    public function data($param = "")
    {
        $pembayaran = new $this->pembayaran;
        $param = decode($param); #decode parameter

        $D = [
            'title' => 'Data pembayaran',
            'data' => $pembayaran->get_pembayaran_id($param),
            'edit' => $param ? TRUE : FALSE,
        ];

        $this->render('v_pembayaran_data', $D);
    }

    public function simpan($param = "")
    {

        $param = decode($param);
        $csrfNewHash = $this->security->get_csrf_hash();
        $D = ['success' => FALSE, 'message' => 'Tidak ada perintah', 'csrfNewHash' => $csrfNewHash];


        //========= form validation start ==================
        if (!$param) {
            $this->form_validation->set_rules('nama_bank', 'Atas nama', 'trim|required|is_unique[bank.id]', [
                'is_unique' => 'Nama bank sudah terdaftar!',
                'required' => 'Nama bank tidak boleh kosong',
            ]);
        }
        $this->form_validation->set_rules('atas_nama', 'Atas nama', 'trim|required', [
            'required' => 'Atas nama tidak boleh kosong!'
        ]);
        $this->form_validation->set_rules('no_rek', 'Nomor rekening', 'trim|required|numeric', [
            'required' => 'Nomor rekening tidak boleh kosong!',
            'numeric' => 'Nomor rekening harus berupa angka!'
        ]);
        // ================== end validation start ==================

        if ($this->form_validation->run() == FALSE) { #jika form tidak valid
            $error = validation_errors();
            $D = ['success' => FALSE, 'message' => $error, 'csrfNewHash' => $csrfNewHash];
        } else {
            $data = array();
            $data['atas_nama'] = htmlspecialchars($this->input->post('atas_nama', true));
            $data['no_rek'] = htmlspecialchars($this->input->post('no_rek', true));

            if ($param) {
                $this->pembayaran->update_pembayaran_info($param, $data);
                $D = ['success' => TRUE, 'message' => 'pembayaran berhasil diperbaharui!'];
            } else {
                $data['id'] = htmlspecialchars($this->input->post('nama_bank', true));
                $this->pembayaran->simpan_pembayaran_info($data);
                $D = ['success' => TRUE, 'message' => 'pembayaran berhasil disimpan!'];
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
            $success = $this->pembayaran->delete_pembayaran_info($param);
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
}
