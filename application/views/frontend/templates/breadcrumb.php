<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?= base_url('home') ?>">Home</a></li>
                <?php
                $count = $this->uri->total_segments();
                $uri1 = ucwords(str_replace('-', ' ', $this->uri->segment($count)));
                echo "<li class='active'>" . ucfirst($uri1) . "</li>";
                if ($uri1 == 'kategori') {
                    $uri2 = $this->uri->segment(2);
                    echo "<li class='active'>" . ucfirst(str_replace('-', ' ', $uri2)) . "</li>";
                }
                ?>

            </ul>
        </div>
    </div>
</div>