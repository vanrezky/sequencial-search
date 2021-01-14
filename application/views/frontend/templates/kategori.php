        <!-- Begin Service Area -->
        <div class="service-area">
            <div class="container">
                <div class="service-nav">
                    <div class="main-category row">
                        <?php foreach ($kategori as $key => $value) {
                            echo "<a class='item' href='". base_url('kategori/' . $value['slug']) ."'>";
                            echo "<div class='text-center'>";
                            echo "<img src=" . base_url('uploads/kategori/' . $value['gambar']) . ">";
                            echo "<p>$value[nm_kategori]</p>";
                            echo "</div>";
                            echo "</a>";
                        }?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Service Area End Here -->