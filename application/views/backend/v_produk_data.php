<link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/summernote/summernote-bs4.css">
<link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<div class="content-wrapper">
    <? $this->load->view('backend/templates/breadcrumbs');?>
    <div class="content">
        <?= $this->session->flashdata('message') ?>
        <?php
        array_unshift($brand, ['id' => '', 'nm_brand' => 'Pilih']);
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"></h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-append">
                                        <a href="<?= base_url('master/produk/') ?>" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="mx-auto col-md-6" role="form" id="submitProduk" action="<?= base_url("master/produk/simpan/" . (isset($data['id']) ? encode($data['id']) : '')); ?>" method="post">
                                <div class="form-group row">
                                    <div class="col-sm-4"></div>
                                    <div forminput="" class="col-sm-8">
                                        <img id="image-preview" src="<?= isset($data['gambar']) ? base_url('uploads/produk/medium/' . $data['gambar']) : '' ?>" alt="image preview" />
                                    </div>
                                </div>
                                <br />
                                <div class="form-group row">
                                    <label formlabel="" class="col-sm-4 col-form-label" for="gambar"> Gambar <i class="text-danger">*</i></label>
                                    <div forminput="" class="col-sm-8">
                                        <small class="text-danger">Rekomendasi gambar 1000x1000 px</small>
                                        <input Fgambar name="gambar" type="file" id="image-source" for="gambar" onchange="previewImage();" />
                                        <?php
                                        if (isset($data['gambar'])) {
                                            echo "<a href='" . base_url('uploads/produk/' . $data['gambar']) . "' target='_blank' class='btn btn-sm btn-default' title='logo website'><i class='fas fa-eye'></i></a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                                echo FormInputText('Slug', 'slug', isset($data['slug']) ? $data['slug'] : '', TRUE);
                                echo FormInputText('Nama Produk|<i class="text-danger">*</i>', 'title', isset($data['title']) ? $data['title'] : '', FALSE, 'onkeyup="createTextSlug()"');
                                echo FormInputNumber('Harga Baru|<i class="text-danger">*</i>', 'harga_baru', isset($data['harga_baru']) ? $data['harga_baru'] : '');
                                echo FormInputNumber('Harga Lama', 'harga_lama', isset($data['harga_lama']) ? $data['harga_lama'] : '');
                                echo FormInputText('Kuantitas', 'kuantitas', isset($data['kuantitas']) ? $data['kuantitas'] : '');
                                echo FormInputText('Deskripsi Singkat|<i class="text-danger">*</i>', 'deskripsi_singkat', isset($data['deskripsi_singkat']) ? $data['deskripsi_singkat'] : '');
                                echo FormInputNumber('Berat (Gram)|<i class="text-danger">*</i>', 'berat', isset($data['berat']) ? $data['berat'] : '');
                                ?>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="variasi">Variasi</label>
                                    <div class="col-md-8">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="variasi" <?= isset($data['variasi']) ? ($data['variasi'] == 1 ? 'checked' : '') : ''; ?> name="variasi">
                                            <label class="custom-control-label" for="variasi">Aktifkan Variasi ?</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="sub_variasi" style="display:<?= isset($data['variasi']) ? ($data['variasi'] == 1 ? 'block' : 'none') : 'none'; ?>">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label">Warna</label>
                                        <div class="col-md-8">
                                            <div class="select2-purple">
                                                <select class="select2" id="warna" multiple="multiple" name="warna[]" data-placeholder="Pilih warna" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                                    <?php
                                                    foreach ($warna as $key => $value) {
                                                        echo "<option value='$value[id]'>$value[warna]</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label">Ukuran</label>
                                        <div class="col-md-8">
                                            <div class="select2-purple">
                                                <select class="select2" id="ukuran" multiple="multiple" name="ukuran[]" data-placeholder="Pilih ukuran" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                                    <?php
                                                    foreach ($ukuran as $key => $value) {
                                                        echo "<option value='$value[id]'>$value[ukuran]</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="deskripsi">Deskripsi</label>
                                    <div class="col-sm-8">
                                        <textarea name="deskripsi" class="form-control deskripsi" rows="3" placeholder="Deskripsi" style="margin-top: 0px; margin-bottom: 0px; height: 250px;" for="deskripsi"><?= isset($data['deskripsi']) ? $data['deskripsi'] : ''; ?></textarea>
                                    </div>
                                </div>

                                <?php
                                echo FormDropdownText('Brand|<i class="text-danger">*</i>', 'brand', $brand, 'id', 'nm_brand', isset($data['brand']) ? $data['brand'] : '');
                                echo FormDropdownText('Kategori|<i class="text-danger">*</i>', 'kategori', $kategori, 'id', 'nm_kategori', (isset($data['kategori']) ? $data['kategori'] : ''));
                                echo FormDropdownText('Publikasi', 'publish', [
                                    ['value' => 1, 'label' => 'Publish'],
                                    ['value' => 0, 'label' => 'Unpublish'],
                                ], 'value', 'label', isset($data['publish']) ? $data['publish'] : '');
                                ?>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                                    <a href="<?= base_url('master/produk/') ?>" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    #image-preview {
        display: <?= isset($data['gambar']) ? 'block' : 'none'; ?>;
        width: 250px;
    }
</style>
<script src="<?= base_url('assets/') ?>plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/select2/js/select2.full.min.js"></script>
<script>
    $('.select2').select2()
    $(function() {
        $('.deskripsi').summernote({
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
            ]
        })
    });
    $(document).ready(function() {
        var my_warna = '<?= isset($data['warna']) ? $data['warna'] : '' ?>';
        var str_array = my_warna.split(',');

        $('#warna').val(str_array);
        $('#warna').trigger('change');

        var my_ukuran = '<?= isset($data['ukuran']) ? $data['ukuran'] : '' ?>';
        var str_array = my_ukuran.split(',');

        $('#ukuran').val(str_array);
        $('#ukuran').trigger('change');

        $(document).on('change', '#variasi', function() {
            if ($(this).is(":checked")) {
                $('#sub_variasi').show();
            } else {
                $('#sub_variasi').hide();
                $('#warna').val(null).trigger('change');
                $('#ukuran').val(null).trigger('change');
            }
        });
        $(document).on('submit', '#submitProduk', function(e) {
            e.preventDefault();
            var fileInput = $.trim($('[Fgambar]').val());

            <?php if (!isset($data['gambar'])) { ?>
                if (fileInput == '') {
                    Swal.fire(
                        'Terjadi Kesalahan!',
                        'Silahkan pilih gambar terlebih dahulu!',
                        'error'
                    );
                    return false;
                }
            <?php } ?>

            SimpanMaster(this, $(this).attr('action'), function(success) {
                // if (success.success) reload();
            }, function(error) {});
            return false;
        });
    });
</script>