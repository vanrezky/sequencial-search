<?php $info =  get_informasi(); ?>
<div class="content-wrapper">
    <?php $this->load->view('backend/templates/breadcrumbs'); ?>
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
                            <form id="submitInformasi" role="form" class="mx-auto col-md-6" action="#" method="post">
                                <?= "<input type='hidden' id='txt_csrfname' name='" . $this->security->get_csrf_token_name() . "' value='" . $this->security->get_csrf_hash() . "'>"; ?>
                                <?php
                                echo FormInputText('Nama Website', 'nama', $info->nama);
                                echo FormInputText('Email', 'email', $info->email);
                                $provinsi = $info->provinsi;
                                echo FormDropdownText('Provinsi|<i class="text-danger">*</i>', 'provinsi', [
                                    ['id' => '', 'provinsi' => 'pilih']
                                ], 'id', 'provinsi', $provinsi);
                                $kabupaten =  $info->kabupaten;
                                echo FormDropdownText('Kabupaten/Kota|<i class="text-danger">*</i>', 'kabupaten', [
                                    ['id' => '', 'kabupaten' => 'pilih']
                                ], 'id', 'kabupaten', $kabupaten);
                                echo FormInputText('Deskripsi', 'deskripsi', $info->deskripsi);
                                echo FormInputText('Keyword', 'keyword', $info->keyword);
                                echo FormInputText('Google Verifikasi', 'google_site_verification', $info->google_site_verification);
                                echo FormInputText('Copyright', 'copyright', $info->copyright);
                                echo FormInputNumber('Kontak 1', 'kontak1', $info->kontak1);
                                echo FormInputNumber('Kontak 2', 'kontak2', $info->kontak2);
                                echo FormInputText('Facebook Link', 'facebook_link', $info->facebook_link);
                                echo FormInputText('Instagram Link', 'instagram_link', $info->instagram_link);
                                echo FormInputText('Twitter Link', 'twitter_link', $info->twitter_link);
                                ?>
                                <div class="form-group row">
                                    <div class="col-sm-4"></div>
                                    <div forminput="" class="col-sm-8">
                                        <img id="image-preview" src="<?= !empty($info->logo) ? base_url('uploads/settings/' . $info->logo) : '' ?>" alt="image preview" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label formlabel="" class="col-sm-4 col-form-label" for="image-source">Logo </label>
                                    <div forminput="" class="col-sm-8">
                                        <input name="logo" type="file" id="image-source" onchange="previewImage();">
                                        <?php
                                        $logo = $info->logo;
                                        if (!empty($logo)) {
                                            echo "<input name='elogo' value='$logo' type='hidden'>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label formlabel="" class="col-sm-4 col-form-label" for="form-field-favicon">Favicon</label>
                                    <div forminput="" class="col-sm-8">
                                        <input name="favicon" type="file" id="form-field-favicon">
                                        <?php
                                        $favicon = $info->favicon;
                                        if (!empty($favicon)) {
                                            echo "<a href='" . base_url('uploads/settings/' . $favicon) . "' target='_blank' class='btn btn-sm btn-default' title='favicon website'><i class='fas fa-eye'></i></a>";
                                            echo "<input name='efavicon' value='$favicon' type='hidden'>";
                                        }
                                        ?>


                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
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
        echo !empty($info->logo) ? 'display:block;' : 'display:none;';
        ?>width: 149px;
        height: 37px;
    }
</style>
<script>
    const provinsi = '<?= !empty($provinsi) ? $provinsi : ''; ?>';
    const kabupaten = '<?= !empty($kabupaten) ? $kabupaten : ''; ?>';
    ajaxprovinsi();

    function ajaxprovinsi() {
        var nameSelect = $('[name="provinsi"]');
        $.ajax({
            url: BASEURL + 'rajaongkir/provinsi',
            type: 'GET',
            dataType: 'JSON',
            beforeSend: function() {
                $('[name="kabupaten"]').prop('disabled', true);
            },
            success: function(x) {
                $('[name="kabupaten"]').prop('disabled', false);
                nameSelect.empty();
                $.each(x, function(index, value) {
                    nameSelect.append('<option value="' + value.province_id + '">' + value.province + '</option>').find('option[value="' + provinsi + '"]').prop('selected', true);
                });
                if (nameSelect.val() != '' || nameSelect.val() != ' ') {
                    nameSelect.trigger('change');
                }
            },
            error: function(x) {
                console.log(x);
            }
        });
    };

    $('[name="provinsi"]').change(function() {
        var id = $(this).val();
        var nameSelect = $('[name="kabupaten"]');
        $.ajax({
            url: BASEURL + 'rajaongkir/kota',
            type: 'GET',
            data: {
                kota: id
            },
            dataType: 'JSON',
            beforeSend: function() {
                nameSelect.prop('disabled', true);
            },
            success: function(x) {
                nameSelect.prop('disabled', false);
                nameSelect.empty();
                $.each(x, function(index, value) {
                    nameSelect.append('<option value="' + value.city_id + '">' + value.city_name + '</option>').find('option[value="' + kabupaten + '"]').prop('selected', true);
                });
            },
            error: function(x) {
                console.log(x);
            }

        });
    });
    $(document).ready(function() {
        $(document).on('submit', '#submitInformasi', function(e) {
            e.preventDefault();
            SimpanMaster(this, '<?= base_url("setting/informasi/perbarui/") ?>', function(success) {
                // if (success.success) reload();
            }, function(error) {});
            return false;
        });
    });
</script>