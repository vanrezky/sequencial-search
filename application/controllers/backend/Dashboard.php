<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_dashboard', 'dashboard');
	}
	public function index()
	{
		$data = $this->dashboard->get_content_dashboard();
		$orderan = $this->dashboard->getPesanan();
		$D = [
			'title' => 'Halaman Dashboard',
			'data' => $data,
			'orderan' => $orderan
		];
		$this->render('v_dashboard_index', $D);
	}
}
