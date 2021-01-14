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
                            <input fUser type="text" name="table_search" class="form-control float-right" value="<?= $this->input->cookie('fUser');?>" placeholder="Search">
                            <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            <a href="<?= base_url('master/user/data/')?>" class="btn btn-info"><i class="fas fa-plus"></i> Tambah</a>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div id="tableDiv" class="card-body p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th width="5%">NO</th>
                                    <th>NAMA</th>
                                    <th>EMAIL</th>
                                    <th>LEVEL</th>
                                    <th width="20%" center>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                                <?php
                                    $no = $this->uri->segment('4') + 1;
                                    if (empty($data)) {
                                        echo "<tr><td colspan='5' class='text-center'>Data tidak ditemukan</td></tr>";
                                    } else {
                                        foreach ($data as $key => $value) {
                                            echo "<tr data-link='master/user/delete/' data-id='" . encode($value['id']) . "'>";
                                            echo "<td>" . $no++ . "</td>";
                                            echo "<td>$value[nama]</td>";
                                            echo "<td>$value[email]</td>";
                                            echo "<td>" . ($value['role']) . "</td>";
                                            echo "<td>";
                                            echo "<a href='" . base_url('master/user/data/') . encode($value['id']) . "' class='btn btn-icon btn-xs btn-info ml-1'><i class='fas fa-pencil-alt'></i></a>";
                                            echo "<a removeData href='javascript:void(0);' class='btn btn-icon btn-xs btn-danger ml-1'><i class='fas fa-trash'></i></a>";
                                            echo "<a resetPassword href='javascript:void(0);' class='btn btn-icon btn-xs btn-primary ml-1'><i class='fas fa-lock'></i></a>";

                                            echo"</td>";
                                            echo "</tr>";
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer float-right">
                        <?= $pagin;?>
                    </div>
                </div><!-- /.card -->
            </div>
        </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('[ResetPassword]').on('click', function(){
        var id = $(this).closest('tr').data('id');
        start(id);
        
    });
    $('[fUser]').change(function() {
        Cookies.set('fUser', $(this).val());
        location.reload();
    });

    async function start(param) {
        var csrfName = $('#txt_csrfname').attr('name');
        var csrfHash = $('#txt_csrfname').val();
        const { value: password } = await Swal.fire({
            title: 'Enter your password',
            input: 'password',
            inputLabel: 'Password',
            inputPlaceholder: 'Enter your password',
            inputAttributes: {
                maxlength: 10,
                autocapitalize: 'off',
                autocorrect: 'off'
            },
            inputValidator: (value) => {
                if (!value) {
                    return 'Tidak boleh kosong!'
                }
            }
        })
        if (password) {
            // Swal.fire(`Entered password: ${password}`)
            $.ajax({
                url: '<?= base_url('master/user/changepassword/')?>' + param,
                type: 'post',
                dataType: 'json',
                data:{
                    pass: password,
                    [csrfName]: csrfHash
                },
                success: function(data) {
                    $("#txt_csrfname").val(data.csrfNewHash);
                    if (data.success) {
                        Swal.fire(
                            'Berhasil!',
                            data.message,
                            'success'
                        );
                        
                    } else{
                        Swal.fire(
                        'Terjadi Kesalahan',
                        data.message,
                        'error'
                        );
                    }
                },
                error: function(error) {
                    Swal.fire(
                        'Gagal!',
                        'Terjadi Kesalahan!',
                        'error'
                    );
                    console.log(error);
                }
            });
        };
    };
});
</script>