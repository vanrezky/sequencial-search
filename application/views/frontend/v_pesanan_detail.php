	<style>
		.whatsapp {
			background-color: #128C7E !important;
		}
	</style>
	<div class="container">
		<div class="row">
			<div class="card-body">
				<table class="table table-striped">
					<tbody>
						<tr>
							<td width='150'>Status</td>
							<td>:</td>
							<td><?= status_order($data['status_order']) ?></td>
						</tr>
						<tr>
							<td>Tanggal Pembelian</td>
							<td>:</td>
							<td><?= $data['tgl_order']; ?></td>
						</tr>
						<tr>
							<td>No. Orderan</td>
							<td>:</td>
							<td><?= $data['no_order']; ?></td>
						</tr>
						<tr>
							<td>No. Resi</td>
							<td>:</td>
							<td><?= !empty($data['no_resi']) ? $data['no_resi'] : 'Belum tersedia'; ?> </td>
						</tr>
					</tbody>
				</table>
				<?php
				if ($data['status_bayar'] == 'belum' && $data['status_order'] == 'Menunggu Pembayaran') {
					//countdown
					echo '<div class="info-box" style="background-color:Bisque">';
					echo '<div class="info-box-content">';
					echo '<span class="info-box-text text-center"><h6>HARAP MELAKUKAN PEMBAYARAN DALAM</h6></span>';
					echo '<span class="info-box-text text-center"><h3 class="sisawaktu" data-time="' . $data['tgl_order'] . '"></h3></span>';
					echo '</div>';
					echo '</div>';
					//countdown
					// nomor rekening
					echo '<h6>Lakukan Transfer ke Rekening <strong>' . get_informasi('nama') . '</strong></h6>';
					echo '<p>Atas Nama <b>' . $data['atas_nama'] . ' (' . $data['bank'] . ')</b></p>';
					echo '<div class="info-box" id="norek" style="background-color:WhiteSmoke">';
					echo '<div class="info-box-content">';
					echo '<span class="info-box-text" style="display: inline-block;"><h2 class="float-left norek" style="margin-right:5px;">' . $data['no_rek'] . '</h2>
							<button class="input-group-text" type="button" id="buttonRekening">Salin</button>
							</span>';
					echo '</div>';
					echo '</div>';
					// nomor rekening
					//nominal bayar
					echo '<h6><strong>Nominal Bayar</strong></h6>';
					echo '<div class="info-box" id="transfer" style="background-color:WhiteSmoke;">';
					echo '<div class="info-box-content">';
					echo '<div class="transfer" hidden>' . ($data['order_total'] + $data['ongkir']) . '</div>';
					echo '<span class="info-box-text" style="display: inline-block;"><h2 class="float-left" style="margin-right:5px;"> Rp ' . ifUang($data['order_total'] + $data['ongkir']) . '</h2><button class="input-group-text" type="button" id="buttonTransfer">Salin</button></span>';
					echo '</div>';
					echo '</div>';
					//nominal bayar
				}
				if ($data['status_bayar'] == 'belum' and  ($data['status_order'] == 'Menunggu Pembayaran' or $data['status_order'] == 'Dikemas')) {
					//upload bukti bayar 
					echo '<h6><strong>Upload Bukti Transfer</strong></h6>';
					echo '<div class="info-box" id="bukti-transfer">';
					echo '<div class="info-box-content">';
					echo '<div class="mx-auto"><img id="image-preview" src="' . (!empty($data['bukti_bayar']) ? base_url('uploads/transfer/' . $data['bukti_bayar']) : '') . '" alt="image preview" /></div>';
					echo '<span class="info-box-text mt-2"><a href="javascript:void(0);" class="kenne-btn kenne-btn_sm" id="uploadBukti"><span>Upload Bukti Pembayaran</span></a></span>';
					echo '</div>';
					echo '</div>';
					echo '<form hidden id="submitBuktiTransfer" method="post" action="' . base_url('member/bukti_transfer/' . encode($data['no_order'])) . '">
						<input Fgambar name="bukti_transfer" type="file" id="image-source" for="gambar" onchange="previewImage();" />
						<button type="submit" id="btnSubmitBuktiTransfer"></button>
					</form>';
					//upload bukti bayar
					if (!empty(get_informasi('kontak1'))) {
						echo '<h6><strong>Chat WhatsApp</strong></h6>';
						echo '<div class="info-box" id="bukti-transfer">';
						echo '<div class="info-box-content">';
						echo '<span class="info-box-text mt-2"><a href="' . $whatsapp . '" target="_newWindow" class="whatsapp kenne-btn kenne-btn_sm"><span>Chat Via WhatsApp</span></a></span>';
						echo '</div>';
						echo '</div>';
					}
				}

				if (empty($detail)) {
					echo "Belum ada pesanan";
				} else {
					foreach ($detail as $key => $value) {
						$gambar = (!is_file(base_url('uploads/produk/small/' . $value['gambar'])) ? '<img src="' . base_url('uploads/produk/small/' . $value['gambar']) . '">' : '<i class="fas fa-shopping-cart"></i>');
						echo '<div class="info-box">';
						echo '<span class="info-box-icon bg-default elevation-1">' . $gambar . '</span>';
						echo '<div class="info-box-content">';
						echo '<span class="info-box-text">' . character_limiter($value['produk_nama'], 30) . ' </span>';
						echo '<small>' . $value['produk_qty'] . ' Barang (' . $value['berat'] . ' Gr) </small>';
						echo '<small>' . $value['warna'] . ' (' . $value['ukuran'] . ') </small>';
						echo '<span class="info-box-number">Rp.' . ifUang($value['produk_harga']) . ' </span>';
						echo '<span class="info-box-number">Total Rp.' . ifUang($value['produk_harga'] * $value['produk_qty']) . ' </span>';
						echo '</div>';
						echo '</div>';
					}
					//============== start detail pengiriman ================================
					echo '<div class="info-box">';
					echo '<span class="info-box-icon bg-info elevation-1"><i class="fas fa-shipping-fast"></i></span>';
					echo '<div class="info-box-content">';
					echo '<span class="info-box-text"><h5>Detail Pengiriman</h5></span>';
					echo '<table>';
					echo '<tr>';
					echo '<td width="130">Kurir Pengiriman</td>';
					echo '<td><strong>' . strtoupper($data['kurir']) . ' - ' . $data['paket'] . '</strong></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td>No. Resi</td>';
					echo '<td><strong>' . (!empty($data['no_resi']) ? strtoupper($data['no_resi']) : 'Belum Tersedia') . '</strong></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td>Alamat Pengiriman</td>';
					echo "<td><strong>$data[nama_penerima] - $data[no_hp] - $data[alamat] $data[kelurahan], $data[kecamatan], $data[kabupaten], $data[provinsi], $data[kode_pos]</strong></td>";
					echo '</tr>';
					echo '</table>';
					echo '</div>';
					echo '</div>';
					//===================== end detail pengiriman ==========================
					//============== start detail pengiriman ================================
					echo '<div class="info-box">';
					echo '<span class="info-box-icon bg-success elevation-1"><i class="fas fa-credit-card"></i></span>';
					echo '<div class="info-box-content">';
					echo '<span class="info-box-text"><h5>Informasi Pembayaran</h5></span>';
					echo '<table>';
					echo '<tr>';
					echo '<td class="align-top" width="150">Metode Pembayaran</td>';
					echo '<td class="align-top"><strong>Transfer Bank</strong></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td class="align-top">Total Harga</td>';
					echo '<td class="align-top"><strong>Rp ' . ifUang($data['order_total']) . '</strong></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td class="align-top">Total Ongkir</td>';
					echo '<td class="align-top"><strong>Rp ' . ifUang($data['ongkir']) . '</strong></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td class="align-top">Total Bayar</td>';
					echo '<td class="align-top"><h6><strong>Rp ' . ifUang($data['order_total'] + $data['ongkir']) . '</strong></h6></td>';
					echo '</tr>';
					echo '</table>';
					echo '</div>';
					echo '</div>';
					//===================== end detail pengiriman ==========================
				}
				?>

			</div>
		</div>
	</div>
	<style>
		#image-preview {
			display: <?= !empty($data['bukti_bayar']) ? 'block' : 'none'; ?>;
			width: 250px;
		}

		.align-top {
			vertical-align: top;
			text-align: left;
			padding: 4px;
		}

		#bukti-transfer {
			cursor: auto !important;
		}
	</style>
	<script>
		var url_string = window.location.href
		var url = new URL(url_string);
		var c = url.searchParams.get("via");
		if (c == 'whatsapp') {
			var url_wa = $('.whatsapp').attr('href');
			window.open(url_wa,
				'newwindow',
				'width=1000,height=1000')
		}

		const no_order = '<?= $data['no_order'] ?>';
		$(document).ready(function(event) {
			var t = $('.sisawaktu');
			if (t.length) {
				sisawaktu(t.data('time'));
			}
			setInterval(function() {
				var date = new Date();
				var h = date.getHours(),
					m = date.getMinutes(),
					s = date.getSeconds();
				h = ("0" + h).slice(-2);
				m = ("0" + m).slice(-2);
				s = ("0" + s).slice(-2);

				var time = h + ":" + m + ":" + s;
				$('.live-clock').html(time);
			}, 1000);
			$('#norek').click(function(event) {
				var norek = $(this).find('.norek');
				copyToClipboard(norek, 'Nomor rekening berhasil disalin');
			});
			$('#transfer').click(function(event) {
				var transfer = $(this).find('.transfer');
				copyToClipboard(transfer, 'Nominal bayar berhasil disalin');
			});
			$('#bukti-transfer-button').click(function(event) {
				alert('hai');
			});
			// $('.kenne-form').submit(function(event) {
			// 	event.preventDefault();
			// 	SimpanMaster(this, $(this).attr('action'), function(success) {}, function(error) {});
			// 	return false;
			// });
			$('#uploadBukti').click(function(event) {
				event.preventDefault();
				$('#image-source').click();

			});
			$('#image-source').change(function() {
				var fileInput = $.trim($(this).val());
				if (fileInput == "") {
					return false;
				}
				$('#btnSubmitBuktiTransfer').click();
			});
			$('#submitBuktiTransfer').submit(function(event) {
				event.preventDefault();
				SimpanMaster(this, $(this).attr('action'), function(success) {}, function(error) {});
			})

		});

		function sisawaktu(t) {
			var csrfName = $("#txt_csrfname").attr("name");
			var csrfHash = $("#txt_csrfname").val();
			var time = new Date(t);
			var n = new Date();
			var x = setInterval(function() {
				var now = new Date().getTime();
				var dis = time.getTime() - now;
				var h = Math.floor((dis % (1000 * 60 * 60 * 60)) / (1000 * 60 * 60));
				var m = Math.floor((dis % (1000 * 60 * 60)) / (1000 * 60));
				var s = Math.floor((dis % (1000 * 60)) / (1000));
				h = ("0" + h).slice(-2);
				m = ("0" + m).slice(-2);
				s = ("0" + s).slice(-2);
				var cd = h + ":" + m + ":" + s;
				$('.sisawaktu').html(cd);
			}, 100);
			setTimeout(function() {
				$.ajax({
					url: BASEURL + 'member/timeoutPesanan',
					type: 'POST',
					data: {
						no_order: no_order,
						[csrfName]: csrfHash
					},
					dataType: 'JSON',
					beforeSend: function() {
						loader(true);
					},
					success: function(x) {
						swallSuccess('Waktu Pesanan Habis', 'Waktu pesanan sudah habis silahkan klik OK', reload);
					},
					error: function(x) {
						console.log(x);
					}
				});
			}, (time.getTime() - n.getTime()));
		}

		function countdown(t) {
			var time = new Date(t);
			var n = new Date();
			var x = setInterval(function() {
				var now = new Date().getTime();
				var dis = time.getTime() - now;
				var d = Math.floor(dis / (1000 * 60 * 60 * 24));
				var h = Math.floor((dis % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
				var m = Math.floor((dis % (1000 * 60 * 60)) / (1000 * 60));
				var s = Math.floor((dis % (1000 * 60)) / (1000));
				d = ("0" + d).slice(-2);
				h = ("0" + h).slice(-2);
				m = ("0" + m).slice(-2);
				s = ("0" + s).slice(-2);
				var cd = d + " Hari, " + h + " Jam, " + m + " Menit, " + s + " Detik ";
				$('.countdown').html(cd);

				setTimeout(function() {
					location.reload()
				}, dis);
			}, 1000);
		}

		function copyToClipboard(element, message) {
			var $temp = $("<input>");
			$("body").append($temp);
			$temp.val($(element).text()).select();
			document.execCommand("copy");
			$temp.remove();
			const Toast = Swal.mixin({
				toast: true,
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true
			});
			Toast.fire({
				icon: "success",
				title: message,
			});
		}

		function previewImage() {
			document.getElementById("image-preview").style.display = "block";
			var fileInput = $.trim($("#image-source").val());
			if (fileInput == "") {
				document.getElementById("image-preview").style.display = "none";
				return false;
			}
			var oFReader = new FileReader();
			oFReader.readAsDataURL(document.getElementById("image-source").files[0]);
			oFReader.onload = function(oFREvent) {
				document.getElementById("image-preview").src = oFREvent.target.result;
			};
		}
	</script>