<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//home

$route['default_controller'] = 'home';
$route['404_override'] = 'Show404';
$route['translate_uri_dashes'] = FALSE;

// dashboard
$route['dashboard'] = 'backend/dashboard';
$route['dashboard/data'] = 'backend/dashboard/data';
$route['dashboard/data/(:any)'] = 'backend/dashboard/data/$1';
$route['dashboard/changePublish/(:any)'] = 'backend/dashboard/changePublish/$1';
$route['dashboard/simpan'] = 'backend/dashboard/simpan';
$route['dashboard/simpan/(:any)'] = 'backend/dashboard/simpan/$1';
$route['dashboard/delete/(:any)'] = 'backend/dashboard/delete/$1';
$route['dashboard/index/(:num)'] = 'backend/dashboard/index/$1';
$route['dashboard/index'] = 'backend/dashboard/index';

// user
$route['master/user'] = 'backend/master/user';
$route['master/user/data'] = 'backend/master/user/data';
$route['master/user/data/(:any)'] = 'backend/master/user/data/$1';
$route['master/user/simpan'] = 'backend/master/user/simpan';
$route['master/user/simpan/(:any)'] = 'backend/master/user/simpan/$1';
$route['master/user/changepassword/(:any)'] = 'backend/master/user/changepassword/$1';
$route['master/user/delete/(:any)'] = 'backend/master/user/delete/$1';
$route['master/user/index/(:num)'] = 'backend/master/user/index/$1';
$route['master/user/index'] = 'backend/master/user/index';

// costumer
$route['master/costumer'] = 'backend/master/costumer';
$route['master/costumer/index/(:num)'] = 'backend/master/costumer/index/$1';
$route['master/costumer/index'] = 'backend/master/costumer/index';
$route['master/costumer/changepublish/(:any)'] = 'backend/master/costumer/changepublish/$1';
$route['master/costumer/preview/(:any)'] = 'backend/master/costumer/preview/$1';


// kategori
$route['master/kategori'] = 'backend/master/kategori';
$route['master/kategori/data'] = 'backend/master/kategori/data';
$route['master/kategori/data/(:any)'] = 'backend/master/kategori/data/$1';
$route['master/kategori/changepublish/(:any)'] = 'backend/master/kategori/changepublish/$1';
$route['master/kategori/delete/(:any)'] = 'backend/master/kategori/delete/$1';
$route['master/kategori/index/(:num)'] = 'backend/master/kategori/index/$1';
$route['master/kategori/index'] = 'backend/master/kategori/index';
$route['master/kategori/simpan'] = 'backend/master/kategori/simpan';
$route['master/kategori/simpan/(:any)'] = 'backend/master/kategori/simpan/$1';

// brand
$route['master/brand'] = 'backend/master/brand';
$route['master/brand/data'] = 'backend/master/brand/data';
$route['master/brand/data/(:any)'] = 'backend/master/brand/data/$1';
$route['master/brand/changepublish/(:any)'] = 'backend/master/brand/changepublish/$1';
$route['master/brand/simpan'] = 'backend/master/brand/simpan';
$route['master/brand/simpan/(:any)'] = 'backend/master/brand/simpan/$1';
$route['master/brand/delete/(:any)'] = 'backend/master/brand/delete/$1';
$route['master/brand/index/(:num)'] = 'backend/master/brand/index/$1';
$route['master/brand/index'] = 'backend/master/brand/index';

// produk
$route['master/produk'] = 'backend/master/produk';
$route['master/produk/data'] = 'backend/master/produk/data';
$route['master/produk/data/(:any)'] = 'backend/master/produk/data/$1';
$route['master/produk/changepublish/(:any)'] = 'backend/master/produk/changepublish/$1';
$route['master/produk/simpan'] = 'backend/master/produk/simpan';
$route['master/produk/simpan/(:any)'] = 'backend/master/produk/simpan/$1';
$route['master/produk/delete/(:any)'] = 'backend/master/produk/delete/$1';
$route['master/produk/index/(:num)'] = 'backend/master/produk/index/$1';
$route['master/produk/index'] = 'backend/master/produk/index';
$route['master/produk/ajaxvariasi'] = 'backend/master/produk/ajaxvariasi';
$route['master/produk/detail/(:any)'] = 'backend/master/produk/detail/$1';

// informasi umum
$route['setting/informasi'] = 'backend/setting/informasi';
$route['setting/informasi/index'] = 'backend/setting/informasi/index';
$route['setting/informasi/perbarui'] = 'backend/setting/informasi/perbarui';

//api rajaongkir
$route['rajaongkir/provinsi'] = 'api/rajaongkir/provinsi';
$route['rajaongkir/kota'] = 'api/rajaongkir/kota';
$route['rajaongkir/kurir'] = 'api/rajaongkir/kurir';
$route['rajaongkir/cost'] = 'api/rajaongkir/cost';

//kategori pilihan
$route['setting/kategori_pilihan'] = 'backend/setting/kategori_pilihan';
$route['setting/kategori_pilihan/index'] = 'backend/setting/kategori_pilihan/index';
$route['setting/kategori_pilihan/changepublish/(:any)'] = 'backend/setting/kategori_pilihan/changepublish/$1';

// limit
$route['setting/limit'] = 'backend/setting/limit';
$route['setting/limit/index'] = 'backend/setting/limit/index';
$route['setting/limit/perbarui'] = 'backend/setting/limit/perbarui';

// Slider
$route['setting/slider'] = 'backend/setting/slider';
$route['setting/slider/index'] = 'backend/setting/slider/index';
$route['setting/slider/simpan/(:any)'] = 'backend/setting/slider/simpan/$1';
$route['setting/slider/delete/(:any)'] = 'backend/setting/slider/delete/$1';

//produk frontend
$route['produk'] = 'frontend/produk';
$route['produk/show'] = 'frontend/produk/show';
$route['produk/show/(:num)'] = 'frontend/produk/show/$1';
$route['produk/view'] = 'frontend/produk/view';
$route['produk/view/(:num)'] = 'frontend/produk/view/$1';
$route['produk/detail/(:any)'] = 'frontend/produk/detail/$1';


// cart frontend
$route['cart'] = 'frontend/cart';
$route['cart/show'] = 'frontend/cart/show';
$route['cart/cart/(:any)'] = 'frontend/cart/cart/$1';
$route['cart/ajaxcart'] = 'frontend/cart/ajaxcart';
$route['cart/ajaxcart/(:any)'] = 'frontend/cart/ajaxcart/$1';
$route['cart/removecart'] = 'frontend/cart/removecart';
$route['cart/updatecart/(:any)'] = 'frontend/cart/updatecart/$1';

//checkout
$route['checkout'] = 'frontend/checkout';
$route['checkout/ajax'] = 'frontend/checkout/ajax';
$route['checkout/order'] = 'frontend/checkout/order';

//order
$route['order'] = 'frontend/order';

//member
$route['member'] = 'frontend/member';
$route['member/daftar'] = 'frontend/member/daftar';
$route['member/masuk'] = 'frontend/member/masuk';
$route['member/logout'] = 'frontend/member/logout';
$route['member/akun'] = 'frontend/member/akun';
$route['member/changePassword'] = 'frontend/member/changePassword';
$route['member/pesanan'] = 'frontend/member/pesanan';
$route['member/timeoutPesanan'] = 'frontend/member/timeoutPesanan';
$route['member/bukti_transfer/(:any)'] = 'frontend/member/bukti_transfer/$1';

//kategori frontend

$route['kategori'] = 'frontend/kategori';
$route['kategori/(:any)'] = 'frontend/kategori/index/$1';
// $route['kategori/show'] = 'frontend/kategori/show';
// $route['kategori/show/(:num)'] = 'frontend/kategori/show/$1';
// $route['kategori/view'] = 'frontend/kategori/view';
// $route['kategori/view/(:num)'] = 'frontend/kategori/view/$1';
// $route['kategori/detail/(:any)'] = 'frontend/kategori/detail/$1';

// orderan

$route['orderan'] = 'backend/orderan';
$route['orderan/info'] = 'backend/orderan/info';
$route['orderan/resi'] = 'backend/orderan/resi';
$route['orderan/detail/(:any)'] = 'backend/orderan/detail/$1';

// halaman

$route['halaman'] = 'backend/halaman';
$route['halaman/data'] = 'backend/halaman/data';
$route['halaman/data/(:any)'] = 'backend/halaman/data/$1';
$route['halaman/changepublish/(:any)'] = 'backend/halaman/changepublish/$1';
$route['halaman/simpan'] = 'backend/halaman/simpan';
$route['halaman/simpan/(:any)'] = 'backend/halaman/simpan/$1';
$route['halaman/delete/(:any)'] = 'backend/halaman/delete/$1';
$route['halaman/index/(:num)'] = 'backend/halaman/index/$1';
$route['halaman/index'] = 'backend/halaman/index';


//halaman frontend
$route['halaman/detail/(:any)'] = 'frontend/halaman/detail/$1';

// pembayaran bank
$route['setting/pembayaran'] = 'backend/setting/pembayaran';
$route['setting/pembayaran/data'] = 'backend/setting/pembayaran/data';
$route['setting/pembayaran/data/(:any)'] = 'backend/setting/pembayaran/data/$1';
$route['setting/pembayaran/changepublish/(:any)'] = 'backend/setting/pembayaran/changepublish/$1';
$route['setting/pembayaran/simpan'] = 'backend/setting/pembayaran/simpan';
$route['setting/pembayaran/simpan/(:any)'] = 'backend/setting/pembayaran/simpan/$1';
$route['setting/pembayaran/delete/(:any)'] = 'backend/setting/pembayaran/delete/$1';
$route['setting/pembayaran/index/(:num)'] = 'backend/setting/pembayaran/index/$1';
$route['setting/pembayaran/index'] = 'backend/setting/pembayaran/index';
