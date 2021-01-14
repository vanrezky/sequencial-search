    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="<?= base_url('uploads/settings/' . get_informasi('favicon')); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Vanrezky | Online Shop">
        <meta name="description" content="<?= get_informasi('deskripsi'); ?>">
        <meta name="keywords" content="<?= get_informasi('keyword'); ?>">
        <meta name="google-site-verification" content="<?= get_informasi('google_site_verification'); ?>" />
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <title> <?= "$title | " . get_informasi('nama'); ?></title>
        <!-- Font Awesome Icons -->
        <script type="text/javascript">
            var BASEURL = '<?= base_url(); ?>';
            var ASSETS = '<?= base_url('assets/'); ?>';
        </script>
        <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/fontawesome-free/css/all.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/adminlte.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <!-- Google Font: Source Sans Pro -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
        <!-- <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.css">     -->
        <script src="<?= base_url('assets/') ?>plugins/jquery/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
    </head>

    <body class="sidebar-mini layout-fixed">
        <div class="wrapper">