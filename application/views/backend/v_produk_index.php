<div class="content-wrapper">
    <? $this->load->view('backend/templates/breadcrumbs');?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <?= $this->session->flashdata('message') ?>
                    <div class="card card-primary card-outline">
                        <div class="card-header">

                            <div class="card-tools">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control float-right" value="<?= $this->input->cookie('fProduk') ?>" placeholder="Search">

                                    <div class="input-group-append">
                                        <button fProduk type="button" class="btn btn-default"><i class="fas fa-search"></i></button>
                                        <a href="<?= base_url('master/produk/data/') ?>" class="btn btn-info"><i class="fas fa-plus"></i> Tambah</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tableDiv" class="card-body p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <!-- <th width="5%">NO</th> -->
                                        <th width="12%">Thumbnail</th>
                                        <th width="50%">Nama Produk</th>
                                        <th>Harga (Rp)</th>
                                        <th>Stok</th>
                                        <th>Variasi</th>
                                        <th width="5%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // $no = $this->uri->segment('4') + 1;
                                    if (empty($data)) {
                                        echo "<tr><td colspan='4' class='text-center'> Data Tidak Ditemukan!</td></tr>";
                                    } else {
                                        foreach ($data as $key => $value) {

                                            echo "<tr data-link='master/produk/delete/' data-id='" . encode($value['id']) . "'>";
                                            // echo "<td>" . $no++ . "</td>";
                                            echo "<td>";
                                            echo "<img alt='$value[title]' class='img-fluid img-thumbnail' src='" . base64_image(base_url('uploads/produk/small/') . $value['gambar']) . "'></li>";
                                            echo "</td>";
                                            echo "<td><b>" . character_limiter($value['title'], 40) . "</b><br/><span>" . character_limiter($value['deskripsi_singkat'], 120) . "</span></td>";
                                            echo "<td><b>" . ifUang($value['harga_baru']) . "</b><br/><del>" . ifUang($value['harga_lama']) . "</del></td>";
                                            echo "<td>$value[kuantitas]</td>";
                                            echo "<td><span class='fas fa-" . ($value['variasi'] == 1 ? 'check' : 'times') . "'></span></td>";
                                            echo "<td class='text-center'>";
                                            // echo "<button bView class='btn btn-icon btn-xs btn-default ml-1' title='Lihat Produk'><i class='fas fa-eye'></i></button>";
                                            echo "<button bChange class='btn btn-icon btn-xs btn-" . ($value['publish'] == 1 ? 'success' : 'warning') . " ml-1'><i class='fas fa-" . ($value['publish'] == 1 ? 'thumbs-up' : 'thumbs-down') . "'></i></button>";
                                            echo "<a href='" . base_url('master/produk/data/') . encode($value['id']) . "' class='btn btn-icon btn-xs btn-info ml-1'><i class='fas fa-pencil-alt' title='edit'></i></a>";
                                            echo "<a removeData href='javascript:void(0);' class='btn btn-icon btn-xs btn-danger ml-1'><i class='fas fa-trash'></i></a>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer float-right">
                            <?= $pagin; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .font10 {
        font-size: 14px;
    }
</style>
<script>
    $(document).ready(function() {
        $('[fProduk]').click(function() {
            Cookies.set('fProduk', $('[name="search"]').val());
            location.reload();
        });
        $(document).on('click', '[bChange]', function() {
            var url = 'master/produk/changepublish/';
            var id = $(this).closest('tr').data('id');
            var btn = $(this);
            changePublish(url, id, btn);
            return false;
        });

        // $('[bView]').click(function(){
        //     var id = $(this).closest('tr').data('id');
        //     $.ajax({
        //         url: BASEURL + 'master/produk/detail/' + id,
        //         type: "GET", 
        //         // dataType: 'json',
        //         success: function (x) {
        //             if (x.success) {
        //                 $('#modalDefault'). modal('show');
        //             } else {
        //                 Swal.fire(
        //                     'Terjadi Kesalahan!',
        //                     x.message,
        //                     'error'
        //                 );
        //             }
        //             return false;
        //         },
        //         error: function (data) {
        //             Swal.fire(
        //                 'Terjadi Kesalahan!',
        //                 data,
        //                 'error'
        //             );
        //         return false;
        //         }
        //     }).done(function () {
        //         return false;
        //     });
        //     return false;
        // });
    });
</script>