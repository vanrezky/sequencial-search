<div class="modal fade modal-wrapper" id="produkModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-inner-area sp-area row">
                    <div class="col-lg-5">
                        <div class="sp-img_area">
                            <div class="kenne-element-carousel">
                                <div class="single-slide red">
                                    <img src="<?= base_url('assets/frontend/images/product/1-1.jpg');?>" id="produkGambar" alt="Gambar produk">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6">
                        <div class="sp-content">
                            <div class="sp-heading">
                                <h5><a href="javascript:void(0)" id="produkNama"></a></h5>
                            </div>
                            <div class="price-box" id="produkHarga">
                            </div>
                            <div class="sp-essential_stuff">
                                <ul id="produkInfo">
                                </ul>
                            </div>
                            <div class="color-list_area">
                                <div class="color-list_heading">
                                    <h4>Pilih Opsi</h4>
                                </div>
                                <strong class="sub-title">Pilihan Warna</strong>
                                <div class="color-list" id="variasiWarna">
                                    <?php
                                        if (!empty($warna)) {
                                            
                                            foreach ($warna as $key => $value) {
                                                echo "<a href='javascript:void(0)' class='single-color' data-id='" . encode($detail_warna['id']) . "'>
                                                            <span class='color-block'>$detail_warna[warna]</span>
                                                        </a>";
                                            }

                                        }
                                    ?>
                                    
                                </div>
                                <strong class="sub-title" style="margin-top:10px; !important">Pilihan Ukuran</strong>
                                <div class="color-list" id="variasiUkuran"></div>
                            </div>
                                <div class="quantity">
                                    <label>Jumlah</label>
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box" name="quantity" value="1" type="text">
                                        <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                        <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                    </div>
                                </div>
                                <div class="kenne-group_btn">
                                    <ul id="dataid" data-id="">
                                        <li><a href="javascript:void(0);" addCart2 class="add-to_cart">Tambah ke Keranjang</a></li>
                                        <!-- <li><a href="<?= base_url('cart')?>" class="add-to_cart"><span class="fas fa-cart-arrow-down"></span> Lihat Troli</a></li> -->
                                    </ul>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>