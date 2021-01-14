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
                                <a href="<?= base_url('master/user/')?>" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- . isset($data['id']) ? encode($data['id']) : '' -->
                            <form id="submitUser" role="form" action="<?= base_url("master/user/simpan/" . (isset($data['id']) ? encode($data['id']) : ''));?>" method="post">
                                <?php if (empty($data)) :?>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" value="<?= isset($data['email'])  ?  $data['email']  :  set_value('email') ?>" placeholder="Masukkan Email">
                                </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama " value="<?= isset($data['email'])  ?  $data['nama'] :  set_value('nama') ?>">
                                </div>
                                <?php if ($edit == FALSE) : ?>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" name="pass1" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword2">Ulangi Password</label>
                                        <input type="password" name="pass2" class="form-control" id="exampleInputPassword2" placeholder="Password">
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Role</label>
                                    <select class="form-control" name="role_id">
                                        <option value="">Pilih</option>
                                        <?php
                                            foreach ($role as $key => $value) {
                                                $s = ($value['id_role'] == $data['role_id']) ? 'selected' : '';
                                                echo "<option $s value='" . encode($value['id_role']) . "'>$value[role]</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                                    <a href="<?= base_url('master/user/')?>" class="btn btn-danger"><i class="fas fa-arrow-left"></i> Kembali</a>
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
        $(document).on('submit', '#submitUser', function (e) {
            e.preventDefault();
            SimpanMaster(this,  $(this).attr('action'), function(success) {
            }, function(error) {});
            return false;
        });
        
    })
</script>

