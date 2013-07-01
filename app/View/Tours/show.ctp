<?php
$this->assign("body_id", "spot");
$this->assign("body_class", "sec");

$this->start("page_css");
$__css[] = $this->Html->css("modules/tour");
echo implode("\n", $__css);
$this->end();

$this->start("page_script");
$__script[] = $this->Html->script("https://maps.googleapis.com/maps/api/js?sensor=true");
$__script[] = $this->Html->script("tour");
$__script[] = $this->Html->script("apps/guest/tour/show");
echo implode("\n", $__script);
$this->end();
?>

<?php echo $this->element("globalnavi"); ?>

<!-- =============== ↓ページコンテンツ↓ =============== -->
<div class="contents">

	<ul id="breadcrumbs">
		<li><a href="../">トップページ</a></li>
		<li><?php echo $tour["Tour"]["name"];?></li>
	</ul>


	<div id="map_area">
		<div id="map"></div>
		<div id="route_distance"></div>
		<div>
		<div id="route_alert" style="color: #f00;"></div>
		<?php if ($this->Session->read("user_info")): ?>
			<?php if (!isset($fb_permission_url)): ?>
			<form id="pg_fb_event_add">
				<input type="hidden" name="tour_id" value="<?php echo $tour["Tour"]["id"];?>">
				<ul>
					<li>
						<label>イベント名</label>
						<input type="text" name="name" value="<?php echo $tour["Tour"]["name"];?>" required="required" />
					</li>
					<li>
						<label>イベント詳細</label>
						<textarea name="description" cols="50" rows="4" required="required"><?php echo $tour["Tour"]["description"];?></textarea>
					</li>
					<li>
						<label>開始日時</label>
						<input type="date" name="start_time" required="required" min="<?php echo date("Y-m-d");?>" />
					</li>
					<li>
						<label>終了日時</label>
						<input type="date" name="end_time" min="<?php echo date("Y-m-d");?>" />
					</li>
					<li>
						<label>プライバシー</label>
						<label><input type="radio" name="privacy" value="open" checked="checked">公開</label>
						<label><input type="radio" name="privacy" value="friends">友達</label>
						<label><input type="radio" name="privacy" value="secret">自分のみ</label>
					</li>
				</ul>
				<input type="submit" value="登録" id="pg_fb_event_submit" />
			</form>
			<div id="pg_fb_event_result"></div>
			<?php else:?>
				<a href="<?php echo $fb_permission_url;?>">Facebookのイベント投稿を許可</a>
			<?php endif;?>
		<?php endif;?>
		</div>
	</div>
	<!-- //maparea -->
	
	<div id="detail_area">
		<p class="photo">
			<?php if ($tour["Tour"]["image"]) : ?>
			<img src="<?php echo $this->html->url("/uploads/spot/middle/".$tour["Tour"]["image"]["file_name"]);?>" alt="" width="265" height="199" />
			<?php else: ?>
			<img src="<?php echo $this->html->url("/img/common/noimage.jpg"); ?>" alt="<?php echo $tour["Tour"]["image"]["file_name"];?>" width="265" height="199" />
			<?php endif;?>
		</p>
		<div class="info">
			<h2><?php echo $tour["Tour"]["name"];?></h2>
			
			<div class="subinfo">
				<dl>
					<dt><img src="<?php echo $this->html->url("/img/common/icon/name.gif"); ?>" alt="作成者" /></dt>
					<dd><?php echo $tour["User"]["name"];?></dd>
				</dl>
				<dl>
					<dt><img src="<?php echo $this->html->url("/img/common/icon/departure.gif"); ?>" alt="出発地" /></dt>
					<dd><?php echo $tour["Tour"]["prefecture"];?></dd>
				</dl>
				<dl>
					<dt><img src="<?php echo $this->html->url("/img/common/icon/time.gif"); ?>" alt="時間" /></dt>
					<dd><?php echo $tour["Tour"]["stay_time"];?>分</dd>
				</dl>
				<dl class="category">
					<dt><img src="<?php echo $this->html->url("/img/common/icon/category_l.gif"); ?>" alt="CATEGORY" /></dt>
					<dd>
						<ul>
<?php
if ($tour["Tour"]["category"]):
	foreach($tour["Tour"]["category"] as $tree):
		$links = array();
		foreach($tree["info"] as $node):
			$links[] = '<a href="">'.$node["name"].'</a>';
		endforeach; ?>
					<li>
					<?php echo implode(" > ", $links); ?>
					</li>
<?php
	endforeach;
endif;?>
						</ul>
					</dd>
				</dl>
				<dl class="tag">
					<dt><img src="<?php echo $this->html->url("/img/common/icon/tag_l.gif"); ?>" alt="タグ" /></dt>
					<dd>
						<ul>
<?php
if ($tour["Tag"]) :
foreach($tour["Tag"] as $tag_key => $tag):?>
							<li><a href=""><?php echo $tag["name"];?></a></li>
<?php endforeach;
endif;
?>
						</ul>
					</dd>
				</dl>
			</div>
			<!-- //subinfo -->
			
		</div>
		<!-- //info -->
		
		<dl class="comment">
			<dt><img src="<?php echo $this->html->url("/img/common/icon/note.gif"); ?>" alt="説明" /></dt>
			<dd><?php echo $tour["Tour"]["description"]?></dd>
		</dl>

		<div class="fb-like" data-href="<?php echo $this->html->url("/tour/show/".$tour["Tour"]["id"], true);?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
		
		<p class="edit">
			<?php if ($this->Session->read("user_info")):?>
			<a href="<?php echo $this->html->url("/tours/form/".$tour["Tour"]["id"]);?>" class="selectbtn mouse_over">編集する</a>
			<?php endif;?>
		</p>
		
	</div>
	<!-- //detail_area -->


	<div id="route_area">
		<h3><?php echo $tour["Tour"]["name"];?><img src="<?php echo $this->html->url("/img/tour/route.gif"); ?>" alt="の行程" /><span>&nbsp;</span></h3>
	
		<div class="routes">
		<?php
		if ($tour["Route"]) :
			$time = strtotime($tour["Tour"]["start_time"]);
			foreach($tour["Route"] as $ruote) :
				$time += $ruote["stay_time"] * 60;
				if ($ruote["spot_id"] == 0): ?>
			<div class="item memo">
				<p class="time"><?php echo date("H:i", $time);?><span class="line">&nbsp;</span></p>
				<dl>
				<dt>メモ</dt>
				<dd><?php echo $ruote["info"]; ?></dd>
				</dl>
			</div>
			<!-- //item --><?php
				else:?>
			<div class="item spot pg_spot" data-spot-id="<?php echo $ruote["spot_id"]?>" data-lat="<?php echo $ruote["Spot"]["lat"];?>" data-lng="<?php echo $ruote["Spot"]["lng"];?>" >
				<p class="time"><?php echo date("H:i", $time);?><span class="line">&nbsp;</span></p>
				<div class="photo_area">
					<p class="photo">
						<?php if ($ruote["Spot"]["image"]) :
						$image = unserialize($ruote["Spot"]["image"]);
						?>
							<img src="<?php echo $this->html->url("/uploads/spot/thumb/".$image["file_name"]);?>" width="98" height="74" alt="" />
						<?php else:?>
							<img src="<?php echo $this->html->url("/img/common/noimage.jpg"); ?>" alt="スポット名スポット名スポット名" width="98" height="74" />
						<?php endif;?>
					</p>
					<div class="fb-like" data-href="<?php echo $this->html->url("/spots/show/".$ruote["spot_id"], true);?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
				</div>
				<!-- //photo_area -->
				<div class="info_area">
					<dl class="name">
						<dt><img src="<?php echo $this->html->url("/img/tour/name.gif"); ?>" alt="名称" /></dt>
						<dd><?php echo $ruote["Spot"]["name"]?></dd>
					</dl>
					<dl class="stay">
						<dt><img src="<?php echo $this->html->url("/img/tour/staytime.gif"); ?>" alt="滞在時間" /></dt>
						<dd><?php echo $ruote["Spot"]["stay_time"];?></dd>
					</dl>
					<dl class="memo">
						<dt><img src="<?php echo $this->html->url("/img/tour/memo.gif"); ?>" alt="一言メモ" /></dt>
						<dd><?php echo $ruote["Spot"]["description"]; ?></dd>
					</dl>
					<p class="linkbtn"><a href="<?php echo $this->html->url("/spots/show/".$ruote["spot_id"]);?>" class="mouse_over">スポット詳細をみる</a></p>
					
				</div>
				<!-- //info_area -->
				
			</div>
			<!-- //item -->
			<?php endif;?>
		<?php endforeach;?>
	<?php endif;?>
			
		</div>
		<!-- //routes -->
		
			<p class="copy">
				<a href="<?php echo $this->html->url("/tours/copy/".$this->request["id"]); ?>" class="selectbtn mouse_over pg_copy">コピーしてツアーを作る</a>
				<a href="<?php echo $this->html->url("/tours/delete/".$this->request["id"]);?>" class="selectbtn mouse_over pg_delete">削除する</a>
			</p>
		
	</div>
	<!-- //route_area -->

	<?php $this->element("guest/search_box", array("mode" => 1));?>

</div>
<!-- //contents -->
<!-- =============== ↑ページコンテンツ↑ =============== -->
