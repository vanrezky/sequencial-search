<div class="account-page-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<ul class="nav myaccount-tab-trigger" id="account-page-tab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="account-dashboard-tab" data-toggle="tab" href="#account-dashboard" role="tab" aria-controls="account-dashboard" aria-selected="true">Dashboard</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="account-orders-tab" data-toggle="tab" href="#account-orders" role="tab" aria-controls="account-orders" aria-selected="false">Pesanan</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="account-details-tab" data-toggle="tab" href="#ganti-password" role="tab" aria-controls="account-details" aria-selected="false">Ganti Password</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="account-logout-tab" href="javascript:void(0)" logoutbutton role="tab" aria-selected="false">Logout</a>
					</li>
				</ul>
			</div>
			<div class="col-lg-9">
				<div class="tab-content myaccount-tab-content" id="account-page-tab-content">
					<div class="tab-pane fade show active" id="account-dashboard" role="tabpanel" aria-labelledby="account-dashboard-tab">
						<div class="myaccount-dashboard">
							<p>Hello <b><?= ucfirst($data['c_nama']); ?></b></p>
							<p>
								Dari dasbor akun Anda, Anda dapat melihat pesanan terbaru,
								mengelola penagihan, serta mengedit kata sandi akun Anda.
							</p>
						</div>
					</div>
					<div class="tab-pane fade" id="account-orders" role="tabpanel" aria-labelledby="account-orders-tab">
						<div class="card card-primary card-outline card-outline-tabs">
							<div class="card-header p-0 border-bottom-0">
								<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="custom-tabs-four-belum-bayar-tab" data-toggle="pill" href="#custom-tabs-four-belum-bayar" role="tab" aria-controls="custom-tabs-four-belum-bayar" aria-selected="true">Belum
											Bayar</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="custom-tabs-four-dikemas-tab" data-toggle="pill" href="#custom-tabs-four-dikemas" role="tab" aria-controls="custom-tabs-four-dikemas" aria-selected="false">Dikemas</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="custom-tabs-four-dikirim-tab" data-toggle="pill" href="#custom-tabs-four-dikirim" role="tab" aria-controls="custom-tabs-four-dikirim" aria-selected="false">Dikirim</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="custom-tabs-four-selesai-tab" data-toggle="pill" href="#custom-tabs-four-selesai" role="tab" aria-controls="custom-tabs-four-selesai" aria-selected="false">Selesai</a>
									</li>
								</ul>
							</div>
							<div class="card-body">
								<div class="tab-content" id="custom-tabs-four-tabContent">
									<div class="tab-pane fade show active" id="custom-tabs-four-belum-bayar" role="tabpanel" aria-labelledby="custom-tabs-four-belum-bayar-tab">
										<?php
										if (empty($belumBayar)) {
											echo "Belum ada pesanan";
										} else {
											foreach ($belumBayar as $key => $value) {
												$gambar = (!is_file(base_url('uploads/produk/small/' . $value['gambar'])) ? '<img src="' . base_url('uploads/produk/small/' . $value['gambar']) . '">' : '<i class="fas fa-shopping-cart"></i>');
												echo '<div class="info-box" link="' . $value['no_order'] . '">';
												echo '<span class="info-box-icon bg-default elevation-1">' . $gambar . '</span>';
												echo '<div class="info-box-content">';
												echo '<span class="info-box-date">' . $value['tgl_order'] . '</span>';
												echo '<span class="info-box-text">NO ORDER - ' . $value['no_order'] . ' </span>';
												echo "<small>Total belanja</small>";
												echo '<strong><span class="info-box-number"> Rp.' . ifUang($value['order_total'] + $value['ongkir']) . ' Untuk ' . $value['items'] . ' Barang</span></strong>';
												echo '</div>';
												echo '</div>';
											}
										}
										?>

									</div>
									<div class="tab-pane fade" id="custom-tabs-four-dikemas" role="tabpanel" aria-labelledby="custom-tabs-four-dikemas-tab">
										<?php
										if (empty($dikemas)) {
											echo "Belum ada pesanan";
										} else {
											foreach ($dikemas as $key => $value) {
												$gambar = (!is_file(base_url('uploads/produk/small/' . $value['gambar'])) ? '<img src="' . base_url('uploads/produk/small/' . $value['gambar']) . '">' : '<i class="fas fa-shopping-cart"></i>');
												echo '<div class="info-box" link="' . $value['no_order'] . '">';
												echo '<span class="info-box-icon bg-default elevation-1">' . $gambar . '</span>';
												echo '<div class="info-box-content">';
												echo '<span class="info-box-date">' . $value['tgl_order'] . '</span>';
												echo '<span class="info-box-text">NO ORDER - ' . $value['no_order'] . ' </span>';
												echo "<small>Total belanja</small>";
												echo '<strong><span class="info-box-number"> Rp.' . ifUang($value['order_total'] + $value['ongkir']) . ' Untuk ' . $value['items'] . ' Barang</span></strong>';
												echo '</div>';
												echo '</div>';
											}
										}
										?>
									</div>
									<div class="tab-pane fade" id="custom-tabs-four-dikirim" role="tabpanel" aria-labelledby="custom-tabs-four-dikirim-tab">
										<?php
										if (empty($dikirim)) {
											echo "Belum ada pesanan";
										} else {
											foreach ($dikirim as $key => $value) {
												$gambar = (!is_file(base_url('uploads/produk/small/' . $value['gambar'])) ? '<img src="' . base_url('uploads/produk/small/' . $value['gambar']) . '">' : '<i class="fas fa-shopping-cart"></i>');
												echo '<div class="info-box" link="' . $value['no_order'] . '">';
												echo '<span class="info-box-icon bg-default elevation-1">' . $gambar . '</span>';
												echo '<div class="info-box-content">';
												echo '<span class="info-box-date">' . $value['tgl_order'] . '</span>';
												echo '<span class="info-box-text">NO ORDER - ' . $value['no_order'] . ' </span>';
												echo "<small>Total belanja</small>";
												echo '<strong><span class="info-box-number"> Rp.' . ifUang($value['order_total'] + $value['ongkir']) . ' Untuk ' . $value['items'] . ' Barang</span></strong>';
												echo '</div>';
												echo '</div>';
											}
										}
										?>
									</div>
									<div class="tab-pane fade" id="custom-tabs-four-selesai" role="tabpanel" aria-labelledby="custom-tabs-four-selesai-tab">
										<?php
										if (empty($selesai)) {
											echo "Belum ada pesanan";
										} else {
											foreach ($selesai as $key => $value) {
												$gambar = (!is_file(base_url('uploads/produk/small/' . $value['gambar'])) ? '<img src="' . base_url('uploads/produk/small/' . $value['gambar']) . '">' : '<i class="fas fa-shopping-cart"></i>');
												echo '<div class="info-box" link="' . $value['no_order'] . '">';
												echo '<span class="info-box-icon bg-default elevation-1">' . $gambar . '</span>';
												echo '<div class="info-box-content">';
												echo '<span class="info-box-date">' . $value['tgl_order'] . '</span>';
												echo '<span class="info-box-text">NO ORDER - ' . $value['no_order'] . ' </span>';
												echo "<small>Total belanja</small>";
												echo '<strong><span class="info-box-number"> Rp.' . ifUang($value['order_total'] + $value['ongkir']) . ' Untuk ' . $value['items'] . ' Barang</span></strong>';
												echo '</div>';
												echo '</div>';
											}
										}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="ganti-password" role="tabpanel" aria-labelledby="account-details-tab">
						<div class="myaccount-details">
							<form action="<?= base_url('member/changePassword') ?>" class="kenne-form">
								<div class="kenne-form-inner">
									<div class="single-input">
										<label for="account-details-oldpass">Password Lama</label>
										<input type="password" name="passLama" id="account-details-oldpass">
									</div>
									<div class="single-input">
										<label for="account-details-newpass">Password Baru</label>
										<input type="password" name="pass1" id="account-details-newpass">
									</div>
									<div class="single-input">
										<label for="account-details-confpass">Confirm Password Baru</label>
										<input type="password" name="pass2" id="account-details-confpass">
									</div>
									<div class="single-input">
										<button class="kenne-btn kenne-btn_dark" type="submit"><span>SAVE
												CHANGES</span></button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(event) {
		$('.info-box').click(function() {
			var link = $(this).attr('link');
			document.location.href = 'pesanan?noorder=' + link;
		});
		$('.kenne-form').submit(function(event) {
			event.preventDefault();
			SimpanMaster(this, $(this).attr('action'), function(success) {}, function(error) {});
			return false;
		});
	});
</script>