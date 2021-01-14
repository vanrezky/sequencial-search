<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_web extends CI_Model
{

    public function getCostumer($email)
    {
        $this->db->select('*');
        $this->db->where('c_email', $email);
        $query = $this->db->get('costumer');
        return $query->row_array();
    }
    public function getLoginData()
    {
        $email = $this->input->post('email', true); // dari form input email
        $password = $this->input->post('password', true); //dari form input password

        $user = $this->db->get_where('costumer', ['c_email' => $email])->row_array(); //ambil data berdasarkan email

        //jika user ada
        if ($user) {
            //jika user aktif
            if ($user['aktif'] == 1) {
                // cek password
                if (password_verify($password, $user['c_password'])) {
                    $data = [
                        'costumer_email' => (encode($user['c_email'])),
                    ];
                    $this->session->set_userdata($data);
                    return ['stat' => TRUE, 'message' => "Berhasil login, selamat datang " . word_limiter($user['c_nama'], 1, '')];
                } else {
                    return ['stat' => FALSE, 'message' => 'Username atau Password Salah!'];
                }
            } else {
                return ['stat' => FALSE, 'message' => 'Akun tidak aktif!'];
            }
        } else {
            return ['stat' => FALSE, 'message' => 'Username atau Password Salah!'];
        }
    }


    public function get_produk_terbaru()
    {

        $get = get_limit('produk_terbaru');
        $limit = $get < 4 ? '4' : $get;

        $this->db->select('produk.id, produk.slug, produk.gambar, title, harga_lama, harga_baru');
        $this->db->join('kategori', 'produk.kategori=kategori.id', 'LEFT');
        $this->db->join('brand', 'produk.brand=brand.id', 'LEFT');
        $this->db->order_by('produk.id', 'DESC');
        $this->db->limit($limit);
        $this->db->where('kategori.publish', 1);
        $this->db->where('brand.publish', 1);
        return $this->db->get('produk')->result_array();
    }

    public function get_produk_pilihan($id_kategori = "")
    {

        $get = get_limit('produk_pilihan');
        $limit = $get < 4 ? '4' : $get;

        $this->db->select('produk.id, produk.slug, produk.gambar, title, harga_lama, harga_baru');
        $this->db->join('kategori', 'produk.kategori=kategori.id', 'LEFT');
        $this->db->join('brand', 'produk.brand=brand.id', 'LEFT');
        $this->db->order_by('produk.id', 'DESC');
        $this->db->limit($limit);
        $this->db->where('produk.kategori', $id_kategori);
        $this->db->where('kategori.publish', 1);
        $this->db->where('brand.publish', 1);
        return $this->db->get('produk')->result_array();
    }

    public function get_kategori_pilihan()
    {
        return $this->db->select('id, nm_kategori')
            ->where('kategori_pilihan', 1)
            ->where('publish', 1)
            ->get('kategori')
            ->result_array();
    }

    public function get_all_kategori()
    {
        return $this->db->select('id, nm_kategori, slug')->get_where('kategori', ['publish' => 1])->result_array();
    }

    public function get_all_produk($limit = "", $offset = "")
    {

        $search = $this->input->get('search');
        $urutan = $this->input->get('urutan');
        $rentan = $this->input->get('rentan');
        $kategori = $this->input->get('kategori');

        $this->db->select("P.*");

        $this->db->join('kategori K', 'P.kategori=K.id', 'LEFT');
        $this->db->join('brand B', 'P.brand=B.id', 'LEFT');

        // rentan 
        if (!empty($rentan)) {
            $rentan = explode('-', $rentan);
            // var_dump($rentan);
            $this->db->where('P.harga_baru BETWEEN "' . $rentan[0] . '" and "' . $rentan[1] . '"');
        }

        //kategori
        if (!empty($kategori)) {
            $this->db->where('P.kategori', $kategori);
        }

        // search
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('P.title', $search, 'both');
            $this->db->or_like('P.deskripsi_singkat', $search, 'both');
            $this->db->or_like('P.deskripsi', $search, 'both');
            $this->db->or_like('P.deskripsi', $search, 'both');
            $this->db->or_like('B.nm_brand', $search, 'both');
            $this->db->or_like('K.nm_kategori', $search, 'both');
            $this->db->group_end();
        }
        //urutan
        if (!empty($urutan)) {
            if ($urutan == 2) {
                $this->db->order_by('P.title', 'ASC');
            } else if ($urutan == 3) {
                $this->db->order_by('P.title', 'DESC');
            } else if ($urutan == 4) {
                $this->db->order_by('P.harga_baru', 'ASC');
            } else if ($urutan == 5) {
                $this->db->order_by('P.harga_baru', 'DESC');
            }
        } else {
            $this->db->order_by('P.id', 'DESC');
        }

        $info = $this->db->get('produk P', $limit, $offset);
        return $info;
    }

    public function get_produk_id($id)
    {
        return $this->db
            ->select('produk.*, brand.nm_brand, kategori.nm_kategori')
            ->join('brand', 'produk.brand=brand.id', 'LEFT')
            ->join('kategori', 'produk.kategori=kategori.id', 'LEFT')
            ->get_where('produk', ['produk.id' => $id])->row_array();
    }

    public function get_produk_slug($slug)
    {
        return $this->db
            ->select('produk.*, brand.nm_brand, kategori.nm_kategori')
            ->join('brand', 'produk.brand=brand.id', 'LEFT')
            ->join('kategori', 'produk.kategori=kategori.id', 'LEFT')
            ->get_where('produk', ['produk.slug' => $slug])->row_array();
    }

    public function no_order()
    {
        $this->load->helper('string');
        return strtoupper(random_string('alnum', 12));
    }

    public function saveOrderan($data)
    {
        $this->db->insert('orderan', $data);
        return $this->db->insert_id();
    }
    public function saveOrderanDetail($data)
    {
        return $this->db->insert('orderan_detail', $data);
    }

    public function getPesananBelumBayar()
    {
        $this->db->select("O.*,(
					SELECT SUM(OD.`produk_qty`) 
					FROM orderan_detail OD
					WHERE OD.`orderan_id` = O.id
				)items,(
					SELECT P.`gambar`
                    FROM orderan_detail OD2
                    LEFT JOIN produk P ON OD2.`produk_id` = P.`id`
                    WHERE OD2.`orderan_id` = O.id
                    LIMIT 1
				)gambar");
        $this->db->where('O.email_customer', decode($this->session->userdata('costumer_email')));
        $this->db->where('O.status_order', 'Menunggu Pembayaran')->or_where('O.status_order', 'Dibatalkan');
        $this->db->order_by('O.id', 'DESC');
        return $this->db->get('orderan O')->result_array();
    }

    public function getPesanan($where)
    {
        $this->db->select("O.*,(
					SELECT SUM(OD.`produk_qty`) 
					FROM orderan_detail OD
					WHERE OD.`orderan_id` = O.id
				)items,(
					SELECT P.`gambar`
                    FROM orderan_detail OD2
                    LEFT JOIN produk P ON OD2.`produk_id` = P.`id`
                    WHERE OD2.`orderan_id` = O.id
                    LIMIT 1
				)gambar");
        $this->db->where('O.email_customer', decode($this->session->userdata('costumer_email')));
        $this->db->where('O.status_order', $where);
        $this->db->order_by('O.id', 'DESC');
        return $this->db->get('orderan O')->result_array();
    }

    public function updatePassCustomer($data)
    {
        $this->db->where('c_email', decode($this->session->userdata('costumer_email')));
        return $this->db->update('costumer', $data);
    }

    public function getOrderanDetail($no_order)
    {
        $this->db->select('O.*, B.atas_nama');
        $this->db->join('bank B', 'O.bank=B.id', 'LEFT');
        $this->db->where('no_order', $no_order);
        return $this->db->get('orderan O')->row_array();
    }

    public function getItemOrder($id_orderan)
    {

        $this->db->select('OD.*, P.gambar, P.berat, W.warna, U.ukuran');
        $this->db->join('produk P', 'OD.produk_id=P.id', 'LEFT');
        $this->db->join('warna W', 'OD.warna_id=W.id', 'LEFT');
        $this->db->join('ukuran U', 'OD.ukuran_id=U.id', 'LEFT');
        $this->db->where('orderan_id', $id_orderan);
        return $this->db->get('orderan_detail OD')->result_array();
    }

    public function updateOrderan($no_order, $data)
    {
        $this->db->where('no_order', $no_order);
        return $this->db->update('orderan', $data);
    }

    public function updateProdukQty($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('produk', $data);
    }


    // $this->db->join('orderan_detail OD', 'O.id=OD.orderan_id', 'INNER');
    // $this->db->join('produk P', 'OD.produk_id=P.id', 'LEFT');
    // $this->db->join('warna W', 'OD.warna_id=W.id', 'LEFT');
    // $this->db->join('ukuran U', 'OD.ukuran_id=U.id', 'LEFT');
}
