<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Halaman extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_halaman', 'halaman');
        is_logged_in();
    }

    public function index()
    {
        $per_page = '10';
        $total = $this->halaman->get_all_halaman();
        $data = $this->halaman->get_all_halaman($per_page, Offset());

        $D = [
            'title' => 'Daftar halaman',
            'pagin' => Pagin('halaman/index', $total->num_rows(), $per_page),
            'data' => $data->result_array(),
        ];

        $this->render('v_halaman_index', $D);
    }

    public function data($param = "")
    {
        $halaman = new $this->halaman;
        $param = decode($param); #decode parameter

        $D = [
            'title' => 'Data halaman',
            'data' => $halaman->get_halaman_id($param),
            'edit' => $param ? TRUE : FALSE,
        ];

        $this->render('v_halaman_data', $D);
    }

    public function simpan($param = "")
    {
        $param = decode($param);
        $csrfNewHash = $this->security->get_csrf_hash();
        $D = ['success' => FALSE, 'message' => 'Tidak ada perintah', 'csrfNewHash' => $csrfNewHash];

        //========= form validation start ==================
        $this->form_validation->set_rules('judul', 'Judul halaman', 'trim|required', [
            'required' => 'Judul halaman tidak boleh kosong!'
        ]);
        $this->form_validation->set_rules('isi', 'Isi halaman', 'trim|required', [
            'required' => 'Isi halaman tidak boleh kosong!'
        ]);
        $this->form_validation->set_rules('publish', 'Pulikasi halaman', 'trim|required', [
            'required' => 'Pulikasi halaman tidak boleh kosong!'
        ]);
        // ================== end validation start ==================

        if ($this->form_validation->run() == FALSE) { #jika form tidak valid
            $error = validation_errors();
            $D = ['success' => FALSE, 'message' => $error, 'csrfNewHash' => $csrfNewHash];
        } else {
            $judul = htmlspecialchars($this->input->post('judul', true));
            $slug = strtolower(str_replace(' ', '-', $judul));
            $data = array();
            $data['judul'] = htmlspecialchars($this->input->post('judul', true));
            $data['slug'] = $slug;
            $data['isi'] = htmlspecialchars($this->input->post('isi', true));
            $data['publish'] = htmlspecialchars($this->input->post('publish', true));
        }
        if ($param) {
            $data['date_update'] = current_timestamp();
        } else {
            $data['date_created'] = current_timestamp();
        }
        if ($param) {
            $this->halaman->update_halaman_info($param, $data);
            $D = ['success' => TRUE, 'message' => 'halaman berhasil diperbaharui!'];
        } else {
            $this->halaman->simpan_halaman_info($data);
            $D = ['success' => TRUE, 'message' => 'halaman berhasil disimpan!'];
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
            $success = $this->halaman->delete_halaman_info($param);
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

    public function changePublish($param = "")
    {
        $param = decode($param); // decode paramenter
        $csrfNewHash = $this->security->get_csrf_hash();
        $D = ['success' => FALSE, 'message' => 'Tidak ada perintah', 'csrfNewHash' => $csrfNewHash]; // tidak ada perintah

        if ($param) {
            $data = $this->db->select('publish')->get_where('halaman', ['id' => $param])->row_array();
            $S['publish'] = $data['publish'] == 1 ? 0 : 1;

            $success = $this->halaman->update_halaman_info($param, $S);

            if ($success) {
                $D = [
                    'success' => TRUE,
                    'message' => ($data['publish'] == 1 ? 'halaman berhasil di unpublish!' : 'halaman berhasil di publish!'),
                    'btn' => ($data['publish'] == 1 ? 'btn-warning' : 'btn-success'),
                    'csrfNewHash' => $csrfNewHash
                ];
            } else {
                $D = ['success' => TRUE, 'message' => 'halaman gagal dipublikasi!', 'csrfNewHash' => $csrfNewHash];
            }
        }
        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }
}
