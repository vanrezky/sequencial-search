<div class="content-wrapper">
<? $this->load->view('backend/templates/breadcrumbs');?>
    <div class="content">
        <?= $this->session->flashdata('message') ?>
        <?php if (validation_errors()) { ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors() ?>
            </div>
        <?php } ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"></h3>

                            <div class="card-tools">
                            <div class="input-group input-group-sm">
                                <div class="input-group-append">
                                <a href="<?= base_url('master/kategori/')?>" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="submitKategori" class="mx-auto col-md-6" role="form" action="<?= base_url("master/kategori/simpan/" . (isset($data['id']) ? encode($data['id']) : ''));?>" method="post">
                                <div class="form-group row"> 
                                    <div class="col-sm-4"></div>
                                    <div forminput="" class="col-sm-8">
                                        <img id="image-preview" src="<?= isset($data['gambar']) ? base_url('uploads/kategori/' . $data['gambar']) : '' ?>" alt="image preview"/>
                                    </div>
                                </div>
                                <br/>
                                <div class="form-group row"> 
                                    <label formlabel="" class="col-sm-4 col-form-label" for="gambar"> Gambar <i class="text-danger">*</i></label> 
                                    <div forminput="" class="col-sm-8">
                                        <small class="text-danger">Rekomendasi gambar 62x62 px</small>
                                        <input Fgambar name="gambar" type="file" id="image-source" for="gambar" onchange="previewImage();"/>
                                        <?php
                                            if (isset($data['gambar'])) {
                                                echo "<a href='" . base_url('uploads/kategori/' . $data['gambar']) . "' target='_blank' class='btn btn-sm btn-default' title='logo website'><i class='fas fa-eye'></i></a>";
                                                
                                            } 
                                        ?> 
                                    </div>
                                </div>
                                <?php
                                    echo FormInputText('Slug', 'slug', isset($data['slug']) ? $data['slug'] : '', TRUE);
                                    echo FormInputText('Nama kategori', 'title', isset($data['nm_kategori']) ? $data['nm_kategori'] : '', FALSE, 'onkeyup="createTextSlug()"');
                                    echo FormInputText('Deskripsi', 'deskripsi', isset($data['deskripsi']) ? $data['deskripsi'] : '');
                                    echo FormDropdownText('Publikasi', 'publish' , [
                                        ['value' => 1, 'label' => 'Publish' ],
                                        ['value' => 0, 'label' => 'Unpublish' ],
                                    ], 'value', 'label', isset($data['publish']) ? $data['publish'] : '');
                                    echo FormInputNumber('Urutan', 'urutan', isset($data['urutan']) ? $data['urutan'] : '');
                                ?>
                                
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                                    <a href="<?= base_url('master/kategori/')?>" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
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
        <?php
            echo isset($data['gambar']) ? 'display:block;' : 'display:none;';
        ?>
        width : 50px;
        height : 50px;
    }
</style>
<script>
    $(document).ready(function(){
        $(document).on('submit', '#submitKategori', function (e) {
            e.preventDefault();
            var fileInput = $.trim($('[Fgambar]').val());

            <?php if (!isset($data['gambar'])) { ?>
                if(fileInput=='') {
                Swal.fire(
                    'Terjadi Kesalahan!',
                    'Silahkan pilih gambar terlebih dahulu!',
                    'error'
                    );
                    return false;
                }
            <?php } ?>

            SimpanMaster(this,  $(this).attr('action'), function(success) {
                // if (success.success) reload();
            }, function(error) {});
            return false;
        });
    });
</script>

