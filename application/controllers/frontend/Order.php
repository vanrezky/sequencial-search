<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Controller {

    public function index() {
        $csrfNewHash = $this->security->get_csrf_hash();
        $D = ['success' => FALSE, 'message' => 'tidak ada perintah!', 'csrfNewHash' => $csrfNewHash];
        
        if ($this->session->has_userdata('customer_email')) {

        } else {
            $D = ['success' => FALSE, 'message' => 'Silahkan login telebih dahulu!', 'csrfNewHash' => $csrfNewHash ];
        }

        header('Content-Type: application/json'); 
		echo json_encode($D);
		exit();
    }
}