<div class="content-wrapper">
	<? $this->load->view('backend/templates/breadcrumbs');?>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-sm-6 col-md-3">
					<div class="info-box">
						<span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Order Masuk</span>
							<span class="info-box-number">
								<?= $data['orderan'] ?>
							</span>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-3">
					<div class="info-box mb-3">
						<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Costumer</span>
							<span class="info-box-number"><?= $data['costumer']; ?></span>
						</div>
					</div>
				</div>
				<div class="clearfix hidden-md-up"></div>
				<div class="col-12 col-sm-6 col-md-3">
					<div class="info-box mb-3">
						<span class="info-box-icon bg-success elevation-1"><i class="fas fa-box"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Produk</span>
							<span class="info-box-number"><?= $data['produk']; ?></span>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-3">
					<div class="info-box mb-3">
						<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-list-alt"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Kategori</span>
							<span class="info-box-number"><?= $data['kategori']; ?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header border-transparent">
							<h3 class="card-title">Orderan Terbaru</h3>

							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
								<button type="button" class="btn btn-tool" data-card-widget="remove">
									<i class="fas fa-times"></i>
								</button>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body p-0" style="display: block;">
							<div class="table-responsive">
								<table class="table m-0">
									<thead>
										<tr>
											<th>No Order</th>
											<th>Item</th>
											<th>Status</th>
											<th>Total Belanja</th>
										</tr>
									</thead>

									<tbody>
										<?php
										if (empty($orderan)) {
											echo "<tr><td colspan='4' class='text-center'><span class='badge badge-warning'>Belum ada orderan</span></td></tr>";
										} else {
											foreach ($orderan as $key => $value) {
												echo "<tr>";
												echo "<td><a href='#'>$value[no_order]</a></td>";
												echo "<td>$value[items] Item</td>";
												echo "<td>" . status_order($value['status_order']) . "</td>";
												echo "<td>Rp " . ifUang($value['order_total'] + $value['ongkir']) . "</td>";
												echo "</tr>";
											}
										}
										?>
									</tbody>
								</table>
							</div>
							<!-- /.table-responsive -->
						</div>
						<!-- /.card-body -->
						<div class="card-footer clearfix" style="display: block;">
							<a href="<?= base_url('orderan') ?>" class="btn btn-sm btn-secondary float-right">Lihat semua Order</a>
						</div>
						<!-- /.card-footer -->
					</div>
					<!-- /.card -->


					<!-- /.card -->
				</div>
			</div>
		</div>
	</div>
</div>