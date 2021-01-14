<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <?php
    ?>
    <title><?= $title;?> | <?= get_informasi('nama');?></title>
    <!-- <meta name="robots" content="noindex, follow" /> -->
    <meta name="description" content="<?=  get_informasi('deskripsi'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script type="text/javascript">
        var BASEURL  = '<?= base_url();?>';
    </script> 
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('uploads/settings/'.  get_informasi('favicon'));?>">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/');?>css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/');?>css/vendor/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/');?>css/vendor/ion-fonts.css">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/');?>css/plugins/slick.css">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/');?>css/plugins/animate.css">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/');?>css/plugins/jquery-ui.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/');?>css/plugins/nice-select.css">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/');?>css/plugins/timecircles.css">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/');?>css/style.css">
    <script src="<?= base_url('assets/frontend/');?>js/vendor/jquery-1.12.4.min.js"></script>
</head>