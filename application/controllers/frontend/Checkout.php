<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checkout extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_web', 'web');
        $this->load->library('cart');
    }

    public function index()
    {
        if (!customer_logged_in()) {
            $this->session->set_flashdata('message', flashdata('<strong>Opps..</strong> Silahkan login terlebih dahulu!', 'danger'));
            redirect('member?link=checkout', 'refresh');
        } else {

            $data = array();

            if (!empty($this->cart->contents())) {
                $empty = false;
                foreach ($this->cart->contents() as $key => $value) {
                    // $total_berat = 0;

                    $data[] = [
                        'name' => $value['name'],
                        'qty'  => $value['qty'],
                        'price' => ($value['price'] * $value['qty'])
                    ];
                }
            } else {
                $this->session->set_flashdata('message', flashdata('Maaf, anda belum memiliki barang di keranjang..', 'danger'));
                redirect('cart', 'refresh');
            }
            $D['title'] = 'Checkout Keranjang';
            $D['data'] = $data;
            $D['subtotal'] = $this->cart->total();
            $D['bank'] = $this->db->get('bank')->result_array();
            $this->public('frontend/v_checkout_index', $D);
        }
    }

    public function order()
    {
        $csrfNewHash = $this->security->get_csrf_hash();
        if (!customer_logged_in()) {
            $D = ['success' => FALSE, 'message' => 'Silahkan login terlebih dahulu!', 'csrfNewHash' => $csrfNewHash];
        } else {
            $this->form_validation->set_rules('nama', 'Nama', 'trim|required', [
                'required' => 'Nama tidak boleh kosong!'
            ]);
            $this->form_validation->set_rules('no_telp', 'No Telp', 'trim|required|numeric', [
                'required' => 'Nomor Handphone tidak boleh kosong!',
                'numeric' => 'Nomor Handphone harus berupa angka!'
            ]);
            $this->form_validation->set_rules('kode_pos', 'Kode Pos', 'trim|required|numeric', [
                'required' => 'Kode Pos tidak boleh kosong!',
                'required' => 'Kode Pos harus berupa angka!',
            ]);
            $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'trim|required', [
                'required' => 'Kecamatan tidak boleh kosong!'
            ]);
            $this->form_validation->set_rules('kelurahan', 'Kelurahan', 'trim|required', [
                'required' => 'Kelurahan tidak boleh kosong!'
            ]);
            $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required', [
                'required' => 'Alamat tidak boleh kosong!'
            ]);
            $this->form_validation->set_rules('ongkir', 'ongkir', 'trim|required', [
                'required' => 'Ongkir tidak boleh kosong!'
            ]);
            $this->form_validation->set_rules('cost', 'cost', 'trim|required', [
                'required' => 'Paket tidak boleh kosong!'
            ]);
            $this->form_validation->set_rules('bank', 'bank', 'trim|required', [
                'required' => 'Silahkan pilih transfer bank!'
            ]);

            if ($this->form_validation->run() == FALSE) {
                $error = validation_errors();
                $D = ['success' => FALSE, 'message' => $error, 'csrfNewHash' => $csrfNewHash];
            } else {
                $total_berat = 0;
                foreach ($this->cart->contents() as $key => $value) {
                    $produk_berat = $this->db->select('berat')->get_where('produk', ['id' => $value['id']])->row()->berat;
                    $berat = $value['qty'] * $produk_berat;
                    $total_berat = $total_berat + $berat;
                }
                $no_rek = $this->db->get_where('bank', ['id' => $this->input->post('bank', true)])->row()->no_rek;
                $no_order = $this->web->no_order();
                $data = [
                    'no_order' => $no_order,
                    'tgl_order' => current_timestamp(),
                    'email_customer' => decode($this->session->userdata('costumer_email')),
                    'provinsi' => $this->input->post('nameProvinsi', true),
                    'kabupaten' => $this->input->post('nameKabupaten', true),
                    'kecamatan' => $this->input->post('kecamatan', true),
                    'kelurahan' => $this->input->post('kelurahan', true),
                    'alamat' => $this->input->post('alamat', true),
                    'kode_pos' => $this->input->post('kode_pos', true),
                    'kurir' => $this->input->post('kurir', true),
                    'paket' => $this->input->post('cost', true),
                    'estimasi' => $this->input->post('estimasi', true),
                    'ongkir' => $this->input->post('ongkir', true),
                    'berat' => $total_berat,
                    'order_total' => $this->cart->total(),
                    'status_bayar' => 'belum',
                    'nama_penerima' => $this->input->post('nama', true),
                    'bank' => $this->input->post('bank', true),
                    'no_rek' => $no_rek,
                    'no_hp' => $this->input->post('no_telp', true),
                    'status_order' => 'Menunggu Pembayaran'
                ];

                $orderanId = $this->web->saveOrderan($data);

                $variasi = 'tidak';
                $warnaId = NULL;
                $ukuranId = NULL;
                foreach ($this->cart->contents() as $key => $value) {
                    $produk = $this->db->select('id, title, berat, harga_baru, kuantitas')->get_where('produk', ['id' => $value['id']])->row();
                    $berat = $value['qty'] * $produk->berat;
                    $total_berat = $total_berat + $berat;
                    $options = $value['options'];
                    if ($options['warna'] != 0) {
                        $variasi = 'ya';
                        $warnaId = $this->db->get_where('warna', ['id' => $options['warna']])->row()->id;
                    }
                    if ($options['ukuran'] != 0) {
                        $variasi = 'ya';
                        $ukuranId = $this->db->get_where('ukuran', ['id' => $options['ukuran']])->row()->id;
                    }

                    $orderan = [
                        'orderan_id' =>  $orderanId,
                        'produk_id' => $produk->id,
                        'produk_nama' => $produk->title,
                        'produk_harga' => $produk->harga_baru,
                        'produk_qty' => $value['qty'],
                        'variasi' => $variasi,
                        'warna_id' => $warnaId,
                        'ukuran_id' => $ukuranId,
                    ];
                    $produkQty = [
                        'kuantitas' => ($produk->kuantitas - $value['qty'])
                    ];
                    $this->web->saveOrderanDetail($orderan);
                    $this->web->updateProdukQty($value['id'], $produkQty);
                }
            }
            $this->cart->destroy();
            $via = strtolower($this->input->post('via', true));
            $url = $via == 'whatsapp' ? '&via=whatsapp' : '';
            $D = ['success' => true, 'message' => 'Berhasil Melakukan Pesanan, Mohon Tunggu..', 'url' => 'member/pesanan?noorder=' . $no_order . $url];
        }
        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }
}
