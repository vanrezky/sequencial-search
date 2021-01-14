<div class="content-wrapper">
<? $this->load->view('templates/breadcrumbs');?>
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
                                <a href="<?= base_url('master/ruangan/')?>" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="offset-3 col-md-6" role="form" action="<?= base_url("master/ruangan/data/" . (isset($data['id_ruangan']) ? encode($data['id_ruangan']) : ''));?>" method="post">
                                <?php
                                    echo FormInputText('Kode Ruangan', 'kode_ruangan', isset($data['kode_ruangan']) ? $data['kode_ruangan'] : '');
                                    echo FormInputText('Nama Ruangan', 'nama_ruangan', isset($data['nama_ruangan']) ? $data['nama_ruangan'] : '');
                                    echo FormDropdownText('unit', 'id_unit' ,$unit , 'id_unit', 'nama_unit', isset($data['id_unit']) ? $data['id_unit'] : '');
                                    echo FormDropdownText('Gedung', 'id_gedung' ,$gedung, 'id_gedung', 'nm_gedung', isset($data['id_gedung']) ? $data['id_gedung'] : '');
                                    echo FormInputText('Kuota', 'kuota', isset($data['kuota']) ? $data['kuota'] : '');
                                    ?>
                                
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                                    <a href="<?= base_url('master/ruangan/')?>" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
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
    <?php
    if (isset($data)) {
        if ($data['jenis_unit'] == 3) {
            echo "$('[hideDiv]').show();";
        }
    }
    ?>
    $(document).ready(function() {
        $('[name="jenis_unit"]').change(function () {
            var v = $(this).val();
            if (v == '3') {
                $('[hideDiv]').show();
            } else {
                $('[hideDiv]').hide();
                $('[name="induk_unit"]').val(null).trigger('change');
                $('[name="idjenjang_unit"]').val(null).trigger('change');
            }
        });
    });
</script>

