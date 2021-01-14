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
                                    <input fCostumer type="text" name="table_search" class="form-control float-right" value="<?= $this->input->cookie('fcostumer'); ?>" placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tableDiv" class="card-body p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">NO</th>
                                        <th>NO ORDER</th>
                                        <th>DATA PEMBELI</th>
                                        <th>ITEM</th>
                                        <th>STATUS</th>
                                        <th>TRANSFER</th>
                                        <th width="10%" center>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $no = $this->uri->segment('4') + 1;
                                    if (empty($data)) {
                                        echo "<tr><td colspan='5' class='text-center'>Data tidak ditemukan</td></tr>";
                                    } else {
                                        //txt_csrfname
                                        echo "<input type='hidden' id='txt_csrfname' name='" . $this->security->get_csrf_token_name() . "' value='" . $this->security->get_csrf_hash() . "'>";

                                        foreach ($data as $key => $value) {
                                            echo "<tr data-id='" . encode($value['id']) . "'>";
                                            echo "<td>" . $no++ . "</td>";
                                            echo "<td>$value[no_order]</td>";
                                            echo "<td><span class='badge badge-success'>$value[nama_penerima]</span><br/><i class='fas fa-envelope'></i> $value[email_customer]<br/><i class='fas fa-phone'></i> $value[no_hp]</td>";
                                            echo "<td>" . $value['items'] . " Item</td>";
                                            echo "<td>" . status_order($value['status_order']) . "</td>";
                                            echo "<td><a href='javascript:void(0)' class='btn btn-info btn-sm btn-detail' data-type='transfer'>Bukti</a></td>";
                                            echo "<td>";
                                            if ($value['status_order'] != 'Menunggu Pembayaran' and $value['status_order'] != 'Dibatalkan') {
                                                echo "<button class='btn btn-success btn-sm btn-detail' data-type='resi'>Resi</button>";
                                            }
                                            echo "<a href='" . base_url('orderan/detail/' . encode($value['id'])) . "' class='btn btn-warning btn-sm' data-type='detail'>Detail</a>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer float-right">
                            <?= $pagin; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row tampil-data"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        var id;
        var tipe;
        $('.btn-detail').click(function() {
            id = $(this).closest('tr').data('id');
            tipe = $(this).data('type');
            $.ajax({
                url: BASEURL + 'orderan/info',
                type: 'GET',
                data: {
                    tipe: tipe,
                    id: id
                },
                dataType: 'JSON',
                success: function(results) {
                    if (results.success) {
                        var preview = $('.tampil-data');
                        preview.empty();
                        if (tipe == 'transfer') {
                            preview.append(`<div class="mx-auto"><img src="` + results.bukti_transfer + `" class="img-responsive" style="max-height:300px;"></div>`);
                        } else if (tipe == 'resi') {
                            preview.append(`<input type="text" class="form-control" name="no_resi" value="` + results.no_resi + `">`);
                        }
                        $('#previewModal').modal('show');
                    }

                },
                error: function(x) {
                    console.log(x);
                }
            })
        });
        $(document).on('blur', '[name="no_resi"]', function(event) {
            var csrfName = $("#txt_csrfname").attr("name");
            var csrfHash = $("#txt_csrfname").val();
            var no_resi = $(this).val();
            if (no_resi == '') {
                return false;
            }
            $.ajax({
                url: BASEURL + 'orderan/resi',
                type: 'POST',
                data: {
                    id: id,
                    no_resi: no_resi,
                    [csrfName]: csrfHash
                },
                dataType: 'JSON',
                success: function(results) {
                    $("#txt_csrfname").val(results.csrfNewHash);
                    if (results.success) {
                        alert(results.message);
                    } else {
                        alert(results.message);
                    }
                },
                error: function(x) {
                    console.log(x);
                }
            })
        });
    });
</script>