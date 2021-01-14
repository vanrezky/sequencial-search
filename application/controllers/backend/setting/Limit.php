<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Limit extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_limit','limit');
    }

    public function index() {
        $D = [
            'title' => 'Limit Website',
        ];

		$this->render('v_limit_index', $D);
    }
    
	public function perbarui() {
        $csrfNewHash = $this->security->get_csrf_hash();
        $D = ['success' => FALSE, 'message' => 'Tidak ada perintah!', 'csrfNewHash' => $csrfNewHash];
        
        $this->form_validation->set_rules('produk_terbaru', 'Produk Terbaru', 'trim|required|numeric', [ 
            'required' => 'Limit produk terbaru tidak boleh kosong!',
            'numeric' => 'Limit produk terbaru harus angka!'
        ]);
        $this->form_validation->set_rules('produk_pilihan', 'produk pilihan', 'trim|required|numeric', [ 
            'required' => 'Limit produk pilihan tidak boleh kosong!',
            'numeric' => 'Limit produk pilihan harus angka!'
        ]);
        $this->form_validation->set_rules('brand', 'brand', 'trim|required|numeric', [ 
            'required' => 'Limit brand tidak boleh kosong!',
            'numeric' => 'Limit brand harus angka!'
        ]);
		
		if ($this->form_validation->run() == FALSE) {
            $error = validation_errors();
            $D = ['success' => FALSE, 'message' => $error];
		} else {
            $cek = [];

            $produk_terbaru = htmlspecialchars($this->input->post('produk_terbaru', true));
            $produk_pilihan = htmlspecialchars($this->input->post('produk_pilihan', true));
            $brand = htmlspecialchars($this->input->post('brand', true));

            $min = 4;
            $max = 12;
            if (($produk_terbaru < $min) OR ($produk_terbaru > $max)) array_push($cek, 'Limit produk terbaru minimal 4 dan maximal 8!');
            if (($produk_pilihan < $min) OR ($produk_pilihan > $max)) array_push($cek, 'Limit produk pilihan minimal 4 dan maximal 8!');
            if (($brand < $min) OR ($brand > $max)) array_push($cek, 'Limit brand minimal 4 dan maximal 8!');
            

            if (!empty($cek)) {
                $D = ['success' => FALSE, 'message' => "<ol><li>" . implode("</li><li>", $cek) ."</li></ol>", 'csrfNewHash' => $csrfNewHash];
            } else {
                $data = [
                    'produk_terbaru' => $produk_terbaru,
                    'produk_pilihan' => $produk_pilihan,
                    'brand' => $brand,
                ];
                $this->limit->simpan_info($data);
                $D = ['success' => TRUE, 'message' => 'Data berhasil disimpan!', 'csrfNewHash' => $csrfNewHash];
            }
        }

        header('Content-Type: application/json'); 
		echo json_encode($D);
		exit();
	}

}