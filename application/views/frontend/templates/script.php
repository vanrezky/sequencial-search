    <a class="scroll-to-top" href=""><i class="ion-chevron-up"></i></a>
    </div>
    <style type="text/css">
        <?php $no= 1;
            foreach (slider() as $key => $value) {
                if (!empty($value['slider'])) {
                    $url = base_url("uploads/slider/" . $value['slider']);
                    echo ".bg-$no { background-image: url('$url'); }";
                } $no++; 
            }?>
    </style>
    <script src="<?= base_url('assets/dist/js/');?>sweetalert2.all.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->
    <script src="<?= base_url('assets/frontend/');?>js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="<?= base_url('assets/frontend/');?>js/vendor/popper.min.js"></script>
    <script src="<?= base_url('assets/frontend/');?>js/vendor/bootstrap.min.js"></script>
    <script src="<?= base_url('assets/frontend/');?>js/plugins/slick.min.js"></script>
    <script src="<?= base_url('assets/frontend/');?>js/plugins/jquery.barrating.min.js"></script>
    <script src="<?= base_url('assets/frontend/');?>js/plugins/jquery.counterup.js"></script>
    <script src="<?= base_url('assets/frontend/');?>js/plugins/jquery.nice-select.js"></script>
    <script src="<?= base_url('assets/frontend/');?>js/plugins/jquery.sticky-sidebar.js"></script>
    <script src="<?= base_url('assets/frontend/');?>js/plugins/jquery-ui.min.js"></script>
    <script src="<?= base_url('assets/frontend/');?>js/plugins/jquery.ui.touch-punch.min.js"></script>
    <script src="<?= base_url('assets/frontend/');?>js/plugins/theia-sticky-sidebar.min.js"></script>
    <script src="<?= base_url('assets/frontend/');?>js/plugins/waypoints.min.js"></script>
    <script src="<?= base_url('assets/frontend/');?>js/plugins/jquery.zoom.min.js"></script>
    <script src="<?= base_url('assets/frontend/');?>js/plugins/timecircles.js"></script>
    <script src="<?= base_url('assets/frontend/');?>js/main.js"></script>
</body>
</html>