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
                            <form id="submitpembayaran" role="form" class="mx-auto col-md-6" action="<?= base_url("setting/pembayaran/simpan/" . (isset($data['id']) ? encode($data['id']) : '')); ?>" method="post" method="post">
                                <?php
                                echo FormInputText('Nama Bank', 'nama_bank', isset($data['id']) ? $data['id'] : '', isset($data['id']) ? true : false);
                                echo FormInputText('Atas Nama', 'atas_nama', isset($data['atas_nama']) ? $data['atas_nama'] : '');
                                echo FormInputNumber('Nomor Rekening', 'no_rek', isset($data['no_rek']) ? $data['no_rek'] : '');
                                ?>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                                    <a href="<?= base_url('setting/pembayaran')?>" class="btn btn-warning"><i class="fas fa-window-close"></i> Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).on('submit', '#submitpembayaran', function(e) {
            e.preventDefault();
            SimpanMaster(this, $(this).attr('action'), function(success) {
                // if (success.success) reload();
            }, function(error) {});
            return false;
        });
    });
</script>