<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Show404 extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->output->set_status_header('404');
        $D = [
            'title' => '404 Opps..',
        ];
        $this->public('error404', $D);
    }
}
