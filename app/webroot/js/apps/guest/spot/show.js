$(function() {
	var lat = $("#detail_area").attr("data-lat");
	var lng = $("#detail_area").attr("data-lng");
	var zoom = parseInt($("#detail_area").attr("data-zoom"));
	var name = $("#pg_name").text();
	latlng = new google.maps.LatLng(lat, lng);
	if (!zoom) zoom = 10;
	var myOptions = {
		zoom: zoom,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map($("#map")[0], myOptions);
	var marker = new google.maps.Marker({
		map			: map,
		position	: latlng,
		title		: name,
		draggable	: false
	});

	// ツアー
	$.ajax({
		url: gBaseUrl + "api/tour",
		data: {
			owner		: "",
			spot_id		: $("#detail_area").attr("data-id"),
			limit		: 6,
			page		: 1,
			sort		: "created_time",
			sort_type	: "desc",
		},
		dataType: "json",
		success: function(json) {
			if (json["count"] > 0) {
				$.each(json["list"], function(id, info) {
					tourCtl.render(info, ".list_area");
				});
				commonCtl.iconTips();
				$(".list_area .pg_description").trunk8({
					lines: 4
				});
			}
		}
	});

	$(".pg_delete").live("click", function() {
		if ($(".list_item:not(.pg_temp)").length > 0) {
			if (!confirm("このスポットが含まれるツアーが存在します。\n本当に削除しますか？")) {
				return false;
			}
		} else {
			if (!confirm("本当に削除しますか？")) {
				return false;
			}
		}
		var id = $("#detail_area").attr("data-id");
		$.ajax({
			"url": gBaseUrl + "api/spot_delete/" + id + ".json",
			"type": "GET",
			"dataType": "json",
			"success": function(json) {
				console.log(json);
				if (json.error == 0) {
					location.href = gBaseUrl + "spots/";
				} else {
					alert(json.message);
					location.href = gBaseUrl + "spots/";
				}
			},
			"error": function(XMLHttpRequest, textStatus, errorThrown) {
				alert(errorThrown.message + "\n" + "スポットの削除に失敗しました。");
			}
		});
		return false;
	});

});