<div class="sp-area">
    <div class="container">
        <div class="sp-nav">
            <div class="row">
                <div class="col-lg-4">
                    <div class="sp-img_area">
                        <div class="sp-img_slider kenne-element-carousel">
                            <div class="">
                                <img src="<?= base_url('uploads/produk/'. $data['gambar']);?>" alt="<?= $data['title'];?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="sp-content">
                        <div class="sp-heading">
                            <h5><a href="#"><?= $data['title']?></a></h5>
                        </div>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="30%">Harga</td>
                                    <td>
                                        <div><h3 class="harga"><?= rupiah($data['harga_baru']);?> <small><del><?= rupiah($data['harga_lama'])?><del></small></h3></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kategori</td>
                                    <td><?= $data['nm_kategori'];?></td>
                                </tr>
                                <tr>
                                    <td>Brand</td>
                                    <td><?= $data['nm_brand'];?></td>
                                </tr>
                                <tr>
                                    <td>Berat</td>
                                    <td><?= $data['berat'];?> Gram</td>
                                </tr>
                                <tr>
                                    <td>Deskripsi</td>
                                    <td><?= $data['deskripsi_singkat'];?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="color-list_area" <?php if (!empty($warna) || !empty($ukuran)) echo "style='display:block;'"?>>
                            <div class="color-list_heading">
                                <h4>Pilih Opsi</h4>
                            </div>
                            <strong class="sub-title">Pilihan Warna</strong>
                            <div class="color-list" id="variasiWarna">
                                <?php
                                    if (!empty($warna)) {
                                        foreach ($warna as $key => $value) {
                                            echo "<a href='javascript:void(0)' class='single-color' data-id='" . encode($value['id']) . "'>
                                                        <span class='color-block'>$value[warna]</span>
                                                    </a>";
                                        }
                                    }
                                ?>
                            </div>
                            <strong class="sub-title" style="margin-top:10px; !important">Pilihan Ukuran</strong>
                            <div class="color-list" id="variasiUkuran">
                                <?php
                                    if (!empty($ukuran)) {
                                        foreach ($ukuran as $key => $value) {
                                            echo "<a href='javascript:void(0)' class='single-color' data-id='" . encode($value['id']) . "'>
                                                        <span class='color-block'>$value[ukuran]</span>
                                                    </a>";
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        
                        <div class="quantity">
                            <label>Jumlah</label>
                            <div class="cart-plus-minus">
                                <input class="cart-plus-minus-box" value="1" name="quantity" type="text">
                                <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                            </div>
                        </div>
                        <div class="qty-btn_area">
                            <ul data-id="<?= base64_encode($data['id']);?>">
                                <li><a class="qty-cart_btn" addCart2 href="javascript:void(0)">Tambah ke keranjang </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="product-tab_area-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="sp-product-tab_nav">
                    <div class="product-tab">
                        <ul class="nav product-menu">
                            <li><a class="active" data-toggle="tab" href="#deskripsi"><span>deskripsi</span></a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content uren-tab_content">
                        <div id="deskripsi" class="tab-pane active show" role="tabpanel">
                            <div class="product-description">
                               <?= html_entity_decode($data['deskripsi']);?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .harga {
        color: tomato;
        font-size: 30px;
    }
</style>