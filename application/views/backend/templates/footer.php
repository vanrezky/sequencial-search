<footer class="main-footer">

    <div class="float-right d-none d-sm-inline">
        <?php $nama =  get_informasi('nama'); ?>
    </div>

    <strong>Copyright &copy; <?= $nama; ?></a>.</strong> All rights reserved.
</footer>
</div>

<script src="<?= base_url('assets/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/') ?>dist/js/adminlte.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/select2/js/select2.full.min.js"></script>
<script src="<?= base_url('assets/dist/js/'); ?>sweetalert2.all.min.js"></script>
<script src="<?= base_url('assets/') ?>dist/js/sadewa.js"></script>
<script>
    $(document).ready(function() {
        $(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
            $("#table_1").DataTable();
        });
    });
</script>
</body>

</html>