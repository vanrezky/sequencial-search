<div class="kenne-cart-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?= $this->session->flashdata('message'); ?>
                <form action="javascript:void(0)">
                    <div class="table-content table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="kenne-product-remove">Hapus</th>
                                    <th class="kenne-product-thumbnail">Gambar</th>
                                    <th class="cart-product-name">Produk</th>
                                    <th class="kenne-product-price">Harga Pcs (Rp)</th>
                                    <th class="kenne-product-quantity">Jumlah</th>
                                    <th class="kenne-product-quantity">Berat</th>
                                    <th class="kenne-product-subtotal">Total (Rp)</th>
                                </tr>
                            </thead>
                            <tbody cartShow>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-5 ml-auto">
                            <div class="cart-page-total">
                                <h3>Ringkasan Belanja</h3>
                                <ul>
                                    <li jumlahBarang>Total Jumlah Barang <span>0</span></li>
                                    <li totalBerat>Total Berat Barang <span>0</span></li>
                                    <li totalBarang>Total Harga Barang <span>0</span></li>

                                </ul>
                                <a href="<?= base_url('checkout'); ?>">Lanjut Pembayaran</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        showcart();
    });
</script>