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
                                <input fCostumer type="text" name="table_search" class="form-control float-right" value="<?= $this->input->cookie('fcostumer');?>" placeholder="Search">
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
                                        <th>NAMA</th>
                                        <th>EMAIL</th>
                                        <th>NO HP</th>
                                        <th>ALAMAT</th>
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
                                            echo "<input type='hidden' id='txt_csrfname' name='". $this->security->get_csrf_token_name() ."' value='" . $this->security->get_csrf_hash() . "'>";
                                            
                                            foreach ($data as $key => $value) {
                                                echo "<tr data-link='master/costumer/delete/' data-id='" . encode($value['id']) . "'>";
                                                echo "<td>" . $no++ . "</td>";
                                                echo "<td>$value[c_nama]</td>";
                                                echo "<td>$value[c_email]</td>";
                                                echo "<td>" . ($value['c_nohp']) . "</td>";
                                                echo "<td>" . ($value['c_alamat']) . "</td>";
                                                echo "<td>";
                                                echo "<button bChange class='btn btn-icon btn-xs btn-" . ($value['aktif'] == 1 ? 'success' : 'warning') . " ml-1'><i class='fas fa-" . ($value['aktif'] == 1 ? 'thumbs-up' : 'thumbs-down') . "'></i></button>";
                                                // echo "<button type='button' previewData class='btn btn-icon btn-xs btn-primary ml-1'><i class='fas fa-eye'></i></button>";
                                                echo "<button type='button' previewData class='btn btn-icon btn-xs btn-primary ml-1' data-toggle='modal' data-target='#previewModal'><i class='fas fa-eye'></i></button>";
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
                    <ul class="list-group list-group-unbordered mb-3" id="previewDataList">
                        
                    </ul>
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
    $('[previewData]').click(function() {
        var id = $(this).closest('tr').data('id');
        $.ajax({
            url: BASEURL + 'master/costumer/preview/' + id,
            type: 'GET',
            dataType: 'JSON',
		    cache: false,
            success:function(data) {
                var preview = $('#previewDataList');
                preview.empty();
                preview.append(data.data);
            },
            error: function(x) {
                console.log(x);
            }
        })
    });
    $(document).on('click', '[bChange]', function() {
        var url = 'master/costumer/changepublish/';
        var id = $(this).closest('tr').data('id');
        var btn = $(this);
        var csrfName = $('#txt_csrfname').attr('name');
        var csrfHash = $('#txt_csrfname').val();
        changePublish(url, id, btn, csrfName, csrfHash);
        return false;
    });
});
</script>