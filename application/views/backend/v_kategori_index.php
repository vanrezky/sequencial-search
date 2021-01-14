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
                            <input type="text" name="search" class="form-control float-right" value="<?= $this->input->cookie('fKategori')?>" placeholder="Search">

                            <div class="input-group-append">
                            <button fKategori type="button" class="btn btn-default"><i class="fas fa-search"></i></button>
                            <a href="<?= base_url('master/kategori/data/')?>" class="btn btn-info"><i class="fas fa-plus"></i> Tambah</a>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div id="tableDiv" class="card-body p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th width="5%">NO</th>
                                    <th class="">NAMA KATEGORI</th>
                                    <th>Gambar</th>
                                    <th width="20%" class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = $this->uri->segment('4') + 1;
                                    if (empty($data)) {
                                        echo "<tr><td colspan='4' class='text-center'> Data Tidak Ditemukan!</td></tr>";
                                    } else {
                                        foreach ($data as $key => $value) {
                                            echo "<tr data-link='master/kategori/delete/' data-id='" . encode($value['id']) . "'>";
                                            echo "<td>" . $no++ . "</td>";
                                            echo "<td>";
                                            echo "<img alt='$value[nm_kategori]' class='img-fluid img-thumbnail' src='" . base64_image(base_url('uploads/kategori/') . (isset($value['gambar']) ? $value['gambar'] : 'interface.png')) . "'></li>";
                                            echo"</td>";
                                            echo "<td>$value[nm_kategori]</td>";
                                            echo "<td class='text-center'>";
                                            echo "<button bChange class='btn btn-icon btn-xs btn-" . ($value['publish'] == 1 ? 'success' : 'warning') . " ml-1'><i class='fas fa-" . ($value['publish'] == 1 ? 'thumbs-up' : 'thumbs-down') . "'></i></button>";
                                            echo "<a href='" . base_url('master/kategori/data/') . encode($value['id']) . "' class='btn btn-icon btn-xs btn-info ml-1'><i class='fas fa-pencil-alt' title='edit'></i></a>";
                                            echo "<a removeData href='javascript:void(0);' class='btn btn-icon btn-xs btn-danger ml-1'><i class='fas fa-trash'></i></a>";
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
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
<!-- /.content -->
</div>
<script>
    $(document).ready(function() {
        $('[fKategori]').click(function() {
            Cookies.set('fKategori', $('[name="search"]').val());
            location.reload();
        });
        $(document).on('click', '[bChange]', function() {
            var url = 'master/kategori/changepublish/';
            var id = $(this).closest('tr').data('id');
            var btn = $(this);
            var csrfName = $('#txt_csrfname').attr('name');
            var csrfHash = $('#txt_csrfname').val();
            changePublish(url, id, btn, csrfName, csrfHash);
            return false;
        });
    });
</script>

