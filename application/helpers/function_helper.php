<?php
defined('BASEPATH') or exit('No direct script access allowed');


function Pagin($url = "", $total_rows = "0", $per_page = "10")
{

    $CI = &get_instance();
    $url_uri_segment = count(explode("/", $url)) + 1;
    $config["base_url"] = site_url($url);
    $config['total_rows'] = $total_rows;
    $config['per_page'] = $per_page;
    $config["uri_segment"] = $url_uri_segment;

    // Membuat Style pagination untuk BootStrap v4
    $config['first_link']       = 'First';
    $config['last_link']        = 'Last';
    $config['next_link']        = 'Next';
    $config['prev_link']        = 'Prev';
    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  = '</span>Next</li>';
    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close'] = '</span></li>';
    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']  = '</span></li>';
    // $config['attributes'] = array('class' => 'page-link');
    $CI->pagination->initialize($config);

    $pagin = "<div class='float-right mr-3'>" . $CI->pagination->create_links() . "</div>";

    $pagin = "<span> Total Records : " . ifUang($total_rows) . " Data</span>" . $pagin;

    return $pagin;
}

function Offset($param = "index", $number = "1")
{
    $CI = &get_instance();
    $prm = $CI->uri->uri_to_assoc($number);
    if (isset($prm["$param"])) {
        $offset = (int) $prm["$param"];
    } else {
        $offset = 0;
    }
    return $offset;
}

function ifUang($nominal = "")
{
    if (is_numeric($nominal)) {
        $panjang = strlen($nominal);
        $char    = str_split($nominal);
        $hasil   = "";
        $no = 0;
        for ($i = count($char) - 1; $i >= 0; $i--) {
            if ($no == 3) {
                $hasil .= ".";
                $no = 0;
            }
            $no++;
            $hasil .= $char[$i];
        }
        return strrev($hasil);
    } else {
        return $nominal;
    }
}

function encode($param)
{
    $CI = get_instance();
    $encrypt  = $CI->encryption->encrypt($param);

    return  str_replace(array('/'), array('0_0'), $encrypt);
}

function decode($param)
{
    $CI = get_instance();
    $decrypt = str_replace(array('0_0'), array('/'), $param);

    return  $CI->encryption->decrypt($decrypt);
}

function current_timestamp()
{
    date_default_timezone_set("Asia/Jakarta");
    return date("Y-m-d H:i:s");
}

function tanggal($tanggal, $hari = FALSE, $time = FALSE, $short = FALSE)
{
    if (empty($tanggal) or $tanggal == '0000-00-00') return "";
    $get_bulan = $short ? 'nama_bulan2' : 'nama_bulan';
    $get_hari  = $short ? 'getShortHari' : 'getHari';

    $days = ($hari === TRUE ? $get_hari(date('w', strtotime($tanggal))) . ", " : "") . date('d', strtotime($tanggal)) . '  ' . $get_bulan(date('m', strtotime($tanggal))) . ' ' . date('Y', strtotime($tanggal));
    if ($time) {
        $time = date('H:i:s', strtotime($tanggal));
        $days = $time . " # " . $days;
    }
    return $days;
}

function nama_bulan($i)
{
    $bulan = array(
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    return $bulan[$i - 1];
}

function nama_bulan2($i)
{
    $bulan = array(
        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'
    );
    return $bulan[$i - 1];
}

function getHari($w = "")
{
    switch ($w) {
        case "0":
            $hari = "Minggu";
            break;
        case "1":
            $hari = "Senin";
            break;
        case "2":
            $hari = "Selasa";
            break;
        case "3":
            $hari = "Rabu";
            break;
        case "4":
            $hari = "Kamis";
            break;
        case "5":
            $hari = "Jumat";
            break;
        case "6":
            $hari = "Sabtu";
            break;
        default:
            $hari = "";
            break;
    }
    return $hari;
}

function getShortHari($w = "")
{
    switch ($w) {
        case "0":
            $hari = "Min";
            break;
        case "1":
            $hari = "Sen";
            break;
        case "2":
            $hari = "Sel";
            break;
        case "3":
            $hari = "Rab";
            break;
        case "4":
            $hari = "Kam";
            break;
        case "5":
            $hari = "Jum";
            break;
        case "6":
            $hari = "Sab";
            break;
        default:
            $hari = "";
            break;
    }
    return $hari;
}

function flashdata($pesan = "", $alert = "success")
{

    $H = '';
    $H .= "<div class='alert alert-$alert' role='alert'>";
    $H .= "$pesan";
    $H .= "</div>";

    return $H;
}

function get_informasi($param = "*")
{
    $op = &get_instance();

    $op->db->select("$param");
    $op->db->from('setting');
    $res = $op->db->get();
    $result =  $res->row();

    if ($param == "*") return $result;

    return $result->$param;
}

function get_limit($param)
{
    $op = &get_instance();

    $op->db->select($param);
    $op->db->from('setting_limit');
    $res = $op->db->get();
    $result =  $res->row();

    return $result->$param;
}

function base64_image($path = "")
{
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    return 'data:image/' . $type . ';base64,' . base64_encode($data);
}

function rupiah($angka)
{
    $hasil_rupiah = number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

function replace_huruf($data)
{
    return preg_replace("/[^a-zA-Z]/", "", $data);
}
function replace_angka($data)
{
    return preg_replace("/[^0-9]/", "", $data);
}
function replace_hurufAngka($data)
{
    return preg_replace("/[^a-zA-Z0-9]/", "", $data);
}

function discount($harga_baru, $harga_lama)
{
    $potongan = $harga_lama - $harga_baru;
    return Round(($potongan / $harga_lama) * 100);
}

function brand()
{

    $CI = &get_instance();
    $limit = get_limit('brand');

    return $CI->db->limit($limit)->where('publish', 1)->get('brand')->result_array();
}

function slider()
{

    $CI = &get_instance();
    return $CI->db->get('slider')->result_array();
}

function is_logged_in()
{
    $CI = &get_instance();

    if (empty($CI->session->has_userdata('email'))) {
        redirect('auth');
    }
}

function customer_logged_in()
{
    $CI = &get_instance();

    if ($CI->session->has_userdata('costumer_email')) {
        return true;
    } else {
        return false;
    }
}

function status_order($status = "")
{
    switch ($status) {
        case "Menunggu Pembayaran":
            $return = "<span class='badge badge-warning'>Menunggu Pembayaran</span>";
            break;
        case "Dikemas":
            $return = "<span class='badge badge-secondary'>Dikemas</span>";
            break;
        case "Dikirim":
            $return = "<span class='badge badge-info'>Dikirim</span>";
            break;
        case "Selesai":
            $return = "<span class='badge badge-success'>Selesai</span>";
            break;
        case "Dibatalkan":
            $return = "<span class='badge badge-danger'>Dibatalkan</span>";
            break;
        default:
            $return = "";
            break;
    }
    return $return;
}
