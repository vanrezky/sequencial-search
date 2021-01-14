<div class="checkout-area">
	<div class="container">
		<form submitPengiriman action="#" method="post">
			<div class="row">
				<div class="col-lg-6 col-12">
					<div class="checkbox-form">
						<h3>Alamat Pengiriman</h3>
						<div class="row">
							<div class="col-md-12">
								<div class="checkout-form-list">
									<label>Nama Lengkap</label>
									<input placeholder="" type="text" name='nama' required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="checkout-form-list">
									<label>No. Handphone</label>
									<input placeholder="" type="tel" name='no_telp' required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="checkout-form-list">
									<label>Kode Pos</label>
									<input placeholder="" type="tel" name='kode_pos' required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="country-select clearfix">
									<label>Provinsi <span class="required">*</span></label>
									<select class="myniceselect nice-select wide" name="provinsi">
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="country-select clearfix">
									<label>Kabupaten/Kota <span class="required">*</span></label>
									<select name="kabupaten" class="myniceselect nice-select wide"></select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="checkout-form-list">
									<label>Kecamatan</label>
									<input placeholder="" type="text" name='kecamatan' required>
								</div>
							</div>
							<div class="col-md-12">
								<div class="checkout-form-list">
									<label>Desa/Kelurahan</label>
									<input placeholder="" type="text" name='kelurahan' required>
								</div>
							</div>
							<div class="col-md-12">
								<div class="order-notes">
									<div class="checkout-form-list checkout-form-list-2" required>
										<label>Alamat</label>
										<textarea id="checkout-mess" cols="30" rows="10" name="alamat" placeholder="Isi dengan nama jalan, nomor rumah, nama gedung, dsb" required></textarea>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="country-select clearfix">
									<label>Jasa Kurir <span class="required">*</span></label>
									<select name="kurir" class="myniceselect nice-select wide"></select>
								</div>
							</div>
							<div class="col-md-8">
								<div class="country-select clearfix">
									<label>Paket <span class="required">*</span></label>
									<select name="cost" class="myniceselect nice-select wide"></select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="country-select clearfix">
									<label>Transfer Bank <span class="required">*</span></label>
									<select name="bank" class="myniceselect nice-select wide">
										<?php
										echo "<option selected disabled>Pilih Bank</option>";
										foreach ($bank as $key => $value) {
											echo "<option value='$value[id]'>$value[id]</option>";
										}
										?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-12">
					<div class="your-order">
						<h3>Orderan Kamu</h3>
						<div class="your-order-table table-responsive">
							<table class="table">
								<tbody>
									<?php
									if (empty($data)) {
										echo "<tr><td colspan='2'>Tidak ada barang..</td></tr>";
									} else {
										foreach ($data as $key => $value) {
											echo "<tr>";
											echo "<td>$value[name]<strong class='product-quantity'> × $value[qty]</strong></td>";
											echo "<td>Rp." . rupiah($value['price']) . "</td>";
											echo "</tr>";
										}
									}
									?>
								</tbody>
								<tfoot>
									<tr class="cart-subtotal">
										<th>Total Belanja</th>
										<td><span class="amount" subtotal>Rp.<?= rupiah($subtotal); ?></span></td>
									</tr>
									<tr class="cart-subtotal">
										<th>Biaya Pengiriman</th>
										<td><span class="amount" ongkir>0</span></td>
									</tr>
									<tr class="order-total">
										<th>Total Pembayaran</th>
										<td><strong><span class="amount" total_bayar>Rp.<?= rupiah($subtotal); ?></span></strong></td>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="payment-method">
							<div class="payment-accordion">
								<div class="order-button-payment row">
									<?php if (empty(get_informasi('kontak1'))) { ?>
										<div class="col-md-12">
											<input value="Lanjutkan" type="submit" name="submitnow">
										</div>
									<?php } else { ?>
										<div class="col-md-6">
											<input value="Lanjutkan" type="submit" name="submitnow" class="submit-button">
										</div>
										<div class="col-md-6">
											<input value="Whatsapp" class="submit-button whatsapp" type="submit" name="whatsappnow">
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<style>
	.whatsapp {
		background-color: #128C7E !important;
	}
</style>
<script>
	var provinsi = $('[name="provinsi"]');
	var kabupaten = $('[name="kabupaten"]');
	var kurir = $('[name="kurir"]');
	var cost = $('[name="cost"]');
	var via = '';
	$(document).ready(function() {
		$('.submit-button').click(function(event) {
			via = $(this).val();

		});
		$(document).on('submit', '[submitPengiriman]', function(e) {
			e.preventDefault();
			var selectedProvinsi = $("option:selected", provinsi).data('provinsi');
			var selectedKabupaten = $("option:selected", kabupaten).data('kabupaten');
			var selectedKurir = kurir.val();
			var selectedCost = $("option:selected", cost).data('ongkir');
			var csrfName = $('#txt_csrfname').attr('name');
			var csrfHash = $('#txt_csrfname').val();
			var formData = new FormData(this);
			formData.append([csrfName], csrfHash);
			formData.append('nameProvinsi', selectedProvinsi);
			formData.append('nameKabupaten', selectedKabupaten);
			formData.append('ongkir', selectedCost);
			formData.append('via', via);
			$.ajax({
				url: BASEURL + 'checkout/order',
				type: "POST",
				data: formData,
				contentType: false,
				cache: false,
				processData: false,
				dataType: 'json',
				beforeSend: function() {},
				success: function(x) {
					$("#txt_csrfname").val(x.csrfNewHash);
					if (x.success) {
						swallSuccess('Pesanan Berhasil', x.message, x.url);
					} else {
						swallError('Terjadi Kesalahan', x.message);
					}
					return false;
				},
				error: function(x) {
					swallError(x.status, x.statusText);
					return false;
				}
			}).done(function() {
				return false;
			});
			return false;
		});
		ajaxprovinsi();
		$('.xyz').on('click', function() {
			event();
		});
		provinsi.change(function() {
			var id = $(this).val();
			if (id == "") {
				return false;
			}
			$.ajax({
				url: BASEURL + 'rajaongkir/kota',
				type: 'GET',
				data: {
					provinsi: id
				},
				dataType: 'JSON',
				beforeSend: function() {
					kurir.empty();
					kabupaten.empty();
					cost.empty();
					$('.nice-select').niceSelect('update');
				},
				success: function(x) {
					kabupaten.append('<option value="" data-kabupaten="" selected disabled>Pilih Kabupaten/Kota</option>');
					$.each(x, function(index, value) {
						kabupaten.append('<option value="' + value.city_id + '" data-kabupaten="' + value.city_name + '">' + value.city_name + '</option>');
					});
					$('.nice-select').niceSelect('update');
				},
				error: function(x) {
					console.log(x);
				}
			});

		});
		kabupaten.change(function(event) {
			$.ajax({
				url: BASEURL + 'rajaongkir/kurir',
				type: 'GET',
				dataType: 'JSON',
				beforeSend: function() {
					cost.empty();
					kurir.empty();
					$('.nice-select').niceSelect('update');
				},
				success: function(x) {
					kurir.append('<option value="" selected disabled>Pilih Kurir</option>');
					$.each(x, function(index, value) {
						kurir.append('<option value="' + value.id + '" data-kurir="' + value.kurir + '">' + value.kurir + '</option>');
					});
					$('.nice-select').niceSelect('update');
				},
			});
		});
		kurir.change(function() {
			var vKabupaten = kabupaten.val();
			var vKurir = kurir.val();
			$.ajax({
				url: BASEURL + 'rajaongkir/cost',
				type: 'GET',
				data: {
					kabupaten: vKabupaten,
					kurir: vKurir
				},
				dataType: 'JSON',
				beforeSend: function() {
					cost.empty();
					cost.niceSelect('update');
				},
				success: function(x) {
					console.log(x);
					cost.append('<option value="" selected disabled>Pilih Paket</option>');
					$.each(x, function(index, value) {
						cost.append('<option value="' + value.value + '" data-ongkir="' + value.ongkir + '">' + value.label + '</option>');
					});
					cost.niceSelect('update');
				},
			});
		});
		cost.change(function() {
			var ongkir = $("option:selected", this).data('ongkir');
			$('[ongkir]').empty().html('Rp.' + rubah(ongkir));
			$('[total_bayar]').empty().html('Rp.' + rubah(parseFloat(ongkir + <?= $subtotal; ?>)));
		});
	});

	function ajaxprovinsi() {
		$.ajax({
			url: BASEURL + 'rajaongkir/provinsi',
			type: 'GET',
			dataType: 'JSON',
			success: function(x) {
				provinsi.empty();
				provinsi.append('<option value="" data-name="" selected="selected" disabled="disabled">Pilih Provinsi</option>');
				$.each(x, function(index, value) {
					provinsi.append('<option value="' + value.province_id + '" data-provinsi="' + value.province + '">' + value.province +
						'</option>');
				});
				provinsi.niceSelect('update');
			},
		});
	};
</script>