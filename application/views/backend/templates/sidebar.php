<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?php $nama = get_informasi('nama'); ?>
    <a href="<?= base_url('dashboard') ?>" class="brand-link">
        <img src="<?= base_url('uploads/settings/' . get_informasi('logo')) ?>" alt="<?= $nama ?>" class="brand-image img-responsive">
        <span class="brand-text font-weight-light">PSJ</span>
    </a>
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('assets/') ?>dist/img/programmer.png" alt="<?= $user['nama']; ?>">
            </div>
            <div class="info">
                <a href="javascript:void(0)" class="d-block"><?= ucfirst($user['nama']); ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php
                $uri = $this->uri->segment(1);
                $uri2 = $this->uri->segment(2);
                foreach ($navigasi as $key => $nav) {
                    $menu_utama = $nav['menu_utama'];

                    if (empty($nav['sub'])) {
                        echo "<li class='nav-item'>";
                        echo "<a href='" . base_url() . "$menu_utama[field_url]' class='nav-link " . ($uri == $menu_utama['field_url'] ? 'active' : '')  . "'>";
                        echo "<i class='nav-icon fas $menu_utama[icon]'></i>";
                        echo "<p>$menu_utama[title]</p>";
                        echo "</a>";
                        echo "</li>";
                    } else {

                        echo "<li class='nav-item has-treeview menu-" .  ($uri == $menu_utama['field_url'] ? 'open' : '') . "'>";
                        echo "<a href='javascript:void(0);' class='nav-link " . ($uri == $menu_utama['field_url'] ? 'active' : '') . "'>";
                        echo "<i class='nav-icon fas $menu_utama[icon]'></i>";
                        echo "<p>$menu_utama[title]</p>";
                        echo "<i class='right fas fa-angle-left'></i>";
                        echo "</a>";
                        foreach ($nav['sub'] as $k => $value) {
                            $explode = explode("/", $value['field_url']);
                            echo "<ul class='nav nav-treeview'>";
                            echo  "<li class='nav-item'>";
                            echo    "<a href='" . base_url() . "$value[field_url]' class='nav-link " . ($uri2 ==  $explode[1] ? 'active' : '')  . "'>";
                            echo     "<i class='far fa-circle nav-icon'></i>";
                            echo      "<p> $value[title]</p>";
                            echo    "</a>";
                            echo  "</li>";
                            echo "</ul>";
                        }
                        echo "</li>";
                    }
                }
                ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>