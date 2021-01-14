<div class="brand-area pt-90">
            <div class="container">
                <div class="brand-nav border-top border-bottom">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="kenne-element-carousel brand-slider slider-nav" data-slick-options='{
                                "slidesToShow": 6,
                                "slidesToScroll": 1,
                                "infinite": false,
                                "arrows": false,
                                "dots": false,
                                "spaceBetween": 30
                                }' data-slick-responsive='[
                                {"breakpoint":992, "settings": {
                                "slidesToShow": 4
                                }},
                                {"breakpoint":768, "settings": {
                                "slidesToShow": 3
                                }},
                                {"breakpoint":576, "settings": {
                                "slidesToShow": 3
                                }}
                            ]'>
                                <?php
                                    foreach(brand() as $value) {
                                        echo "<div class='brand-item'>";
                                        echo "<a href='javascript:void(0)'>";
                                        echo "<img src='" . base_url('uploads/brand/' . $value['gambar']) . "' alt='$value[nm_brand]'>";
                                        echo "</a>";
                                        echo "</div>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>