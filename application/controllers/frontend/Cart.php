<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_web', 'web');
		$this->load->library('cart');
	}

	public function index()
	{
		$D['title'] = 'Keranjang';
		$this->public('frontend/v_cart_index', $D);
	}

	function cart($param)
	{ // insert cart

		$csrfNewHash = $this->security->get_csrf_hash();
		$param = base64_decode($param);
		$D = ['success' => FALSE, 'message' => 'produk tidak ditemukan!', 'csrfNewHash' => $csrfNewHash];
		if ($param) {
			$qty = htmlspecialchars($this->input->post('qty'), true);
			$warna = 0;
			$ukuran = 0;

			$warnaId = decode(htmlspecialchars($this->input->post('warnaId'), true));
			$ukuranId = decode(htmlspecialchars($this->input->post('ukuranId'), true));

			if ($warnaId) {
				$textWarna = $this->db->get_where('warna', ['id' => $warnaId])->row()->warna;
				$warna = $warnaId;
			}
			if ($ukuranId) {
				$textUkuran = $this->db->get_where('ukuran', ['id' => $ukuranId])->row()->ukuran;

				$ukuran = $ukuranId;
			}

			$produk = $this->db->get_where('produk', ['id' => $param])->row_array();
			if ($produk) {
				$data = array(
					'id'      => $produk['id'],
					'qty'     => $qty,
					'price'   => $produk['harga_baru'],
					'name'    => $produk['title'],
					'options' => array('gambar' => $produk['gambar'], 'warna' => $warna, 'ukuran' => $ukuran)
				);

				$this->cart->insert($data);

				$D = [
					'success' => TRUE,
					'message' => "$qty $produk[title] " . (isset($textWarna) ? 'warna ' . $textWarna : '') . " " . (isset($textUkuran) ? 'ukuran ' . $textUkuran : ''),
					'csrfNewHash' => $csrfNewHash,
				];
			} else {
				$D = ['success' => FALSE, 'message' => 'produk tidak ditemukan!', 'csrfNewHash' => $csrfNewHash];
			}
		}

		header('Content-Type: application/json');
		echo json_encode($D);
		exit();
	}

	function ajaxcart()
	{
		$total = 0;
		$count = 0;
		// $minicart = '';

		if (!empty($this->cart->contents())) {
			$content = $this->cart->contents();
			$count = $this->cart->total_items();
			$total = $this->cart->total();
		}
		$D = [
			'total' => $total,
			'count' => $count,
			// 'minicart' => $minicart,
		];

		header('Content-Type: application/json');
		echo json_encode($D);
		exit();
	}

	function updatecart($param)
	{
		$csrfNewHash = $this->security->get_csrf_hash();
		$D = ['success' => FALSE, 'message' => 'produk tidak ditemukan!', 'csrfNewHash' => $csrfNewHash];

		$data = array();
		$data['qty'] = $this->input->post('qty');
		$data['rowid'] = $param;
		$success = $this->cart->update($data);
		if ($success) {
			$D = [
				'success' => TRUE,
				'message' => "Keranjang produk berhasil diperbarui!",
				'csrfNewHash' => $csrfNewHash,
			];
		}
		header('Content-Type: application/json');
		echo json_encode($D);
		exit();
	}

	function removecart()
	{
		$csrfNewHash = $this->security->get_csrf_hash();
		$D = ['success' => FALSE, 'message' => 'produk tidak ditemukan!', 'csrfNewHash' => $csrfNewHash];

		$row_id = $this->input->post('rowid');
		$success = $this->cart->remove($row_id);
		if ($success) {

			$D = [
				'success' => TRUE,
				'message' => "Produk berhasil dihapus!",
				'csrfNewHash' => $csrfNewHash,
			];
		}
		header('Content-Type: application/json');
		echo json_encode($D);
		exit();
	}

	public function show()
	{
		$total = 0;
		$total_berat = 0;
		$total_item = 0;
		$H = '';
		if (!empty($this->cart->contents())) {
			$content = $this->cart->contents();
			$total_item = $this->cart->total_items();
			$total = $this->cart->total();
			$warna = '';
			$ukuran = '';
			foreach ($content as $key => $value) {
				$produk_berat = $this->db->select('berat')->get_where('produk', ['id' => $value['id']])->row()->berat;
				$berat = $value['qty'] * $produk_berat;
				$total_berat = $total_berat + $berat;
				$options = $value['options'];
				$gambar = $options['gambar'];
				if ($options['warna'] != 0) {
					$warna = "warna " . $this->db->get_where('warna', ['id' => $options['warna']])->row()->warna;
				}
				if ($options['ukuran'] != 0) {
					$ukuran = "ukuran " . $this->db->get_where('ukuran', ['id' => $options['ukuran']])->row()->ukuran;
				}

				$H .= "<tr data-id='$value[rowid]'>";
				$H .=    "<td class='kenne-product-remove'><a href='javascript:void(0)' removeCart2><i class='fa fa-trash' title='Hapus dari keranjang'></i></a></td>";
				$H .=    "<td class='kenne-product-thumbnail'><a href='javascript:void(0)'><img src='" . base_url('uploads/produk/small/' . $gambar) .  "' alt='$value[name]'></a></td>";
				$H .=    "<td class='kenne-product-name'><a href='javascript:void(0)'>$value[name] $warna $ukuran</a></td>";
				$H .=    "<td class='kenne-product-price'><span class='amount'>" . rupiah($value['price']) . "</span></td>";
				$H .=    "<td class='quantity'>";
				$H .=        "<div class='cart-plus-minus'>";
				$H .=            "<input class='cart-plus-minus-box' qtyVal value='$value[qty]' type='tel'>";
				$H .=            "<div class='dec qtybutton custom'><i class='fa fa-angle-down'></i></div>";
				$H .=            "<div class='inc qtybutton custom'><i class='fa fa-angle-up'></i></div>";
				$H .=        "<div class='dec qtybutton custom'><i class='fa fa-angle-down'></i></div><div class='inc qtybutton custom'><i class='fa fa-angle-up'></i></div></div>";
				$H .=    "</td>";
				$H .=    "<td class='kenne-product-price'><span class='amount'>" . rupiah($berat) . " Gram</span></td>";
				$H .=    "<td class='product-subtotal'><span class='amount'>" . rupiah($value['subtotal']) . "</span></td>";
				$H .= "</tr>";
			}
		} else {
			$total_item = '';
		}



		$D = [
			'totalBarang' => $total,
			'jumlahBarang' => $total_item,
			'cart' => $H,
			'beratBarang' => $total_berat
		];

		header('Content-Type: application/json');
		echo json_encode($D);
		exit();
	}
}
