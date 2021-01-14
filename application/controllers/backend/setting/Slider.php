<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_slider','slider');
    }

    public function index() {
        $D = [
            'title' => 'Slider Website',
            'data' => $this->db->get('slider')->result_array()
        ];

		$this->render('v_slider_index', $D);
    }
    
	public function simpan($param) {

        $param = decode($param);
        $csrfNewHash = $this->security->get_csrf_hash();
        $D = ['success' => FALSE, 'message' => 'Tidak ada perintah!', 'csrfNewHash' => $csrfNewHash];
        $cek = [];
        
        if ($param) {

            if (!empty($_FILES['slider']['name'])) {
				$config['upload_path'] = './uploads/slider/';
				$config['allowed_types'] = 'jpg|png';
				$config['encrypt_name'] = TRUE;

				$this->upload->initialize($config);

				if (!$this->upload->do_upload('slider')) {
					$error = $this->upload->display_errors();
					array_push($cek, $error);
				} else {

                    $gambar = $this->db->select('slider')->get_where('slider', ['id' => $param])->row()->slider;
                    if (!empty($gambar)) unlink('uploads/slider/'.$gambar);
					$post_image = $this->upload->data();

					$config['image_library']='GD2';
					$config['source_image']='./uploads/slider/'.$post_image['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '100%';
					$config['width']= 800;
					$config['height']= 267;
					$config['new_image']= './uploads/slider/'.$post_image['file_name'];
					$this->load->library('image_lib', $config);
					if (!$this->image_lib->resize()) {
						array_push($cek, $error);
					} else {
						$data['slider'] = $post_image['file_name'];
						$this->image_lib->clear();
					}
				}
			} else {
                array_push($cek, 'File tidak boleh kosong!');
            }
            
            if (!empty($cek)) {
                $D = ['success' => FALSE, 'message' => "<ol><li>" . implode("</li><li>", $cek) ."</li></ol>", 'csrfNewHash' => $csrfNewHash];
            } else {
                $this->slider->update_info($param, $data);
                $D = ['success' => TRUE, 'message' => 'Slider berhasil disimpan!', 'csrfNewHash' => $csrfNewHash];
            }
        }

    header('Content-Type: application/json'); 
    echo json_encode($D);
    exit();
    }
    
    	public function delete($param) {

        $param = decode($param);
        $D = ['success' => FALSE, 'message' => 'Tidak ada perintah!'];
        
        if ($param) {
            $data = $this->db->get_where('slider', ['id' => $param])->row_array();
            if ($data) {
                $S['slider'] = NULL; 
                $this->slider->update_info($param, $S);
                unlink('uploads/slider/'.$data['slider']);
                $D = ['success' => TRUE, 'message' => 'Slider berhasil dihapus!'];
            }
        }

    header('Content-Type: application/json'); 
    echo json_encode($D);
    exit();
	}

}