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
                            <input type="text" name="search" class="form-control float-right" value="<?= $this->input->cookie('fKategori_pilihan')?>" placeholder="Search">

                            <div class="input-group-append">
                            <button fKategori_pilihan type="button" class="btn btn-default"><i class="fas fa-search"></i></button>
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
                                    <th width="20%" class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = $this->uri->segment('4') + 1;
                                    if (empty($data)) {
                                        echo "<tr><td colspan='4' class='text-center'> Data Tidak Ditemukan!</td></tr>";
                                    } else {
                                        //txt_csrfname
                                        echo "<input type='hidden' id='txt_csrfname' name='". $this->security->get_csrf_token_name() ."' value='" . $this->security->get_csrf_hash() . "'>";
                                        foreach ($data as $key => $value) {
                                            echo "<tr data-link='master/kategori_pilihan/delete/' data-id='" . encode($value['id']) . "'>";
                                            echo "<td>" . $no++ . "</td>";
                                            echo "<td>$value[nm_kategori]</td>";
                                            echo "<td class='text-center'>";
                                            echo "<button bChange class='btn btn-icon btn-xs btn-" . ($value['kategori_pilihan'] == 1 ? 'success' : 'warning') . " ml-2'><i class='fas fa-" . ($value['kategori_pilihan'] == 1 ? 'thumbs-up' : 'thumbs-down') . "'></i></button>";
                                            echo"</td>";
                                            echo "</tr>";
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer float-right">
                    </div>
                </div>
            </div>
        </div>
       
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('[fKategori_pilihan]').click(function() {
            Cookies.set('fKategori_pilihan', $('[name="search"]').val());
            location.reload();
        });
        $(document).on('click', '[bChange]', function() {
            var url = 'setting/kategori_pilihan/changepublish/';
            var id = $(this).closest('tr').data('id');
            var btn = $(this);
            var csrfName = $('#txt_csrfname').attr('name');
            var csrfHash = $('#txt_csrfname').val();
            changePublish(url, id, btn, csrfName, csrfHash);
            return false;
        });
    });
</script>

