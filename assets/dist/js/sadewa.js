$(document).on("change", "[type=tel]", function (e) {
	$(e.target).val(
		$(e.target)
			.val()
			.replace(/[^\d\.]/g, "")
	);
});
$(document).on("keypress", "[type=tel]", function (e) {
	keys = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "."];
	return keys.indexOf(event.key) > -1;
});
$(document).on("click", "[removeData]", function () {
	// var link = $(this).data('link');
	var link = $(this).closest("tr").data("link");
	var id = $(this).closest("tr").data("id");
	Swal.fire({
		title: "Yakin Hapus Data ?",
		text: "Data tidak akan dapat dikembalikan!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Ya, hapus!",
		cancelButtonText: "Tidak",
		reverseButtons: true,
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: BASEURL + link + id,
				type: "DELETE",
				dataType: "JSON",
				error: function () {
					alert("Terjadi kesalahan");
				},
				success: function (data) {
					if (data.success) {
						$("tr[data-id='" + id + "']").remove();
						Swal.fire("Berhasil!", data.message, "success");
						// .then( () => {
						//     location.reload();
						// })
					} else {
						Swal.fire("Terjadi Kesalahan!", data.message, "error");
					}
				},
			});
		} else {
			swal.fire("Batal", "Data batal dihapus", "error");
		}
	});
});
function SimpanMaster(form, url) {
	var csrfName = $("#txt_csrfname").attr("name");
	var csrfHash = $("#txt_csrfname").val();
	var formData = new FormData(form);
	formData.append([csrfName], csrfHash);
	// console.log(formData);
	// return false;
	$.ajax({
		url: url,
		type: "POST",
		data: formData,
		contentType: false,
		cache: false,
		processData: false,
		dataType: "json",
		success: function (x) {
			$("#txt_csrfname").val(x.csrfNewHash);
			if (x.success) {
				Swal.fire("Sukses", x.message, "success").then(() => {
					location.reload();
				});
			} else {
				Swal.fire("Terjadi Kesalahan!", x.message, "error");
			}
			return false;
		},
		error: function (data) {
			Swal.fire("Terjadi Kesalahan!", data, "error");
			return false;
		},
	}).done(function () {
		return false;
	});
	return false;
}

function createTextSlug() {
	var title = $('[name="title"]').val();
	$('[name="slug"]').val(generateSlug(title));
}

function generateSlug(text) {
	return text
		.toString()
		.toLowerCase()
		.replace(/^-+/, "")
		.replace(/-+$/, "")
		.replace(/\s+/g, "-")
		.replace(/\-\-+/g, "-")
		.replace(/[^\w\-]+/g, "");
}

function previewImage() {
	document.getElementById("image-preview").style.display = "block";
	var oFReader = new FileReader();
	var fileInput = $.trim($("#image-source").val());
	if (fileInput == "") {
		return false;
	}
	oFReader.readAsDataURL(document.getElementById("image-source").files[0]);
	oFReader.onload = function (oFREvent) {
		document.getElementById("image-preview").src = oFREvent.target.result;
	};
}

function multiPreviewImage(id) {
	document.getElementById("image-preview").style.display = "block";
	var oFReader = new FileReader();
	var fileInput = $.trim($("#" + id).val());
	if (fileInput == "") {
		return false;
	}
	oFReader.readAsDataURL(document.getElementById(id).files[0]);
	oFReader.onload = function (oFREvent) {
		document.getElementById("image-preview").src = oFREvent.target.result;
	};
}

if ($(window).width() < 514) {
	$("#tableDiv").addClass("table-responsive ");
} else {
	$("#tableDiv").removeClass("table-responsive");
}

function changePublish(url, id, btn) {
	var csrfName = $("#txt_csrfname").attr("name");
	var csrfHash = $("#txt_csrfname").val();
	$.ajax({
		url: BASEURL + url + id,
		type: "POST",
		data: { [csrfName]: csrfHash },
		dataType: "JSON",
		success: function (data) {
			$("#txt_csrfname").val(data.csrfNewHash);
			if (data.success) {
				btn.removeClass().addClass("btn btn-icon btn-xs ml-1 " + data.btn);
				if (data.btn == "btn-success") {
					btn.find("i").removeClass().addClass("fas fa-thumbs-up");
				} else {
					btn.find("i").removeClass().addClass("fas fa-thumbs-down");
				}
				Swal.fire("Berhasil!", data.message, "success").then(() => {});
			} else {
				Swal.fire("Terjadi Kesalahan!", data.message, "error");
			}
		},
	});
}
