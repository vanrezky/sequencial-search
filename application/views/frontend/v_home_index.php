        <!-- Begin Product Area -->
        <div class="product-area ">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h3>Produk Terbaru</h3>
                            <div class="product-arrow">
                                <a href="<?= base_url('produk'); ?>">Lihat Semua > </a>
                            </div>
                        </div>
                        <div class="shop-product-wrap row">
                            <?php foreach ($produk_terbaru as $key => $value) { ?>
                                <div class="col-lg-2 col-md-3 col-sm-6 col-6 custom-div">
                                    <div class="product-item">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <a href="<?= base_url('produk/detail/' . $value['slug']); ?>">
                                                    <img class="primary-img" src="<?= base64_image(base_url('uploads/produk/medium/') . $value['gambar']); ?>" alt="<?= $value['title'] ?>">
                                                </a>
                                                <span class="sticker-2"><?= discount($value['harga_baru'], $value['harga_lama']); ?>% OFF</span>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-desc_info">
                                                    <h3 class="product-name"><a href="<?= base_url('produk/detail/' . $value['slug']); ?>"><?= character_limiter($value['title'], 40); ?></a></h3>
                                                    <div class="price-box">
                                                        <?php if (!empty($value['harga_lama'])) {
                                                            echo "<span class='old-price'>Rp." . rupiah($value['harga_lama']) . "</span>";
                                                        } ?>
                                                        <span class="new-price">Rp.<?= rupiah($value['harga_baru']); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $data = $kategori_pilihan;
        if (!empty($data)) {
            foreach ($data as $key => $value) { ?>
                <div class="product-area ">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-title">
                                    <h3><?= ucwords($value['nm_kategori']) ?></h3>
                                    <div class="product-arrow">
                                    </div>
                                </div>
                                <div class="shop-product-wrap row">
                                    <?php
                                    $produk = $produk_pilihan->get_produk_pilihan($value['id']);
                                    foreach ($produk as $k => $v) { ?>
                                        <div class="col-lg-2 col-md-3 col-sm-6 col-6 custom-div">
                                            <div class="product-item">
                                                <div class="single-product">
                                                    <div class="product-img">
                                                        <a href="<?= base_url('produk/detail/' . $v['slug']); ?>">
                                                            <img class="primary-img" src="<?= base64_image(base_url('uploads/produk/medium/') . $v['gambar']); ?>" alt="<?= $v['title'] ?>">
                                                        </a>
                                                        <span class="sticker-2"><?= discount($v['harga_baru'], $v['harga_lama']); ?>% OFF</span>
                                                    </div>
                                                    <div class="product-content">
                                                        <div class="product-desc_info">
                                                            <h3 class="product-name"><a href="<?= base_url('produk/detail/' . $v['slug']); ?>"><?= character_limiter($v['title'], 40); ?></a></h3>
                                                            <div class="price-box">
                                                                <?php if (!empty($v['harga_lama'])) {
                                                                    echo "<span class='old-price'>Rp." . rupiah($v['harga_lama']) . "</span>";
                                                                } ?>
                                                                <span class="new-price">Rp.<?= rupiah($v['harga_baru']); ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php }
        }
        ?>