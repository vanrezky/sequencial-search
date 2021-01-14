<link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/summernote/summernote-bs4.css">
<link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<div class="content-wrapper">
    <? $this->load->view('backend/templates/breadcrumbs');?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-append">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="submitHalaman" role="form" class="col-md-12" action="<?= base_url("halaman/simpan/" . (isset($data['id']) ? encode($data['id']) : '')); ?>" method="post" method="post">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label class="form-label" for="judul">Judul Halaman</label>
                                        <input class="form-control" name="judul" value="<?= isset($data['judul']) ? $data['judul'] : '' ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label class="form-label" for="isi">Isi Halaman</label>
                                        <textarea name="isi" class="form-control isi" rows="3" placeholder="isi" style="margin-top: 0px; margin-bottom: 0px; height: 250px;" for="isi"><?= isset($data['isi']) ? $data['isi'] : ''; ?></textarea>
                                    </div>
                                </div>
                                <?php echo FormDropdownText('Publikasi', 'publish', [
                                    ['value' => 1, 'label' => 'Publish'],
                                    ['value' => 0, 'label' => 'Unpublish'],
                                ], 'value', 'label', isset($data['publish']) ? $data['publish'] : '');
                                ?>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script script src="<?= base_url('assets/') ?>plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/select2/js/select2.full.min.js"></script>
<script>
    $('.select2').select2()
    $(function() {
        $('.isi').summernote({
            // toolbar: [
            //     ['style', ['bold', 'italic', 'underline', 'clear']],
            //     ['fontsize', ['fontsize']],
            //     ['para', ['ul', 'ol', 'paragraph']],
            // ]
        })
    });
    $(document).ready(function() {
        $(document).on('submit', '#submitHalaman', function(e) {
            e.preventDefault();
            SimpanMaster(this, $(this).attr('action'), function(success) {
                // if (success.success) reload();
            }, function(error) {});
            return false;
        });
    });
</script>