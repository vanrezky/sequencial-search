<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rajaongkir extends MY_Controller
{

    private $api_key = '4c92805c41efa46d0b826e8b9b390605';
    private $type = 'starter';

    public function provinsi()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/" . $this->type . "/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: $this->api_key"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {

            $array_response = json_decode($response, true);
            $D = $array_response['rajaongkir']['results'];

            header('Content-Type: application/json');
            echo json_encode($D);
            exit();
            // echo "<pre>";
            // print_r($array_response['rajaongkir']['results']);
            // echo "</pre>";
            // ['rajaongkir']['result'];
        }
    }

    public function kota()
    {
        $curl = curl_init();

        $provinsi = $this->input->get('provinsi');

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/" . $this->type . "/city?province=$provinsi",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: $this->api_key"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {

            $array_response = json_decode($response, true);
            $D = $array_response['rajaongkir']['results'];
            header('Content-Type: application/json');
            echo json_encode($D);
            exit();
        }
    }

    function cost()
    {
        $this->load->library('cart');
        $total_berat = 0;
        foreach ($this->cart->contents() as $key => $value) {
            $berat_produk = $this->db->select('berat')->get_where('produk', ['id' => $value['id']])->row()->berat;
            $berat = $berat_produk * $value['qty'];
            $total_berat = $total_berat + $berat;
        }
        $kabupaten = $this->input->get('kabupaten');
        // $berat = $this->input->get('berat');
        $kurir = $this->input->get('kurir');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/" . $this->type . "/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=" . $this->alamat_penjual() . "&destination=$kabupaten&weight=$total_berat&courier=$kurir",
            CURLOPT_HTTPHEADER => array(
                "key: $this->api_key"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $array_response = json_decode($response, true);
            $data = $array_response['rajaongkir']['results'][0]['costs'];
            $D = array();
            if (empty($data)) {
                $D[] = [
                    'value' => '',
                    'label' => 'Paket tidak dapat dikirim'
                ];
            } else {
                foreach ($data as $key => $value) {
                    $D[] = [
                        'value' => $value['service'],
                        'ongkir' => $value['cost'][0]['value'],
                        'label' => $value['description'] . ' - Rp. ' . ifUang($value['cost'][0]['value']) . ' - ' . $value['cost'][0]['etd']
                    ];
                }
            }
            header('Content-Type: application/json');
            echo json_encode($D);
            exit();
        }
    }

    private function alamat_penjual()
    {
        return get_informasi('kabupaten');
    }

    function kurir()
    {
        $D = $this->db->get_where('rajaongkir_kurir', ['tipe' => $this->type])->result_array();
        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }
}
