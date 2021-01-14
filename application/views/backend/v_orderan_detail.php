<div class="content-wrapper">
    <? $this->load->view('backend/templates/breadcrumbs');?>
    <div class="content">
        <div class="container-fluid">
            <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                    <div class="col-12">
                        <h4>
                            <i class="fas fa-globe"></i> <?= $orderan['no_order'] ?>
                            <small class="float-right">Date: <?= $orderan['tgl_order']; ?></small>
                        </h4>
                    </div>
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        Dari
                        <address>
                            <strong><?= ucfirst($costumer['c_nama']); ?></strong><br>
                            Phone: <?= $costumer['c_nohp']; ?><br>
                            Email: <?= $costumer['c_email']; ?>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        Ke
                        <address>
                            <strong><?= ucfirst($orderan['nama_penerima']); ?></strong><br>
                            <?= "$orderan[alamat], <br/> 
                            $orderan[kelurahan], $orderan[kecamatan], $orderan[kabupaten] <br/>
                            $orderan[provinsi], $orderan[kode_pos]" ?><br>
                            Phone: <?= $orderan['no_hp']; ?><br>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <b>No Order:</b> <?= $orderan['no_order']; ?><br>
                        <?php
                        $image = !empty($orderan['bukti_bayar']) ?  base_url('uploads/transfer/' . $orderan['bukti_bayar']) : base_url('uploads/transfer/noimage.png');
                        ?>
                        <b>Bukti bayar:</b> <a href="javascript:void(0);" onclick="window.open('<?= $image; ?>', 
                         'newwindow', 
                         'width=500,height=400'); 
                          return false;" class="badge badge-info">Disini</a><br>
                        <b>Kurir: </b><?= strtoupper($orderan['kurir']); ?><br />
                        <b>Paket: </b><?= $orderan['paket']; ?><br />
                        <b>Status Bayar: </b><?= ucfirst($orderan['status_bayar']); ?><br />
                        <b>Status Order: </b><?= status_order($orderan['status_order']); ?>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Qty</th>
                                    <th>Produk</th>
                                    <th>Variasi</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($orderan_detail as $key => $value) {

                                    echo "<tr>";
                                    echo "<td>$value[produk_qty]</td>";
                                    echo "<td>$value[produk_nama]</td>";
                                    echo "<td>";
                                    if ($value['variasi'] == 'ya') {
                                        echo $value['warna'];
                                        if (!empty($value['ukuran'])) echo " ($value[ukuran])";
                                    } else {
                                        $value['variasi'];
                                    }
                                    echo "</td>";
                                    echo '<td>Rp ' . ifUang($value['produk_harga']) . '</td>';
                                    echo '<td>Rp ' . ifUang($value['produk_harga'] * $value['produk_qty']) . '</td>';
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-lg-6 col-sm-12">
                        <p class="lead">Metode Pembayaran:</p>
                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                            Transfer ke bank <?= $orderan['bank'] .  ' no rekening ' . $orderan['no_rek'] ?>
                        </p>
                    </div>
                    <!-- /.col -->
                    <div class="col-lg-6 col-sm-12">
                        <p class="lead">Detail Pembayaran</p>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td>Rp <?= ifUang($orderan['order_total']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Ongkir:</th>
                                        <td> Rp <?= ifUang($orderan['ongkir']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td>Rp <?= ifUang($orderan['order_total'] + $orderan['order_total']) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <?php
                    if ($orderan['status_bayar'] == 'sudah') { ?>
                        <div class="col-lg-6 col-sm-12">
                            <div class="input-group">
                                <input type="text" name="noresi" value="<?= $orderan['no_resi'] ?>" class="form-control" placeholder="No Resi">
                                <span class="input-group-append">
                                    <button btnResi type="button" class="btn btn-info btn-flat">Simpan</button>
                                </span>
                            </div>
                        </div>
                    <?php  } ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('[btnResi]').click(function() {
            const id = '<?= encode($orderan['id']) ?>';
            var no_resi = $('[name="noresi"]').val();
            var csrfName = $("#txt_csrfname").attr("name");
            var csrfHash = $("#txt_csrfname").val();
            if (no_resi == '') {
                return false;
            }
            $.ajax({
                url: BASEURL + 'orderan/resi',
                type: 'POST',
                data: {
                    id: id,
                    no_resi: no_resi,
                    [csrfName]: csrfHash
                },
                dataType: 'JSON',
                success: function(results) {
                    $("#txt_csrfname").val(results.csrfNewHash);
                    if (results.success) {
                        alert(results.message);
                    } else {
                        alert(results.message);
                    }
                },
                error: function(x) {
                    console.log(x);
                }
            })
        });

    });
</script>