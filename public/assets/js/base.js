$(function () {

	loading(false);

	var msg = $("#info").val();
	if (msg != "") {
		//alert(msg);
	}

	// Pagination用
	$("li.active>a, li.disabled>a").click(function () {
		return false;
	});


	/*
	 * Address utility
	 */
	$("#auto_address").on("click", function () {

	});
	Address.prefs().done(function (data) {
		$("#pref, #city, #town").children().remove();
		$.each(data, function (k, v) {
			$("#pref").append($("<option />").val(k).html(v));
		});
	});
	$("#pref").on("change", function () {
		Address.cities($(this).val()).done(function (data) {
			$("#city, #town").children().remove();
			$.each(data, function (k, v) {
				$("#city").append($("<option />").val(k).html(v));
			});
		});
	});
	$("#city").on("change", function () {
		Address.towns($(this).val()).done(function (data) {
			$("#town").children().remove();
			$.each(data, function (k, v) {
				$("#town").append($("<option />").val(k).html(v));
			});
		});
	});
	$("#town").on("change", function () {
		$("#town").val($(this).val());
	});

	/*
	 * file size check
	 */
	$("#upload_file").on("change", function () {
		var size = 0;
		$.each(this.files, function () {
			size += this.size;
		});
		var mb = 20;
		if (size > (1048576 * mb)) {
			$(this).val("");
			alert("アップロードできるファイルのサイズは" + mb + "MBまでです。");
		}
	});


	/*
	 * submit
	 */
	$("form .text, form .selection").on("change", function () {
		$(this).closest("form").submit();
	});

});


function loading(on) {
	$("#loading").toggle(on);
}




var Address = {
	byZip: function (zipcode) {
		var defer = $.Deferred();
		$.get({
			url: "api/address/get_address_by_zip/" + zipcode,
			success: defer.resolve,
			error: defer.reject
		});
		return defer.promise();
	},
	prefs: function () {
		var defer = $.Deferred();
		$.ajax({
			url: "api/address/prefs.json",
			success: defer.resolve,
			error: defer.reject
		});
		return defer.promise();
	},
	cities: function (prefCd) {
		var defer = $.Deferred();
		$.ajax({
			url: "api/address/cities/" + prefCd + ".json",
			success: defer.resolve,
			error: defer.reject
		});
		return defer.promise();
	},
	towns: function (cityCd) {
		var defer = $.Deferred();
		$.ajax({
			url: "api/address/towns/" + cityCd + ".json",
			success: defer.resolve,
			error: defer.reject
		});
		return defer.promise();
	},
};