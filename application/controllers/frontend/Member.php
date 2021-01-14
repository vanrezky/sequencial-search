<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_web', 'web');
    }

    public function index()
    {
        if (customer_logged_in()) {
            if (!empty($this->input->get('link'))) {
                redirect($this->input->get('link'), 'refresh');
            }
            redirect('member/akun', 'refresh');
        }
        $D['title'] = 'Masuk/Daftar';
        $this->public('frontend/v_login_register', $D);
    }

    public function masuk()
    {

        if (customer_logged_in()) {
            redirect('home', 'redirect');
        }

        $csrfNewHash = $this->security->get_csrf_hash();
        $D = ['success' => FALSE, 'message' => 'Tidak ada perintah', 'csrfNewHash' => $csrfNewHash];
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
            'required' => 'Email tidak boleh kosong!',
            'valid_email' => 'Email tidak valid!'
        ]);
        // validasi password
        $this->form_validation->set_rules('password', 'Password', 'trim|required', [
            'required' => 'Password tidak boleh kosong!',
        ]);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors();
            $D = ['success' => FALSE, 'message' => $error, 'csrfNewHash' => $csrfNewHash];
        } else {

            $status = $this->web->getLoginData();

            if ($status['stat'] === FALSE) {
                $D = ['success' => FALSE, 'message' => $status['message'], 'label' => 'Opps..', 'csrfNewHash' => $csrfNewHash];
            } else {
                $D = ['success' => TRUE, 'message' => $status['message'], 'label' => 'Berhasil login',  'csrfNewHash' => $csrfNewHash];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }

    public function daftar()
    {
        $csrfNewHash = $this->security->get_csrf_hash();
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required', [
            'required' => 'Nama tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[costumer.c_email]', [
            'is_unique' => 'Email sudah terdaftar!',
            'required' => 'Email tidak boleh kosong!',
            'valid_email' => 'Email tidak valid!'
        ]);
        $this->form_validation->set_rules('pass1', 'Password', 'trim|required|min_length[4]|matches[pass2]', [
            'required' => 'Password tidak boleh kosong!',
            'min_length' => 'Password terlalu singkat!',
            'matches' => 'Password tidak cocok!'
        ]);
        $this->form_validation->set_rules('pass2', 'Password', 'trim|required', [
            'required' => 'Retype Password tidak boleh kosong!',
        ]);

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors();
            $D = ['success' => FALSE, 'message' => $error, 'csrfNewHash' => $csrfNewHash];
        } else {
            $data = array(
                'c_nama' => htmlspecialchars($this->input->post('nama', true)),
                'c_email' => htmlspecialchars($this->input->post('email', true)),
                'c_password' => password_hash($this->input->post('pass1', true), PASSWORD_DEFAULT),
                'aktif' => 1,
                'date_created' => current_timestamp()
            );

            $success = $this->db->insert('costumer', $data);
            if ($success) {
                $D = ['success' => TRUE, 'message' => 'Akun berhasil ditambahkan, silahkan login kembali!', 'csrfNewHash' => $csrfNewHash];
            } else {
                $D = ['success' => TRUE, 'message' => 'Sistem sedang dalam perbaikan, mohon tunggu..', 'csrfNewHash' => $csrfNewHash];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }

    function logout()
    {
        $this->session->unset_userdata('costumer_email');
        $this->load->library('cart');
        $this->cart->destroy();

        $D = ['success' => TRUE, 'message' => 'Anda Berhasil logout, sampai jumpa!'];

        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }

    function akun()
    {
        if (customer_logged_in()) {
            $email = decode($this->session->userdata('costumer_email'));
            $data = $this->web->getCostumer($email);
            $belumBayar = $this->web->getPesananBelumBayar(); //belum bayar
            $dikemas = $this->web->getPesanan('Dikemas'); // pesanan dikemas
            $dikirim = $this->web->getPesanan('Dikirim'); // pesanan dikirim
            $selesai = $this->web->getPesanan('Selesai'); // pesanan selesai
            // var_dump($belumBayar);
            // die;
            $D = [
                'title' => 'Akun saya',
                'data' => $data,
                'belumBayar' => $belumBayar,
                'dikemas' => $dikemas,
                'dikirim' => $dikirim,
                'selesai' => $selesai
            ];

            $this->public('frontend/v_member_akun', $D);
        } else {

            redirect('member', 'refresh');
        }
    }

    public function pesanan()
    {
        if (customer_logged_in()) {

            $no_order = $this->input->get('noorder');
            $data = $this->web->getOrderanDetail($no_order);
            $detail = '';
            if (!empty($data)) {
                $tgl1 = $data['tgl_order'];
                $tgl2 = date('Y-m-d H:i:s', strtotime('+1 days', strtotime($tgl1))); //operasi penjumlahan tanggal sebanyak 1 hari
                $data['tgl_order'] = $tgl2;
                $detail = $this->web->getItemOrder($data['id']);
            }

            // whatsapp
            // whatsapp
            $kontak1 = get_informasi('kontak1');
            $nomorWhatsapp = '62' . ltrim($kontak1, $kontak1[0]);
            $enterLine = '%0A';
            $textWhatsapp = '';
            $textWhatsapp .= "Halo kak, saya mau order,\n\n";
            $no = 1;
            foreach ($detail as $key => $value) {
                $warna_ukuran = '-';
                if (!empty($value['warna']) && !empty($value['ukuran'])) {
                    $warna_ukuran = "$value[warna] Size ($value[ukuran])";
                } else if (!empty($value['warna'])) {
                    $warna_ukuran = "$value[warna]";
                } else if (!empty($value['ukuran'])) {
                    $warna_ukuran = "Size ($value[ukuran])";
                }
                $textWhatsapp .= "*$no. $value[produk_nama]*\n";
                $textWhatsapp .= "- Jumlah : $value[produk_qty]\n";
                $textWhatsapp .= "- Varian : $warna_ukuran\n";
                $textWhatsapp .= "- Harga : (@) Rp." . ifUang($value['produk_harga']) . "\n";
                $textWhatsapp .= "- Harga Total : Rp." . ifUang($value['produk_harga'] * $value['produk_qty']) . "\n\n";
                $no++;
            }
            $textWhatsapp .= "Subtotal : *Rp." . ifUang($data['order_total']) . "*\n";
            $textWhatsapp .= "Ongkir (" . strtoupper($data['kurir']) . " - " . $data['paket'] . ") : *Rp." . ifUang($data['order_total']) . "*\n";
            $textWhatsapp .= "------------------\n";
            $textWhatsapp .= "total : *Rp." . ifUang($data['order_total'] + $data['ongkir']) . "*\n\n";
            $textWhatsapp .= "--------------------------\n\n";
            $textWhatsapp .= "Nama : *$data[nama_penerima] ($data[no_hp])*\n";
            $textWhatsapp .= "Alamat : $data[alamat] $data[kelurahan], $data[kecamatan], $data[kabupaten], $data[provinsi], $data[kode_pos]\n";


            $pesanWhatsapp = "https://api.whatsapp.com/send/?phone=$nomorWhatsapp&text=" . urlencode($textWhatsapp) . "&app_absent=0";

            // $pesanWhatsapp = 'https://api.whatsapp.com/send/?phone=6285272582448&text=Halo+kak%2C+saya+mau+order.+%0A%0A+%2A1.+Asus+Zenfone+MAX+M1+ZB555KL+Smartphone+%5B32GB%2F+3GB%2F+L%5D%2A%0AJumlah%3A+1%0AHarga+%28%40%29%3A+Rp1.260.000%0AHarga+Total%3A+Rp1.260.000%0AKeterangan%3A+-%0A%0ASubtotal%3A+%2ARp1.260.000%2A%0AOngkir%28TIKI+ECO%29%3A+%2ARp33.000%2A%0ATotal%3A+%2ARp1.293.000%2A%0A-----------------------%0A%2ANama%3A%2A%0Aasdasd+%28123123%29%0A%0A%2AAlamat%3A%2A%0Aasdasd+asdasd%2C+adasdsd%2C+Kabupaten+Buleleng%2C+Bali+-+123123%0A%0A&app_absent=0';

            $D = [
                'title' => 'Daftar Pesanan kamu',
                'data' => $data,
                'detail' => $detail,
                'whatsapp' => $pesanWhatsapp
            ];
            $this->public('frontend/v_pesanan_detail', $D);
        } else {
            show_404();
        }
    }

    public function timeoutPesanan()
    {
        // $input = $this->input->post();
        $D = 'not allowed';
        if (customer_logged_in()) {
            $no_order = $this->input->post('no_order', true);
            $data['status_order'] = 'Dibatalkan';
            $update = $this->web->updateOrderan($no_order, $data);
            if ($update) $D = 'Success';
            else $D = 'Failed';
        }
        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }

    public function bukti_transfer($no_order)
    {
        $D = 'not allowed';
        $cek = [];
        if (customer_logged_in()) {
            $no_order = decode($no_order);

            if ($no_order) {

                $csrfNewHash = $this->security->get_csrf_hash();
                if (!empty($_FILES['bukti_transfer']['name'])) {
                    $config['upload_path'] = './uploads/transfer/';
                    $config['allowed_types'] = 'jpg|png';
                    $config['encrypt_name'] = TRUE;

                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('bukti_transfer')) {
                        $error = $this->upload->display_errors();
                        array_push($cek, $error);
                    } else {
                        $post_image = $this->upload->data();
                        $bukti_transfer = $this->db->select('bukti_bayar')->get_where('orderan', ['no_order' => $no_order])->row()->bukti_bayar;
                        if (!empty($bukti_transfer)) {
                            unlink('uploads/transfer/' . $bukti_transfer);
                        }
                    }

                    if (!empty($cek)) {
                        $D = ['success' => FALSE, 'message' => "<ol><li>" . implode("</li><li>", $cek) . "</li></ol>", 'csrfNewHash' => $csrfNewHash];
                    } else {
                        $data = [
                            'bukti_bayar' => $post_image['file_name'],
                            'status_order' => 'Dikemas',
                            'status_bayar' => 'sudah'
                        ];
                        $update = $this->web->updateOrderan($no_order, $data);
                        if ($update) {
                            $D = ['success' => true, 'message' => 'Berhasil upload bukti transfer..'];
                        } else {
                            $D = ['success' => false, 'message' => 'Gagal upload bukti transfer..'];
                        }
                    }
                } else {
                    $D = ['success' => false, 'message' => 'Silahkan upload bukti transfer..', 'csrfNewHash' => $csrfNewHash];
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }

    public function changePassword()
    {
        $D = 'not allowed';
        if (customer_logged_in()) {
            $csrfNewHash = $this->security->get_csrf_hash();
            $D = ['success' => FALSE, 'message' => 'Tidak ada perintah', 'label' => 'Opps..', 'csrfNewHash' => $csrfNewHash];

            $this->form_validation->set_rules('pass1', 'Password', 'trim|required|min_length[4]|matches[pass2]', [
                'required' => 'Password tidak boleh kosong!',
                'min_length' => 'Password terlalu singkat!',
                'matches' => 'Password tidak cocok!'
            ]);
            $this->form_validation->set_rules('pass2', 'Password', 'trim|required', [
                'required' => 'Retype Password tidak boleh kosong!',
            ]);
            if ($this->form_validation->run() == false) {
                $error = validation_errors();
                $D = ['success' => FALSE, 'message' => $error, 'label' => 'Opps..', 'csrfNewHash' => $csrfNewHash];
            } else {
                $email = decode($this->session->userdata('costumer_email'));
                $passLama = $this->input->post('passLama', true);
                $user = $this->db->get_where('costumer', ['c_email' => $email])->row_array();
                if (password_verify($passLama, $user['c_password'])) {
                    $data = [
                        'c_password' => password_hash($this->input->post('pass1', true), PASSWORD_DEFAULT),
                        'date_updated' => current_timestamp()
                    ];
                    $update = $this->web->updatePassCustomer($data);
                    if ($update) {
                        $D = ['success' => TRUE, 'message' => 'Password berhasil dirubah', 'label' => 'Berhasil', 'csrfNewHash' => $csrfNewHash];
                    } else {
                        $D = ['success' => FALSE, 'message' => 'Gagal merubah password..', 'label' => 'Opps..', 'csrfNewHash' => $csrfNewHash];
                    }
                } else {
                    $D = ['success' => FALSE, 'message' => 'Password Lama Anda salah!', 'label' => 'Opps..', 'csrfNewHash' => $csrfNewHash];
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }
}
