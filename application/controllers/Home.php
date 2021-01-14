<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_web','web');
	}

	public function index()
	{	
		$D = [
			'title' => 'Home',
			'produk_terbaru' => $this->web->get_produk_terbaru(),
			'produk_pilihan' => (new $this->web),
			'kategori_pilihan' => $this->web->get_kategori_pilihan(),
		];
		// $this->public('frontend/v_home_index', $D);
		$this->public('frontend/v_home_index', $D, TRUE);
		
	}

	function loader() {
		$this->session->set_userdata('loader', 'loader');
	}
}
