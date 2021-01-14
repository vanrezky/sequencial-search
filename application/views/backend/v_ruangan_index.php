<script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
<script type="module" src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.mjs"></script>
<div class="content-wrapper">
    <? $this->load->view('templates/breadcrumbs');?>
    <div class="content">
        <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
            <?= $this->session->flashdata('message') ?>
                <div class="card card-primary card-outline">
                    <div class="card-header row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 control-label">Ruangan</label>
                                <div class="col-sm-8">
                                    <select fruangan class="form-control select2bs4" name style="width: 100%;">
                                        <option value="">Pilih</option>
                                        <?php
                                            foreach ($ruangan as $key => $value) {
                                                $selected = $value['id_ruangan'] == decode($this->input->cookie('fruangan')) ? 'selected="selected"' : '';
                                                echo "<option value='" . encode($value['id_ruangan']) . "' $selected>$value[nm_ruangan]</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <a href="<?= base_url('master/ruangan/data/')?>" class="btn btn-info"><i class="fas fa-plus"></i> Tambah</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th width="5%">NO</th>
                                    <th>KODE</th>
                                    <th>RUANGAN</th>
                                    <th>GEDUNG</th>
                                    <th>PRODI</th>
                                    <th>KUOTA</th>
                                    <th width="20%" class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = $this->uri->segment('3') + 1;
                                    if (empty($data)) {
                                        echo "<tr><td colspan='5' class='text-center'>Data tidak ditemukan</td></tr>";
                                    } else {
                                        foreach ($data as $key => $value) {
                                            echo "<tr data-link='master/ruangan/delete/" . encode($value['id_ruangan']) . "'>";
                                            echo "<td>" . $no++ . "</td>";
                                            echo "<td>$value[kode_ruangan]</td>";
                                            echo "<td>$value[nama_ruangan]</td>";
                                            echo "<td>" . ($value['nm_gedung']) . "</td>";
                                            echo "<td>$value[nama_unit]</td>";
                                            echo "<td>$value[kuota]</td>";
                                            echo "<td>";
                                            echo "<a href='" . base_url('master/ruangan/data/') . encode($value['id_ruangan']) . "' class='btn btn-icon btn-sm btn-info'><i class='fas fa-edit'></i> Edit</a>";
                                            echo "<a removeData href='javascript:void(0);'  class='btn btn-icon btn-sm btn-danger ml-2'><i class='fas fa-trash'></i> Hapus</a>";

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
        $('[fruangan]').change(function() {
            Cookies.set('fIdruangan', $("option:selected", this).val());
            location.reload();
        });    
    });
    
</script>

