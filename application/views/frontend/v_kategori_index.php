<div class="kenne-content_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-3  order-2 order-lg-1">
                <div class="kenne-sidebar-catagories_area">
                    <div class="kenne-sidebar_categories">
                        <div class="kenne-categories_title first-child">
                            <h5>Filter</h5>
                        </div>
                        <form id="formFilter" role="form" >
                            <div class="form-group">
                                <label for="search">Cari Produk</label>
                                <input type="text" class="form-control" id="search" name="search" aria-describedby="emailHelp" placeholder="Cari disini..">
                            </div>
                            <div class="form-group">
                                <label for="urutan">Urutan</label>
                                <select id="urutan" class="form-control" name="urutan">
                                    <option value="">Produk Terbaru</option>
                                    <option value="2">Nama, A ke Z</option>
                                    <option value="3">Nama, Z ker A</option>
                                    <option value="4">Harga, dari termurah</option>
                                    <option value="5">Harga, dari tertinggi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="price-filter">Rentan Harga</label>
                                <div class="price-filter" style="margin-top: 0px;">
                                    <div id="slider-range"></div>
                                    <div class="price-slider-amount">
                                        <div class="label-input">
                                            <label>Harga : </label>
                                            <input type="text" readonly id="rentan1" name="rentan1" placeholder="Rentan harga" />
                                            <input type="text" hidden readonly id="rentan2" name="rentan2" />
                                        </div>
                                    </div>
                                </div>
                                <p class="form-text text-muted border-bottom"></p>
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <select id="kategori" class="form-control" name="kategori">
                                    <option value="">Semua Kategori</option>
                                    <?php
                                        foreach ($kategori as $key => $value) {
                                            $s = ($slug == $value['slug'] ? 'selected' : '');
                                            echo "<option value='$value[id]' $s>$value[nm_kategori]</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="input-group" >
                                <button class="input-group-text mr-1" type="button" id="buttonFilter">
                                    <i class="fas fa-search"></i> Terapkan
                                </button>
                                <button class="input-group-text danger" type="button" id="resetFilter">
                                    <i class="fas fa-search"></i> Reset Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 order-1 order-lg-2">
                <div id="ajaxContent"></div>
            </div>
        </div>
    </div>
</div>
<style>
    /* @media (max-width: 575px) {
        .mobile-div{
            padding-left: 10px !important;
            padding-right: 10px !important; 
        }
    } */
</style>
<script>
    var url_string = window.location.href
    var url = new URL(url_string);
    var c = url.searchParams.get("search");
    if (c != '') $('#search').val(c);

    var amount = '';
    var sliderrange = $('#slider-range');
    var amountprice = $('#rentan1');
    var amountprice2 = $('#rentan2');
    var minV = <?= $min;?>;
    var maxV = <?= $max;?>;
	$(function () {
		sliderrange.slider({
			range: true,
			min: minV,
			max: maxV,
			values: [minV, maxV],
			slide: function (event, ui) {
                amountprice.val('Rp.' + ui.values[0] + ' - Rp.' + ui.values[1]);
                amountprice2.val(ui.values[0] + '-' + ui.values[1]);
			}
		});
        amountprice.val('Rp.' + sliderrange.slider('values', 0) + ' - Rp.' + sliderrange.slider('values', 1));
        // amountprice2.val(sliderrange.slider('values', 0) + '-' + sliderrange.slider('values', 1));
	});
$(function() {
    ajaxlist(page_url=false);

    $(document).on('click', "#buttonFilter", function() {
        
        var search = $('#search').val();
        var urutan = $('#urutan').val();
        var rentan = $('#rentan2').val();
        var kategori = $('#kategori').val();
        ajaxlist(page_url=false);
    });

    $(document).on('click', "#resetFilter", function() {
        var formFilter = $('#formFilter');
        clearForm(formFilter);
        ajaxlist(page_url=false);
        scrollTop();
    });

    $(document).on('click', ".pagination li a", function(event) {
        var page_url = $(this).attr('href');
        ajaxlist(page_url);
        event.preventDefault();
        scrollTop();
    });
    function ajaxlist(page_url = false)
    {   
        var search = $('#search').val();
        var urutan = $('#urutan').val();
        var rentan = $('#rentan2').val();
        var kategori = $('#kategori').val();
        var dataSearch = '';
        var dataUrutan = '';
        var dataRentan = '';
        var dataKategori = '';

        if (search != '') dataSearch = 'search=' + search;
        if (rentan != '') dataRentan = 'rentan=' + rentan;
        if (kategori != '') dataKategori = 'kategori=' + kategori;
        if (urutan != '') dataUrutan = 'urutan=' + urutan;
        var dataString = dataSearch + '&' + dataRentan + '&' + dataKategori + '&' + dataUrutan;
        var base_url = BASEURL + 'produk/show';
        if(page_url == false) {
            var page_url = base_url;
        }
        $.ajax({
            type: "GET",
            url: page_url,
            data: dataString,
            beforeSend: function(){
                loader(true);
            },
            success: function(response) {
                loader();
                $("#ajaxContent").html(response);
            },
            error: function(x) {
                console.log(x);
            }
        });
    }
});

function scrollTop() {
    $('html, body').animate({
        scrollTop: $('[scrollTop]').offset().top
    }, 800);
}
</script>