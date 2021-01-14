<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_web', 'web');
		$this->load->library('cart');
	}

	public function index()
	{
		$D = [
			'title' => 'Daftar Produk',
			'kategori' => $this->web->get_all_kategori(),
			'min' => $this->db->select_min('harga_baru', 'min')->get('produk')->row()->min,
			'max' => $this->db->select_max('harga_baru', 'max')->get('produk')->row()->max,
		];
		$this->public('frontend/v_produk_index', $D);
	}

	public function show()
	{
		$limit = 12;
		$offset = offset('show', '2');
		$total_produk = $this->web->get_all_produk()->num_rows();

		$config['base_url'] = site_url('produk/show/');
		$config['total_rows'] = $total_produk;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 3;
		$config['num_links'] = 3;
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><span>';
		$config['cur_tag_close'] = '</span></li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = 'Previous';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		$D = [
			'pagin' => $this->pagination->create_links(),
			'produk' => $this->web->get_all_produk($limit, $offset)->result_array(),

		];

		$this->load->view('frontend/v_produk_show', $D);
	}

	public function view()
	{

		$id_e = $this->input->get('id', true);
		$id = base64_decode($id_e);
		$produk = $this->web->get_produk_id($id);
		$image = base64_image(base_url('uploads/produk/' . $produk['gambar']));
		$price = "<span class='new-price new-price-2'>Rp. " . rupiah($produk['harga_baru']) . "</span><span class='old-price'>Rp. " . rupiah($produk['harga_lama']) . "</span>";

		$desc = "";
		$desc .= "<li><b>Brand:</b> <a href='javascript:void(0)'>$produk[nm_brand]</a></li>";
		$desc .= "<li><b>Kategori:</b> <a href='javascript:void(0)'>$produk[nm_kategori]</a></li>";
		$desc .= "<li><b>Deskripsi Singkat:</b> <a href='javascript:void(0)'>$produk[deskripsi_singkat]</a></li>";
		$desc .= "<li><b>Berat:</b> <a href='javascript:void(0)'>$produk[berat] Gram</a></li>";

		$warna = FALSE;
		$ukuran = FALSE;
		if ($produk['variasi'] == 1) {
			$warna = "";
			$ukuran = "";
			if (!empty($produk['warna'])) {

				$pilihan_warna = explode(',', $produk['warna']);
				foreach ($pilihan_warna as $key => $value) {
					$detail_warna = $this->db->get_where('warna', ['id' => $value])->row_array();
					$warna .= "<a href='javascript:void(0)' class='single-color' data-id='" . encode($detail_warna['id']) . "'>
								<span class='color-block'>$detail_warna[warna]</span>
							</a>";
				}
			}
			if (!empty($produk['ukuran'])) {
				$pilihan_ukuran = explode(',', $produk['ukuran']);
				foreach ($pilihan_ukuran as $key => $value) {
					$detail_ukuran = $this->db->get_where('ukuran', ['id' => $value])->row_array();
					$ukuran .= "<a href='javascript:void(0)' class='single-color' data-id='" . encode($detail_ukuran['id']) . "'>
								<span>$detail_ukuran[ukuran]</span>
							</a>";
				}
			}
		}
		$D = [
			'name' => $produk['title'],
			// 'sort_desc' => $produk['deskripsi_singkat'],
			'desc' => $desc,
			'price' => $price,
			'image' => $image,
			'id' => $id_e,
			'warna' => $warna,
			'ukuran' => $ukuran
		];

		header('Content-Type: application/json');
		echo json_encode($D);
		exit();
	}

	public function detail($slug = "")
	{

		$data = $this->web->get_produk_slug($slug);
		if (!empty($data)) {

			$warna = array();
			if (!empty($data['warna'])) {
				$pilihan_warna = explode(',', $data['warna']);
				foreach ($pilihan_warna as $key => $value) {
					$detail_warna = $this->db->get_where('warna', ['id' => $value])->row_array();
					$warna[] = [
						'id' => $detail_warna['id'],
						'warna' => $detail_warna['warna'],
					];
				}
			}
			$ukuran = array();
			if (!empty($data['ukuran'])) {
				$pilihan_ukuran = explode(',', $data['ukuran']);
				foreach ($pilihan_ukuran as $key => $value) {
					$detail_ukuran = $this->db->get_where('ukuran', ['id' => $value])->row_array();
					$ukuran[] = [
						'id' => $detail_ukuran['id'],
						'ukuran' => $detail_ukuran['ukuran'],
					];
				}
			}

			$D = [
				'title' => $data['title'],
				'data' => $data,
				'warna' => $warna,
				'ukuran' => $ukuran
			];
		} else {
			redirect('404');
		}

		$this->public('frontend/v_produk_detail', $D);
	}
}
