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


$(function () {
	
	loading(false);

	var msg = $("#info").val();
	if (msg != "") {
		//alert(msg);
	}
	
	// Pagination用
	$('li.active>a, li.disabled>a').click(function () {
		return false;
	});

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
});


function loading(on) {
	$("#loading").toggle(on);
}


function search_select() {
	$(".ma_form").submit();
}
function search_input() {
	$('#free_word_1').keydown(function (e) {
		if (e.keyCode == 13) {
			var val = $(':text[id="free_word_1"]').val();
			var hidden = $(':hidden[id="free_word_1_hidden"]').val();
			var para = getParamString('none_search');
			if (val == hidden) {
				$(location).attr('href', base_url + para);
			} else {
				$(".ma_form").submit();
			}
		}
	});
}






