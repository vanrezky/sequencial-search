<?php $setting = get_informasi(); ?>

<body class="template-color-1">
    <div class="main-wrapper">

        <!-- Begin Loading Area -->
        <div class="loading">
            <div class="text-center middle">
                <span class="loader">
                    <span class="loader-inner"></span>
                </span>
            </div>
        </div>
        <header class="main-header_area-2">
            <div class="header-top_area d-none d-lg-block">
                <div class="container">
                    <div class="header-top_nav">
                        <div class="row">
                            <div class="col-lg-6">
                            </div>
                            <div class="col-lg-6">
                                <div class="header-top_right">
                                    <ul>
                                        <?php if (!$this->session->has_userdata('costumer_email')) {
                                            echo "<li><a href='" . base_url('member') . "'>Login atau daftar</a></li>";
                                        } else {
                                            echo "<li><a href='" . base_url('member/akun') . "'>Akun Saya</a></li>";
                                            echo "<li><a href='javascript:void(0);' logoutButton>Logout</a></li>";
                                            echo "<li><a href='javascript:void(0);'>Hi. " . decode($this->session->userdata('costumer_email')) . "</a></li>";
                                        } ?>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-middle_area " scrollTop>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="header-middle_nav">
                                <div class="header-logo_area">
                                    <a href="<?= base_url(); ?>">
                                        <img src="<?= base_url('uploads/settings/' .  $setting->logo); ?>" alt="Logo <?= $setting->nama ?>">
                                    </a>
                                </div>
                                <div class="header-contact d-none d-md-flex">
                                    <i class="fa fa-headphones-alt"></i>
                                    <div class="contact-content">
                                        <p>
                                            Butuh Bantuan ?
                                            <br>
                                            Hubungi Kami <?= $setting->kontak1; ?>

                                        </p>
                                    </div>
                                </div>
                                <div class="header-search_area d-none d-lg-block">
                                    <form method="get" class="search-form" action="<?= base_url('produk') ?>">
                                        <input name="search" type="text" placeholder="Cari produk disini..">
                                        <button class="search-button" type="submit"><i class="ion-ios-search"></i></button>
                                    </form>
                                </div>

                                <div class="header-right_area d-none d-lg-block">
                                    <ul>
                                        <li class="minicart-wrap">
                                            <a href="<?= base_url('cart'); ?>" class="minicart-btn">
                                                <div class="minicart-count_area">
                                                    <span class="item-count" countProduk>0</span>
                                                    <i class="ion-bag"></i>
                                                </div>
                                                <div class="minicart-front_text">
                                                    <span>Troli:</span>
                                                    <span class="total-price" totalHarga>0</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="header-right_area header-right_area-2 d-block d-lg-none">
                                    <ul>
                                        <li class="mobile-menu_wrap d-inline-block d-lg-none">
                                            <a href="#mobileMenu" class="mobile-menu_btn toolbar-btn color--white">
                                                <i class="ion-android-menu"></i>
                                            </a>
                                        </li>
                                        <li class="minicart-wrap">
                                            <a href="<?= base_url('cart') ?>" class="minicart-btn">
                                                <div class="minicart-count_area">
                                                    <span class="item-count" miniCount>0</span>
                                                    <i class="ion-bag"></i>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#searchBar" class="search-btn toolbar-btn">
                                                <i class="ion-android-search"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom_area d-none d-lg-block">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-menu_area position-relative">
                                <nav class="main-nav d-flex justify-content-center">
                                    <ul>
                                        <li><a href="<?= base_url() ?>">Home</a></li>

                                        <li><a href="javascript:void(0)">Kategori <i class="ion-chevron-down"></i></a>
                                            <ul class="kenne-dropdown">
                                                <?php
                                                foreach ($kategori as $key => $value) {
                                                    echo "<li><a href='" . base_url('kategori/' . $value['slug']) . "'>$value[nm_kategori]</a></li>";
                                                }
                                                ?>
                                            </ul>
                                        </li>
                                        <li><a href="<?= base_url('produk/') ?>">Semua Produk</a></li>
                                        <?php
                                        if (!empty($halaman)) {
                                            foreach ($halaman as $key => $value) {
                                                echo "<li><a href='" . base_url('halaman/detail/' . $value['slug']) . "'>$value[judul]</a></li>";
                                            }
                                        }
                                        ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-sticky">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="sticky-header_nav position-relative">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col">
                                        <div class="header-logo_area">
                                            <a href="<?= base_url(); ?>">
                                                <img src="<?= base_url('uploads/settings/' .  get_informasi('logo')); ?>" alt="Logo <?= get_informasi('nama'); ?>">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 d-none d-lg-block position-static">
                                        <div class="main-menu_area">
                                            <nav class="main-nav d-flex justify-content-center">
                                                <ul>
                                                    <li><a href="<?= base_url(); ?>">Home</a></li>
                                                    <li><a href="<?= base_url('produk') ?>">Produk</a></li>
                                                    <li class="dropdown-holder"><a href="javascript:void(0)">Kategori <i class="ion-chevron-down"></i></a>
                                                        <ul class="kenne-dropdown">
                                                            <?php
                                                            foreach ($kategori as $key => $value) {
                                                                echo "<li><a href='" . base_url('kategori/' . $value['slug']) . "'>$value[nm_kategori]</a></li>";
                                                            }
                                                            ?>
                                                        </ul>
                                                    </li>
                                                    <?php
                                                    if (!empty($halaman)) {
                                                        foreach ($halaman as $key => $value) {
                                                            echo "<li><a href='" . base_url('halaman/detail/' . $value['slug']) . "'>$value[judul]</a></li>";
                                                        }
                                                    }
                                                    ?>

                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="header-right_area header-right_area-2">
                                            <ul>
                                                <li class="mobile-menu_wrap d-inline-block d-lg-none">
                                                    <a href="#mobileMenu" class="mobile-menu_btn toolbar-btn color--white">
                                                        <i class="ion-android-menu"></i>
                                                    </a>
                                                </li>
                                                <li class="minicart-wrap">
                                                    <a href="<?= base_url('cart'); ?>" class="minicart-btn">
                                                        <div class="minicart-count_area">
                                                            <span class="item-count" stikycount></span>
                                                            <i class="ion-bag"></i>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#searchBar" class="search-btn toolbar-btn">
                                                        <i class="ion-ios-search"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-menu_wrapper" id="mobileMenu">
                <div class="offcanvas-menu-inner">
                    <div class="container">
                        <a href="#" class="btn-close white-close_btn"><i class="ion-android-close"></i></a>
                        <div class="offcanvas-inner_logo">
                            <a href="<?= base_url(); ?>">
                                <img src="<?= base_url('uploads/settings/' .  get_informasi('logo')); ?>" alt="Logo <?= get_informasi('nama'); ?>">
                            </a>
                        </div>
                        <nav class="offcanvas-navigation">
                            <ul class="mobile-menu">
                                <li class="menu-item-has-children active">
                                    <a href="<?= base_url(); ?>"><span class="mm-text">Home</span></a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="javascript:void(0);"><span class="mm-text">Kategori</span></a>
                                    <ul class="sub-menu">
                                        <?php
                                        foreach ($kategori as $key => $value) {
                                            echo "<li><a href='" . base_url('kategori/' . $value['id']) . "'>$value[nm_kategori]</a></li>";
                                        }
                                        ?>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="<?= base_url('produk'); ?>"><span class="mm-text">Semua Produk</span></a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="javascript:void(0);"><span class="mm-text">Costumer Setting</span></a>
                                    <ul class="sub-menu">
                                        <?php if (!$this->session->has_userdata('costumer_email')) {
                                            echo "<li><a href='" . base_url('member') . "'><span class='mm-text'>Login & Daftar</span></a></li>";
                                        } else {
                                            echo "<li><a href='javascript:void(0);'><span class='mm-text'>Hi. " . decode($this->session->userdata('costumer_email')) . "</span></a></li>";
                                            echo "<li><a href='" . base_url('member/akun') . "'>Akun Saya</a></li>";
                                            echo "<li><a href='javascript:void(0);' logoutButton><span class='mm-text'>Logout</span></a></li>";
                                        } ?>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="offcanvas-search_wrapper" id="searchBar">
                <div class="offcanvas-menu-inner">
                    <div class="container">
                        <a href="#" class="btn-close"><i class="ion-android-close"></i></a>
                        <div class="offcanvas-search">
                            <form method="get" action="<?= base_url('produk') ?>" class="hm-searchbox">
                                <input name="search" type="text" placeholder="Cari produk disini..">
                                <button class="search-form" type="submit"></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="global-overlay"></div>
            <div id="loading-custom" class=""></div>
        </header>
        <?php echo "<input type='hidden' id='txt_csrfname' name='" . $this->security->get_csrf_token_name() . "' value='" . $this->security->get_csrf_hash() . "'>"; ?>