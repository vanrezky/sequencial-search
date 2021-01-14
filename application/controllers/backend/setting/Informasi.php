<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Informasi extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_informasi', 'informasi');
    }

    public function index()
    {
        $D = [
            'title' => 'Informasi Umum Website',
        ];

        $this->render('v_informasi_index', $D);
    }

    public function perbarui()
    {
        $csrfNewHash = $this->security->get_csrf_hash();
        $D = ['success' => FALSE, 'message' => 'Tidak ada perintah!'];
        $this->form_validation->set_rules('nama', 'Nama Webiste', 'trim|required|max_length[100]', [
            'required' => 'Nama Webiste tidak Boleh Kosong!',
            'max_length' => 'Nama Webiste tidak Boleh lebih dari 100 karakter!'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[100]', [
            'required' => 'Email tidak Boleh Kosong!',
            'max_length' => 'Email tidak Boleh lebih dari 100 karakter!',
            'valid_email' => 'Email tidak valid!'
        ]);
        $this->form_validation->set_rules('kontak1', 'Kontak 1', 'trim|required|max_length[16]', [
            'required' => 'Kontak 1 tidak Boleh Kosong!',
            'max_length' => 'Kontak 1 tidak Boleh lebih dari 16 karakter!'
        ]);
        $this->form_validation->set_rules('facebook_link', 'Link Facebook', 'trim|valid_url', [
            'valid_url' => 'Link Facebook tidak valid!'
        ]);
        $this->form_validation->set_rules('instagram_link', 'Link Instagram', 'trim|valid_url', [
            'valid_url' => 'Link Instagram tidak valid!'
        ]);
        $this->form_validation->set_rules('twitter_link', 'Link Twitter', 'trim|valid_url', [
            'valid_url' => 'Link Twitter tidak valid!'
        ]);
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
        $this->form_validation->set_rules('kontak2', 'Kontak 2', 'trim');
        $this->form_validation->set_rules('favicon', 'Favicon', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors();
            $D = ['success' => FALSE, 'message' => $error, 'csrfNewHash' => $csrfNewHash];
        } else {
            $cek = [];

            $data = [
                'copyright' => htmlspecialchars($this->input->post('copyright', true)),
                'kontak1' => htmlspecialchars($this->input->post('kontak1', true)),
                'kontak2' => htmlspecialchars($this->input->post('kontak2', true)),
                'facebook_link' => htmlspecialchars($this->input->post('facebook_link', true)),
                'instagram_link' => htmlspecialchars($this->input->post('instagram_link', true)),
                'twitter_link' => htmlspecialchars($this->input->post('twitter_link', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'deskripsi' => htmlspecialchars($this->input->post('deskripsi', true)),
                'provinsi' => htmlspecialchars($this->input->post('provinsi', true)),
                'kabupaten' => htmlspecialchars($this->input->post('kabupaten', true)),
            ];

            $elogo = $this->input->post('elogo');
            $efavicon = $this->input->post('efavicon');

            if (!empty($_FILES['logo']['name'])) {
                $config['upload_path'] = './uploads/settings/';
                $config['allowed_types'] = 'jpg|png';
                $config['encrypt_name'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('logo')) {
                    $error = $this->upload->display_errors();
                    array_push($cek, $error);
                } else {
                    $logo = get_informasi('logo');
                    if (!empty($logo)) unlink('uploads/settings/' . $logo);
                    $post_image = $this->upload->data();

                    $config['image_library'] = 'GD2';
                    $config['source_image'] = './uploads/settings/' . $post_image['file_name'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = FALSE;
                    $config['quality'] = '100%';
                    $config['width'] = 149;
                    $config['height'] = 37;
                    $config['new_image'] = './uploads/settings/' . $post_image['file_name'];
                    $this->load->library('image_lib', $config);
                    if (!$this->image_lib->resize()) {

                        // array_push($cek, $error);
                    } else {
                        $data['logo'] = $post_image['file_name'];
                        $this->image_lib->clear();
                    }
                }
            }

            if (!empty($_FILES['favicon']['name'])) {
                $config['upload_path'] = './uploads/settings/';
                $config['allowed_types'] = '|jpg|png';
                $config['encrypt_name'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('favicon')) {
                    $error = $this->upload->display_errors();
                    array_push($cek, $error);
                } else {
                    $favicon = get_informasi('favicon');
                    if (!empty($favicon)) unlink('uploads/settings/' . $favicon);
                    $post_image = $this->upload->data();
                    $config['image_library'] = 'GD2';
                    $config['source_image'] = './uploads/settings/' . $post_image['file_name'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = FALSE;
                    $config['quality'] = '100%';
                    $config['width'] = 32;
                    $config['height'] = 32;
                    $config['new_image'] = './uploads/settings/' . $post_image['file_name'];
                    $this->load->library('image_lib', $config);
                    if (!$this->image_lib->resize()) {
                        array_push($cek, $error);
                    } else {
                        $data['favicon'] = $post_image['file_name'];
                        $this->image_lib->clear();
                    }
                }
            }

            if (!empty($cek)) {
                $D = ['success' => FALSE, 'message' => "<ol><li>" . implode("</li><li>", $cek) . "</li></ol>", 'csrfNewHash' => $csrfNewHash];
            } else {
                $this->informasi->simpan_info($data);
                $D = ['success' => TRUE, 'message' => 'Data berhasil disimpan!', 'csrfNewHash' => $csrfNewHash];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }
}
