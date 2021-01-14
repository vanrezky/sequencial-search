<div class="shop-product-wrap row">
<?php
    if (empty($produk)) {
        echo "<div class='mx-auto mt-5'><h3>Produk tidak ditemukan!</h3></div>";
    } else {
        foreach ($produk as $key => $value) { ?>
            <div class="col-xl-2 col-lg-3 col-md-3 col-6 custom-div">
                <div class="product-item">
                    <div class="single-product">
                        <div class="product-img">
                            <a href="<?= base_url('produk/detail/' .$value['slug'] );?>">
                                <img class="primary-img" src="<?= base64_image(base_url('uploads/produk/medium/' . $value['gambar']));?>" alt="<?= $value['title']?>">
                            </a>
                            <span class="sticker-2"><?= discount($value['harga_baru'], $value['harga_lama']);?>% OFF</span>
                            <div class="add-actions">
                                <ul data-id="<?= base64_encode($value['id']);?>">
                                    <!-- <li class="quick-view-btn" detailProduk ><a href="javascript:void(0)" title="Quick View"><i class="ion-ios-search"></i></a></li> -->
                                    <!-- <li><a href="javascript:void(0);" addCart data-qty="1" data-toggle="tooltip" data-placement="right" title="Add To cart"><i class="ion-bag"></i></a></li> -->
                                    <!-- <li><a href="javascript:void(0);"  data-qty="1" data-toggle="tooltip" data-placement="right" title="Pesan Via Whatsapp"><i class="ion-social-whatsapp"></i></a></li> -->
                                </ul>
                            </div>
                        </div>
                        <div class="product-content">
                            <div class="product-desc_info">
                                <h3 class="product-name"><a href="<?= base_url('produk/detail/' .$value['slug'] );?>"><?= character_limiter($value['title'], 40)?></a></h3>
                                <div class="price-box">
                                    <?php if (!empty($value['harga_lama'])) {
                                        echo "<span class='old-price'>Rp." . rupiah($value['harga_lama']) . "</span><br/>";
                                    } ?>
                                    <span class="new-price">Rp.<?= rupiah($value['harga_baru']);?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
<?php 
        } 
    } ?>
</div>
<?php if (!empty($pagin)) : ?>
<div class="row">
    <div class="col-lg-12">
        <div class="kenne-paginatoin-area">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="kenne-pagination-box primary-color pagination">
                        <?= $pagin; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>