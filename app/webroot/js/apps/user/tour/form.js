(function() {

var tourentryCtl={};

$(document).ready(function(){
	tourentryCtl.init();
});

tourentryCtl.init=function(){
	
	var map = null;
	var current_window = null;
	var current_window_id = null;
	var marker_list = new Array();
	var info_list = new Array();
	var latlng = {};
	var myOptions = {};
	var linePath = null;
	
	commonCtl.searchBoxSet.setFunc = function() {
		search();
		return false;
	};
	commonCtl.searchBoxSet.unsetFunc = function() {
		search();
		return false;
	};
	
	function mapInit() {
		var latlng = new google.maps.LatLng(35.6815,139.786);
		var myOptions = {
			zoom: 12,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById("map"),myOptions);

		tour_center();
		// 地図検索
		var autocomplete = new google.maps.places.Autocomplete($('#search-address')[0]);
		autocomplete.bindTo('bounds', map);
		$("#search-map").submit(function(){
			var adrs = $("#search-address").val();
			var gc = new google.maps.Geocoder();
			gc.geocode({ address : adrs }, function(results, status){
				if (status == google.maps.GeocoderStatus.OK) {
					var ll = results[0].geometry.location;
					map.setCenter(ll);
					map.fitBounds(results[0].geometry.viewport);
				} else {
					$("#search-address").select();
					$("#falledMessage").show().fadeOut(4000);
				}
			});
			return false;
		});
		// 移動
		google.maps.event.addListener(autocomplete, 'place_changed', function() {
			var place = autocomplete.getPlace();
			if (place.geometry.viewport) {
				map.fitBounds(place.geometry.viewport);
			} else {
				map.setCenter(place.geometry.location);
				map.setZoom(17);  // Why 17? Because it looks good.
			}
			//
			var _place = $("#search-place").val();
			var _name = $("#search-name").val();
			var request={
					location: place.geometry.location,
					radius: '500',
					types: [_place],
					name: _name
				};
			// 検索結果の中央座標設定
//			setPosition(place.geometry.location);
		});
		// スポット一覧再検索
		$("#category,#keyword,#season,#limit,#sort").change(function() {
			search();
		});
		
		google.maps.event.addListener(map, 'dragend', function() {
			search();
		});
		google.maps.event.addListener(map, 'zoom_changed', function() {
			search();
		});
		google.maps.event.addListenerOnce(map, 'tilesloaded', function() {
			search(1);
		});
		$("#search").click(function() {
			search();
		});
		$("#spotFilterButton").click(function() {
			search();
		});
		$(".search_box .search-btn").click(function() {
			search();
		});
		$("#userspot").change(function() {
			search();
		});
		// 予定時刻を反映
		change_time();
		// ツアーにスポット追加
		$(".iconAdd").live("click", function() {
			var self = $(this).closest(".tour_point");
			self.clone().hide().appendTo($("#tour_make .list_area")).fadeIn("slow");
			change_time();
			return false;
		});
		// ツアーにスポット解除
		$(".iconClose").live("click", function() {
			$(this).closest(".tour_point").fadeOut(300).queue(function(){ $(this).remove();});
			change_time();
			return false;
		});
		// 予定のスポットを入れ替え（上）
		$(".iconUp").live("click", function() {
			var self = $(this).closest(".tour_point");
			self.insertBefore(self.prev());
			change_time();
			return false;
		});
		// 予定のスポットを入れ替え（下）
		$(".iconDown").live("click", function() {
			var self = $(this).closest(".tour_point");
			self.insertAfter(self.next());
			change_time();
			return false;
		});
		// スポットのソート、滞在時間変更で予定時刻を変更
		$("#start_time, .pg_stay_time").live("change", function() {
			change_time();
		});
		// カテゴリ選択UI設定
		$(".select-category").each(function() {
			var path = $(this).parent().find(".category_val").val();
			var current = 1;
			var node = [];
			if (path) {
				path_split = path.split("/");
				current = path_split[path_split.length - 2];
				node = [ "node_"+current ];
			}
			var jstree_option = {
				"json_data" : {
					"ajax": {
						"url": gBaseUrl + 'user/category/tree/' + current,
						"data": function(n) {
							return {
								"opration": "get_children",
								"id": n.attr ? n.attr("id").replace("node_", ""): ""
							};
						}
					}
				},
				"ui": { "initially_select": node },
				"plugins" : [ "themes", "json_data", "ui" ]
			};
			$(this).jstree(jstree_option).bind("select_node.jstree", function (e, data) {
				$(this).parent().find(".category_label").val($(this).jstree("get_path", data.rslt.obj, false).join(" > "));
				var val = "/" + $(this).jstree("get_path", data.rslt.obj, true).join("/").replace(/node_/g, "") + "/";
				$(this).parent().find(".category_val").val(val);
				$(this).hide();
			});
		});
		// カテゴリのラベルクリックで入力
		$(".category_label").click(function(e, elm) {
			var current_category = $(this).parent().find(".select-category");
			$(".select-category").not(current_category).hide("fast");
			$(current_category).css({
				"left": $(this).position().left + 25,
				"width": $(this).css("width") - 25
			}).toggle("fast");
			e.stopPropagation();
		});
		// カテゴリ選択後のイベントバブリング停止
		$(".select-category").click(function(e) {
			e.stopPropagation();
		});
		// カテゴリ入力クリア
		$(".category_clear").click(function(e){
			$(this).parent().find(".category_val, .category_label").val("");
		});
		// カテゴリ選択キャンセル 
		$(document).click(function(e) {
			$(".select-category").hide("fast");
		});
		// 時間選択
		$('#start_time').timepicker({
			'minTime': '0:00am',
			'maxTime': '11:00pm',
			'step': 30,
			'timeFormat': 'H:i'
		});
		// タグ入力補完
		$("#tags").tagit({
			itemName: "Tag",
			fieldName: "Tag",
			tagSource: function(search, showChoices) {
				$.ajax({
					url : gBaseUrl + 'user/tag/search',
					data: { term: search.term },
					dataType : 'json',
					success: function(data) {
						var list = [];
						for(i in data.list) list.push(data.list[i]);
						showChoices(list);
					}
				});
			}
		});
		
		$(".linkbtn a").live("click", function() {
			spotCtl.popup($(this).attr("href"));
			return false;
		});
		// 保存ボタン
		$("#save_button").click(function() {
			if (form_validate() == false) {
				return false;
			}
			var categories = [];
			$(".maincategory").each(function(i, elm) {
				categories.push($(elm).val());
			});
			// フォーム情報
			var formData = new FormData();
			var params = $("#tour-form").serializeArray();
			$.each(params, function (i, val) {
				formData.append(val.name, val.value);
			});
			formData.append("Tour[start_time]", $("#start_time").val());
			formData.append("Tour[image]", $('input[name=select_image]:checked').val() ? $('input[name=select_image]:checked').val() : "");
			// ルート情報
			var j = 0;
			$("#tour_make .list_area .tour_point").each(function(i, elm) {
				formData.append("Route["+j+"][spot_id]", $(elm).attr("data-spot-id") ? $(elm).attr("data-spot-id") : "");
				formData.append("Route["+j+"][stay_time]", $(elm).find(".pg_stay_time").val() ? $(elm).find(".pg_stay_time").val() : "");
				formData.append("Route["+j+"][info]", $(elm).find(".pg_memo").val() ? $(elm).find(".pg_memo").val() : "");
				formData.append("Route["+j+"][lat]", $(elm).attr("data-spot-lat"));
				formData.append("Route["+j+"][lng]", $(elm).attr("data-spot-lng"));
				formData.append("Route["+j+"][sort]", j+1);
				j++;
			});
			// カテゴリ
			$("#tour-form input[name='category[]']").each(function() {
				formData.append("Tour[category][]", $(this).val());
			});
			$.ajax({
				url: gBaseUrl + 'api/tour_save',
				type: "post",
				processData: false,
				contentType: false,
				data: formData,
				dataType: "json",
				success: function(json) {
					console.log(json);
					if (json["status"] == true) {
						if (json["result"]["Tour"]["id"]) {
							location.href = gBaseUrl + 'tours/?owner=mydata'; // &_lat='+map.getCenter().lat()+'&_lng='+map.getCenter().lng();
						}
						
					} else {
						alert("登録に失敗しました");
					}
				}
			});
			return false;
		});
		$("#pg_tour_center").click(tour_center);
		
	}
	
	function form_validate() {
		var messages = [];
		var input_item = [];
		
		if ($("#tour-name").val().replace(/(^\s+)|(\s+$)/g, "") == "") {
			messages.push("ツアー名の入力がありません");
			input_item.push("#tour-name");
		}
		
		if ($("#tour-description").val().replace(/(^\s+)|(\s+$)/g, "") == "") {
			messages.push("ツアー説明の入力がありません");
			input_item.push("#tour-description");
		}
		
		/*
		if ($("#tags").tagit("assignedTags").length == 0) {
			messages.push("タグの入力がありません");
			input_item.push("#tags");
		}
		*/
		
		/*
		if ($(".maincategory").length == 0) {
			messages.push("カテゴリの指定がありません");
			input_item.push(".input_form .categories");
		}
		*/

		if (messages.length > 0) {
			alert(messages.join("\n"));
			if (input_item) {
				$(input_item[0]).focus();
				$(input_item.join(",")).css("background-color", "#ffc").animate({
					backgroundColor: "#fff"
				}, 1500 );
			}
			return false;
		}
		return true;

	}

	
	mapInit();
	commonCtl.registCategoryAddSet();
	

	/**
	 * 地図にツアー全体を表示
	 */
	function tour_center() {
		var route = [];
		var lat_min = lat_max = lng_min = lng_max = null;
		$("#tour_make .list_area .tour_point").each(function() {
			var id = $(this).attr("data-spot-id");
			if (id) {
				var lat = $(this).attr("data-spot-lat");
				var lng = $(this).attr("data-spot-lng");
				if (lat_min == null) {
					lat_min = lat;
					lat_max = lat;
					lng_min = lng;
					lng_max = lng;
				}
				if (lat <= lat_min) { lat_min = lat; }
				if (lat >  lat_max) { lat_max = lat; }
				if (lng <= lng_min) { lng_min = lng; }
				if (lng >  lng_max) { lng_max = lng; }
			}
		});
		if (lat_min) {
			var ne = new google.maps.LatLng(lat_max, lng_max);
			var sw = new google.maps.LatLng(lat_min, lng_min);
			var bounds = new google.maps.LatLngBounds(sw, ne);
			map.fitBounds(bounds);
		}
	}
	
	/**
	 * ルートを表示
	 */
	function show_route() {
		var route = [];
		if (linePath) {
			linePath.setMap(null);
		}
		var marker;
		var li_cnt = $("#tour_make .list_area .tour_point").length;
		$("#tour_make .list_area .tour_point").each(function(i, elm) {
			var id = $(this).attr("data-spot-id");
			if (id) {
				if (id in marker_list) {
					marker = marker_list[id]; 
				} else {
					var lat		= $(this).attr("data-spot-lat");
					var lng		= $(this).attr("data-spot-lng");
					var name	= $(this).find(".spotTitle").text();
					var desc	= $(this).find(".spotDescription").text();
					var img_src	= $(this).find(".thumbnail img").attr("src");
					marker = add_marker(id, lat, lng, name, desc, img_src, "");
				}
				if (i == 0) {
					marker.setIcon(gAssetUrl + '/img/map/icons/start.png');
				} else if(i == li_cnt - 1) {
					marker.setIcon(gAssetUrl + '/img/map/icons/finish.png');
				} else {
					marker.setIcon(gAssetUrl + '/img/map/icons/spot.png');
				}
				marker.setZIndex(9999);
				route.push(marker.getPosition());
			}
		});
		if (route.length > 1) {
			linePath = new google.maps.Polyline({
				path: route,
				clickable:		false,
				geodesic:		true,
				strokeColor:	"#009",
				strokeOpacity:	0.6,
				strokeWeight:	6
			});
			linePath.setMap(map);			
		}
	}

	/**
	 * 滞在時間で予定時刻を表示
	 */
	function change_time() {
		var start_time = $("#start_time").val();
		var times = [];
		if (!start_time) {
			times = [0, 0];
		} else {
			times = start_time.split(":");
		}
		var time = new Date();
		var total = 0;
		time.setHours(times[0]);
		time.setMinutes(times[1]);
		time.setSeconds(0);
		$("#tour_make .list_area .tour_point").each(function(i, elm) {
			$(elm).find(".pg_timecode").text($.format.date(time, "HH:mm"));
			var stay_time = $(elm).find(".pg_stay_time").val();
			total += Number(stay_time);
			time.setTime(time.getTime() + (stay_time * 60 * 1000));
		});
		$("#pg_hour").text(Math.floor(total / 60));
		$("#pg_minutes").text(total % 60);
	}
	
	/**
	 * スポット一覧検索
	 */
	function search(page) {
		if (!page) page = 1;
		if (marker_list) {
			marker_list.forEach(function(marker, idx) {
				marker.setMap(null);
			});
			marker_list = new Array();
		}
		$.ajax({
			url: gBaseUrl + "api/spot",
			async: false,
			data: {
				category:	$(".search_box .category dd input").val(),
				keyword:	$("#keyword").val(),
				userspot:	$("#userspot:checked").length,
				limit:		20,
				sort:		$("#sort").val(),
				page:		page,
				ne_lat:		map.getBounds().getNorthEast().lat(),
				ne_lng:		map.getBounds().getNorthEast().lng(),
				sw_lat:		map.getBounds().getSouthWest().lat(),
				sw_lng:		map.getBounds().getSouthWest().lng()
			},
			dataType: "json",
			success: function(json) {
				google.maps.event.addListener(map, "click", function(e) {
					if (current_window) {
						current_window.close();
					}
				});
				$("#spot_select .list_area .tour_point:not(.pg_spot_temp)").remove();
				$.each(json.list, function(id, spot_info) {
					// テンプレートのクローン作成
					var spot_elm = $("#spot_select .pg_spot_temp")
						.clone(true)
						.removeClass("pg_spot_temp")
						.css("display", "block")
						.attr({
							"data-spot-id": spot_info.Spot.id,
							"data-spot-lat": spot_info.Spot.lat,
							"data-spot-lng": spot_info.Spot.lng,
							});
					
					if (spot_info.Spot.image) {
						spot_elm.find(".pg_image")
							.attr("src", gBaseUrl + 'uploads/spot/thumb/' + spot_info.Spot.image.file_name);
						spot_elm.find("input:[name='select_image']")
							.val(spot_info.Spot.id);
					} else {
						spot_elm.find(".pg_select_image").remove();
					}
					spot_elm.find(".pg_name")
						.text(spot_info.Spot.name);
					spot_elm.find(".pg_description")
						.text(spot_info.Spot.description);
					spot_elm.find(".pg_standard_time")
						.text(spot_info.Spot.stay_time);
					spot_elm.find(".linkbtn a").attr("href", gBaseUrl + 'spots/show/' + spot_info.Spot.id);
					spot_elm.appendTo("#spot_select .list_area");
					
					var img_src = "";
					if (spot_info.Spot.image) {
						img_src = spot_info.Spot.image.file_name;
					}
					add_marker(spot_info.Spot.id, spot_info.Spot.lat, spot_info.Spot.lng, spot_info.Spot.name, spot_info.Spot.description, img_src, "");
				});
				
//				FB.XFBML.parse();
				
				// ドラッグ
				$("#spot_select .tour_point:not(.pg_spot_temp)").draggable({
					connectToSortable: "#tour_make .list_area",
					containment: "document",
					revert: "invalid",
					helper: "clone",
					cursor: "move",
					delay: 100,
					scroll: false,
					opacity: 0.6,
					start: function(event, ui) {
						$("#spot_select .list_area").css("overflow", "hidden");
					},
					stop: function(event, ui) {
						$("#spot_select .list_area").css("overflow", "auto");
					}
				});

				$( "#tour_make .list_area" ).sortable({
					stop: function(event, ui) {
						change_time();
						show_route();
						FB.XFBML.parse();
					},
					axis: "y",
					revert: true
				});

				var start = ((page - 1) * $("#limit").val()) + 1;
				var end = page * $("#limit").val();
				if (json.count < end) {
					end = json.count;
				}
				$("#search-count").text(json.count);
				$("#start").text(start);
				$("#end").text(end);
				var page_count = Math.ceil(json.count / $("#limit").val());
				
				pager(page_count, page);
				show_route();
				blockHeightAdjust();
			}
		});
	}
	
	function add_marker(id, lat, lng, name, description, image, icon) {
		var latlng = new google.maps.LatLng(lat, lng);
		var marker = new google.maps.Marker({
			icon : gAssetUrl + "img/map/marker.png",
			shadow: gAssetUrl + "img/map/shadow.png",
			map			: map,
			position	: latlng,
			title		: name,
			draggable	: false
		});
		google.maps.event.addListener(marker, "click", function() {
			info_window(id);
			if (current_window) {
				current_window.close();
			}
			var content = "";
			if (image) {
				content += '<img style="float:left;" src="' + gBaseUrl + 'uploads/spot/thumb/' + image + '" width="60" height="60" alt="" />';
			}
			content += "<b>" + name + "</b><br />" + description;
			var infowindow = new google.maps.InfoWindow({
				content: content
			});
			infowindow.open(map, marker);
			current_window = infowindow;
		});
		marker_list[id] = marker;
		return marker;
	}
	
	function info_window(id) {
		close_info_window(current_window_id);
		$('#spot_select [data-spot-id="' + id + '"]').each(function(i, spot) {
			$("#spot_select .list_area")
				.animate({scrollTop: $("#spot_select .list_area").scrollTop() + $(spot).position().top}, "first");
			$(spot).addClass("active");
//				.css("background-color", "#000");
		});
		current_window_id = id;
	}
	
	function close_info_window(id) {
		if (current_window_id) {
			$('[data-spot-id="' + current_window_id + '"]').each(function(i, spot) {
				$(spot).removeClass("active");
//					.css({ background: "#fff"});
			});
		}
	}

	/**
	 * スポット一覧のページネーション
	 */
	function pager(page_count, now) {
		$(".pager").simplePaginate({
			count		: page_count,
			current		: now,
			onChange	: function(page) {
				search(page);
			}
		});
	}
	
	//block高さ調整
	function blockHeightAdjust(){
		var spotSearch=$("#spot_select");
		var tourMake=$("#tour_make");
		heightAdjust();
		function heightAdjust(){
			var targetHeight=$("#basic_area").height();
			spotSearch.find(".list_area").css("height",(targetHeight-spotSearch.find(".search_box").height()-spotSearch.find(".search_info").height()-spotSearch.find(".memo_item").height()-100)+"px");
			tourMake.find(".list_area").css("height",targetHeight-226+"px");
			$("#joint span").css("height",spotSearch.find(".search_box").height()+39+"px");
		}
	}
//	blockHeightAdjust();
	
	
	
	
	
	// inputpopup 
	$(window).resize(inputResize);
	
	function inputResize(){
		browser.sizeChk();
		var targetLeft=(1000-browser.width)*0.5;
		if(targetLeft>0){
			targetLeft=0;
		}
		$("#input_area").css("top",-($("header").height()+$("#globalnavi").height())-30+"px").css("left",targetLeft+"px");
		$("#input_area .cover").css("width",browser.width+"px").css("height",$(document).height()+"px");
		$("#input_box").css("left",(browser.width-500)*0.5+"px");
	}
	$("#tour_make .inputshowbtn").click(function(){
		if ($("#start_time").val() == "") {
			alert("開始時間の入力がありません");
			$("#start_time").forcus();
			return false;
		}

		if ($("#tour_make .list_area .tour_point").length < 2) {
			alert("ルートの指定がありません");
			$("#start_time").forcus();
			return false;
		}

		if ($("#tour_make .list_area .tour_point").length > 100) {
			alert("1日のツアーは100拠点以上登録できません");
			$("#start_time").forcus();
			return false;
		}

		inputShow();
		return false;
	});
	$("#input_area .cover,#input_area #input_box p.close").click(function(){
		inputHide();
		return false;
	});
	
	function inputShow(){
		inputResize();
		$("#input_area").fadeIn(300)
	}
	function inputHide(){
		$("#input_area").fadeOut(300)
	}
	
	
	inputResize();
}

})();