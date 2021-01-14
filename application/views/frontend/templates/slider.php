<div class="slider-area slider-area-3">
            <div class="kenne-element-carousel home-slider home-slider-3 arrow-style" data-slick-options='{
                "slidesToShow": 1,
                "slidesToScroll": 1,
                "infinite": true,
                "arrows": true,
                "dots": false,
                "autoplay" : true,
                "fade" : true,
                "autoplaySpeed" : 7000,
                "pauseOnHover" : false,
                "pauseOnFocus" : false
                }'>
            <?php
                foreach (slider() as $key => $value) {
                if (!empty($value['slider'])) { ?>
                <div class="slide-item bg-<?= $key +1?> animation-style-01">
                    <div class="slider-progress"></div>
                    <div class="container">
                        <div class="slide-content">
                        </div>
                    </div>
                </div>
            <?php } } ?>
            </div>
        </div>