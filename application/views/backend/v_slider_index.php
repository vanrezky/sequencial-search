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
                            <div class="form-group row"> 
                                <div forminput="" class="mx-auto col-sm-12">
                                    <img id="image-preview" src="<?= isset($data['gambar']) ? base_url('uploads/produk/medium/' . $data['gambar']) : '' ?>" alt="image preview"/>
                                </div>
                            </div>
                            <br/>
                            <div  class="mx-auto col-md-8"  >
                                
                                <?php
                                    $limit = 6;
                                    $no = 1;
                                    foreach ($data as $value) { ?>
                                    <form id="formSlider<?= $no;?>" method="post" action="<?= base_url('setting/slider/simpan/')?>" data-id="<?= encode($value['id']);?>">
                                        <?=  "<input type='hidden' id='txt_csrfname' name='". $this->security->get_csrf_token_name() ."' value='" . $this->security->get_csrf_hash() . "'>";?>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Slider <?= $no;?></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input Ffile type="file" class="custom-file-input" name="slider" id="image-source<?= $no;?>">
                                                        <label class="custom-file-label" for="image-source<?= $no;?>" >Choose file</label>
                                                        
                                                    </div>
                                                <div class="input-group-append">
                                                    <button class="input-group-text" type="submit" >Upload</button>
                                                    <?php
                                                        if (isset($value['slider'])) {
                                                            echo "<a href='" . base_url('uploads/slider/' . $value['slider']) . "' target='_blank' class='input-group-text' title=''><i class='fas fa-eye'></i></a>";
                                                            echo "<button class='input-group-text' type='button' buttonDelete><i class='fas fa-trash-alt'></i></button>";
                                                        } 
                                                    ?> 
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                <?php $no++; } ?>
                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    #image-preview{
        display: none;
        width : 800px;
        height : 267px;
    }
</style>
<script src="<?= base_url('assets/');?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
    $(document).ready(function(){
        bsCustomFileInput.init();
        $(document).on('change', '[Ffile]', function(){
            
            var id = $(this).attr("id");
            multiPreviewImage(id);
        });

        <?php $no = 1; foreach  ($data as $value) {  ?>
            $(document).on('submit', '#formSlider<?= $no;?>', function (e) {
                e.preventDefault();
                var id = $(this).closest('form').data('id');
                SimpanMaster(this, $(this).attr('action') + id, function(success) {
                    // if (success.success) reload();
                }, function(error) {});
                return false;
            });
        <?php $no++; } ?>
        $(document).on('click', '[buttonDelete]', function (e) {
            var id = $(this).closest('form').data('id');
            $.ajax({
                url: BASEURL + 'setting/slider/delete/' + id,
                type: 'POST',
                dataType: 'JSON',
                success: function(data) {
                    if (data.success) {
                        Swal.fire(
                            'Berhasil!',
                            data.message,
                            'success'
                        ).then( () => {
                            location.reload();
                        })
                    } else {
                        Swal.fire(
                        'Terjadi Kesalahan!',
                        data.message,
                        'error'
                        );
                    }
                }
            });
            return false;
        });
    });

    
</script>

