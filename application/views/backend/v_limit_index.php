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
                            <form id="submitLimit" role="form" class="mx-auto col-md-6" action="#" method="post">
                            
                                <?php
                                //txt_csrfname
                                        echo "<input type='hidden' id='txt_csrfname' name='". $this->security->get_csrf_token_name() ."' value='" . $this->security->get_csrf_hash() . "'>";
                                    echo FormInputNumber('Produk Terbaru', 'produk_terbaru', get_limit('produk_terbaru'));
                                    echo FormInputNumber('Produk Pilihan', 'produk_pilihan', get_limit('produk_pilihan'));
                                    echo FormInputNumber('Brand', 'brand', get_limit('brand'));
                                ?>
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
<script>
    $(document).ready(function(){
        $(document).on('submit', '#submitLimit', function (e) {
            e.preventDefault();
            SimpanMaster(this, '<?= base_url("setting/limit/perbarui/")?>', function(success) {
                // if (success.success) reload();
            }, function(error) {});
            return false;
        });
    });

    
</script>

