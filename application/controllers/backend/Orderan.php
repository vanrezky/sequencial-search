<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orderan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_orderan', 'orderan');
        is_logged_in();
    }

    public function index()
    {
        $per_page = '10';
        $total = $this->orderan->get_all_orderan();
        $data = $this->orderan->get_all_orderan($per_page, Offset());

        $D = [
            'title' => 'Daftar orderan',
            'pagin' => Pagin('orderan/index', $total->num_rows(), $per_page),
            'data' => $data->result_array(),
        ];

        $this->render('v_orderan_index', $D);
    }

    public function info()
    {
        $id = decode($this->input->get('id', true));
        $data = $this->orderan->getInfo($id);
        $tipe = $this->input->get('tipe', true);
        if ($tipe == 'transfer') {
            $bukti_transfer = !empty($data['bukti_bayar']) ? $data['bukti_bayar'] : 'noimage.png';
            $D = [
                'success' => true,
                'bukti_transfer' => base_url('uploads/transfer/' . $bukti_transfer),
            ];
        } else if ($tipe == 'resi') {
            $D = [
                'success' => true,
                'no_resi' => (!empty($data['no_resi']) ? $data['no_resi'] : '')
            ];
        } else {
            $D = [
                'success' => false
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }

    public function resi()
    {
        $csrfNewHash = $this->security->get_csrf_hash();
        $id = decode($this->input->post('id'));
        $this->form_validation->set_rules('no_resi', 'Nama', 'trim');
        $no_resi = $this->input->post('no_resi', true);
        $data = $this->orderan->getInfo($id);
        if (!empty($data)) {
            $data['no_resi'] = $no_resi;
            $update = $this->orderan->updateInfo($id, $data);
            if ($update) {
                $D = [
                    'success' => true,
                    'message' => 'No resi berhasil disimpan',
                    'csrfNewHash' => $csrfNewHash
                ];
            } else {
                $D = [
                    'success' => true,
                    'message' => 'No resi gagal disimpan',
                    'csrfNewHash' => $csrfNewHash
                ];
            }
        } else {
            $D = [
                'success' => false,
                'message' => 'not allowed',
                'csrfNewHash' => $csrfNewHash
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }

    public function detail($id)
    {
        $id = decode($id);
        $orderan = $this->orderan->getInfo($id);
        $orderan_detail = $this->orderan->getInfoDetail($id);
        $costumer = $this->orderan->getCostumer($orderan['email_customer']);

        $D = [
            'title' => 'No Order ' . $orderan['no_order'],
            'orderan' => $orderan,
            'orderan_detail' => $orderan_detail,
            'costumer' => $costumer
        ];

        $this->render('v_orderan_detail', $D);
    }
}
